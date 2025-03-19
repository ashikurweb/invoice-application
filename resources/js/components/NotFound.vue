<template>
    <div class="flex items-center justify-center min-h-screen bg-gradient-to-r from-blue-500 via-purple-600 to-pink-500">
      <div class="text-center p-8 bg-white rounded-lg shadow-lg max-w-lg w-full">
        <h1 class="text-6xl font-bold text-gray-800 mb-4">404</h1>
        <p class="text-2xl text-gray-600 mb-4">Oops! The page you're looking for doesn't exist.</p>
        <p class="text-lg text-gray-500 mb-8">It seems like you've lost your way. Try going back to the homepage or use the navigation above.</p>
        <router-link to="/" class="bg-blue-500 text-white px-6 py-3 rounded-lg shadow-md hover:bg-blue-600 transition ease-in-out duration-300">
          Go to Homepage
        </router-link>
      </div>
    </div>
  </template>
  
  <script>
  export default {
    name: 'NotFound',
  }
  </script>
  
  <style scoped>
  /* You can add additional custom styles here if needed */
  </style>
  