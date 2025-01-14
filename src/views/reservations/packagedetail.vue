<script setup>
// Import dependencies
import { ref, onMounted } from "vue";
import { useRouter, useRoute } from "vue-router";
import api from "../../api";

// Router and route initialization
const router = useRouter();
const route = useRoute();

// State for listing packages
const packages = ref([]);
const expandedPackages = ref(new Set());

// Fetch all packages
const fetchDataPackages = async () => {
  try {
    const response = await api.get("/api/packages");
    packages.value = response.data.data.data;
    // Fetch details for all packages
    await Promise.all(packages.value.map(pkg => fetchPackageDetails(pkg.id)));
  } catch (error) {
    console.error("Failed to fetch packages:", error);
  }
};

const fetchPackageDetails = async (id) => {
  try {
    const response = await api.get(`/api/packages/${id}`);
    // Update the package with full details
    const packageIndex = packages.value.findIndex(p => p.id === id);
    if (packageIndex !== -1) {
      packages.value[packageIndex] = { ...packages.value[packageIndex], ...response.data.data };
    }
  } catch (error) {
    console.error("Failed to fetch package details:", error);
  }
};

const togglePackageDetails = (packageId) => {
  if (expandedPackages.value.has(packageId)) {
    expandedPackages.value.delete(packageId);
  } else {
    expandedPackages.value.add(packageId);
  }
};

onMounted(() => {
  fetchDataPackages();
});

// Handle file input change
const handleFileChange = (e, imageRef) => {
  imageRef.value = e.target.files[0];
};

// Store new package
const storePackage = async () => {
  let formData = new FormData();
  formData.append("name", name.value);
  formData.append("image1", image1.value);
  formData.append("image2", image2.value);
  formData.append("image3", image3.value);
  formData.append("destination1", destination1.value);
  formData.append("destination2", destination2.value);
  formData.append("destination3", destination3.value);
  formData.append("destination4", destination4.value);
  formData.append("destination5", destination5.value);
  formData.append("destination6", destination6.value);
  formData.append("destination7", destination7.value);
  formData.append("destination8", destination8.value);
  formData.append("price", price.value);
  formData.append("content", content.value);
  formData.append("status", status.value);

  await api
    .post("/api/packages", formData)
    .then(() => {
      router.push({ path: "/packages" });
    })
    .catch((error) => {
      errors.value = error.response.data;
    });
};
</script>

<template>
  <div class="bg-gray-300 flex items-center justify-center flex-col gap-4">
    <!-- Tampilkan pesan loading atau error jika perlu -->
    <div v-if="!packages.length" class="text-center p-4">Loading packages...</div>

    <div v-for="packageItem in packages" :key="packageItem.id" class="w-[80%]">
      <!-- Package Header -->
      <article class="h-[20vh] bg-primary flex items-center justify-center mb-4 cursor-pointer" @click="togglePackageDetails(packageItem.id)">
        <div class="text-white w-[70%]">
          <h1 class="text-3xl font-semibold">
            {{ packageItem.name }}
          </h1>
          <br />
          <p class="font-light">{{ packageItem.content }}</p>
          <br />
          <p>
            mulai <span class="text-xl font-semibold">Rp {{ packageItem.price }}</span>/orang
          </p>
        </div>
      </article>

      <!-- Package Details -->
      <article v-if="expandedPackages.has(packageItem.id)" class="pt-4 w-full flex justify-center items-center bg-white rounded-lg mb-4">
        <div class="w-[80%] flex justify-center items-center flex-col gap-4">
          <div class="flex flex-col items-center justify-center gap-1">
            <img :src="packageItem.image1" class="w-96 h-96 object-cover object-center" alt="" />
            <div class="flex justify-center gap-1 items-center flex-row">
              <img :src="packageItem.image2" class="w-[190px] h-[190px] object-cover object-center" alt="" />
              <img :src="packageItem.image3" class="w-[190px] h-[190px] object-cover object-center" alt="" />
            </div>
          </div>
          <div class="bg-primary rounded-2xl px-6 py-2 text-white flex justify-center items-center">
            <h1 class="text-sm">Harga : Rp {{ packageItem.price }}</h1>
          </div>
          <div class="px-6 py-2 bg-slate-300">
            <h1>Destinasi</h1>
          </div>
          <div class="bg-gray-400 px-28 py-8 flex flex-col rounded-t-lg justify-between gap-28 items-center">
            <ul class="list-disc">
              <li>{{ packageItem.destination1 }}</li>
              <li>{{ packageItem.destination2 }}</li>
              <li>{{ packageItem.destination3 }}</li>
              <li>{{ packageItem.destination4 }}</li>
              <li v-if="packageItem.destination5">{{ packageItem.destination5 }}</li>
              <li v-if="packageItem.destination6">{{ packageItem.destination6 }}</li>
              <li v-if="packageItem.destination7">{{ packageItem.destination7 }}</li>
              <li v-if="packageItem.destination8">{{ packageItem.destination8 }}</li>
            </ul>
            <button class="rounded-3xl bg-primary text-white px-16 py-2">Pesan</button>
          </div>
        </div>
      </article>
    </div>

    <!-- Reservation and Features Section -->
    <article class="flex justify-between items-center w-[80%] mb-4">
      <div class="bg-gray-200 py-8 pr-36 rounded-lg my-2" style="box-shadow: 0px 0px 14px -2px rgba(0, 0, 0, 0.27); -webkit-box-shadow: 0px 0px 14px -2px rgba(0, 0, 0, 0.27); -moz-box-shadow: 0px 0px 14px -2px rgba(0, 0, 0, 0.27)">
        <!-- Reservation form content remains the same -->
        <form action="" class="flex items-start justify-start flex-col gap-2 pl-4">
          <h1 class="font-semibold text-2xl mb-4">Reservasi</h1>
          <p class="font-light mb-4 text-sm">
            Isi nama, no. telp dan alamat email agar <br />
            kami mudah menghubungi Anda.
          </p>
          <div class="flex justify-start items-start flex-col">
            <label for="nama">Nama</label>
            <input style="border: 0.8px solid black" type="text" class="rounded-sm shadow-2xl" />
          </div>
          <div class="flex justify-start items-start flex-col">
            <label for="nama">Pilih Paket</label>
            <input style="border: 0.8px solid black" type="text" disabled class="rounded-sm shadow-2xl" />
          </div>
          <div class="flex justify-start items-start flex-col">
            <label for="nama">Tanggal Mulai Tour</label>
            <input style="border: 0.8px solid black" type="text" class="rounded-sm shadow-2xl" />
          </div>
          <div class="flex justify-start items-start flex-col">
            <label for="nama">Waktu Penjemputan</label>
            <input style="border: 0.8px solid black" type="text" class="rounded-sm shadow-2xl" />
          </div>
          <div class="flex justify-start items-start flex-col">
            <label for="nama">E-mail</label>
            <input style="border: 0.8px solid black" type="text" class="rounded-sm shadow-2xl" />
          </div>
          <div class="flex justify-start items-start flex-col">
            <label for="nama">No.telp</label>
            <input style="border: 0.8px solid black" type="text" class="rounded-sm shadow-2xl" />
          </div>
          <button class="rounded-3xl bg-primary text-sm text-white px-8 py-1 mt-4">Pesan</button>
        </form>
      </div>

      <div class="grid grid-cols-2 gap-24">
        <!-- Features grid content remains the same -->
        <div class="flex justify-center items-center flex-col gap-2">
          <i class="fas fa-clock text-primary text-5xl"></i>
          <h1 class="font-semibold">Berpengalaman</h1>
          <p class="font-light text-xs text-center">
            Berpengalaman dari 2004 dalam <br />melayani paket wisata seluruh <br />
            Indonesia terutama paket wisata <br />
            malang
          </p>
        </div>
        <div class="flex justify-center items-center flex-col gap-2">
          <i class="fas fa-handshake text-primary text-5xl"></i>
          <h1 class="font-semibold">Terpercaya</h1>
          <p class="font-light text-xs text-center">
            Sudah di percaya melayani berbagai <br />
            instansi, perusahaan, serta rombongan <br />
            yang ingin liburan ke malang.
          </p>
        </div>
        <div class="flex justify-center items-center flex-col gap-2">
          <i class="fas fa-wallet text-primary text-5xl"></i>
          <h1 class="font-semibold">Terjangkau</h1>
          <p class="font-light text-xs text-center">
            Harga tour malang terjangkau dengan <br />
            transport, akomodasi & pelayanan <br />
            terbaik serta bisa request tempat wisata <br />
            malang Hits / favorite.
          </p>
        </div>
        <div class="flex justify-center items-center flex-col gap-2">
          <i class="fas fa-car text-primary text-5xl"></i>
          <h1 class="font-semibold">Terjamin</h1>
          <p class="font-light text-xs text-center">
            Kendaraan yang kami sediakan sangat <br />
            memadai demi menjamin keamanan <br />
            serta kenyamanan Anda selama <br />
            perjalanan.
          </p>
        </div>
      </div>
    </article>
  </div>
</template>