<script setup>
import {defineProps} from 'vue';

const model = defineModel();
const {id, label, error, required, placeholder} = defineProps({
    id: String,
    label: String,
    error: String,
    required: Boolean,
    placeholder: {
        type: String,
        default: 'Escribe aquí...'
    }
});
</script>

<template>
    <div class="mb-4">
        <label :for="id" class="block text-sm font-semibold text-gray-800 mb-1">{{ label }}</label>

        <textarea
            :id="id"
            v-model="model"
            :required="required"
            :placeholder="placeholder"
            class="mt-1 block w-full min-h-[120px] resize-y rounded-md border border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50 p-3 text-gray-700"
        ></textarea>

        <p v-if="error" class="text-sm text-red-600 mt-1">{{ error }}</p>
    </div>
</template>

<style scoped>
/* Optional CSS for further customization */
textarea:focus {
    outline: none;
}
</style>
