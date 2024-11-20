<template>
    <div class="mb-4">
        <label :for="id" class="block text-sm font-semibold text-gray-800 mb-1">{{ label }}</label>

        <div class="relative">
            <select
                :id="id"
                v-model="model"
                :class="[
                    'appearance-none block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50',
                    error ? 'border-red-500' : 'border-gray-300'
                ]"
                class="bg-white py-2 px-3 pr-10 text-gray-700 capitalize"
            >
                <option v-if="!model" value="" disabled class="text-gray-400">{{ placeholder }}</option>
                <option v-for="option in options" :key="option.value" :value="option.value" class="capitalize">
                    {{ option.label }}
                </option>
            </select>

        </div>

        <p v-if="error" class="text-sm text-red-600 mt-1">{{ error }}</p>
    </div>
</template>

<script setup>
const model = defineModel();
defineProps({
    label: String,
    id: String,
    options: {
        type: Array,
        required: true
    },
    placeholder: {
        type: String,
        default: 'Selecciona una opción'
    },
    error: {
        type: String,
        default: null
    }
});

defineEmits(['update:modelValue']);
</script>
