<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { defineProps, ref } from 'vue';

// Definir las props para recibir datos de historialPrecios
const props = defineProps({
    historialPrecios: Array,
});

// Crear una referencia para historialPrecios
const historialPrecios = ref(props.historialPrecios);

</script>

<template>
    <AppLayout title="Historial">
        <template #header>
            <div class="flex flex-wrap items-center justify-between sm:flex-nowrap">
                <h2 class="mb-4 text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200 sm:mb-0">
                    Historial de precios
                </h2>

                <div class="flex items-center space-x-3">
                    <button @click="openAddProductModal"
                            class="px-4 py-2 text-sm font-semibold text-white bg-blue-500 rounded hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:ring-opacity-75">
                        Exportar CSV
                    </button>
                    <button @click="openAddProductModal"
                            class="px-4 py-2 text-sm font-semibold text-white bg-blue-500 rounded hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:ring-opacity-75">
                        Exportar PDF
                    </button>
                    <button @click="openAddProductModal"
                            class="px-4 py-2 text-sm font-semibold text-white bg-blue-500 rounded hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:ring-opacity-75">
                        Exportar Excel
                    </button>
                </div>
            </div>
        </template>


        <div class="py-12">
            <form class="max-w-md mx-auto">   
                <label for="default-search" class="mb-2 text-sm font-medium text-gray-900 sr-only dark:text-white">Search</label>
                <div class="relative">
                    <div class="absolute inset-y-0 flex items-center pointer-events-none start-0 ps-3">
                        <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                        </svg>
                    </div>
                    <input type="search" id="default-search" class="block w-full p-4 text-sm text-gray-900 border border-gray-300 rounded-lg ps-10 bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Nombre o id del producto..." required />
                </div>
            </form>
            <br>
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-xl dark:bg-gray-800 sm:rounded-lg">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-gray-50 dark:bg-gray-700">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-gray-300">
                                    User ID
                                </th>
                                <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-gray-300">
                                    Producto
                                </th>
                                <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-gray-300">
                                    fecha
                                </th>
                                <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-gray-300">
                                    Precio Compra Total
                                </th>
                                <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-gray-300">
                                    Cantidad
                                </th>
                                <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-gray-300">
                                    Precio Compra Producto UNI
                                </th>
                                <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-gray-300">
                                    Divisor
                                </th>
                                <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-gray-300">
                                    % Minimo
                                </th>
                                <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-gray-300">
                                    % Maximo
                                </th>
                                <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-gray-300">
                                    Precio Venta
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700">
                            <tr v-for="(historial, index) in historialPrecios" :key="index">
                                <td class="px-6 py-4 text-sm font-medium text-gray-900 whitespace-nowrap dark:text-gray-200">
                                    {{ historial.user_id }}
                                </td>
                                <td class="px-6 py-4 text-sm font-medium text-gray-900 whitespace-nowrap dark:text-gray-200">
                                    {{ historial.producto.nombre }}
                                </td>                                
                                <td class="px-6 py-4 text-sm font-medium text-gray-900 whitespace-nowrap dark:text-gray-200">
                                    {{ historial.formatted_created_at  }}
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-500 whitespace-nowrap dark:text-gray-300">
                                    {{ historial.precio_compra_total }}
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-500 whitespace-nowrap dark:text-gray-300">
                                    {{ historial.cantidad }}
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-500 whitespace-nowrap dark:text-gray-300">
                                    {{ historial.precio_compra_producto }}
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-500 whitespace-nowrap dark:text-gray-300">
                                    {{ historial.dividendo }}
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-500 whitespace-nowrap dark:text-gray-300">
                                    {{ historial.porcentaje_min }}
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-500 whitespace-nowrap dark:text-gray-300">
                                    {{ historial.porcentaje_max }}
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-500 whitespace-nowrap dark:text-gray-300">
                                    {{ historial.precio_venta }}
                                </td>
                            </tr>
                        </tbody>
                    </table>

                    <div class="flex items-center justify-end p-4 space-x-3 border-t border-gray-200 rounded-b dark:border-gray-600">
                        <button @click="closeLargeModal" type="button"
                            class="py-2.5 px-5 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">
                            boton de adorno 
                        </button>
                    </div>
                    
                </div>
            </div>
        </div>
    </AppLayout>
</template>


