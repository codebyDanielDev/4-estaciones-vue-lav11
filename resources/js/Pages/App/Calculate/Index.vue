<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';

const products = [
    { name: 'Producto 1', price: 100, quantity: 0, total: 0, note: '' },
    { name: 'Producto 2', price: 200, quantity: 0, total: 0, note: '' },
    // Agrega más productos según sea necesario
];
</script>

<template>
    <AppLayout title="Calcular precios">
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
                Calcular precios
            </h2>

        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-xl dark:bg-gray-800 sm:rounded-lg">

                    <div class="py-12">
                        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                            <div class="overflow-hidden bg-white shadow-xl dark:bg-gray-800 sm:rounded-lg">
                                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                                    <thead class="bg-gray-50 dark:bg-gray-700">
                                        <tr>
                                            <th scope="col"
                                                class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-gray-300">
                                                Producto
                                            </th>
                                            <th scope="col"
                                                class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-gray-300">
                                                Divisor
                                            </th>
                                            <th scope="col"
                                                class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-gray-300">
                                                % Minimo
                                            </th>
                                            <th scope="col"
                                                class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-gray-300">
                                                % Maximo
                                            </th>
                                            <th scope="col"
                                                class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-gray-300">
                                                Cantidad
                                            </th>
                                            <th scope="col"
                                                class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-gray-300">
                                                Cantidad
                                            </th>
                                            <th scope="col"
                                                class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-gray-300">
                                                Precio Total
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody
                                        class="bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700">
                                        <tr v-for="(product, index) in products" :key="index">
                                            <td
                                                class="px-6 py-4 text-sm font-medium text-gray-900 whitespace-nowrap dark:text-gray-200">
                                                {{ product.name }}
                                            </td>
                                            <td
                                                class="px-6 py-4 text-sm text-gray-500 whitespace-nowrap dark:text-gray-300">
                                                {{ product.price }}
                                            </td>
                                            <td
                                                class="px-6 py-4 text-sm text-gray-500 whitespace-nowrap dark:text-gray-300">
                                                {{ product.price }}
                                            </td>
                                            <td
                                                class="px-6 py-4 text-sm text-gray-500 whitespace-nowrap dark:text-gray-300">
                                                {{ product.price }}
                                            </td>
                                            <td
                                                class="px-6 py-4 text-sm text-gray-500 whitespace-nowrap dark:text-gray-300">
                                                {{ product.total }}
                                            </td>
                                            <td
                                                class="px-6 py-4 text-sm text-gray-500 whitespace-nowrap dark:text-gray-300">
                                                <input type="number" v-model="product.quantity"
                                                    class="block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-300" />
                                            </td>

                                            <td
                                                class="px-6 py-4 text-sm text-gray-500 whitespace-nowrap dark:text-gray-300">
                                                <input type="text" v-model="product.note"
                                                    class="block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-300" />
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
