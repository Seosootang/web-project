<script setup>
import { onMounted, onBeforeUnmount } from "vue";

onMounted(() => {
  // Toggle mobile menu
  const menuToggle = document.getElementById("menuToggle");
  const navigation = document.getElementById("navigation");

  menuToggle.addEventListener("click", () => {
    navigation.classList.toggle("hidden");
  });

  // Add active state to navigation items
  document.querySelectorAll("nav a").forEach((link) => {
    link.addEventListener("click", (e) => {
      // Remove active state from all links
      document.querySelectorAll("nav a").forEach((l) => {
        l.classList.remove("bg-slate-700");
      });
      // Add active state to clicked link
      e.target.classList.add("bg-slate-700");
    });
  });

  // Hide mobile menu when resizing to larger screens
  const resizeHandler = () => {
    if (window.innerWidth >= 640) {
      // sm breakpoint
      navigation.classList.remove("hidden");
    } else {
      navigation.classList.add("hidden");
    }
  };
  window.addEventListener("resize", resizeHandler);

  function toggleSubmenu(submenuId) {
    const submenu = document.getElementById(submenuId);
    const arrow = document.getElementById("bookingsArrow");

    if (submenu.classList.contains("hidden")) {
      submenu.classList.remove("hidden");
      arrow.style.transform = "rotate(180deg)";
    } else {
      submenu.classList.add("hidden");
      arrow.style.transform = "rotate(0deg)";
    }
  }

  // Clean up event listeners when the component is unmounted
  onBeforeUnmount(() => {
    menuToggle.removeEventListener("click", () => {
      navigation.classList.toggle("hidden");
    });
    window.removeEventListener("resize", resizeHandler);
  });
});
</script>

<template>
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Mojoskem Admin</title>
  </head>
  <body>
    <div class="flex flex-col sm:flex-row h-screen bg-gray-100">
      <!-- Sidebar - Hidden on mobile by default, toggleable -->
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
          <router-link 
                    :to="{ name: 'admins.package' }" 
                    class="block px-4 py-2 hover:bg-slate-700 transition-colors">
                    Paket Tour
                </router-link>

          <!-- Bookings Menu with Submenu -->
          <div class="relative">
            <button class="w-full px-4 py-3 flex items-center justify-between hover:bg-slate-700 transition-colors" onclick="toggleSubmenu('bookingsSubmenu')">
              <span>Bookings</span>
              <svg id="bookingsArrow" class="w-4 h-4 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
              </svg>
            </button>
            <div id="bookingsSubmenu" class="hidden pl-4 bg-slate-900">
                <router-link 
                    :to="{ name: 'admins.package' }" 
                    class="block px-4 py-2 hover:bg-slate-700 transition-colors">
                    Booking Paket
                </router-link>
              <a href="booking-mobil.html" class="block px-4 py-2 hover:bg-slate-700 transition-colors">Booking Mobil</a>
              <a href="booking-bis.html" class="block px-4 py-2 hover:bg-slate-700 transition-colors">Booking Bus</a>
            </div>
          </div>

          <a href="users.html" class="block px-4 py-3 hover:bg-slate-700 transition-colors">Users</a>
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
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6">
              <!-- Stats Cards -->
              <div class="bg-white rounded-lg shadow p-4 sm:p-6">
                <h3 class="text-gray-500 text-xs sm:text-sm font-medium">Total Paket</h3>
                <p class="mt-2 text-2xl sm:text-3xl font-bold text-gray-900">100</p>
              </div>

              <div class="bg-white rounded-lg shadow p-4 sm:p-6">
                <h3 class="text-gray-500 text-xs sm:text-sm font-medium">Booking Paket</h3>
                <p class="mt-2 text-2xl sm:text-3xl font-bold text-gray-900">100</p>
              </div>

              <div class="bg-white rounded-lg shadow p-4 sm:p-6">
                <h3 class="text-gray-500 text-xs sm:text-sm font-medium">Booking Mobil</h3>
                <p class="mt-2 text-2xl sm:text-3xl font-bold text-gray-900">100</p>
              </div>

              <div class="bg-white rounded-lg shadow p-4 sm:p-6">
                <h3 class="text-gray-500 text-xs sm:text-sm font-medium">Booking Bus</h3>
                <p class="mt-2 text-2xl sm:text-3xl font-bold text-gray-900">100</p>
              </div>

              <div class="bg-white rounded-lg shadow p-4 sm:p-6">
                <h3 class="text-gray-500 text-xs sm:text-sm font-medium">Total Pengguna</h3>
                <p class="mt-2 text-2xl sm:text-3xl font-bold text-gray-900">1000</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </body>
</template>
