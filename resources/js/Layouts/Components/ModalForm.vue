<script setup>
import Modal from "@/Layouts/Components/Modal.vue";

const props = defineProps({
    show: Boolean,
    title: String,
    maxWidth:String
});

const emit = defineEmits(['close', 'saved']);
</script>

<template>
    <Modal :show="show" :max-width="maxWidth" @close="$emit('close')">
        <div class="p-8 bg-white rounded-lg shadow-lg">

            <h2 class="text-2xl font-semibold text-dark mb-6">
                <slot name="title"/>
            </h2>

            <div class="space-y-5">
                <slot/>
            </div>

            <div class="flex justify-end mt-8 space-x-4">
                <button
                    @click="$emit('close')"
                    class="px-5 py-2 rounded-lg font-semibold text-black bg-light border border-gray-300 hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-gray-400 transition duration-150 ease-in-out"
                >
                    Cancelar
                </button>

                <button
                    @click="$emit('saved')"
                    class="px-5 py-2 rounded-lg font-semibold text-white bg-blue-500 hover:bg-gold focus:outline-none focus:ring-2 focus:ring-primary transition duration-150 ease-in-out"
                >
                    Guardar
                </button>
            </div>
        </div>
    </Modal>
</template>

