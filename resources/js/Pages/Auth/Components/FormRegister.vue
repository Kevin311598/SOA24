<script setup>
import InputPassword from "@/Components/InputPassword.vue";
import PrimaryInput from "@/Components/PrimaryInput.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import useFormAuth from "@/Composables/useFormAuth.js";

const formAuth = useFormAuth();
const { form, submitRegister } = formAuth;
</script>

<template>
    <div class="bg-white rounded-lg shadow-lg p-8 w-full sm:w-3/4 mx-auto">
        <h3 class="text-2xl font-bold mb-6 text-center">Registrarse</h3>
        <div class="flex-grow flex flex-col gap-4 mb-5">
            <PrimaryInput
                v-model="form.full_name"
                :error="form.errors.full_name"
                label="Nombre y Apellido"
                placeholder="Juan Pérez"
            />
            <PrimaryInput
                v-model="form.email"
                :error="form.errors.email"
                label="Correo Electrónico"
                placeholder="tu.email@ejemplo.com"
            />
            <InputPassword
                v-model="form.password"
                :error="form.errors.password"
                placeholder="Tu contraseña"
            />
            <p class="text-sm text-gray-600">
                Tus datos personales se utilizarán para procesar tu pedido, mejorar tu experiencia en esta web,
                gestionar el acceso a tu cuenta y otros propósitos descritos en nuestra política de
                privacidad.
            </p>
        </div>
        <PrimaryButton @click="submitRegister" class="w-full">Registrarse</PrimaryButton>
    </div>
</template>

<style scoped>
</style>
