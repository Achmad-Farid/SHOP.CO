<script setup>
import { useRouter } from "vue-router";

const router = useRouter();
function goToLogin() {
  router.push("/login");
}
</script>

<template>
  <nav class="bg-white shadow-md">
    <div class="container mx-auto px-4 py-3 flex items-center justify-between">
      <!-- Logo -->
      <img src="../assets/logo.png" alt="Logo" class="w-32 mr-6 cursor-pointer" />

      <!-- Menu -->
      <ul class="hidden md:flex space-x-6 text-gray-700 font-medium">
        <li><a href="#" class="hover:text-black transition-colors">Shop</a></li>
        <li><a href="#" class="hover:text-black transition-colors">On Sale</a></li>
        <li><a href="#" class="hover:text-black transition-colors">New Arrivals</a></li>
        <li><a href="#" class="hover:text-black transition-colors">Brands</a></li>
      </ul>

      <!-- Search -->
      <div class="hidden md:block flex-1 mx-6">
        <div class="relative w-full">
          <!-- Icon Search -->
          <span class="absolute inset-y-0 left-3 flex items-center text-gray-400 group-focus-within:text-black">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35M11 18a7 7 0 100-14 7 7 0 000 14z" />
            </svg>
          </span>

          <!-- Input -->
          <input
            type="text"
            placeholder="Search for products..."
            class="w-full pl-10 pr-3 py-1.5 text-sm border rounded-full bg-gray-100 text-gray-700 focus:outline-none focus:ring-2 focus:ring-black focus:border-black hover:border-gray-400 transition"
          />
        </div>
      </div>

      <!-- Cart + Sign In -->
      <div class="flex items-center space-x-4">
        <!-- Cart Icon -->
        <button class="relative hover:text-black transition-colors cursor-pointer">
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-6 h-6 text-gray-700">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13l-1.5 7h13M7 13L5.4 5M17 21a2 2 0 11-4 0 2 2 0 014 0zM9 21a2 2 0 11-4 0 2 2 0 014 0z" />
          </svg>
        </button>

        <!-- Sign In -->
        <button @click="goToLogin" class="px-4 py-2 bg-black text-white rounded-full hover:bg-gray-800 transition-colors cursor-pointer">Sign In</button>
      </div>
    </div>
  </nav>
</template>
