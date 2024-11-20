<script setup>
import ButtonEye from "@/Components/ButtonEye.vue";
import PrimaryInput from "@/Components/PrimaryInput.vue";
import {computed, ref, watch} from "vue";

const show = ref(false)
const showPassword = computed(()=> show.value ? "text" : "password")
</script>

<template>
    <PrimaryInput label="Contraseña" :component="ButtonEye" :type="showPassword" >
        <template #component>
            <ButtonEye class="w-5 h-5 cursor-pointer" v-model="show"/>
        </template>
    </PrimaryInput>
</template>

<style scoped>

</style>
