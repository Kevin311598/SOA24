<script setup>
import {Link} from '@inertiajs/vue3';

defineProps({
    href: {
        type: String,
        required: true,
    },
});
</script>

<template>
    <Link
        :href="href"
        class="block w-full px-4 bg-light py-2 text-start text-sm leading-5 text-dark transition duration-150 ease-in-out hover:bg-primary hover:text-dark focus:bg-primary focus:outline-none"
    >
        <slot/>
    </Link>
</template>
