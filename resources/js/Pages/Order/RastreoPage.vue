<script setup>
import {ref} from "vue";
import {Head} from "@inertiajs/vue3";
import MainLayout from "@/Layouts/MainLayout.vue";

const props = defineProps({
    orders: {
        type: Array,
        default: [],
    },
});

const searchId = ref("");
const filteredOrder = ref(props.orders);

const filterOrders = () => {
    if (!searchId.value) {
        filteredOrder.value = props.orders;
    } else {
        filteredOrder.value = props.orders.filter(order => order.order_code.includes(searchId.value.toString()))
    }
};

</script>

<template>
    <Head title="Buscar Pedidos"/>
    <MainLayout>
        <div class="w-full relative sm:px-7 md:px-4 lg-px-0 xl:mx-auto
        xl:w-5/6 2xl:w-4/5 mx-auto py-10">

            <h1 class="text-3xl font-bold text-primary-default mb-6">
                Buscar un Pedido
            </h1>
            <div class="flex mb-8">
                <input
                    v-model="searchId"
                    type="text"
                    placeholder="Introduce el Codigo del Pedido"
                    class="border border-gray-300 rounded-lg py-2 px-4 w-1/2"
                    @input="filterOrders"
                />
            </div>

            <div class="overflow-x-auto">
                <table class="table-auto w-full border-collapse border border-gray-200 rounded-lg shadow-md">
                    <thead class="bg-primary-hover text-white">
                    <tr>
                        <th class="border border-gray-200 px-4 py-2">CODIGO</th>
                        <th class="border border-gray-200 px-4 py-2">Evento</th>
                        <th class="border border-gray-200 px-4 py-2">FECHA EVENTO</th>
                        <th class="border border-gray-200 px-4 py-2">FECHA DE ENTREGA</th>
                        <th class="border border-gray-200 px-4 py-2">ESTADO</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr
                        v-for="order in filteredOrder"
                        :key="order.id"
                        class="hover:bg-gray-100"
                    >
                        <td class="border border-gray-200 px-4 py-2 text-center">
                            {{ order.order_code }}
                        </td>
                        <td class="border border-gray-200 px-4 py-2">
                            {{ order.event.name }}
                        </td>
                        <td class="border border-gray-200 px-4 py-2 text-center">
                            {{ order.event_date }}
                        </td>
                        <td class="border border-gray-200 px-4 py-2 text-center">
                            {{ order.delivery_date }}
                        </td>
                        <td class="border border-gray-200 px-4 py-2 capitalize">
                            {{ order.status }}
                        </td>
                    </tr>

                    <tr v-if="filteredOrder.length === 0">
                        <td colspan="4" class="text-center text-gray-500 py-4">
                            No se encontraron eventos con ese ID.
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </MainLayout>
</template>

<style scoped>
.container {
    max-width: 800px;
}

input:focus {
    outline: none;
    border-color: #2563eb; /* Azul */
    box-shadow: 0 0 3px #2563eb;
}

table {
    border-spacing: 0;
}
</style>
