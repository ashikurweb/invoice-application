<template>
    <div class="flex flex-col items-center justify-center min-h-screen bg-gray-100">
      <transition name="fade" mode="out-in">
        <div class="text-center">
          <h1 class="text-9xl font-bold text-gray-800">404</h1>
          <p class="text-2xl text-gray-600 mt-4">Oops! Page not found.</p>
          <p class="text-lg text-gray-500 mt-2">The page you are looking for might have been removed or is temporarily unavailable.</p>
          <router-link
            to="/"
            class="mt-6 inline-block px-6 py-3 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 transition duration-300"
          >
            Go Back Home
          </router-link>
        </div>
      </transition>
    </div>
  </template>
  
  <script>
  export default {
    name: 'NotFound',
  };
  </script>
  
  <style scoped>
  .fade-enter-active, .fade-leave-active {
    transition: opacity 0.5s;
  }
  .fade-enter, .fade-leave-to {
    opacity: 0;
  }
  </style>