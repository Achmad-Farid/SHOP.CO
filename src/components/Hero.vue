<script setup></script>

<template>
  <section class="relative w-full bg-[#F2F0F1]">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
      <div class="grid items-center gap-10 lg:grid-cols-12">
        <!-- Left: Text -->
        <div class="lg:col-span-6 space-y-6">
          <h1 class="text-4xl leading-tight font-extrabold text-black sm:text-5xl md:text-6xl">
            <span class="block">FIND CLOTHES</span>
            <span class="block">THAT MATCHES</span>
            <span class="inline-block relative">YOUR STYLE</span>
          </h1>

          <p class="max-w-xl text-base md:text-lg text-black/70">Browse through our diverse range of meticulously crafted garments, designed to bring out your individuality and cater to your sense of style.</p>

          <div class="flex items-center gap-4 pt-2">
            <a
              href="#shop"
              class="group inline-flex items-center justify-center rounded-2xl bg-black px-6 py-3 text-white font-semibold shadow-md ring-1 ring-black/10 transition hover:scale-[1.02] hover:shadow-lg active:scale-95 focus:outline-none focus-visible:ring-2 focus-visible:ring-offset-2 focus-visible:ring-black"
            >
              Shop Now
              <svg class="ml-2 h-4 w-4 transition-transform group-hover:translate-x-0.5" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                <path d="M13.172 12 8.222 7.05l1.414-1.414L16 12l-6.364 6.364-1.414-1.414z" />
              </svg>
            </a>
          </div>

          <!-- Stats -->
          <div class="grid grid-cols-2 sm:grid-cols-3 gap-6 pt-6 max-w-2xl">
            <div class="group">
              <p class="text-2xl md:text-3xl font-extrabold text-black tracking-tight">200+</p>
              <p class="text-sm text-black/60 group-hover:text-black transition">International Brands</p>
            </div>
            <div class="group">
              <p class="text-2xl md:text-3xl font-extrabold text-black tracking-tight">2,000+</p>
              <p class="text-sm text-black/60 group-hover:text-black transition">High-Quality Products</p>
            </div>
            <div class="group">
              <p class="text-2xl md:text-3xl font-extrabold text-black tracking-tight">30,000+</p>
              <p class="text-sm text-black/60 group-hover:text-black transition">Happy Customers</p>
            </div>
          </div>
        </div>

        <!-- Right: Image -->
        <div class="lg:col-span-6">
          <img src="../assets/model.png" class="h-full w-full" loading="lazy" decoding="async" />
        </div>
      </div>
    </div>

    <!-- Subtle noise texture (monochrome) -->
    <div class="pointer-events-none absolute inset-0 opacity-[.03] mix-blend-multiply [background-image:radial-gradient(#000_1px,transparent_1px)] [background-size:12px_12px]"></div>
    <section class="w-full bg-black py-12">
      <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between md:gap-20 items-center text-white">
          <img src="../assets/brands/versace.png" class="h-8 w-auto object-contain" loading="lazy" decoding="async" />
          <img src="../assets/brands/gucci.png" class="h-8 w-auto object-contain" loading="lazy" decoding="async" />
          <img src="../assets/brands/prada.png" class="h-8 w-auto object-contain" loading="lazy" decoding="async" />
          <img src="../assets/brands/kalvin.png" class="h-8 w-auto object-contain" loading="lazy" decoding="async" />
          <img src="../assets/brands/zara.png" class="h-8 w-auto object-contain" loading="lazy" decoding="async" />
        </div>
      </div>
    </section>
  </section>
</template>
