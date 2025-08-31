<script setup>
import { reactive } from "vue";
import { useRouter } from "vue-router";
import { useAuthStore } from "../store/auth.store";

const router = useRouter();
const auth = useAuthStore();

const form = reactive({
  name: "Achmad Farid",
  email: "farid@example.com",
  password: "Password123",
  password_confirmation: "Password123",
});

async function onSubmit() {
  const ok = await auth.register(form);
  if (ok) router.push("/profile");
}
</script>

<template>
  <div style="max-width: 360px">
    <h1>Register</h1>
    <form @submit.prevent="onSubmit">
      <div>
        <label>Name</label>
        <input v-model="form.name" required />
      </div>
      <div>
        <label>Email</label>
        <input v-model="form.email" type="email" required />
      </div>
      <div>
        <label>Password</label>
        <input v-model="form.password" type="password" required />
      </div>
      <div>
        <label>Confirm Password</label>
        <input v-model="form.password_confirmation" type="password" required />
      </div>
      <button :disabled="auth.status === 'loading'">Create account</button>
      <p v-if="auth.error?.message" style="color: red">{{ auth.error.message }}</p>
    </form>
  </div>
</template>
