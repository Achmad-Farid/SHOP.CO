<template>
  <section class="w-full">
    <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
      <article v-for="p in products" :key="p.id || p.title" class="group rounded-2xl border border-black/10 bg-white shadow-sm transition hover:shadow-lg">
        <!-- Gambar -->
        <div class="relative overflow-hidden rounded-t-2xl">
          <img :src="p.image || placeholder" :alt="p.title" class="h-64 w-full object-cover transition duration-500 ease-out group-hover:scale-[1.03]" loading="lazy" decoding="async" />
        </div>

        <!-- Body -->
        <div class="p-4 space-y-3">
          <!-- Judul -->
          <h3 class="line-clamp-2 text-base font-semibold text-black">
            {{ p.title }}
          </h3>

          <!-- Rating -->
          <div class="flex items-center gap-2">
            <div class="flex">
              <svg v-for="i in 5" :key="i" class="h-4 w-4" viewBox="0 0 20 20" :fill="i <= Math.round(p.rating || 0) ? 'currentColor' : 'none'" stroke="currentColor" aria-hidden="true">
                <path
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.967 0 1.371 1.24.588 1.81l-2.802 2.035a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.802-2.035a1 1 0 00-1.176 0l-2.802 2.035c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.379-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"
                />
              </svg>
            </div>
            <span class="text-xs text-black/60">
              {{ (p.rating ?? 0).toFixed(1) }}
              <template v-if="p.reviews">• {{ p.reviews }} reviews</template>
            </span>
          </div>

          <!-- Harga -->
          <div class="flex items-center justify-between">
            <div class="flex items-baseline gap-2">
              <span class="text-lg font-extrabold text-black">
                {{ formatIDR(effectivePrice(p)) }}
              </span>

              <!-- Harga lama dicoret jika diskon -->
              <span v-if="isDiscounted(p)" class="text-sm text-black/50 line-through">
                {{ formatIDR(p.oldPrice) }}
              </span>
            </div>

            <!-- Badge diskon merah -->
            <span v-if="isDiscounted(p)" class="rounded-md border border-red-500/20 bg-red-50 px-2 py-0.5 text-xs font-semibold text-red-600"> -{{ discountPercent(p) }}% </span>
          </div>
        </div>
      </article>
    </div>
  </section>
</template>

<script setup>
const props = defineProps({
  products: {
    type: Array,
    required: true,
    default: () => [],
  },
});

// Placeholder SVG (monokrom)
const placeholder =
  "data:image/svg+xml;utf8," +
  encodeURIComponent(`
<svg xmlns="http://www.w3.org/2000/svg" width="800" height="600">
  <rect width="100%" height="100%" fill="#F2F0F1"/>
  <g fill="none" stroke="#999" stroke-width="2">
    <rect x="20" y="20" width="760" height="560" rx="16" ry="16"/>
    <path d="M120 420l120-140 120 120 80-80 140 140" />
    <circle cx="240" cy="220" r="40" />
  </g>
</svg>`);

// Helpers
const isDiscounted = (p) => typeof p.oldPrice === "number" && p.oldPrice > p.price;

const effectivePrice = (p) => p.price;

const discountPercent = (p) => (isDiscounted(p) ? Math.round(((p.oldPrice - p.price) / p.oldPrice) * 100) : 0);

const formatIDR = (n) => new Intl.NumberFormat("id-ID", { style: "currency", currency: "IDR", maximumFractionDigits: 0 }).format(n);
</script>

<style scoped>
/* Hover halus untuk kartu (tema hitam-putih) */
article {
  transition: transform 200ms ease, box-shadow 200ms ease;
}
article:hover {
  transform: translateY(-2px);
}
</style>
