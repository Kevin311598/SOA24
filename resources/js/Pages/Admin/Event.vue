<script setup>
import CrudLayout from "@/Layouts/CrudLayout.vue";
import ThMain from "@/Components/ThMain.vue";
import TdMain from "@/Components/TdMain.vue";
import FormInput from "@/Components/FormInput.vue";
import {Event} from "@/models/index.js";
import FormTextArea from "@/Components/FormTextArea.vue";

const props = defineProps({
    events: {
        type: Array,
        default: []
    },
})

</script>

<template>
    <CrudLayout route_str="events" :models="events" :model="Event" title="Eventos"
                single_title="Evento">
        <template #th>
            <ThMain>Nombre</ThMain>
        </template>
        <template v-slot:tr="{item}">
            <TdMain first>{{ item.name }}</TdMain>
        </template>

        <template v-slot:modal_form="{item}">
            <FormInput id="name" label="Nombre"
                       v-model="item.name"
                       :error="item.errors.name"
                       required autofocus/>
            <FormTextArea
                id="titulo"
                label="Titulo"
                v-model="item.titulo"
                :error="item.errors.titulo"
            />
            <FormTextArea
                id="sub_titulo"
                label="Sub Titulo"
                v-model="item.sub_titulo"
                :error="item.errors.sub_titulo"
            />
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