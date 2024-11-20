<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import {ref} from "vue";
import {Head, router, useForm} from "@inertiajs/vue3";
import TableMain from "@/Layouts/Components/TableMain.vue";
import ModalForm from "@/Layouts/Components/ModalForm.vue";
import ModalDelete from "@/Layouts/Components/ModalDelete.vue";
import ThMain from "@/Components/ThMain.vue";

const {model, route_str, title, single_title, models} = defineProps({
    title: String,
    single_title: String,
    model: Object,
    models: Array,
    route_str: String,
    maxWidth: String
});

const showFormModal = ref(false);
const showDeleteModal = ref(false);
const selectedModel = useForm({...model});

const deepClone = (obj) => JSON.parse(JSON.stringify(obj));
const openCreateModal = () => {
    Object.assign(selectedModel, deepClone(model));
    showFormModal.value = true;
};

const openEditModal = (news) => {
    Object.assign(selectedModel, deepClone(news));
    showFormModal.value = true;
};

const openDeleteModal = (news) => {
    Object.assign(selectedModel, deepClone(news));
    showDeleteModal.value = true;
};

const closeModals = () => {
    Object.assign(selectedModel, deepClone(model));

    showFormModal.value = false;
    showDeleteModal.value = false;
};

const saved = () => {
    if (selectedModel.id) {
        selectedModel.post(route(`${route_str}.update`, selectedModel.id), {
            onSuccess: () => closeModals(),
        });
    } else {
        selectedModel.post(route(`${route_str}.store`), {
            onSuccess: () => closeModals()
        });
    }
};

const deleted = () => {
    selectedModel.delete(route(`${route_str}.destroy`, selectedModel.id), {
        onSuccess: () => closeModals()
    });
};
</script>

<template>
    <Head :title="title"/>
    <AuthenticatedLayout>
        <template #header>
            <div class="flex justify-between items-center">
                <h1 class="text-2xl font-semibold text-dark">{{ title }}</h1>
                <button
                    @click="openCreateModal"
                    class="bg-blue-500 text-white px-6 py-2 rounded-lg shadow-lg hover:bg-dark hover:text-white focus:outline-none transition duration-200 ease-in-out transform hover:scale-105"
                >
                    Crear {{ single_title }}
                </button>
            </div>
        </template>

        <TableMain @delete="openDeleteModal" @edit="openEditModal" :news-items="models">
            <template #th>
                <slot name="th"/>
                <ThMain/>
            </template>
            <template v-slot:tr="{ item }">
                <slot name="tr" :item="item"/>
            </template>
        </TableMain>

        <ModalForm
            :show="showFormModal"
            @close="closeModals"
            @saved="saved"
            :max-width="maxWidth"
        >
            <template #title>
                {{ selectedModel.id ? 'Editar ' + single_title : 'Crear ' + single_title }}
            </template>
            <slot name="modal_form" :item="selectedModel"/>
        </ModalForm>

        <ModalDelete
            :show="showDeleteModal"
            :title="single_title"
            @close="closeModals"
            @deleted="deleted"
        >
            <p class="text-lg font-semibold">¿Estás seguro que deseas eliminar <span class="text-danger">{{ single_title }}</span>?</p>
            <p class="text-sm text-gray-600 mt-1">Esta acción no se puede deshacer.</p>
            <slot name="msj_delete" :item="selectedModel"/>
        </ModalDelete>
    </AuthenticatedLayout>
</template>


<style scoped>
/* Estilos adicionales si son necesarios */
</style>
