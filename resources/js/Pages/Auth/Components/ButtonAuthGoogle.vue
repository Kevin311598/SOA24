<script setup>

</script>

<template>
    <div class="text-center my-4">
        <span class="text-gray-500">o</span>
    </div>

    <a :href="route('auth.google')" class="w-full">
        <button class="bg-red-500 text-white font-bold py-2 px-4 rounded w-full">
            Iniciar sesión con Google
        </button>
    </a>
</template>

<style scoped>

</style>
