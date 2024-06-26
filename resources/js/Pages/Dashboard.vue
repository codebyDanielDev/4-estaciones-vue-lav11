<script setup>
import { ref } from 'vue';
import axios from 'axios';
import { debounce } from 'lodash';
import AppLayout from '@/Layouts/AppLayout.vue';
import Welcome from '@/Components/Welcome.vue';

const query = ref('');
const products = ref([]);

const search = async () => {
  if (query.value.length > 0) {
    try {
      const response = await axios.get(route('products.search'), {
        params: { query: query.value }
      });
      products.value = response.data;
    } catch (error) {
      console.error('Error fetching products:', error);
    }
  } else {
    products.value = [];
  }
};

const debouncedSearch = debounce(search, 1000);

const onInput = () => {
  debouncedSearch();
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
          <!-- <Welcome /> -->

          <!-- Buscador -->
          <div class="mt-6">
            <input
              type="text"
              v-model="query"
              @input="onInput"
              placeholder="Buscar productos..."
              class="w-full px-4 py-2 border rounded-lg dark:bg-gray-700 dark:text-gray-200 dark:border-gray-600 focus:outline-none focus:ring-2 focus:ring-indigo-500"
            />
            <div class="grid grid-cols-1 gap-6 mt-4 sm:grid-cols-2 lg:grid-cols-3">
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
            </div>
          </div>
        </div>
      </div>
    </div>
  </AppLayout>
</template>
