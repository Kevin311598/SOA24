<script setup>
import {defineProps, defineEmits} from 'vue';

const props = defineProps({
    newsItems: {
        type: Array,
        required: true,
    },
});

const emit = defineEmits(['edit', 'delete']);
</script>

<template>
    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
        <table class="w-full text-sm text-left rtl:text-right text-gray-500">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50">
            <tr class="bg-primary-default text-white text-sm uppercase tracking-wider">
                <slot name="th"/>
            </tr>
            </thead>
            <tbody>
            <tr v-for="item in newsItems" :key="item.id"
                class="border-b hover:bg-gray-200 bg-white transition duration-150 ease-in-out">
                <slot name="tr" :item="item"/>
                <td class="px-6 py-4 border-b text-end">
                    <button
                        @click="$emit('edit', item)"
                        class="px-3 py-1 bg-green-400 text-white font-semibold rounded-md hover:bg-dark hover:text-white transition duration-150 ease-in-out mr-2"
                    >
                        Editar
                    </button>
                    <button
                        @click="$emit('delete', item)"
                        class="px-3 py-1 bg-red-400 text-white font-semibold rounded-md hover:bg-red-700 transition duration-150 ease-in-out"
                    >
                        Eliminar
                    </button>
                </td>
            </tr>
            </tbody>
        </table>
    </div>
</template>


