<script setup>
import { Head } from "@inertiajs/vue3";
import MainLayout from "@/Layouts/MainLayout.vue";
import FormLogin from "@/Pages/Auth/Components/FormLogin.vue";
import FormRegister from "@/Pages/Auth/Components/FormRegister.vue";
</script>

<template>
    <Head title="Login" />
    <MainLayout>
        <div class="pt-10 flex items-center justify-center">
            <div class="w-full px-7 2xl:w-2/3 lg:mx-auto grid lg:grid-cols-2 gap-y-16">
                <FormLogin />
                <FormRegister />
            </div>
        </div>
    </MainLayout>
</template>

<style scoped>

</style>
