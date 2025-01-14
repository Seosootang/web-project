<template>
  <div>
    <nav class="bg-white h-16 w-[100vw] sticky top-0 z-10 flex items-center justify-between px-5">
      <div class="flex flex-row gap-8">
<img src="./assets/logomojoskem.png" class="w-[100px] " alt="">
      </div>
      <div class="border border-black rounded-md ">
        <i>&#128269;</i>
        <input type="text" placeholder="Cari" class="text-sm font-light w-96 ">
      </div>
      <div class="flex gap-1">
          <router-link 
              :to="{ name: 'home' }" 
              >
              <button
          class="hover:bg-white hover:text-primary duration-300 border-2 border-primary bg-primary rounded-lg px-4 py-1 text-white text-sm font-medium">Home</button>
            </router-link>
          <router-link 
              :to="{ name: 'admins.index' }" 
              >
              <button
          class="hover:bg-primary hover:text-white border-2 duration-300 border-primary bg-white rounded-lg px-4 py-1 text-primary text-sm font-medium">Admin Menu</button>
            </router-link>
      </div>
    </nav>
    <router-view></router-view>
    <footer class="bg-primary text-white flex items-center justify-between flex-col">
      <div class="text-white">
        <div style="border-bottom: 0.8px solid white;" class="pl-16 py-8 flex flex-row items-center justify-center w-[100%]">
          <!-- Tentang Kami -->
          <div class="w-1/3 flex flex-col items-center justify-center">
            <h1 class="text-md font-bold mb-4">TENTANG KAMI</h1>
            <p class="text-xs leading-relaxed">
              Travel MojoSkem adalah penyedia layanan perjalanan terpercaya yang berkomitmen memberikan pengalaman
              perjalanan yang tak terlupakan. Dengan berbagai paket wisata menarik, kami hadir untuk membantu Anda
              menjelajahi destinasi impian dengan mudah, nyaman, dan terjangkau.
            </p>
          </div>

          <!-- Media Sosial -->
          <div class="w-1/3 flex flex-col items-center justify-center">
            <h1 class="text-lg font-bold mb-4 text-md">MEDIA SOSIAL</h1>
            <ul class="space-y-2 text-xs">
              <li>📘 Facebook: Travel MojoSkem</li>
              <li>📸 Instagram: @travelmojoskem</li>
              <li>🎥 TikTok: Travel MojoSkem</li>
              <li>▶ YouTube: Travel MojoSkem</li>
            </ul>
          </div>

          <!-- Kontak Kami -->
          <div class="w-1/3 flex flex-col items-center justify-center">
            <h1 class="text-md font-bold mb-4">KONTAK KAMI</h1>
            <ul class="space-y-2 text-xs">
              <li>📞 +62 812 3388 7420</li>
              <li>📧 travelmojoskem@gmail.com</li>
              <li>📍 Jl. Besar Ijen No. 1, Malang</li>
            </ul>
          </div>
        </div>
      </div>

      <div class="bg-primary py-2 text-sm">
        <h1>&copy; Travel Mojoskem. Semua Hak Dilindungi</h1>
      </div>

    </footer>
  </div>
</template>