<script setup>
import { ref, onMounted } from "vue";
import { useRouter, useRoute } from "vue-router";
import api from "../../api";

const loading = ref(false);
const reservations = ref([]);
const showEditModal = ref(false);
const showDeleteModal = ref(false);
const selectedReservation = ref(null);

const router = useRouter();
const route = useRoute();

const customer = ref("");
const packagechoice = ref("");
const date = ref("");
const pickup = ref("");
const email = ref("");
const phonenumber = ref("");
const status = ref("");
const errors = ref([]);

const fetchDataReservations = async () => {
  try {
    loading.value = true;
    const response = await api.get("/api/reservations");
    reservations.value = response.data.data.data;
  } catch (error) {
    console.error("Error fetching reservation:", error);
  } finally {
    loading.value = false;
  }
};

const openEditModal = (reservation) => {
  selectedReservation.value = reservation;
  customer.value = reservation.customer;
  packagechoice.value = reservation.packagechoice;
  date.value = reservation.date;
  pickup.value = reservation.pickup;
  email.value = reservation.email;
  phonenumber.value = reservation.phonenumber;
  status.value = reservation.status;
  showEditModal.value = true;
};

const closeEditModal = () => {
  showEditModal.value = false;
  selectedReservation.value = null;
  resetForm();
};

const resetForm = () => {
  customer.value = "";
  packagechoice.value = "";
  date.value = "";
  pickup.value = "";
  email.value = "";
  phonenumber.value = "";
  status.value = "";
  errors.value = [];
};

const updateReservation = async () => {
  try {
    const formData = new FormData();
    formData.append("customer", customer.value);
    formData.append("packagechoice", packagechoice.value);
    formData.append("date", date.value);
    formData.append("pickup", pickup.value);
    formData.append("email", email.value);
    formData.append("phonenumber", phonenumber.value);
    formData.append("status", status.value);
    formData.append("_method", "PATCH");

    await api.post(`/api/reservations/${selectedReservation.value.id}`, formData);
    await fetchDataReservations();
    closeEditModal();
  } catch (error) {
    errors.value = error.response.data;
  }
};

const openDeleteModal = (reservation) => {
  selectedReservation.value = reservation;
  showDeleteModal.value = true;
};

const closeDeleteModal = () => {
  showDeleteModal.value = false;
  selectedReservation.value = null;
};

const deleteReservation = async () => {
  try {
    await api.delete(`/api/reservations/${selectedReservation.value.id}`);
    await fetchDataReservations();
    closeDeleteModal();
  } catch (error) {
    console.error("Error deleting reservation:", error);
  }
};

onMounted(() => {
  fetchDataReservations();
});
</script>

<template>
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Mojoskem Admin - Bookings</title>
  </head>
  <body>
    <!-- Edit Booking Modal -->
    <div v-if="showEditModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full flex items-center justify-center z-40 p-4">
      <div class="relative p-4 sm:p-5 border w-full max-w-[95%] sm:max-w-lg shadow-lg rounded-md bg-white">
        <h3 class="text-lg font-medium mb-4">Edit Booking</h3>
        <form @submit.prevent="updateReservation">
          <div class="space-y-4">
            <div>
              <label class="block text-gray-700 text-sm font-bold mb-2">Customer</label>
              <input v-model="customer" type="text" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" />
              <span v-if="errors.customer" class="text-red-500 text-sm">{{ errors.customer[0] }}</span>
            </div>
            <div>
              <label class="block text-gray-700 text-sm font-bold mb-2">Paket</label>
              <input v-model="packagechoice" type="text" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" />
              <span v-if="errors.packagechoice" class="text-red-500 text-sm">{{ errors.packagechoice[0] }}</span>
            </div>
            <div>
              <label class="block text-gray-700 text-sm font-bold mb-2">Tanggal</label>
              <input v-model="date" type="date" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" />
              <span v-if="errors.date" class="text-red-500 text-sm">{{ errors.date[0] }}</span>
            </div>
            <div>
              <label class="block text-gray-700 text-sm font-bold mb-2">Lokasi Penjemputan</label>
              <input v-model="pickup" type="text" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" />
              <span v-if="errors.pickup" class="text-red-500 text-sm">{{ errors.pickup[0] }}</span>
            </div>
            <div>
              <label class="block text-gray-700 text-sm font-bold mb-2">Email</label>
              <input v-model="email" type="email" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" />
              <span v-if="errors.email" class="text-red-500 text-sm">{{ errors.email[0] }}</span>
            </div>
            <div>
              <label class="block text-gray-700 text-sm font-bold mb-2">No.Telepon</label>
              <input v-model="phonenumber" type="text" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" />
              <span v-if="errors.phonenumber" class="text-red-500 text-sm">{{ errors.phonenumber[0] }}</span>
            </div>
            <div>
              <label class="block text-gray-700 text-sm font-bold mb-2">Status</label>
              <select v-model="status" class="shadow border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                <option value="Confirmed">Confirmed</option>
                <option value="Pending">Pending</option>
                <option value="Cancelled">Cancelled</option>
              </select>
              <span v-if="errors.status" class="text-red-500 text-sm">{{ errors.status[0] }}</span>
            </div>
          </div>
          <div class="flex items-center justify-end mt-4 space-x-2">
            <button type="button" @click="closeEditModal" class="bg-gray-500 text-white px-4 py-2 rounded-md hover:bg-gray-600">Cancel</button>
            <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded-md hover:bg-green-600">Save</button>
          </div>
        </form>
      </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div v-if="showDeleteModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full flex items-center justify-center z-40">
      <div class="relative p-4 w-full max-w-md mx-auto bg-white rounded-lg shadow-lg">
        <h3 class="text-lg font-medium mb-4">Konfirmasi Hapus</h3>
        <p class="text-gray-500 mb-4">Apakah anda yakin ingin menghapus booking ini?</p>
        <div class="flex justify-end space-x-2">
          <button @click="closeDeleteModal" class="px-4 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600">Cancel</button>
          <button @click="deleteReservation" class="px-4 py-2 bg-red-500 text-white rounded-md hover:bg-red-600">Delete</button>
        </div>
      </div>
    </div>

    <div class="flex flex-col sm:flex-row h-screen bg-gray-100">
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
      <nav class="mt-4 sm:block" id="navigation">
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
            <h1 class="text-lg sm:text-xl font-semibold text-gray-800">Booking Paket</h1>
          </div>
        </header>

        <!-- Scrollable Container -->
        <div class="flex-1 overflow-auto p-4 sm:p-6">
          <div v-if="loading" class="text-center py-4">
            Loading...
          </div>
          
          <!-- Card with horizontal scroll for table -->
          <div v-else class="bg-white rounded-lg shadow">
            <!-- Mobile View: Card Layout -->
            <div class="block sm:hidden">
              <div class="divide-y divide-gray-200">
                <div v-for="reservation in reservations" :key="reservation.id" class="p-4 space-y-4">
                  <div class="flex justify-between">
                    <span class="text-sm font-medium text-gray-500">Customer:</span>
                    <span class="text-sm text-gray-900">{{ reservation.customer }}</span>
                  </div>
                  <div class="flex justify-between">
                    <span class="text-sm font-medium text-gray-500">Paket:</span>
                    <span class="text-sm text-gray-900">{{ reservation.packagechoice }}</span>
                  </div>
                  <div class="flex justify-between">
                    <span class="text-sm font-medium text-gray-500">Tanggal:</span>
                    <span class="text-sm text-gray-900">{{ reservation.date }}</span>
                  </div>
                  <div class="flex justify-between">
                    <span class="text-sm font-medium text-gray-500">Lokasi Penjemputan:</span>
                    <span class="text-sm text-gray-900">{{ reservation.pickup }}</span>
                  </div>
                  <div class="flex justify-between">
                    <span class="text-sm font-medium text-gray-500">Email:</span>
                    <span class="text-sm text-gray-900">{{ reservation.email }}</span>
                  </div>
                  <div class="flex justify-between">
                    <span class="text-sm font-medium text-gray-500">No.Telepon:</span>
                    <span class="text-sm text-gray-900">{{ reservation.phonenumber }}</span>
                  </div>
                  <div class="flex justify-between items-center">
                    <span class="text-sm font-medium text-gray-500">Status:</span>
                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                      {{ reservation.status }}
                    </span>
                  </div>
                  <div class="mt-2 flex space-x-2">
                    <button @click="openEditModal(reservation)" class="bg-blue-500 text-white px-2 py-1 rounded text-sm hover:bg-blue-600">
                      Edit
                    </button>
                    <button @click="openDeleteModal(reservation)" class="bg-red-500 text-white px-2 py-1 rounded text-sm hover:bg-red-600">
                      Delete
                    </button>
                  </div>
                </div>
              </div>
            </div>

            <!-- Desktop View: Table Layout -->
            <div class="hidden sm:block overflow-x-auto">
              <table class="min-w-full">
                <thead>
                  <tr class="bg-gray-50 border-b">
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Customer</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Paket</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Lokasi Penjemputan</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider hidden lg:table-cell">Email</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider hidden md:table-cell">No.Telepon</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                  </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                  <tr v-for="reservation in reservations" :key="reservation.id">
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ reservation.customer }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ reservation.packagechoice }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ reservation.date }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ reservation.pickup }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 hidden lg:table-cell">{{ reservation.email }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 hidden md:table-cell">{{ reservation.phonenumber }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">
                      <span 
                        class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full"
                        :class="{
                          'bg-green-100 text-green-800': reservation.status === 'Confirmed',
                          'bg-yellow-100 text-yellow-800': reservation.status === 'Pending',
                          'bg-red-100 text-red-800': reservation.status === 'Cancelled'
                        }"
                      >
                        {{ reservation.status }}
                      </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                      <button @click="openEditModal(reservation)" class="text-blue-600 hover:text-blue-900 mr-3">
                        Edit
                      </button>
                      <button @click="openDeleteModal(reservation)" class="text-red-600 hover:text-red-900">
                        Delete
                      </button>
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