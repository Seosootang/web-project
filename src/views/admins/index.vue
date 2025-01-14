<script setup>
import { ref, onMounted, computed } from "vue";
import { useRouter, useRoute } from "vue-router";
import api from "../../api";

const loading = ref(false);
const reservations = ref([]);
const packages = ref([]);

const isMenuVisible = ref(false);
const isSubmenuVisible = ref(false);

// Computed properties for totals
const totalPackages = computed(() => packages.value.length);
const totalReservations = computed(() => reservations.value.length);

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

onMounted(() => {
  fetchDataPackages();
  fetchDataReservations();
});

const toggleMenu = () => {
  isMenuVisible.value = !isMenuVisible.value;
};

const toggleSubmenu = () => {
  isSubmenuVisible.value = !isSubmenuVisible.value;
};

// Handle resizing
onMounted(() => {
  const handleResize = () => {
    if (window.innerWidth >= 640) {
      isMenuVisible.value = true;
    } else {
      isMenuVisible.value = false;
    }
  };

  window.addEventListener("resize", handleResize);
  handleResize(); // Run once on mount

  // Cleanup on unmount
  return () => {
    window.removeEventListener("resize", handleResize);
  };
});
</script>

<template>
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
      <nav class="mt-4" :class="{ 'hidden sm:block': !isMenuVisible }">
        <router-link :to="{ name: 'admins.index' }" class="block px-4 py-3 hover:bg-slate-700 transition-colors"> Dashboard </router-link>
        <router-link :to="{ name: 'admins.package' }" class="block px-4 py-3 hover:bg-slate-700 transition-colors"> Package </router-link>
        <router-link :to="{ name: 'admins.reservation' }" class="block px-4 py-2 hover:bg-slate-700 transition-colors"> Reservation </router-link>
      </nav>
    </div>

    <!-- Main Content -->
    <div class="flex-1 flex flex-col overflow-hidden">
      <header class="bg-white shadow">
        <div class="px-4 sm:px-6 py-4">
          <h1 class="text-lg sm:text-xl font-semibold text-gray-800">Dashboard Overview</h1>
        </div>
      </header>
      <div class="flex-1 overflow-auto">
        <div class="p-4 sm:p-6">
          <!-- Loading State -->
          <div v-if="loading" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6">
            <div v-for="i in 2" :key="i" class="bg-white rounded-lg shadow p-4 sm:p-6 animate-pulse">
              <div class="h-4 bg-gray-200 rounded w-1/2"></div>
              <div class="mt-2 h-8 bg-gray-200 rounded w-1/3"></div>
            </div>
          </div>

          <!-- Stats Cards -->
          <div v-else class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6">
            <div class="bg-white rounded-lg shadow p-4 sm:p-6">
              <div class="flex items-center">
                <div class="flex-shrink-0">
                  <svg class="h-8 w-8 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16" />
                  </svg>
                </div>
                <div class="ml-4">
                  <h3 class="text-gray-500 text-xs sm:text-sm font-medium">Total Package</h3>
                  <p class="mt-2 text-2xl sm:text-3xl font-bold text-gray-900">{{ totalPackages }}</p>
                </div>
              </div>
            </div>
            <div class="bg-white rounded-lg shadow p-4 sm:p-6">
              <div class="flex items-center">
                <div class="flex-shrink-0">
                  <svg class="h-8 w-8 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                  </svg>
                </div>
                <div class="ml-4">
                  <h3 class="text-gray-500 text-xs sm:text-sm font-medium">Total Reservation</h3>
                  <p class="mt-2 text-2xl sm:text-3xl font-bold text-gray-900">{{ totalReservations }}</p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>