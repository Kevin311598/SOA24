<script setup>
import {Link} from '@inertiajs/vue3';
</script>

<template>
    <Link :href="href"
          class="relative block px-40 py-20 rounded-2xl shadow-md transition-transform transform hover:scale-105 hover:shadow-lg">
        <div
            class="absolute inset-0 bg-danger bg-opacity-70 rounded-2xl flex justify-center items-center transition duration-200 ease-in-out hover:bg-opacity-90">
            <div class="text-white text-3xl font-extrabold">
                <slot/>
            </div>
        </div>
    </Link>
</template>

<style scoped>
.shadow-md {
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}
</style>
