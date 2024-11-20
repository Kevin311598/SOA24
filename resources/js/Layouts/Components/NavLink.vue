<template>
    <Link :href="href" :class="classes">
        <slot />
    </Link>
</template>

<script setup>
import { computed } from 'vue';
import { Link } from '@inertiajs/vue3';

const props = defineProps({
    href: String,
    active: Boolean,
});

const classes = computed(() =>
    props.active
        ? 'inline-flex items-center px-3 py-2 border-b-2 border-primary text-primary font-semibold'
        : 'inline-flex items-center px-3 py-2 border-b-2 border-transparent text-white hover:border-primary hover:text-gold'
);
</script>
