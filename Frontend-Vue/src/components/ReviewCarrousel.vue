<template>
  <section class="w-full">
    <!-- Header -->
    <div class="max-w-7xl mx-auto px-4">
      <div class="flex items-center justify-between mb-4">
        <h3 class="text-xl md:text-2xl font-extrabold tracking-wide">OUR HAPPY COSTUMER</h3>

        <div class="flex items-center gap-2">
          <button @click="scroll(-1)" class="px-3 py-2 border border-black bg-white text-black rounded-md hover:bg-gray-100 transition" aria-label="Scroll left">
            <!-- Panah kiri -->
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="currentColor">
              <path d="M15.5 19a1 1 0 0 1-.7-.29l-6-6a1 1 0 0 1 0-1.42l6-6a1 1 0 1 1 1.4 1.42L10.9 12l5.3 5.29A1 1 0 0 1 15.5 19z" />
            </svg>
          </button>
          <button @click="scroll(1)" class="px-3 py-2 border border-black bg-white text-black rounded-md hover:bg-gray-100 transition" aria-label="Scroll right">
            <!-- Panah kanan -->
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="currentColor">
              <path d="M8.5 19a1 1 0 0 1-.7-1.71L13.1 12 7.8 6.71a1 1 0 0 1 1.4-1.42l6 6a1 1 0 0 1 0 1.42l-6 6A1 1 0 0 1 8.5 19z" />
            </svg>
          </button>
        </div>
      </div>
    </div>

    <!-- List review (horizontal, tak dibatasi jumlahnya) -->
    <div ref="track" class="flex gap-4 overflow-x-auto scroll-smooth snap-x snap-mandatory pb-2 [-ms-overflow-style:none] [scrollbar-width:none]">
      <article v-for="(r, idx) in reviews" :key="idx" class="min-w-[260px] max-w-[320px] snap-start shrink-0 rounded-xl border border-gray-200 bg-white p-4">
        <!-- Bintang -->
        <div class="mb-2 flex items-center gap-1">
          <template v-for="i in 5">
            <svg v-if="i <= Math.round(r.rating)" :key="`s-${i}`" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
              <path d="M10 15l-5.878 3.09 1.122-6.545L.488 6.91l6.561-.953L10 0l2.951 5.957 6.561.953-4.756 4.635 1.122 6.545z" />
            </svg>
            <svg v-else :key="`o-${i}`" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
              <path d="M12 17.27 18.18 21l-1.64-7.03L22 9.24l-7.19-.62L12 2 9.19 8.62 2 9.24l5.46 4.73L5.82 21z" />
            </svg>
          </template>
        </div>

        <!-- Nama -->
        <h4 class="font-semibold text-gray-900">{{ r.name }}</h4>

        <!-- Komentar -->
        <p class="mt-1 text-gray-700 leading-relaxed">
          {{ r.comment }}
        </p>
      </article>
    </div>
  </section>
</template>

<script setup>
import { ref } from "vue";

const props = defineProps({
  reviews: {
    type: Array,
    default: () => [
      { name: "Aulia", rating: 5, comment: "Kualitas produk mantap, pengiriman cepat!" },
      { name: "Bima", rating: 4, comment: "Nyaman dipakai seharian. Akan beli lagi." },
      { name: "Citra", rating: 5, comment: "Desainnya keren, sesuai foto." },
      { name: "Doni", rating: 4, comment: "Harga oke, pelayanan ramah." },
      { name: "Eka", rating: 5, comment: "Ukuran pas, material tebal dan halus." },
      { name: "Eka", rating: 5, comment: "Ukuran pas, material tebal dan halus." },
      { name: "Eka", rating: 5, comment: "Ukuran pas, material tebal dan halus." },
      { name: "Eka", rating: 5, comment: "Ukuran pas, material tebal dan halus." },
      { name: "Eka", rating: 5, comment: "Ukuran pas, material tebal dan halus." },
      { name: "Eka", rating: 5, comment: "Ukuran pas, material tebal dan halus." },
      { name: "Eka", rating: 5, comment: "Ukuran pas, material tebal dan halus." },
      { name: "Eka", rating: 5, comment: "Ukuran pas, material tebal dan halus." },
      { name: "Eka", rating: 5, comment: "Ukuran pas, material tebal dan halus." },
      { name: "Eka", rating: 5, comment: "Ukuran pas, material tebal dan halus." },
    ],
  },
  // Berapa banyak pixel untuk geser sekali klik panah
  step: { type: Number, default: 320 },
});

const track = ref(null);

function scroll(dir = 1) {
  if (!track.value) return;
  track.value.scrollBy({ left: props.step * dir, behavior: "smooth" });
}
</script>
<!-- hide scrollbar (webkit) -->
<style>
.no-scrollbar::-webkit-scrollbar {
  display: none;
}
</style>
