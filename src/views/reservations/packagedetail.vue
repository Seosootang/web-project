<script setup>
// Import dependencies
import { ref, onMounted } from "vue";
import { useRouter, useRoute } from "vue-router";
import api from "../../api";

// Router and route initialization
const router = useRouter();
const route = useRoute();

//define state
const customer = ref("");
const packagechoice = ref("");
const date = ref("");
const pickup = ref("");
const email = ref([]);
const phonenumber = ref([]);
const status = ref([]);
const errors = ref([]);

const storeReservation = async () => {
  //init formData
  let formData = new FormData();

  //assign state value to formData
  formData.append("customer", customer.value);
  formData.append("packagechoice", packagechoice.value);
  formData.append("date", date.value);
  formData.append("pickup", pickup.value);
  formData.append("email", email.value);
  formData.append("phonenumber", phonenumber.value);
  formData.append("status", status.value);

  //store data with API
  await api
    .post("/api/reservations", formData)
    .then(() => {
      // Tampilkan notifikasi berhasil
      alert("Reservasi berhasil dibuat!");

      // Redirect ke halaman reservations
      router.push({ path: "/reservations" });
    })
    .catch((error) => {
      errors.value = error.response.data;
    });
};

// State for a single package
const packageDetail = ref(null);
const packageId = route.params.id; // Get package ID from the route

// Fetch package details
const fetchPackageDetail = async () => {
  try {
    const response = await api.get(`/api/packages/${packageId}`);
    packageDetail.value = response.data.data; // Set the detailed package data
  } catch (error) {
    console.error("Failed to fetch package details:", error);
  }
};

// Fetch data on component mount
onMounted(() => {
  if (packageId) {
    fetchPackageDetail();
  } else {
    console.error("No package ID provided in the route.");
    router.push("/"); // Redirect to home if no packageId is found
  }
});
</script>

<template>
  <div class="bg-gray-300 flex items-center justify-center flex-col gap-4">
    <!-- Display loading or error message -->
    <div v-if="!packageDetail" class="text-center p-4">Loading package details...</div>

    <!-- Display package details -->
    <div v-else class="w-[80%]">
      <article class="h-[40vh] bg-primary flex items-center justify-center mb-4">
        <div class="text-white w-[70%]">
          <h1 class="text-3xl font-semibold">
            {{ packageDetail.name }}
          </h1>
          <br />
          <p class="font-light">{{ packageDetail.content }}</p>
          <br />
          <p>
            mulai <span class="text-xl font-semibold">Rp {{ packageDetail.price }}</span
            >/orang
          </p>
        </div>
      </article>

      <div class="pt-4 w-full flex justify-center items-center bg-white rounded-lg mb-4">
        <div class="w-[80%] flex justify-center items-center flex-col gap-4">
          <div class="flex flex-col items-center justify-center gap-1">
            <img :src="packageDetail.image1" class="w-96 h-96 object-cover object-center" alt="" />
            <div class="flex justify-center gap-1 items-center flex-row">
              <img :src="packageDetail.image2" class="w-[190px] h-[190px] object-cover object-center" alt="" />
              <img :src="packageDetail.image3" class="w-[190px] h-[190px] object-cover object-center" alt="" />
            </div>
          </div>
          <div class="bg-primary rounded-2xl px-6 py-2 text-white flex justify-center items-center">
            <h1 class="text-sm">Harga : Rp {{ packageDetail.price }}</h1>
          </div>
          <div class="px-6 py-2 bg-slate-300">
            <h1>Destinasi</h1>
          </div>
          <div class="bg-gray-400 px-28 py-8 flex flex-col rounded-t-lg justify-between gap-28 items-center">
            <ul class="list-disc">
              <li>{{ packageDetail.destination1 }}</li>
              <li>{{ packageDetail.destination2 }}</li>
              <li>{{ packageDetail.destination3 }}</li>
              <li>{{ packageDetail.destination4 }}</li>
              <li v-if="packageDetail.destination5">{{ packageDetail.destination5 }}</li>
              <li v-if="packageDetail.destination6">{{ packageDetail.destination6 }}</li>
              <li v-if="packageDetail.destination7">{{ packageDetail.destination7 }}</li>
              <li v-if="packageDetail.destination8">{{ packageDetail.destination8 }}</li>
            </ul>
            <button class="rounded-3xl bg-primary text-white px-16 py-2">Pesan</button>
          </div>
        </div>
      </div>
    </div>

    <!-- Reservation and Features Section -->
    <article class="flex justify-between items-center w-[80%] mb-4">
      <div class="bg-gray-200 py-8 pr-36 rounded-lg my-2" style="box-shadow: 0px 0px 14px -2px rgba(0, 0, 0, 0.27); -webkit-box-shadow: 0px 0px 14px -2px rgba(0, 0, 0, 0.27); -moz-box-shadow: 0px 0px 14px -2px rgba(0, 0, 0, 0.27)">
        <!-- Reservation form content remains the same -->
        <form @submit.prevent="storeReservation" class="flex items-start justify-start flex-col gap-2 pl-4">
          <h1 class="font-semibold text-2xl mb-4">Reservasi</h1>
          <p class="font-light mb-4 text-sm">
            Isi nama, no. telp dan alamat email agar <br />
            kami mudah menghubungi Anda.
          </p>
          <div class="flex justify-start items-start flex-col">
            <label for="nama">Nama</label>
            <input style="border: 0.8px solid black" v-model="customer" type="text" class="rounded-sm shadow-2xl" />
          </div>
          <div class="flex justify-start items-start flex-col">
            <label for="nama">Pilih Paket</label>
            <input style="border: 0.8px solid black" v-model="packagechoice" type="text" class="rounded-sm shadow-2xl" />
          </div>
          <div class="flex justify-start items-start flex-col">
            <label for="nama">Tanggal Mulai Tour</label>
            <input style="border: 0.8px solid black" v-model="date" type="text" class="rounded-sm shadow-2xl" />
          </div>
          <div class="flex justify-start items-start flex-col">
            <label for="nama">Waktu Penjemputan</label>
            <input style="border: 0.8px solid black" v-model="pickup" type="text" class="rounded-sm shadow-2xl" />
          </div>
          <div class="flex justify-start items-start flex-col">
            <label for="nama">E-mail</label>
            <input style="border: 0.8px solid black" v-model="email" type="text" class="rounded-sm shadow-2xl" />
          </div>
          <div class="flex justify-start items-start flex-col">
            <label for="nama">No.telp</label>
            <input style="border: 0.8px solid black" v-model="phonenumber" type="text" class="rounded-sm shadow-2xl" />
          </div>
          <button type="submit" class="rounded-3xl bg-primary text-sm text-white px-8 py-1 mt-4">Pesan</button>
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