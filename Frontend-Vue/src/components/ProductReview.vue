<script setup>
import ProductList from "./ProductList.vue";

const items = [
  { id: 1, title: "Minimalist Cotton Tee", image: "/assets/tee.jpg", price: 149000, oldPrice: 199000, rating: 4.6, reviews: 128 },
  { id: 2, title: "Linen Shirt", image: null, price: 249000, rating: 4.2, reviews: 54 },
  { id: 3, title: "Oversized Hoodie", image: "/assets/hoodie.jpg", price: 299000, oldPrice: 399000, rating: 4.9, reviews: 220 },
  { id: 4, title: "Oversized Hoodie", image: "/assets/hoodie.jpg", price: 299000, oldPrice: 399000, rating: 4.9, reviews: 220 },
];
</script>

<template>
  <div class="max-w-7xl mx-auto px-4 py-6 space-y-6 mt-8">
    <h1 class="text-3xl font-bold text-center">NEW ARRIVALS</h1>
    <ProductList :products="items" />
    <div class="flex justify-center">
      <button class="cursor-pointer mt-4 px-6 py-2 border border-black text-black bg-white hover:bg-gray-100 transition rounded-md">View All</button>
    </div>
  </div>

  <div class="max-w-7xl mx-auto px-4 py-6 space-y-6 mt-8">
    <h1 class="text-3xl font-bold text-center">TOP SELLING</h1>
    <ProductList :products="items" />
    <div class="flex justify-center">
      <button class="cursor-pointer mt-4 px-6 py-2 border border-black text-black bg-white hover:bg-gray-100 transition rounded-md">View All</button>
    </div>
  </div>
</template>
