import axios from "axios";

export const http = axios.create({
  baseURL: import.meta.env.VITE_API_URL, // http://localhost:8000
  withCredentials: true,
  headers: { Accept: "application/json" },
  xsrfCookieName: "XSRF-TOKEN",
  xsrfHeaderName: "X-XSRF-TOKEN",
});

// helper ambil cookie by name
function getCookie(name) {
  const match = document.cookie.match(new RegExp("(^|;\\s*)" + name + "=([^;]*)"));
  return match ? decodeURIComponent(match[2]) : null;
}

export async function csrf() {
  // ambil cookie dari backend
  await http.get("/sanctum/csrf-cookie");
  // setelah dapat cookie, set header manual
  const token = getCookie("XSRF-TOKEN");
  if (token) {
    http.defaults.headers.common["X-XSRF-TOKEN"] = token;
  }
}

// interceptor jaga-jaga kalau token ilang
http.interceptors.request.use((config) => {
  if (!config.headers["X-XSRF-TOKEN"]) {
    const token = getCookie("XSRF-TOKEN");
    if (token) config.headers["X-XSRF-TOKEN"] = token;
  }
  return config;
});
