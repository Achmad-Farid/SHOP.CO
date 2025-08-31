<script setup>
import { useAuthStore } from "../store/auth.store";
const auth = useAuthStore();

async function refresh() {
  await auth.me();
}
async function doLogout() {
  await auth.logout();
}
</script>

<template>
  <div>
    <h1>Profile</h1>
    <pre>{{ auth.user }}</pre>
    <div style="display: flex; gap: 8px">
      <button @click="refresh">Refresh Me</button>
      <button @click="doLogout">Logout</button>
    </div>
  </div>
</template>
