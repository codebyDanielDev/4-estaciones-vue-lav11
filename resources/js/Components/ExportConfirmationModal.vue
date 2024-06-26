<template>
    <div class="fixed inset-0 flex items-center justify-center bg-gray-900 bg-opacity-50">
        <div class="p-6 bg-white rounded-lg shadow-lg">
            <h2 class="mb-4 text-lg font-semibold">{{ title }}</h2>
            <p>{{ message }}</p>
            <div class="flex justify-end mt-6 space-x-4">
                <button @click="confirm" class="px-4 py-2 text-white bg-blue-500 rounded-lg">Confirmar</button>
                <button @click="cancel" class="px-4 py-2 text-white bg-gray-500 rounded-lg">Cancelar</button>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        title: {
            type: String,
            required: true
        },
        message: {
            type: String,
            required: true
        }
    },
    methods: {
        confirm() {
            this.$emit('confirm');
        },
        cancel() {
            this.$emit('cancel');
        }
    }
}
</script>
