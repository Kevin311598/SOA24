<script setup>
import {ref} from 'vue';
import {Link, usePage} from "@inertiajs/vue3";
import NavLink from "@/Components/NavLink.vue";
import DropdownLink from "@/Components/DropdownLink.vue";
import Dropdown from "@/Components/Dropdown.vue";

const page = usePage()
const user = page.props.auth.user
const events =page.props.events
const isOffCanvasOpen = ref(false);

const toggleOffCanvas = () => {
    isOffCanvasOpen.value = !isOffCanvasOpen.value;
};


</script>

<template>
    <div>
        <div class="mb-5">
            <div class="bg-primary-600">
                <div class="flex gap-5 py-3 w-full px-7 xl:w-2/3 lg:mx-auto text-white">
                    <div class="flex gap-2 items-center">
                        <i class="fa-solid fa-phone"></i><span class="hidden md:block">(074) 753 996</span>
                    </div>
                    <div class="flex gap-2 items-center">
                        <i class="fa-brands fa-whatsapp"></i><span class="hidden md:block">933 123 753</span>
                    </div>
                    <div class="flex gap-2 items-center">
                        <i class="fa-solid fa-envelope"></i><span class="hidden md:block">serviciocliente@deliverytortitas.com</span>
                    </div>
                    <Link v-if="!user" :href="route('login')" class="flex gap-2 items-center">
                        <i class="fa-solid fa-user"></i>
                        Iniciar Sesión
                    </Link>
                    <Dropdown v-else align="left" width="48">
                        <template #trigger>
                            <span class="inline-flex rounded-md">
                                <button
                                    type="button"
                                    class="inline-flex items-center gap-2 rounded-md border border-transparent
                                     leading-4  focus:outline-none"
                                >
                                    <i class="fa-solid fa-user"></i>{{ user.full_name }}
                                </button>
                            </span>
                        </template>
                        <template #content>
                            <DropdownLink
                                :href="route('logout')"
                                method="post"
                                as="button"
                            >Salir
                            </DropdownLink>
                        </template>
                    </Dropdown>
                </div>
            </div>

            <div class="bg-primary-default text-white">
                <div class="flex justify-between items-center py-6 lg:py-8 w-full px-7 xl:w-2/3 lg:mx-auto">

                    <div class="text-3xl lg:text-5xl">Delivery Tortitas</div>

                    <div class="md:hidden">
                        <button @click="toggleOffCanvas" class="text-3xl focus:outline-none">
                            <i class="fa-solid fa-bars"></i>
                        </button>
                    </div>

                    <div class="hidden md:flex items-center gap-4">
                        <i class="fa-brands fa-instagram"></i>
                        <i class="fa-brands fa-facebook"></i>
                        <i class="fa-brands fa-youtube"></i>
                        <i class="fa-solid fa-cart-shopping"></i>
                    </div>
                </div>
            </div>

            <div
                class="fixed inset-0 z-50 bg-white transform transition-transform duration-300"
                :class="{'translate-x-0': isOffCanvasOpen, '-translate-x-full': !isOffCanvasOpen}"
            >
                <div class="p-4">
                    <button @click="toggleOffCanvas" class="text-3xl focus:outline-none">
                        <i class="fa-solid fa-times"></i>
                    </button>
                </div>

                <div class="flex flex-col items-center gap-4 py-8">
                    <NavLink :href="route('home')">Home</NavLink>
                    <Dropdown align="left" width="48">
                        <template #trigger>
                            <span class="inline-flex rounded-md">
                                <button
                                    type="button"
                                    class="inline-flex items-center rounded-md border border-transparent bg-white px-3 py-2 text-lg font-medium leading-4 text-gray-500 transition duration-150 ease-in-out hover:text-gray-700 focus:outline-none"
                                >
                                    Servicio de Tortas
                                    <svg
                                        class="-me-0.5 ms-2 h-4 w-4"
                                        xmlns="http://www.w3.org/2000/svg"
                                        viewBox="0 0 20 20"
                                        fill="currentColor"
                                    >
                                        <path
                                            fill-rule="evenodd"
                                            d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                            clip-rule="evenodd"
                                        />
                                    </svg>
                                </button>
                            </span>
                        </template>
                        <template #content>
                            <DropdownLink class="capitalize" v-for="event in events" :href="route('client.order.index', event.name)">{{event.name}}</DropdownLink>
                        </template>
                    </Dropdown>
                    <NavLink :href="route('client.order.rastreo')">Rastrear Pedido</NavLink>

                </div>
            </div>

            <div class="hidden md:flex items-center justify-center gap-4 py-4">
                <NavLink :href="route('home')">Home</NavLink>
                <Dropdown align="left" width="48">
                    <template #trigger>
                        <span class="inline-flex rounded-md">
                            <button
                                type="button"
                                class="inline-flex items-center rounded-md border border-transparent bg-white px-3 py-2 text-lg font-medium leading-4 text-gray-500 transition duration-150 ease-in-out hover:text-gray-700 focus:outline-none"
                            >
                                Servicio de Tortas
                                <svg
                                    class="-me-0.5 ms-2 h-4 w-4"
                                    xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 20 20"
                                    fill="currentColor"
                                >
                                    <path
                                        fill-rule="evenodd"
                                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                        clip-rule="evenodd"
                                    />
                                </svg>
                            </button>
                        </span>
                    </template>
                    <template #content>
                        <DropdownLink class="capitalize" v-for="event in events" :href="route('client.order.index', event.name)">{{event.name}}</DropdownLink>
                    </template>
                </Dropdown>
                <NavLink :href="route('client.order.rastreo')">Rastrear Pedido</NavLink>
            </div>
        </div>

        <div class="bg-gray-50">
            <slot/>
        </div>
    </div>
</template>

<style scoped>

</style>
