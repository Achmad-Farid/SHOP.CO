// src/stores/auth.js
import { defineStore } from "pinia";
import { http, csrf } from "../api/http";

export const useAuthStore = defineStore("auth", {
  state: () => ({
    user: null,
    status: "idle", // 'idle' | 'loading' | 'error'
    error: null,
    _bootstrapped: false,
  }),

  getters: {
    isAuthenticated: (s) => !!s.user,
  },

  actions: {
    // Helper umum: eksekusi request, kalau 419 → refresh csrf → retry sekali
    async requestWithCsrfRetry(fn) {
      try {
        return await fn();
      } catch (e) {
        // 419 = CSRF token mismatch / expired
        const status = e?.response?.status;
        if (status === 419) {
          try {
            await csrf();
            return await fn(); // retry sekali
          } catch (e2) {
            throw e2;
          }
        }
        throw e;
      }
    },

    async register(payload) {
      this.status = "loading";
      this.error = null;
      try {
        await csrf();
        await this.requestWithCsrfRetry(() => http.post("/api/v1/auth/register", payload));
        await this.me();
        this.status = "idle";
        return true;
      } catch (e) {
        this.status = "error";
        this.error = normalizeError(e);
        return false;
      }
    },

    async login(payload) {
      this.status = "loading";
      this.error = null;
      try {
        await csrf();
        await this.requestWithCsrfRetry(() => http.post("/api/v1/auth/login", payload));
        await this.me();
        this.status = "idle";
        return true;
      } catch (e) {
        this.status = "error";
        this.error = normalizeError(e);
        return false;
      }
    },

    async me() {
      try {
        const { data } = await http.get("/api/v1/auth/me");
        this.user = data;
        return data;
      } catch {
        this.user = null;
        return null;
      }
    },

    async logout() {
      this.status = "loading";
      this.error = null;
      try {
        // Beberapa setup butuh CSRF juga saat logout
        await csrf();
        await this.requestWithCsrfRetry(() => http.post("/api/v1/auth/logout"));
        this.user = null;
        this.status = "idle";
      } catch (e) {
        this.status = "error";
        this.error = normalizeError(e);
      }
    },

    async init() {
      if (this._bootstrapped) return;
      await this.me(); // restore session dari cookie kalau ada
      this._bootstrapped = true;
    },

    clearError() {
      this.error = null;
      this.status = "idle";
    },
  },
});

function normalizeError(err) {
  // Ambil pesan validasi Laravel (422), atau message umum
  const res = err?.response;
  if (res?.data) {
    // Bisa return { message, errors } dari Laravel
    return res.data;
  }
  return { message: err?.message || "Unknown error" };
}
