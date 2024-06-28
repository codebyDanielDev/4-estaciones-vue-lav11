<script setup>
import { ref } from 'vue';
import axios from 'axios';
import { debounce } from 'lodash';
import AppLayout from '@/Layouts/AppLayout.vue';
import Welcome from '@/Components/Welcome.vue';

const query = ref('');
const products = ref([]);
const isLoading = ref(false);
const error = ref(null);
const page = ref(1);

const search = async () => {
  if (query.value.length > 0) {
    try {
      isLoading.value = true;
      error.value = null;
      const response = await axios.get(route('products.search'), {
        params: { query: query.value, page: page.value }
      });
      products.value = response.data.data;
    } catch (err) {
      console.error('Error fetching products:', err);
      error.value = 'Error fetching products. Please try again.';
    } finally {
      isLoading.value = false;
    }
  } else {
    products.value = [];
  }
};

const debouncedSearch = debounce(search, 1000);

const onInput = () => {
  debouncedSearch();
};

const nextPage = () => {
  page.value += 1;
  search();
};

const previousPage = () => {
  if (page.value > 1) {
    page.value -= 1;
    search();
  }
};
</script>

<template>
  <AppLayout title="Dashboard">
    <template #header>
      <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
        Hola
      </h2>
    </template>

    <div class="py-12">
      <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
        <div class="overflow-hidden bg-white shadow-xl dark:bg-gray-800 sm:rounded-lg">
          <!-- Buscador -->
          <div class="mt-6">
            <input
              type="text"
              v-model="query"
              @input="onInput"
              placeholder="Buscar productos..."
              class="w-full px-4 py-2 border rounded-lg dark:bg-gray-700 dark:text-gray-200 dark:border-gray-600 focus:outline-none focus:ring-2 focus:ring-indigo-500"
            />
            <div class="mt-4">
              <transition name="fade">
                <div v-if="isLoading" class="flex items-center justify-center py-4">
                  <svg class="w-6 h-6 text-gray-500 animate-spin" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8z"></path>
                  </svg>
                  <span class="ml-2 text-gray-500 dark:text-gray-400">Cargando...</span>
                </div>
              </transition>
              <div v-if="error" class="mt-4 text-red-500 dark:text-red-400">
                {{ error }}
              </div>
              <transition-group name="list" tag="div" class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
                <div
                  v-for="product in products"
                  :key="product.id"
                  class="p-4 border rounded-lg shadow dark:border-gray-600 dark:bg-gray-700"
                >
                  <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200">
                    {{ product.nombre }}
                  </h3>
                  <p class="text-gray-600 dark:text-gray-400">
                    <strong>Unidad ID:</strong> {{ product.unidad_id }}
                  </p>
                  <p class="text-gray-600 dark:text-gray-400">
                    <strong>Categoría ID:</strong> {{ product.categoria_id }}
                  </p>
                  <p class="text-gray-600 dark:text-gray-400">
                    <strong>Dividendo:</strong> {{ product.dividendo }}
                  </p>
                  <p class="text-gray-600 dark:text-gray-400">
                    <strong>Porcentaje Min:</strong> {{ product.porcentaje_min }}%
                  </p>
                  <p class="text-gray-600 dark:text-gray-400">
                    <strong>Porcentaje Max:</strong> {{ product.porcentaje_max }}%
                  </p>
                </div>
              </transition-group>
              <div class="flex justify-between mt-4">
                <button @click="previousPage" :disabled="page === 1" class="px-4 py-2 text-white bg-blue-500 rounded-lg hover:bg-blue-600">
                  Anterior
                </button>
                <button @click="nextPage" class="px-4 py-2 text-white bg-blue-500 rounded-lg hover:bg-blue-600">
                  Siguiente
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </AppLayout>
</template>

<style scoped>
.fade-enter-active, .fade-leave-active {
  transition: opacity 0.5s;
}
.fade-enter, .fade-leave-to /* .fade-leave-active in <2.1.8 */ {
  opacity: 0;
}

.list-enter-active, .list-leave-active {
  transition: all 0.5s;
}
.list-enter, .list-leave-to /* .list-leave-active in <2.1.8 */ {
  opacity: 0;
  transform: translateY(30px);
}
</style>
