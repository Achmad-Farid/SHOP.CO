<script setup>
import { reactive } from "vue";
import { useRouter, useRoute } from "vue-router";
import { useAuthStore } from "../store/auth.store";

const router = useRouter();
const route = useRoute();
const auth = useAuthStore();

const form = reactive({
  email: "farid@example.com",
  password: "Password123",
});

async function onSubmit() {
  const ok = await auth.login(form);
  if (ok) {
    router.push(route.query.redirect?.toString() || "/profile");
  }
}
</script>

<template>
  <div style="max-width: 360px">
    <h1>Login</h1>
    <form @submit.prevent="onSubmit">
      <div>
        <label>Email</label>
        <input v-model="form.email" type="email" required />
      </div>
      <div>
        <label>Password</label>
        <input v-model="form.password" type="password" required />
      </div>
      <button :disabled="auth.status === 'loading'">Login</button>
      <p v-if="auth.error?.message" style="color: red">{{ auth.error.message }}</p>
    </form>
  </div>
</template>
