<script setup>
import {Head} from "@inertiajs/vue3";
import MainLayout from "@/Layouts/MainLayout.vue";
import FormOrder from "@/Pages/Order/Components/FormOrder.vue";
import useFormOrder from "@/Composables/useFormOrder.js";
import ContentLayout from "@/Pages/Order/Layouts/ContentLayout.vue";
import ModalSuccessful from "@/Components/ModalSuccessful.vue";
import {onMounted} from "vue";

const {form, successful, submit} = useFormOrder()

const props = defineProps({
    event: Object,
    order_code: Object
})

onMounted(() => {
    form.event_id = props.event.id
})
</script>

<template>
    <Head :title="'Pedido '+event.name"/>
    <MainLayout>
        <ContentLayout>
            <template #image>
                <div class="col-span-4 xl:col-span-4 hidden lg:block">
                    <img :src="`${$page.props.urls.storage_url}/${event.img_url}`" alt=""
                         class="w-full max-h-[600px] object-contain">
                </div>
            </template>
            <template #form>
                <FormOrder v-model="form" @submit="submit">
                    <template #title>
                        {{ event.titulo }}
                    </template>
                    <template #subtitle>
                        {{ event.sub_titulo }}
                    </template>
                </FormOrder>
            </template>
        </ContentLayout>
        <ModalSuccessful v-model:successful="successful">
            Solicitud Enviada {{$page.props.order_code}}
        </ModalSuccessful>
    </MainLayout>

</template>

<style scoped>

</style>
