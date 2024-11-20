<script setup>
const model = defineModel()
const props = defineProps({
    label: {
        type: String,
    },
    id: {
        type: String,
    },
    type: {
        type: String,
    },
    required: {
        type: Boolean,
        default: false
    },
    error: {
        type: String
    }
})
</script>

<template>
    <div class="relative z-0">
        <label :for="id" class="mb-2">{{ label }}</label>
        <div class="border border-gray-200 flex items-center gap-3 pr-1">
            <input v-model="model"
                :id="id" :type="type"
                   class="w-full border-0 rounded-md py-2.5 focus:outline-none focus:ring-0 "
                   :required="required"/>
            <slot name="component"/>
        </div>
        <p class="text-sm text-red-500">{{ error }}</p>
    </div>
</template>

<style scoped>

</style>
