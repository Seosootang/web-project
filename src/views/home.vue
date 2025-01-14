<script setup>
import { ref, onMounted } from "vue";
import api from "../api";

const packages = ref([]);

const fetchDataPackages = async () => {
  await api
    .get("/api/packages")
    .then((response) => {
      packages.value = response.data.data.data;
    })
    .catch((error) => {
      console.error("Error fetching packages:", error);
    });
};

onMounted(() => {
  fetchDataPackages();
});
</script>

<template>
  <div class="h-[55vh]">
    <img src="../assets/image1.png" alt="Main banner" class="w-full h-full object-cover" />
  </div>

  <!-- ARTICLE 1 -->
  <article class="h-[35vh] bg-primary flex items-center justify-center flex-col">
    <div class="text-white flex items-center justify-center flex-col">
      <h1 class="text-2xl font-bold">PRODUK DAN LAYANAN KAMI</h1>
      <p class="font-light">Rekomendasi pilihan produk dan layanan untuk perjalanan anda</p>
    </div>
    <div class="h-[50%] w-[45%] flex flex-row items-center justify-between">
      <div class="drop-shadow-xl shadow-xl hover:scale-105 duration-150 h-[10vh] w-[47%] relative rounded-md overflow-hidden">
        <img src="../assets/image2.png" alt="Paket Wisata" class="w-full h-full object-cover" />
        <h1 class="font-medium text-white absolute inset-0 flex items-center justify-center">Paket Wisata</h1>
      </div>
      <div class="drop-shadow-xl shadow-xl hover:scale-105 duration-150 h-[10vh] w-[47%] relative rounded-md overflow-hidden">
        <img src="../assets/image3.png" alt="Tour" class="w-full h-full object-cover" />
        <h1 class="font-medium text-white absolute inset-0 flex items-center justify-center">Tour</h1>
      </div>
    </div>
  </article>

  <!-- ARTICLE 2 -->
  <article class="h-[130vh] text-black flex items-center justify-center relative z-0">
    <img src="../assets/CANDI.jpeg" alt="Background" class="absolute inset-0 w-full h-full object-cover" />
    <div class="absolute inset-0 bg-white/20 backdrop-brightness-125"></div>
    <div class="w-[65%] h-[90%] relative z-10">
      <h1 class="text-3xl" style="font-family: 'Varela Round', serif">MAU LIBURAN KEMANA?</h1>
      <div class="grid grid-cols-4 gap-9 mt-4 text-white font-semibold" style="font-family: 'Kanit', serif">
        <!-- Dynamic content from database -->
        <div v-for="(packageItem, index) in packages" :key="index" class="h-[34vh] bg-white rounded-lg drop-shadow-xl shadow-xl hover:scale-105 duration-150 relative overflow-hidden">
          <img :src="packageItem.image1" :alt="packageItem.name" class="w-full h-full object-cover" />
          <div class="absolute bottom-0 left-0 p-3">
            <h1>PAKET WISATA</h1>
            <span class="leading-none mb-1 text-2xl">{{ packageItem.name }}</span>
            <router-link 
              :to="{ name: 'reservations.packagedetail', params: { id: packageItem.id } }" 
              class="bg-primary text-xs rounded-2xl font-light px-7 py-2">
              Detail
            </router-link>
          </div>
        </div>
      </div>
    </div>
  </article>

  <!-- ARTICLE 3 -->
  <article class="h-[47vh] bg-primary flex flex-row gap-7 items-center justify-center">
    <div class="text-white">
      <h1 class="text-4xl font-semibold mb-3">
        INSPIRASI DESTINASI <br />
        LIBURAN
      </h1>
      <p>Pilih destinasi liburan kamu dari bulan-bulan pilihan & musim-<br />musim menarik yang tak terlupakan</p>
    </div>
    <div class="flex flex-row items-center justify-center gap-7 text-white">
      <div class="drop-shadow-xl shadow-xl hover:scale-105 duration-150 relative h-[20vh] w-[30vw] rounded-lg overflow-hidden">
        <img src="../assets/InMonth.png" alt="Bulan" class="w-full h-full object-cover" />
        <div class="absolute inset-0 flex items-center justify-center flex-col">
          <img src="../assets/Clip path group.png" alt="Icon" />
          <h1 class="font-semibold">Bulan</h1>
        </div>
        <h1 class="absolute top-0 right-0 py-2 px-3 font-light text-sm">Lihat Tour &rarr;</h1>
      </div>
      <div class="drop-shadow-xl shadow-xl hover:scale-105 duration-150 relative h-[20vh] w-[30vw] rounded-lg overflow-hidden">
        <img src="../assets/InSession.png" alt="Musim" class="w-full h-full object-cover" />
        <div class="absolute inset-0 bg-black/60 backdrop-brightness-70"></div>
        <div class="absolute inset-0 z-10 flex items-center justify-center flex-col">
          <img src="../assets/Group.png" alt="Icon" />
          <h1 class="font-semibold">Musim</h1>
        </div>
        <h1 class="absolute top-0 right-0 py-2 px-3 font-light text-sm z-20">Lihat Tour &rarr;</h1>
      </div>
    </div>
  </article>

  <!-- ARTICLE 4 -->
  <article class="h-[45vh] bg-black flex items-center justify-center flex-col gap-4 relative">
    <img src="../assets/BROMOWIDE.jpg" alt="Bromo background" class="absolute inset-0 w-full h-full object-cover" />
    <div class="text-white text-center relative z-10">
      <h1 class="text-4xl font-semibold mb-3">TEMUKAN INSPIRASI UNTUK MENJELAJAHI INDONESIA</h1>
      <p class="text-sm">Masukkan alamat e-mail Anda untuk mendapatkan informasi menarik seputar destinasi liburan terbaik serta promo terbaik kami</p>
    </div>
    <div class="bg-white rounded-md py-1 px-2 shadow-sm shadow-white relative z-10">
      <i class="mr-1">&#9993;</i>
      <input type="email" placeholder="Masukkan alamat e-mail" class="placeholder:text-sm" />
      <button type="button" class="text-sm font-semibold">Kirim</button>
    </div>
  </article>

  <!-- ARTICLE 5 -->
  <article>
    <div class="container mx-auto px-4 py-8 max-w-6xl">
        <!-- Header -->
        <h1 class="text-4xl font-bold text-center mb-12">MENGAPA ANDA HARUS MEMILIH MOJOSKEM?</h1>

        <!-- Grid Container -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <!-- Left Column -->
            <div class="space-y-12">
                <!-- Section 1 -->
                <div class="text-right">
                    <h2 class="text-xl font-semibold mb-4">Penyedia Perjalanan Terbaik</h2>
                    <p class="text-gray-600 mb-4">
                        Kami berkomitmen menjadikan setiap liburan Anda penuh cerita berharga. Dengan perhatian penuh pada setiap memori dan pengalaman Anda, kami memastikan setiap langkah liburan Anda berjalan mulus dan penuh kebahagiaan.
                    </p>
                    <div class="w-full h-64 ml-auto overflow-hidden rounded-lg shadow-lg">
                        <img src="../assets/penyedia.png" alt="Keluarga di musim dingin" class="w-full h-full object-cover object-center">
                    </div>
                </div>

                <!-- Section 2 -->
                <div class="text-right">
                    <h2 class="text-xl font-semibold mb-4">Pelayanan Premium dan Personal</h2>
                    <p class="text-gray-600 mb-4">
                        Rasakan perbedaan dengan pelayanan terbaik dan personal yang kami tawarkan! Kami mengutamakan kebutuhan unik setiap pelanggan, memastikan setiap pengalaman Anda selama perjalanan terasa istimewa.
                    </p>
                    <div class="w-full h-64 ml-auto overflow-hidden rounded-lg shadow-lg">
                        <img src="../assets/pelayanan.png" alt="Keluarga di musim dingin" class="w-full h-full object-cover object-center">
                    </div>
                </div>

                <!-- Section 3 -->
                <div class="text-right">
                    <h2 class="text-xl font-semibold mb-4">Keamanan dan Kenyamanan Terjamin</h2>
                    <p class="text-gray-600 mb-4">
                        Kami memastikan setiap perjalanan Anda dipenuhi dengan rasa aman dan nyaman. Dengan perencanaan matang dan dukungan profesional, liburan Anda akan menjadi pengalaman yang tak terlupakan.
                    </p>
                    <div class="w-full h-64 ml-auto overflow-hidden rounded-lg shadow-lg">
                        <img src="../assets/kenyamanan dan keamanan.png" alt="Keluarga di musim dingin" class="w-full h-full object-cover object-center">
                    </div>
                </div>
            </div>

            <!-- Right Column -->
            <div class="space-y-12">
                <!-- Section 1 -->
                <div>
                    <h2 class="text-xl font-semibold mb-4">Layanan Agen Berpengalaman</h2>
                    <p class="text-gray-600 mb-4">
                        Dengan jam terbang yang tinggi, tim kami siap memberikan solusi terbaik untuk setiap kebutuhan Anda. Kepuasan pelanggan adalah prioritas kami, terbukti dari banyaknya pelanggan yang terus kembali setelah menggunakan jasa kami.
                    </p>
                    <div class="w-full h-64 overflow-hidden rounded-lg shadow-lg">
                        <img src="../assets/agent.png" alt="Keluarga di musim dingin" class="w-full h-full object-cover object-center">
                    </div>
                </div>

                <!-- Section 2 -->
                <div>
                    <h2 class="text-xl font-semibold mb-4">Nikmati Liburan Tanpa Beban</h2>
                    <p class="text-gray-600 mb-4">
                        Rasakan kebebasan sejati saat berlibur! Dengan pelayanan menyeluruh di setiap aspek, Anda tidak perlu repot mengurus berbagai hal. Biarkan kami yang menangani semua detail, sehingga Anda bisa fokus menikmati setiap momen berharga.
                    </p>
                    <div class="w-full h-64 overflow-hidden rounded-lg shadow-lg">
                        <img src="../assets/bebas.png" alt="Keluarga di musim dingin" class="w-full h-full object-cover object-center">
                    </div>
                </div>

                <!-- Section 3 -->
                <div>
                    <h2 class="text-xl font-semibold mb-4">Pilihan Fleksibel dan Menyenangkan</h2>
                    <p class="text-gray-600 mb-4">
                        Nikmati berbagai pilihan paket wisata yang dirancang untuk memenuhi kebutuhan unik Anda. Kami hadir untuk menghadirkan fleksibilitas dan kebahagiaan di setiap perjalanan.
                    </p>
                    <div class="w-full h-64 overflow-hidden rounded-lg shadow-lg">
                        <img src="../assets/fleksibel.png" alt="Keluarga di musim dingin" class="w-full h-full object-cover object-center">
                    </div>
                </div>
            </div>
        </div>
    </div>
</article>

</template>
