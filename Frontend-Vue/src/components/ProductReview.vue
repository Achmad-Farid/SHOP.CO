<script setup>
import ProductList from "./ProductList.vue";

const items = [
  { id: 1, title: "Minimalist Cotton Tee", image: "/assets/tee.jpg", price: 149000, oldPrice: 199000, rating: 4.6, reviews: 128 },
  { id: 2, title: "Linen Shirt", image: null, price: 249000, rating: 4.2, reviews: 54 },
  { id: 3, title: "Oversized Hoodie", image: "/assets/hoodie.jpg", price: 299000, oldPrice: 399000, rating: 4.9, reviews: 220 },
];
</script>

<template>
  <ProductList :products="items" />
  <ProductList :products="items" />
</template>
