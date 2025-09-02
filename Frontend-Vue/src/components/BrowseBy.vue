<!-- BrowseByDressStyle.vue -->
<template>
  <div class="max-w-7xl mx-auto px-4 py-10">
    <div class="bg-[#F0F0F0] p-8 rounded-2xl">
      <!-- Judul -->
      <h2 class="text-2xl font-bold text-center mb-8">
        {{ title }}
      </h2>

      <!-- Grid -->
      <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Baris 1 -->
        <a href="#" class="group relative col-span-1 md:col-span-2 h-40 md:h-56 overflow-hidden rounded-xl focus:outline-none focus:ring-2 focus:ring-black" :aria-label="`Kategori ${labels.casual}`">
          <div class="absolute inset-0 bg-center bg-cover transition-transform duration-300 group-hover:scale-105" :style="bgStyle(images.casual)" />
          <div class="absolute inset-0 bg-gradient-to-t from-black/35 to-black/0" />
          <span class="absolute top-3 left-4 text-white font-semibold text-lg drop-shadow">
            {{ labels.casual }}
          </span>
        </a>

        <a href="#" class="group relative col-span-1 h-40 md:h-56 overflow-hidden rounded-xl focus:outline-none focus:ring-2 focus:ring-black" :aria-label="`Kategori ${labels.formal}`">
          <div class="absolute inset-0 bg-center bg-cover transition-transform duration-300 group-hover:scale-105" :style="bgStyle(images.formal)" />
          <div class="absolute inset-0 bg-gradient-to-t from-black/35 to-black/0" />
          <span class="absolute top-3 left-4 text-white font-semibold text-lg drop-shadow">
            {{ labels.formal }}
          </span>
        </a>

        <!-- Baris 2 -->
        <a href="#" class="group relative col-span-1 h-40 md:h-56 overflow-hidden rounded-xl focus:outline-none focus:ring-2 focus:ring-black" :aria-label="`Kategori ${labels.party}`">
          <div class="absolute inset-0 bg-center bg-cover transition-transform duration-300 group-hover:scale-105" :style="bgStyle(images.party)" />
          <div class="absolute inset-0 bg-gradient-to-t from-black/35 to-black/0" />
          <span class="absolute top-3 left-4 text-white font-semibold text-lg drop-shadow">
            {{ labels.party }}
          </span>
        </a>

        <a href="#" class="group relative col-span-1 md:col-span-2 h-40 md:h-56 overflow-hidden rounded-xl focus:outline-none focus:ring-2 focus:ring-black" :aria-label="`Kategori ${labels.gym}`">
          <div class="absolute inset-0 bg-center bg-cover transition-transform duration-300 group-hover:scale-105" :style="bgStyle(images.gym)" />
          <div class="absolute inset-0 bg-gradient-to-t from-black/35 to-black/0" />
          <span class="absolute top-3 left-4 text-white font-semibold text-lg drop-shadow">
            {{ labels.gym }}
          </span>
        </a>
      </div>
    </div>
  </div>
</template>

<script setup>
const props = defineProps({
  title: { type: String, default: "BROWSE BY DRESS STYLE" },
  images: {
    type: Object,
    default: () => ({
      casual: "https://images.unsplash.com/photo-1519741497674-611481863552?q=80&w=1200&auto=format&fit=crop",
      formal: "https://images.unsplash.com/photo-1520975916090-3105956dac38?q=80&w=1200&auto=format&fit=crop",
      party: "https://images.unsplash.com/photo-1519741496770-87f7b19d2c09?q=80&w=1200&auto=format&fit=crop",
      gym: "https://images.unsplash.com/photo-1517836357463-d25dfeac3438?q=80&w=1200&auto=format&fit=crop",
    }),
  },
  labels: {
    type: Object,
    default: () => ({
      casual: "Casual",
      formal: "Formal",
      party: "Party",
      gym: "Gym",
    }),
  },
});

function bgStyle(url) {
  // fallback warna abu jika url kosong
  return url ? { backgroundImage: `url('${url}')` } : { backgroundColor: "#e5e7eb" }; // gray-200
}
</script>
