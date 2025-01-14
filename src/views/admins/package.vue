<script setup>
import { ref, onMounted, onBeforeUnmount } from "vue";
import api from "../../api";

// State untuk data dan formulir
const packages = ref([]);
const loading = ref(true);
const showModal = ref(false);
const showDeleteModal = ref(false);
const selectedPackageId = ref(null);

// State untuk atribut paket
const image1 = ref("");
const image2 = ref("");
const image3 = ref("");
const name = ref("");
const destination1 = ref("");
const destination2 = ref("");
const destination3 = ref("");
const destination4 = ref("");
const destination5 = ref("");
const destination6 = ref("");
const destination7 = ref("");
const destination8 = ref("");
const price = ref("");
const content = ref("");
const status = ref("");
const errors = ref([]);

// Fungsi untuk menangani perubahan file
const handleFileChange = (e, imageRef) => {
  imageRef.value = e.target.files[0];
};

// Fungsi untuk membuat paket baru
const storePackage = async () => {
  let formData = new FormData();

  // Tambahkan data ke FormData
  formData.append("image1", image1.value);
  formData.append("image2", image2.value);
  formData.append("image3", image3.value);
  formData.append("name", name.value);
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

  // Simpan data ke API
  try {
    await api.post('/api/packages', formData);
    fetchDataPackages(); // Perbarui data setelah sukses
    closeModal(); // Tutup modal
  } catch (error) {
    errors.value = error.response?.data || ["An error occurred."];
  }
};

// Fungsi untuk mendapatkan data paket
const fetchDataPackages = async () => {
  try {
    loading.value = true;
    const response = await api.get("/api/packages");
    packages.value = response.data.data.data;
  } catch (error) {
    console.error("Error fetching packages:", error);
  } finally {
    loading.value = false;
  }
};

// Fungsi untuk menghapus paket
const deletePackage = async (id) => {
  await api.delete(`/api/packages/${id}`).then(() => {
    fetchDataPackages();
  });
};

// Lifecycle hooks
onMounted(() => {
  fetchDataPackages();
});

// Fungsi modal
const openModal = (type, id = null) => {
  if (type === "edit") {
    selectedPackageId.value = id;
  }
  showModal.value = true;
};

const closeModal = () => {
  showModal.value = false;
  selectedPackageId.value = null;
};

const openDeleteModal = (id) => {
  selectedPackageId.value = id;
  showDeleteModal.value = true;
};

const closeDeleteModal = () => {
  showDeleteModal.value = false;
  selectedPackageId.value = null;
};
</script>


<template>
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Mojoskem Admin - Paket Tour</title>
  </head>
  <body class="bg-gray-100">
    <!-- Image Preview Modal -->
    <div id="imagePreviewModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden overflow-y-auto h-full w-full flex items-center justify-center z-50 p-4">
      <div class="relative max-w-4xl w-full">
        <button @click="closeImagePreview()" class="absolute top-0 right-0 -mt-4 -mr-4 bg-white rounded-full p-2 hover:bg-gray-100 z-10">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
          </svg>
        </button>
        <img id="previewImage" src="" alt="Preview" class="max-h-[80vh] w-auto mx-auto rounded-lg shadow-lg" />
      </div>
    </div>

    <!-- Package Modal/Popup -->
    <div v-if="showModal" id="packageModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden overflow-y-auto h-full w-full flex items-center justify-center z-40 p-4">
      <div class="relative p-4 sm:p-5 border w-full max-w-[95%] sm:max-w-lg shadow-lg rounded-md bg-white">
        <h3 class="text-lg font-medium mb-4">Tambahkan paket baru</h3>
        <form @submit.prevent="storePackage">
          <div class="space-y-4">
            <div>
              <label class="block text-gray-700 text-sm font-bold mb-2">Nama Paket</label>
              <input type="text" v-model="packageName" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" />
              <div v-if="errors.name" class="text-red-500 text-sm">{{ errors.name[0] }}</div>
            </div>
            <div>
              <label class="block text-gray-700 text-sm font-bold mb-2">Gambar</label>
              <div class="mt-1 flex justify-center px-4 py-4 border-2 border-gray-300 border-dashed rounded-md">
                <div class="space-y-1 text-center">
                  <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                    <path
                      d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02"
                      stroke-width="2"
                      stroke-linecap="round"
                      stroke-linejoin="round"
                    />
                  </svg>
                  <div class="flex text-sm text-gray-600 justify-center">
                    <label class="relative cursor-pointer bg-white rounded-md font-medium text-indigo-600 hover:text-indigo-500">
                      <span>Upload a file</span>
                      <input id="file-upload" name="file-upload" type="file" class="sr-only" />
                    </label>
                  </div>
                </div>
              </div>
            </div>
            <div>
              <label class="block text-gray-700 text-sm font-bold mb-2">Destinasi 1</label>
              <input type="text" v-model="destination1" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" />
              <div v-if="errors.destination" class="text-red-500 text-sm">{{ errors.destination[0] }}</div>
            </div>
            <div>
              <label class="block text-gray-700 text-sm font-bold mb-2">Biaya</label>
              <input type="text" id="price" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" />
            </div>
            <div>
              <label class="block text-gray-700 text-sm font-bold mb-2">Deskripsi</label>
              <textarea id="description" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline resize-none" rows="4"></textarea>
            </div>
            <div>
              <label class="block text-gray-700 text-sm font-bold mb-2">Status</label>
              <select id="status" class="shadow border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                <option>Active</option>
                <option>Inactive</option>
              </select>
            </div>
          </div>
          <div class="flex items-center justify-end mt-4 space-x-2">
            <button type="button" @click="closeModal" class="bg-gray-500 text-white px-4 py-2 rounded-md hover:bg-gray-600">Cancel</button>
            <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded-md hover:bg-green-600">Save</button>
          </div>
        </form>
      </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <tr v-for="pkg in packages" :key="pkg.id">
      <div v-if="showDeleteModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full flex items-center justify-center z-40">
        <div class="relative p-4 w-full max-w-md mx-auto bg-white rounded-lg shadow-lg">
          <h3 class="text-lg font-medium mb-4">Konfirmasi Hapus</h3>
          <p class="text-gray-500 mb-4">Apakah anda yakin ingin menghapus paket ini?</p>
          <div class="flex justify-end space-x-2">
            <button @click="closeDeleteModal" class="px-4 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600">Cancel</button>
            <button @click="deletePackage(pkg.id)" class="px-4 py-2 bg-red-500 text-white rounded-md hover:bg-red-600">Delete</button>
          </div>
        </div>
      </div>
    </tr>

    <div class="flex flex-col sm:flex-row min-h-screen">
      <!-- Sidebar -->
      <div class="w-full sm:w-56 md:w-64 bg-slate-800 text-white">
        <div class="flex justify-between items-center p-4 border-b border-slate-500">
          <div class="font-bold text-base sm:text-lg">MOJOSKEM ADMIN</div>
          <button class="sm:hidden text-white" id="menuToggle">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
            </svg>
          </button>
        </div>
        <nav class="mt-4 hidden sm:block" id="navigation">
          <a href="index.html" class="block px-4 py-3 hover:bg-slate-700 transition-colors">Dashboard</a>
          <a href="paket.html" class="block px-4 py-3 hover:bg-slate-700 transition-colors">Paket Tour</a>

          <!-- Bookings Menu with Submenu -->
          <div class="relative">
            <button class="w-full px-4 py-3 flex items-center justify-between hover:bg-slate-700 transition-colors" @click="toggleSubmenu('bookingsSubmenu')">
              <span>Bookings</span>
              <svg id="bookingsArrow" class="w-4 h-4 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
              </svg>
            </button>
            <div id="bookingsSubmenu" class="hidden pl-4 bg-slate-900">
              <a href="booking-paket.html" class="block px-4 py-2 hover:bg-slate-700 transition-colors">Booking Paket</a>
              <a href="booking-mobil.html" class="block px-4 py-2 hover:bg-slate-700 transition-colors">Booking Mobil</a>
              <a href="booking-bis.html" class="block px-4 py-2 hover:bg-slate-700 transition-colors">Booking Bis</a>
            </div>
          </div>

          <a href="users.html" class="block px-4 py-3 hover:bg-slate-700 transition-colors">Users</a>
        </nav>
      </div>

      <!-- Main Content -->
      <div class="flex-1 flex flex-col overflow-hidden">
        <header class="bg-white shadow">
          <div class="px-4 sm:px-6 py-4">
            <h1 class="text-lg sm:text-xl font-semibold text-gray-800">Paket Tour</h1>
          </div>
        </header>

        <div class="flex-1 overflow-auto p-4 sm:p-6">
          <div class="mb-4">
            <button @click="openModal('add')" class="bg-green-500 text-white px-4 py-2 rounded-md hover:bg-green-600 transition-colors flex items-center">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
              </svg>
              Tambahkan paket
            </button>
          </div>

          <!-- Mobile Card View -->
          <div class="block sm:hidden space-y-4">
            <div class="bg-white rounded-lg shadow p-4">
              <div class="flex items-center space-x-4">
                <tr>
                  <img src="./assets/bromosunrise.jpg" alt="Tour Image" class="h-16 w-16 rounded-md cursor-pointer" @click="openImagePreview(this.src)" />
                  <div class="flex-1">
                    <h3 class="font-medium">Bromo Sunrise Tour</h3>
                    <div class="mt-2 flex space-x-2">
                      <button @click="openModal('edit', pkg.id)" class="bg-blue-500 text-white px-2 py-1 rounded text-sm hover:bg-blue-600">Edit</button>
                      <button @click="openDeleteModal(pkg.id)" class="bg-red-500 text-white px-2 py-1 rounded text-sm hover:bg-red-600">Delete</button>
                    </div>
                    <p class="text-sm text-gray-500">East Java</p>
                    <p class="text-sm font-medium">Rp 1.500.000</p>
                    <p class="text-sm text-gray-500 mt-2 break-words">
                      Paket wisata malang 1 hari murah dan terbaik 2024. Harga paket one day tour malang murah keliling ke tempat wisata malang hits dan yang terbaru. Liburan ke malang seharian pasti mengesankan..
                    </p>
                    <span class="inline-flex mt-2 px-2 text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Active</span>
                  </div>
                </tr>
              </div>
            </div>
          </div>

          <!-- Desktop Table View -->
          <div class="hidden sm:block bg-white rounded-lg shadow">
            <div class="overflow-x-auto">
              <table class="min-w-full">
                <thead>
                  <tr class="bg-gray-50 border-b">
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Gambar</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Destinasi</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider hidden lg:table-cell">Biaya</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Deskripsi</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                  </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                  <tr v-for="(pkg, index) in packages" :key="pkg.id" class="border-b hover:bg-gray-50">
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ pkg.name }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                      <img :src="pkg.image1" :alt="pkg.name" class="h-10 w-10 rounded-md cursor-pointer hover:opacity-80 transition-opacity" @click="openImagePreview(this.src)" />
                      <img :src="pkg.image2" :alt="pkg.name" class="h-10 w-10 rounded-md cursor-pointer hover:opacity-80 transition-opacity" @click="openImagePreview(this.src)" />
                      <img :src="pkg.image3" :alt="pkg.name" class="h-10 w-10 rounded-md cursor-pointer hover:opacity-80 transition-opacity" @click="openImagePreview(this.src)" />
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                      <ul>
                        <li v-for="(destination, i) in [pkg.destination1, pkg.destination2, pkg.destination3, pkg.destination4, pkg.destination5, pkg.destination6, pkg.destination7, pkg.destination8]" :key="i">
                          {{ destination }}
                        </li>
                      </ul>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 hidden lg:table-cell">{{ pkg.price }}</td>
                    <td class="px-6 py-4 text-sm text-gray-900">{{ pkg.content }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">
                      <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">{{ pkg.status }}</span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                      <button @click="openModal('edit', 1)" class="text-blue-600 hover:text-blue-900 mr-3">Edit</button>
                      <button @click="openDeleteModal(pkg.id)" class="text-red-600 hover:text-red-900">Delete</button>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </body>
</template>
