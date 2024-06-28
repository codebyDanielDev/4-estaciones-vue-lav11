<script setup>
import { ref, onMounted } from 'vue';
import axios from 'axios';
import AppLayout from '@/Layouts/AppLayout.vue';

const transactions = ref([]);
const currentPage = ref(1);
const perPage = ref(1);
const loading = ref(false);
const error = ref('');
const noMoreResults = ref(false);

const fetchTransactions = async () => {
    if (loading.value || noMoreResults.value) return;

    loading.value = true;
    error.value = '';

    try {
        const response = await axios.get('/fetch-transactions', {
            params: {
                perPage: perPage.value,
                page: currentPage.value,
            }
        });

        const fetchedTransactions = response.data.transactions.data;

        if (fetchedTransactions.length > 0) {
            // Insertar las nuevas transacciones al principio del array para mantener el orden
            transactions.value = [...transactions.value, ...fetchedTransactions];
            currentPage.value++;
        } else {
            noMoreResults.value = true;
        }
    } catch (err) {
        error.value = 'Ocurrió un error al cargar el historial de transacciones.';
    } finally {
        loading.value = false;
    }
};

onMounted(() => {
    fetchTransactions();

    const observer = new IntersectionObserver(entries => {
        if (entries[0].isIntersecting) {
            fetchTransactions();
        }
    });

    observer.observe(document.querySelector('#scroll-anchor'));
});
</script>

<template>
    <AppLayout title="Historial">
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
                Historial de precios
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-xl dark:bg-gray-800 sm:rounded-lg">
                    <div v-for="transaction in transactions" :key="transaction.id"
                        class="p-6 mb-4 rounded-lg shadow-md dark:bg-gray-800">
                        <div class="flex items-center justify-between mb-4">
                            <h2 class="text-lg font-bold text-indigo-600 dark:text-indigo-300">Transaction ID: {{ transaction.id }}</h2>
                            <div>
                                <button @click="viewTransaction(transaction.id)"
                                    class="px-4 py-2 mr-2 text-white bg-indigo-500 rounded-md dark:bg-indigo-700 hover:bg-indigo-600 dark:hover:bg-indigo-800">
                                    Ver
                                </button>
                                <button @click="exportTransaction(transaction.id)"
                                    class="px-4 py-2 text-white bg-teal-500 rounded-md dark:bg-teal-700 hover:bg-teal-600 dark:hover:bg-teal-800">
                                    Exportar
                                </button>
                            </div>
                        </div>
                        <p class="mb-2 text-gray-700 dark:text-gray-300">User: {{ transaction.user.name }}</p>
                        <div class="overflow-x-auto">
                            <table class="min-w-full bg-white dark:bg-gray-700">
                                <thead>
                                    <tr>
                                        <th class="px-6 py-3 text-xs font-semibold text-left text-gray-600 uppercase border-b-2 border-gray-300 dark:border-gray-500 dark:text-gray-300">Producto</th>
                                        <th class="px-6 py-3 text-xs font-semibold text-left text-gray-600 uppercase border-b-2 border-gray-300 dark:border-gray-500 dark:text-gray-300">Cantidad</th>
                                        <th class="px-6 py-3 text-xs font-semibold text-left text-gray-600 uppercase border-b-2 border-gray-300 dark:border-gray-500 dark:text-gray-300">Precio Compra Total</th>
                                        <th class="px-6 py-3 text-xs font-semibold text-left text-gray-600 uppercase border-b-2 border-gray-300 dark:border-gray-500 dark:text-gray-300">Precio Venta Kilo Min</th>
                                        <th class="px-6 py-3 text-xs font-semibold text-left text-gray-600 uppercase border-b-2 border-gray-300 dark:border-gray-500 dark:text-gray-300">Precio Venta Kilo Max</th>
                                        <th class="px-6 py-3 text-xs font-semibold text-left text-gray-600 uppercase border-b-2 border-gray-300 dark:border-gray-500 dark:text-gray-300">Precio General</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="detail in transaction.details" :key="detail.id" class="hover:bg-gray-100 dark:hover:bg-gray-600">
                                        <td class="px-6 py-4 text-sm text-gray-700 border-b border-gray-200 dark:border-gray-600 dark:text-gray-300">{{ detail.producto.name }}</td>
                                        <td class="px-6 py-4 text-sm text-gray-700 border-b border-gray-200 dark:border-gray-600 dark:text-gray-300">{{ detail.cantidad }}</td>
                                        <td class="px-6 py-4 text-sm text-gray-700 border-b border-gray-200 dark:border-gray-600 dark:text-gray-300">{{ detail.precio_compra_total }}</td>
                                        <td class="px-6 py-4 text-sm text-gray-700 border-b border-gray-200 dark:border-gray-600 dark:text-gray-300">{{ detail.precio_venta_kilo_min }}</td>
                                        <td class="px-6 py-4 text-sm text-gray-700 border-b border-gray-200 dark:border-gray-600 dark:text-gray-300">{{ detail.precio_venta_kilo_max }}</td>
                                        <td class="px-6 py-4 text-sm text-gray-700 border-b border-gray-200 dark:border-gray-600 dark:text-gray-300">{{ detail.precio_general }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div v-if="loading" class="flex justify-center">
                        <span>Cargando más transacciones...</span>
                    </div>
                    <div v-if="error" class="flex justify-center text-red-600">
                        <span>{{ error }}</span>
                    </div>
                    <div v-if="noMoreResults" class="flex justify-center text-gray-600 dark:text-gray-400">
                        <span>Ya no hay más resultados</span>
                    </div>
                    <div v-if="!noMoreResults && !loading" class="flex justify-center mt-4">
                        <button @click="fetchTransactions" class="px-4 py-2 text-white bg-blue-500 rounded-md hover:bg-blue-600">
                            Cargar más
                        </button>
                    </div>
                </div>
                <div id="scroll-anchor" class="h-1"></div>
            </div>
        </div>
    </AppLayout>
</template>
