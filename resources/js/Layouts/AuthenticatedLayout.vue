<script setup>
import {ref} from 'vue';
import DropdownLink from '@/Layouts/Components/DropdownLink.vue';
import NavLink from '@/Layouts/Components/NavLink.vue';
import {Link} from '@inertiajs/vue3';

const showingSidebar = ref(false);
const toggleSidebar = () => {
    showingSidebar.value = !showingSidebar.value;
};
</script>

<template>
    <div class="min-h-screen flex flex-col bg-gray-200 text-dark">
        <div
            :class="`fixed inset-y-0 left-0 w-64 bg-black text-white z-30 transform transition-transform ${
                showingSidebar ? 'translate-x-0' : '-translate-x-full'
            }`"
        >
            <div class="p-4 grid">
                <Link :href="route('dashboard')" class="flex items-center mb-8">
                    <img src="@/assets/img/logo-icono.jpg" class="h-9 w-auto"/>
                    <span class="ml-3 text-xl font-semibold text-primary">Courrier</span>
                </Link>
                <NavLink :href="route('dashboard')" :active="route().current('dashboard')" class="block mb-4">
                    Dashboard
                </NavLink>
                <NavLink :href="route('events.index')" :active="route().current('events.index')" class="block mb-4">
                    Eventos
                </NavLink>
                <NavLink :href="route('torta.index')" :active="route().current('torta.index')" class="block mb-4">
                    Torta
                </NavLink>
                <NavLink :href="route('orders.index')" :active="route().current('orders.index')" class="block mb-4">
                    Pedidos
                </NavLink>
                <DropdownLink :href="route('logout')" method="post" as="button" class="block mt-4">
                    Salir
                </DropdownLink>
            </div>
        </div>

        <div
            v-show="showingSidebar"
            @click="toggleSidebar"
            class="fixed inset-0 bg-black bg-opacity-50 z-20"
        ></div>

        <div class="flex-1 min-h-screen flex flex-col">
            <nav class="bg-black text-white shadow-md flex gap-3 items-center px-4 sm:px-6 lg:px-8 h-16">
                <button @click="toggleSidebar" class="text-gold focus:outline-none">
                    <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                         stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                </button>

                <Link :href="route('dashboard')" class="hidden sm:flex items-center">
                    <img src="@/assets/img/logo-icono.jpg" class="h-9 w-auto"/>
                    <span class="ml-3 text-xl font-semibold text-primary">Courrier</span>
                </Link>
            </nav>

            <header class="bg-white shadow" v-if="$slots.header">
                <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
                    <slot name="header"/>
                </div>
            </header>

            <main class="p-4 mx-4 my-4">
                <slot/>
            </main>
        </div>
    </div>
</template>

<style scoped>
.transition-transform {
    transition: transform 0.3s ease-in-out;
}
</style>
