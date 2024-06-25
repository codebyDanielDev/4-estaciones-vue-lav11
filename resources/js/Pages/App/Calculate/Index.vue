<script setup>
import { ref, defineAsyncComponent } from 'vue'; // Asegúrate de importar defineAsyncComponent aquí
import AppLayout from '@/Layouts/AppLayout.vue';
import BaseModal from '@/Components/BaseModal.vue';
import axios from 'axios';
import { useToast } from 'vue-toastification';
import { useModal } from '@/composables/useModal';
import { defineProps } from 'vue';

const toast = useToast();
const AddProduct = defineAsyncComponent(() => import('@/Components/AddProductModal.vue'));
const { isModalOpen, currentComponent, modalProps, openModal, closeModal } = useModal();
const openAddProductModal = () => {
    openModal(AddProduct, { title: 'Agregar Producto' });
};

const isLargeModalOpen = ref(false);
const openLargeModal = async () => {
    const success = await loadListProductos();
    if (success) {
        isLargeModalOpen.value = true;
    }
};
const closeLargeModal = () => {
    isLargeModalOpen.value = false;
};

const props = defineProps({
    calculate_productos: Array,
});

const calculate_productos = ref(props.calculate_productos);
const list_productos = ref([]);

const selectedProducts = ref([]);
const isDropdownOpen = ref(false);

const toggleDropdown = () => {
    isDropdownOpen.value = !isDropdownOpen.value;
};

const archiveProducto = async (id) => {
    try {
        await axios.delete(`/calcular/archive/${id}`);
        calculate_productos.value = calculate_productos.value.filter(producto => producto.id !== id);
        toast.success('Producto archivado exitosamente');
    } catch (error) {
        console.error('Error archivando producto:', error);
        toast.error('Error archivando producto');
    }
};

const selectAll = (event) => {
    if (event.target.checked) {
        selectedProducts.value = list_productos.value.map(product => product.id);
    } else {
        selectedProducts.value = [];
    }
};

const addProduct = async (product) => {
    try {
        await axios.post('/calcular/store-multiple', { producto_ids: [product.id] });
        calculate_productos.value.push(product);
        list_productos.value = list_productos.value.filter(p => p.id !== product.id);
        toast.success('Producto agregado exitosamente');
        await loadListProductos(); // Volver a cargar la lista de productos
        if (list_productos.value.length === 0) {
            closeLargeModal();
        }
    } catch (error) {
        console.error('Hubo un error!', error);
        toast.error('Error agregando producto');
    }
};

const addProducts = async () => {
    try {
        await axios.post('/calcular/store-multiple', { producto_ids: selectedProducts.value });
        selectedProducts.value.forEach(id => {
            const product = list_productos.value.find(product => product.id === id);
            calculate_productos.value.push(product);
            list_productos.value = list_productos.value.filter(p => p.id !== id);
        });
        selectedProducts.value = [];
        toast.success('Productos agregados exitosamente');
        await loadListProductos(); // Volver a cargar la lista de productos
        closeLargeModal(); // Cerrar el modal después de agregar los productos seleccionados
    } catch (error) {
        console.error('Hubo un error!', error);
        toast.error('Error agregando productos');
    }
};

const loadListProductos = async () => {
    try {
        const response = await axios.get('/calcular/get-list-productos');
        if (response.status === 204) {
            toast.info('No hay productos disponibles');
            return false;
        }
        list_productos.value = response.data;
        return true;
    } catch (error) {
        console.error('Error cargando productos:', error);
        toast.error('Error cargando productos');
        return false;
    }
};



const enviarDatos = async () => {
    try {
        await axios.post('/calcular-y-guardar', { productos: calculate_productos.value });
        toast.success('Datos guardados exitosamente');
    } catch (error) {
        console.error('Error al guardar los datos:', error);
        toast.error('Error al guardar los datos');
    }
};
</script>


<template>
    <AppLayout title="Calcular precios">
        <template #header>
            <div class="flex items-center justify-between">
                <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
                    Lista de Productos a Calcular Precios
                </h2>

                <button @click="openAddProductModal"
                    class="px-4 py-2 mt-4 text-sm font-semibold text-white bg-blue-500 rounded hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:ring-opacity-75">
                    Agregar Producto
                </button>
            </div>
        </template>
        <div>
            <BaseModal :isOpen="isModalOpen" :title="modalProps.title" @close="closeModal">
                <component :is="currentComponent" v-bind="modalProps"></component>
            </BaseModal>
        </div>

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
                                    Precio Total
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-gray-300">
                                    Acción
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700">
                            <tr v-for="(calculate_producto, index) in calculate_productos" :key="index">
                                <td
                                    class="px-6 py-4 text-sm font-medium text-gray-900 whitespace-nowrap dark:text-gray-200">
                                    {{ calculate_producto.nombre }}
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-500 whitespace-nowrap dark:text-gray-300">
                                    {{ calculate_producto.dividendo }}
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-500 whitespace-nowrap dark:text-gray-300">
                                    {{ calculate_producto.porcentaje_min }}
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-500 whitespace-nowrap dark:text-gray-300">
                                    {{ calculate_producto.porcentaje_max }}
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-500 whitespace-nowrap dark:text-gray-300">
                                    <input type="number" v-model.number="calculate_producto.cantidad"
                                        class="block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-300" />
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-500 whitespace-nowrap dark:text-gray-300">
                                    <input type="number" v-model.number="calculate_producto.precio_compra_total"
                                        class="block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-300" />
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-500 whitespace-nowrap dark:text-gray-300">
                                    <button @click="archiveProducto(calculate_producto.id)"
                                        class="px-4 py-2 font-semibold text-white bg-red-500 rounded-md shadow-sm hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                        Eliminar
                                    </button>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="7"
                                    class="px-6 py-4 text-sm text-center text-gray-500 whitespace-nowrap dark:text-gray-300">
                                    <button @click="openLargeModal"
                                        class="px-4 py-2 font-semibold text-white bg-blue-500 rounded-md shadow-sm hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                        Agregar producto
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <button @click="enviarDatos"
                        class="px-4 py-2 mt-4 font-semibold text-white bg-green-500 rounded-md shadow-sm hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                        Guardar
                    </button>
                </div>
            </div>
        </div>

        <div>
            <div v-if="isLargeModalOpen" id="large-modal" tabindex="-1"
                class="fixed inset-0 z-50 flex items-center justify-center w-full p-4 overflow-x-hidden overflow-y-auto bg-gray-900 bg-opacity-50">
                <div class="relative w-full max-w-4xl max-h-full bg-white rounded-lg shadow-lg dark:bg-gray-800">
                    <div class="p-4 space-y-4 md:p-5">

                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-gray-50 dark:bg-gray-700">
                                <tr>
                                    <th scope="col"
                                        class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-gray-300">
                                        <input type="checkbox" @click="selectAll">
                                    </th>
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
                                        Acción
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700">
                                <tr v-for="(list_producto, index) in list_productos" :key="index">
                                    <td
                                        class="px-6 py-4 text-sm font-medium text-gray-900 whitespace-nowrap dark:text-gray-200">
                                        <input type="checkbox" v-model="selectedProducts" :value="list_producto.id">
                                    </td>
                                    <td
                                        class="px-6 py-4 text-sm font-medium text-gray-900 whitespace-nowrap dark:text-gray-200">
                                        {{ list_producto.nombre }}
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-500 whitespace-nowrap dark:text-gray-300">
                                        {{ list_producto.dividendo }}
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-500 whitespace-nowrap dark:text-gray-300">
                                        {{ list_producto.porcentaje_min }}
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-500 whitespace-nowrap dark:text-gray-300">
                                        {{ list_producto.porcentaje_max }}
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-500 whitespace-nowrap dark:text-gray-300">
                                        <button @click="addProduct(list_producto)"
                                            :disabled="selectedProducts.length > 0"
                                            class="px-4 py-2 font-semibold text-white bg-green-500 rounded-md shadow-sm hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 disabled:opacity-50 disabled:cursor-not-allowed">
                                            Agregar
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>

                        <div v-if="selectedProducts.length > 0" class="flex justify-end mt-4">
                            <button @click="addProducts"
                                class="px-4 py-2 font-semibold text-white bg-green-500 rounded-md shadow-sm hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                                Agregar Seleccionados
                            </button>
                        </div>

                    </div>
                    <div
                        class="flex items-center p-4 space-x-3 border-t border-gray-200 rounded-b dark:border-gray-600">

                        <button @click="closeLargeModal" type="button"
                            class="py-2.5 px-5 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">
                            Cancelar
                        </button>
                    </div>
                </div>
            </div>
        </div>



    </AppLayout>
</template>
