<script setup>
import CrudLayout from "@/Layouts/CrudLayout.vue";
import ThMain from "@/Components/ThMain.vue";
import TdMain from "@/Components/TdMain.vue";
import FormInput from "@/Components/FormInput.vue";
import {Torta} from "@/models/index.js";

const props = defineProps({
    tortas: {
        type: Array,
        default: []
    },
})

</script>

<template>
    <CrudLayout route_str="torta" :models="tortas" :model="Torta" title="Tortas"
                single_title="Torta">
        <template #th>
            <ThMain>Nombre</ThMain>
            <ThMain>Precio</ThMain>
        </template>
        <template v-slot:tr="{item}">
            <TdMain first>{{ item.nombre }}</TdMain>
            <TdMain first>{{ item.precio }}</TdMain>
        </template>

        <template v-slot:modal_form="{item}">
            <FormInput id="nombre" label="Nombre"
                       v-model="item.nombre"
                       :error="item.errors.nombre"
                       required autofocus/>
            <FormInput id="precio" label="Precio"
                       type="number" step="0.1"
                       v-model="item.precio"
                       :error="item.errors.precio"
                       required/>
            <FormInput accept="image/*" id="imagen_url" label="Imagen" type="file"
                       v-model="item.imagen_url"
                       :error="item.errors.imagen_url"
            />
        </template>

        <template v-slot:msj_delete="{item}">
            {{ item.nombre }}
        </template>
    </CrudLayout>
</template>
