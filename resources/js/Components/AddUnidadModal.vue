<script setup>
import { reactive, onMounted, watch } from 'vue';
import axios from 'axios';
import { useToast } from 'vue-toastification';

const form = reactive({
    name: '',
    category: '',
    unit: '',
    price: '',
    percentage_min: '',
    percentage_max: ''
});

const categories = reactive([]);
const units = reactive([]);

const fetchCategories = async () => {
    try {
        const response = await axios.get('/categorias');
        categories.push(...response.data);
    } catch (error) {
        console.error('Error fetching categories:', error);
    }
};

const fetchUnits = async () => {
    try {
        const response = await axios.get('/unidades');
        units.push(...response.data);
    } catch (error) {
        console.error('Error fetching units:', error);
    }
};

onMounted(() => {
    fetchCategories();
    fetchUnits();
});

const toast = useToast();

const resetForm = () => {
    form.name = '';
    form.category = '';
    form.unit = '';
    form.price = '';
    form.percentage_min = '';
    form.percentage_max = '';
};

const validatePercentage = () => {
    if (form.percentage_max !== '' && form.percentage_min !== '' && parseFloat(form.percentage_min) >= parseFloat(form.percentage_max)) {
        toast.error('El porcentaje mínimo debe ser menor que el porcentaje máximo.');
    }
};

watch(() => form.percentage_min, validatePercentage);
watch(() => form.percentage_max, validatePercentage);

const restrictToNumbers = (event) => {
    const key = event.key;
    if (!/[0-9]/.test(key)) {
        event.preventDefault();
    }
};

const restrictMaxValue = (event) => {
    const input = event.target;
    if (parseFloat(input.value) > 100) {
        toast.error('El valor no puede ser mayor a 100.');
        input.value = 100;
    }
};

const submitForm = async () => {
    if (parseFloat(form.percentage_min) >= parseFloat(form.percentage_max)) {
        toast.error('El porcentaje mínimo debe ser menor que el porcentaje máximo.');
        return;
    }

    try {
        const response = await axios.post('/products', {
            name: form.name,
            category: form.category,
            unit: form.unit,
            price: form.price,
            percentage_min: form.percentage_min,
            percentage_max: form.percentage_max
        });
        toast.success('Producto creado exitosamente');
        resetForm();
    } catch (error) {
        if (error.response && error.response.data && error.response.data.errors) {
            const errors = error.response.data.errors;
            Object.keys(errors).forEach(key => {
                errors[key].forEach(message => {
                    toast.error(message);
                });
            });
        } else {
            toast.error('Error al crear el producto');
        }
        console.error('Error submitting form:', error);
    }
};
</script>

<template>
    <form @submit.prevent="submitForm">
        <div class="grid gap-4 mb-4 sm:grid-cols-2">
            <div>
                <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Name</label>
                <input type="text" name="name" id="name" v-model="form.name"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                    placeholder="Type product name" required>
            </div>
            <div>
                <label for="category"
                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Category</label>
                <select name="category" id="category" v-model="form.category"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                    required>
                    <option v-for="category in categories" :key="category.id" :value="category.id">
                        {{ category.nombre }}
                    </option>
                </select>
            </div>
            <div>
                <label for="unit"
                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Unit</label>
                <select name="unit" id="unit" v-model="form.unit"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                    required>
                    <option v-for="unit in units" :key="unit.id" :value="unit.id">
                        {{ unit.nombre }}
                    </option>
                </select>
            </div>
            <div>
                <label for="price" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Price</label>
                <input type="text" name="price" id="price" v-model="form.price"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                    placeholder="2999" required @keypress="restrictToNumbers">
            </div>
            <div>
                <label for="percentage_min"
                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Percentage Min</label>
                <input type="text" name="percentage_min" id="percentage_min" v-model="form.percentage_min"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                    placeholder="0" required @keypress="restrictToNumbers" @input="restrictMaxValue">
            </div>
            <div>
                <label for="percentage_max"
                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Percentage Max</label>
                <input type="text" name="percentage_max" id="percentage_max" v-model="form.percentage_max"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                    placeholder="100" required @keypress="restrictToNumbers" @input="restrictMaxValue">
            </div>
        </div>
        <button type="submit"
            class="text-white inline-flex items-center bg-primary-700 hover:bg-primary-800 focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800">
            <svg class="w-6 h-6 mr-1 -ml-1" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd"
                    d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z"
                    clip-rule="evenodd"></path>
            </svg>
            Add new product
        </button>
    </form>
</template>
