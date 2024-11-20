<script setup>
import InputPassword from "@/Components/InputPassword.vue";
import PrimaryInput from "@/Components/PrimaryInput.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import useFormAuth from "@/Composables/useFormAuth.js";
import ButtonAuthGoogle from "@/Pages/Auth/Components/ButtonAuthGoogle.vue";

const formAuth = useFormAuth();
const { form, submitLogin } = formAuth;
</script>

<template>
    <div class="bg-white rounded-lg shadow-lg p-8 w-full sm:w-3/4 mx-auto">
        <h3 class="text-2xl font-bold mb-6 text-center">Acceder</h3>

        <div class="flex-grow flex flex-col gap-4 mb-5">
            <PrimaryInput
                v-model="form.email"
                :error="form.errors.email"
                label="Correo Electrónico *"
                placeholder="tu.email@ejemplo.com"
            />
            <InputPassword
                v-model="form.password"
                :error="form.errors.password"
                placeholder="Tu contraseña"
            />
        </div>
        <PrimaryButton @click="submitLogin" class="w-full mb-4">Acceso</PrimaryButton>
        <ButtonAuthGoogle/>

    </div>
</template>

<style scoped>
</style>
