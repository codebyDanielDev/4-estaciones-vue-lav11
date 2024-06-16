<template>
    <div class="relative group">
      <!-- Icono de información -->
      <div class="inline-flex items-center justify-center w-8 h-8 bg-gray-200 rounded-full cursor-pointer dark:bg-gray-700">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-gray-600 dark:text-gray-300" viewBox="0 0 20 20" fill="currentColor">
          <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm.75-10.5a.75.75 0 10-1.5 0v.75a.75.75 0 001.5 0v-.75zm-.75 2.5a.75.75 0 00-.75.75v3.25a.75.75 0 001.5 0v-3.25a.75.75 0 00-.75-.75z" clip-rule="evenodd" />
        </svg>
      </div>
      <!-- Tooltip -->
      <div class="absolute left-full top-1/2 transform -translate-y-1/2 ml-2 w-64 p-2 bg-gray-800 text-white text-sm rounded-lg shadow-lg opacity-0 group-hover:opacity-100 transition-opacity duration-300">
        {{ text }}
      </div>
    </div>
  </template>

  <script setup>
  import { defineProps } from 'vue';

  defineProps({
    text: {
      type: String,
      required: true
    }
  });
  </script>

  <style scoped>
  @media (max-width: 640px) {
    .w-64 {
      width: 100%;
    }
  }
  </style>
