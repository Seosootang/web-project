<script setup>
import { ref, onMounted } from "vue";
import api from "../../api";

// State untuk data dan formulir
const packages = ref([]);
const loading = ref(true);
const showModal = ref(false);
const showDeleteModal = ref(false);
const showImagePreview = ref(false);
const previewImageSrc = ref('');
const modalMode = ref('add'); // 'add' or 'edit'
const selectedPackageId = ref(null);

// State untuk atribut paket
const image1 = ref(null);
const image2 = ref(null);
const image3 = ref(null);
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
const status = ref("Active");
const errors = ref({});

// Handle file inputs
const handleFileInput = (event, imageNumber) => {
  const file = event.target.files[0];
  if (file) {
    switch(imageNumber) {
      case 1:
        image1.value = file;
        break;
      case 2:
        image2.value = file;
        break;
      case 3:
        image3.value = file;
        break;
    }
  }
};

const resetForm = () => {
  image1.value = null;
  image2.value = null;
  image3.value = null;
  name.value = "";
  destination1.value = "";
  destination2.value = "";
  destination3.value = "";
  destination4.value = "";
  destination5.value = "";
  destination6.value = "";
  destination7.value = "";
  destination8.value = "";
  price.value = "";
  content.value = "";
  status.value = "Active";
  errors.value = {};
};

const openModal = (mode, packageId = null) => {
  modalMode.value = mode;
  if (mode === 'edit' && packageId) {
    selectedPackageId.value = packageId;
    const pkg = packages.value.find(p => p.id === packageId);
    if (pkg) {
      name.value = pkg.name;
      destination1.value = pkg.destination1;
      destination2.value = pkg.destination2;
      destination3.value = pkg.destination3;
      destination4.value = pkg.destination4;
      destination5.value = pkg.destination5;
      destination6.value = pkg.destination6;
      destination7.value = pkg.destination7;
      destination8.value = pkg.destination8;
      price.value = pkg.price;
      content.value = pkg.content;
      status.value = pkg.status;
    }
  } else {
    resetForm();
  }
  showModal.value = true;
};

const closeModal = () => {
  showModal.value = false;
  resetForm();
};

const openDeleteModal = (packageId) => {
  selectedPackageId.value = packageId;
  showDeleteModal.value = true;
};

const closeDeleteModal = () => {
  showDeleteModal.value = false;
  selectedPackageId.value = null;
};

const openImagePreview = (src) => {
  previewImageSrc.value = src;
  showImagePreview.value = true;
};

const closeImagePreview = () => {
  showImagePreview.value = false;
  previewImageSrc.value = '';
};

const storePackage = async () => {
  try {
    let formData = new FormData();

    if (image1.value) formData.append("image1", image1.value);
    if (image2.value) formData.append("image2", image2.value);
    if (image3.value) formData.append("image3", image3.value);
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

    await api.post("/api/packages", formData, {
      headers: {
        'Content-Type': 'multipart/form-data'
      }
    });
    
    await fetchDataPackages();
    closeModal();
  } catch (error) {
    errors.value = error.response?.data?.errors || { general: ["An error occurred."] };
  }
};

const updatePackage = async () => {
  if (!selectedPackageId.value) return;

  try {
    let formData = new FormData();

    if (image1.value) formData.append("image1", image1.value);
    if (image2.value) formData.append("image2", image2.value);
    if (image3.value) formData.append("image3", image3.value);
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
    formData.append("_method", "PATCH");

    await api.post(`/api/packages/${selectedPackageId.value}`, formData, {
      headers: {
        'Content-Type': 'multipart/form-data'
      }
    });
    
    await fetchDataPackages();
    closeModal();
  } catch (error) {
    errors.value = error.response?.data?.errors || { general: ["An error occurred."] };
  }
};

const deletePackage = async (id) => {
  try {
    await api.delete(`/api/packages/${id}`);
    await fetchDataPackages();
    closeDeleteModal();
  } catch (error) {
    console.error("Error deleting package:", error);
  }
};

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

// Mobile menu toggle
const isMenuOpen = ref(false);
const toggleMenu = () => {
  isMenuOpen.value = !isMenuOpen.value;
};

onMounted(() => {
  fetchDataPackages();
});

</script>

<template>
    <body class="bg-gray-100">
      <!-- Image Preview Modal -->
      <div v-if="showImagePreview" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full flex items-center justify-center z-50 p-4">
        <div class="relative max-w-4xl w-full">
          <button @click="closeImagePreview" class="absolute top-0 right-0 -mt-4 -mr-4 bg-white rounded-full p-2 hover:bg-gray-100 z-10">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
          </button>
          <img :src="previewImageSrc" alt="Preview" class="max-h-[80vh] w-auto mx-auto rounded-lg shadow-lg" />
        </div>
      </div>
  
      <!-- Package Modal/Popup -->
      <div v-if="showModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full flex items-start justify-center z-40 p-4">
        <div class="relative p-4 sm:p-5 border w-full max-w-[95%] sm:max-w-lg shadow-lg rounded-md bg-white">
          <h3 class="text-lg font-medium mb-4">{{ modalMode === 'add' ? 'Tambahkan paket baru' : 'Edit paket' }}</h3>
          <form @submit.prevent="modalMode === 'add' ? storePackage() : updatePackage()">
            <div class="space-y-4">
              <div>
                <label class="block text-gray-700 text-sm font-bold mb-2">Nama Paket</label>
                <input 
                  type="text" 
                  v-model="name"
                  class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" 
                />
                <div v-if="errors.name" class="text-red-500 text-sm">{{ errors.name[0] }}</div>
              </div>
  
              <div>
                <label class="block text-gray-700 text-sm font-bold mb-2">Gambar</label>
                <div class="mt-1 flex justify-center px-4 py-4 border-2 border-gray-300 border-dashed rounded-md">
                  <div class="space-y-1 text-center">
                    <div class="flex flex-col space-y-2">
                      <label class="relative cursor-pointer bg-white rounded-md font-medium text-indigo-600 hover:text-indigo-500">
                        <span>Upload Image 1</span>
                        <input type="file" @change="(e) => handleFileInput(e, 1)" class="sr-only" accept="image/*" />
                      </label>
                      <label class="relative cursor-pointer bg-white rounded-md font-medium text-indigo-600 hover:text-indigo-500">
                        <span>Upload Image 2</span>
                        <input type="file" @change="(e) => handleFileInput(e, 2)" class="sr-only" accept="image/*" />
                      </label>
                      <label class="relative cursor-pointer bg-white rounded-md font-medium text-indigo-600 hover:text-indigo-500">
                        <span>Upload Image 3</span>
                        <input type="file" @change="(e) => handleFileInput(e, 3)" class="sr-only" accept="image/*" />
                      </label>
                    </div>
                  </div>
                </div>
              </div>
  
              <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                  <label class="block text-gray-700 text-sm font-bold mb-2">Destinasi 1</label>
                  <input type="text" v-model="destination1" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" />
                </div>
                <div>
                  <label class="block text-gray-700 text-sm font-bold mb-2">Destinasi 2</label>
                  <input type="text" v-model="destination2" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" />
                </div>
                <div>
                  <label class="block text-gray-700 text-sm font-bold mb-2">Destinasi 3</label>
                  <input type="text" v-model="destination3" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" />
                </div>
                <div>
                  <label class="block text-gray-700 text-sm font-bold mb-2">Destinasi 4</label>
                  <input type="text" v-model="destination4" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" />
                </div>
                <div>
                  <label class="block text-gray-700 text-sm font-bold mb-2">Destinasi 5</label>
                  <input type="text" v-model="destination5" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" />
                </div>
                <div>
                  <label class="block text-gray-700 text-sm font-bold mb-2">Destinasi 6</label>
                  <input type="text" v-model="destination6" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" />
                </div>
                <div>
                  <label class="block text-gray-700 text-sm font-bold mb-2">Destinasi 7</label>
                  <input type="text" v-model="destination7" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" />
                </div>
                <div>
                  <label class="block text-gray-700 text-sm font-bold mb-2">Destinasi 8</label>
                  <input type="text" v-model="destination8" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" />
                </div>
              </div>
  
              <div>
                <label class="block text-gray-700 text-sm font-bold mb-2">Biaya</label>
                <input 
                  type="text" 
                  v-model="price"
                  class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" 
                />
              </div>
  
              <div>
                <label class="block text-gray-700 text-sm font-bold mb-2">Deskripsi</label>
                <textarea 
                  v-model="content"
                  class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline resize-none" 
                  rows="4"
                ></textarea>
              </div>
  
              <div>
                <label class="block text-gray-700 text-sm font-bold mb-2">Status</label>
                <select 
                  v-model="status"
                  class="shadow border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                >
                  <option>Active</option>
                  <option>Inactive</option>
                </select>
              </div>
            </div>
  
            <div class="flex items-center justify-end mt-4 space-x-2">
              <button type="button" @click="closeModal" class="bg-gray-500 text-white px-4 py-2 rounded-md hover:bg-gray-600">Cancel</button>
              <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded-md hover:bg-green-600">
                {{ modalMode === 'add' ? 'Save' : 'Update' }}
              </button>
            </div>
          </form>
        </div>
      </div>
  
      <!-- Delete Confirmation Modal -->
      <div v-if="showDeleteModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full flex items-center justify-center z-40">
        <div class="relative p-4 w-full max-w-md mx-auto bg-white rounded-lg shadow-lg">
          <h3 class="text-lg font-medium mb-4">Konfirmasi Hapus</h3>
          <p class="text-gray-500 mb-4">Apakah anda yakin ingin menghapus paket ini?</p>
          <div class="flex justify-end space-x-2">
            <button @click="closeDeleteModal" class="px-4 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600">Cancel</button>
            <button @click="deletePackage(selectedPackageId)" class="px-4 py-2 bg-red-500 text-white rounded-md hover:bg-red-600">Delete</button>
          </div>
        </div>
      </div>
  
      <div class="flex flex-col sm:flex-row min-h-screen">
        <!-- Sidebar -->
        <div class="w-full sm:w-56 md:w-64 bg-slate-800 text-white">
          <div class="flex justify-between items-center p-4 border-b border-slate-500">
            <div class="font-bold text-base sm:text-lg">MOJOSKEM ADMIN</div>
            <button class="sm:hidden text-white" @click="toggleMenu">
              <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
              </svg>
            </button>
          </div>
          <nav class="mt-4" :class="{ 'hidden sm:block': !isMenuOpen }">
            <router-link :to="{ name: 'admins.index' }" class="block px-4 py-3 hover:bg-slate-700 transition-colors">
              Dashboard
            </router-link>
            <router-link :to="{ name: 'admins.package' }" class="block px-4 py-3 hover:bg-slate-700 transition-colors">
              Package
            </router-link>
            <router-link :to="{ name: 'admins.reservation' }" class="block px-4 py-2 hover:bg-slate-700 transition-colors">
              Reservation
            </router-link>
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
  
            <!-- Loading State -->
            <div v-if="loading" class="flex justify-center items-center h-64">
              <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-gray-900"></div>
            </div>
  
            <!-- Mobile Card View -->
            <div v-else class="block sm:hidden space-y-4">
              <div v-for="pkg in packages" :key="pkg.id" class="bg-white rounded-lg shadow p-4">
                <div class="flex items-center space-x-4">
                  <div class="flex-shrink-0">
                    <img :src="pkg.image1" :alt="pkg.name" class="h-16 w-16 rounded-md cursor-pointer" @click="openImagePreview(pkg.image1)" />
                  </div>
                  <div class="flex-1">
                    <h3 class="font-medium">{{ pkg.name }}</h3>
                    <p class="text-sm text-gray-500">{{ pkg.destination1 }}</p>
                    <p class="text-sm font-medium">{{ pkg.price }}</p>
                    <p class="text-sm text-gray-500 mt-2 break-words">{{ pkg.content }}</p>
                    <span class="inline-flex mt-2 px-2 text-xs leading-5 font-semibold rounded-full" 
                      :class="pkg.status === 'Active' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'">
                      {{ pkg.status }}
                    </span>
                    <div class="mt-2 flex space-x-2">
                      <button @click="openModal('edit', pkg.id)" class="bg-blue-500 text-white px-2 py-1 rounded text-sm hover:bg-blue-600">Edit</button>
                      <button @click="openDeleteModal(pkg.id)" class="bg-red-500 text-white px-2 py-1 rounded text-sm hover:bg-red-600">Delete</button>
                    </div>
                  </div>
                </div>
              </div>
            </div>
  
            <!-- Desktop Table View -->
            <div v-else class="hidden sm:block bg-white rounded-lg shadow">
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
                  <tr v-for="pkg in packages" :key="pkg.id" class="border-b hover:bg-gray-50">
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ pkg.name }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">
                      <div class="flex space-x-2">
                        <img v-if="pkg.image1" :src="pkg.image1" :alt="pkg.name" class="h-10 w-10 rounded-md cursor-pointer hover:opacity-80 transition-opacity" @click="openImagePreview(pkg.image1)" />
                        <img v-if="pkg.image2" :src="pkg.image2" :alt="pkg.name" class="h-10 w-10 rounded-md cursor-pointer hover:opacity-80 transition-opacity" @click="openImagePreview(pkg.image2)" />
                        <img v-if="pkg.image3" :src="pkg.image3" :alt="pkg.name" class="h-10 w-10 rounded-md cursor-pointer hover:opacity-80 transition-opacity" @click="openImagePreview(pkg.image3)" />
                      </div>
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-900">
                      <ul class="list-disc list-inside">
                        <li v-if="pkg.destination1">{{ pkg.destination1 }}</li>
                        <li v-if="pkg.destination2">{{ pkg.destination2 }}</li>
                        <li v-if="pkg.destination3">{{ pkg.destination3 }}</li>
                        <li v-if="pkg.destination4">{{ pkg.destination4 }}</li>
                        <li v-if="pkg.destination5">{{ pkg.destination5 }}</li>
                        <li v-if="pkg.destination6">{{ pkg.destination6 }}</li>
                        <li v-if="pkg.destination7">{{ pkg.destination7 }}</li>
                        <li v-if="pkg.destination8">{{ pkg.destination8 }}</li>
                      </ul>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 hidden lg:table-cell">{{ pkg.price }}</td>
                    <td class="px-6 py-4 text-sm text-gray-900">
                      <div class="max-w-xs overflow-hidden">
                        {{ pkg.content }}
                      </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                      <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full" 
                        :class="pkg.status === 'Active' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'">
                        {{ pkg.status }}
                      </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                      <button @click="openModal('edit', pkg.id)" class="text-blue-600 hover:text-blue-900 mr-3">Edit</button>
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