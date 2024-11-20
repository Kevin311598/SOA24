<script setup>
import Modal from "@/Layouts/Components/Modal.vue";

const props = defineProps({
    show: Boolean,
    title: String
});

const emit = defineEmits(['close', 'deleted']);
</script>

<template>
    <Modal :show="show" max-width="md" @close="$emit('close')">
        <div class="p-6 bg-white rounded-lg shadow-md">
            <h2 class="text-xl font-semibold text-danger mb-4">Eliminar {{ title }}</h2>
            <p class="text-gray-700 mb-4">
                <slot/>
            </p>
            <div class="flex justify-end mt-6 space-x-3">
                <button @click="$emit('close')"
                        class="px-4 py-2 rounded-lg text-gray-600 bg-gray-100 hover:bg-gray-200 transition duration-150 ease-in-out focus:outline-none focus:ring-2 focus:ring-gray-300">
                    Cancelar
                </button>
                <button @click="$emit('deleted')"
                        class="px-4 py-2 rounded-lg text-white bg-red-400 hover:bg-red-700 transition duration-150 ease-in-out focus:outline-none focus:ring-2 focus:ring-red-500">
                    Eliminar
                </button>
            </div>
        </div>
    </Modal>
</template>

