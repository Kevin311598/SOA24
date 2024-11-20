<script setup>
defineProps({
    first: {
        type: Boolean,
        default: false
    }
})
</script>

<template>
    <th v-if="first" scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
        <slot/>
    </th>
    <td v-else class="px-6 py-4">
        <slot/>
    </td>
</template>
