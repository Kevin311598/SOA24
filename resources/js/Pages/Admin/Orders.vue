<script setup>
import CrudLayout from "@/Layouts/CrudLayout.vue";
import ThMain from "@/Components/ThMain.vue";
import TdMain from "@/Components/TdMain.vue";
import FormInput from "@/Components/FormInput.vue";
import FormSelect from "@/Components/FormSelect.vue";
import {Order} from "@/models/index.js";
import FormTextArea from "@/Components/FormTextArea.vue";

const props = defineProps({
    orders: {
        type: Array,
        default: []
    },
    tortas: {
        type: Array,
        default: []
    },
    events: {
        type: Array,
        default: []
    },
    customers: {
        type: Array,
        default: []
    },
});

const statuses =
    [
        {nombre: 'pendiente'},
        {nombre: 'confirmado'},
        {nombre: 'preparando'},
        {nombre: 'enviado'},
        {nombre: 'entregado'},
        {nombre: 'cancelado'}
    ]

function selectTorta(order, torta) {
    const existing = order.tortas.find((t) => t.id === torta.id);
    if (!existing) {
        order.tortas.push({...torta, pivot: {quantity: 1}});
        order.total = parseFloat(order.total) + parseFloat(torta.precio);
    }
}

function removeTorta(order, index) {
    const torta = order.tortas[index];
    order.total = parseFloat(order.total) - torta.pivot.quantity * parseFloat(torta.precio);
    order.tortas.splice(index, 1);
}

function increaseQuantity(order, torta) {
    torta.pivot.quantity += 1;
    order.total = parseFloat(order.total) + parseFloat(torta.precio);
}

function decreaseQuantity(order, torta) {
    if (torta.pivot.quantity > 1) {
        torta.pivot.quantity -= 1;
        order.total = parseFloat(order.total) - parseFloat(torta.precio)
    }
}

const formattedTotal = (item) => {
    const total = parseFloat(item.total);
    return isNaN(total) ? '0.00' : total.toFixed(2);
};

</script>

<template>
    <CrudLayout route_str="orders" :models="orders" :model="Order" title="Pedidos"
                single_title="Pedido">
        <template #th>
            <ThMain>Codigo</ThMain>
            <ThMain>Cliente</ThMain>
            <ThMain>Evento</ThMain>
            <ThMain>Fecha de Evento</ThMain>
            <ThMain>Fecha de Entrega</ThMain>
            <ThMain>Direccion de Envio</ThMain>
            <ThMain>Estado</ThMain>
        </template>
        <template v-slot:tr="{item}">
            <TdMain first>{{ item.order_code }}</TdMain>
            <TdMain>{{ item.customer.full_name }}</TdMain>
            <TdMain>{{ item.event.name }}</TdMain>
            <TdMain>{{ item.event_date }}</TdMain>
            <TdMain>{{ item.delivery_date }}</TdMain>
            <TdMain>{{ item.shipping_address }}</TdMain>
            <TdMain>{{ item.status }}</TdMain>
        </template>

        <template v-slot:modal_form="{item}">
            <template v-if="item.id && !item.confirmed_at">
                <FormInput id="delivery_date" label="Fecha del Entrega"
                           type="date"
                           v-model="item.delivery_date"
                           :error="item.errors.delivery_date"
                           required/>
            </template>
            <template v-else>
                <FormSelect
                    id="user_id"
                    label="Cliente"
                    :options="customers.map(e => ({ label: e.full_name, value: e.id }))"
                    v-model="item.user_id"
                    :error="item.errors.user_id"
                    required
                />
                <FormSelect
                    id="event_id"
                    label="Evento"
                    :options="events.map(e => ({ label: e.name, value: e.id }))"
                    v-model="item.event_id"
                    :error="item.errors.event_id"
                    required
                />
                <FormInput id="event_date" label="Fecha del Evento"
                           type="date"
                           v-model="item.event_date"
                           :error="item.errors.event_date"
                           required/>
                <FormInput id="delivery_date" label="Fecha del Entrega"
                           type="date"
                           v-model="item.delivery_date"
                           :error="item.errors.delivery_date"
                           required/>
                <FormInput id="shipping_address" label="Direccion de Envio"
                           v-model="item.shipping_address"
                           :error="item.errors.shipping_address"
                           required/>
                <FormSelect
                    id="status"
                    label="Estado"
                    :options="statuses.map(e => ({ label: e.nombre, value: e.nombre }))"
                    v-model="item.status"
                    :error="item.errors.status"
                    required
                />
                <div class="mt-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Tortas</label>

                    <div class="flex overflow-x-scroll space-x-4 p-4 border rounded-lg bg-gray-50 shadow-inner">
                        <div v-for="torta in tortas" :key="torta.id"
                             class="flex-shrink-0 w-48 border rounded-lg p-2 cursor-pointer transition transform hover:shadow-xl hover:scale-105"
                             @click="selectTorta(item, torta)">
                            <img :src="$page.props.urls.storage_url+'/'+torta.imagen_url" alt="Imagen de torta"
                                 class="h-24 w-full object-cover rounded"/>
                            <div class="text-center mt-2">
                                <p class="font-semibold text-gray-800">{{ torta.nombre }}</p>
                                <p class="text-sm text-gray-500">{{ torta.precio }}</p>
                            </div>
                        </div>
                    </div>


                    <div v-if="item.tortas.length" class="mt-6">
                        <div class="flex justify-between">
                            <p class="text-base font-semibold text-gray-700 mb-4">Tortas seleccionadas:</p>
                            <p class="text-base font-semibold text-gray-700 mb-4">{{ formattedTotal(item) }}</p>

                        </div>
                        <div class="space-y-4">
                            <div v-for="(torta, index) in item.tortas" :key="index"
                                 class="flex items-center border rounded-lg shadow-sm p-4 bg-white">
                                <img :src="$page.props.urls.storage_url+'/'+torta.imagen_url"
                                     alt="Imagen de torta" class="h-16 w-16 rounded mr-4 shadow"/>
                                <div class="flex-grow">
                                    <p class="font-semibold text-gray-800">{{ torta.nombre }}</p>
                                    <div class="flex items-center mt-1">
                                        <button @click="decreaseQuantity(item, torta)"
                                                class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-bold py-1 px-3 rounded-l transition">
                                            -
                                        </button>
                                        <span class="px-4 font-semibold text-gray-700">{{ torta.pivot.quantity }}</span>
                                        <button @click="increaseQuantity(item, torta)"
                                                class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-bold py-1 px-3 rounded-r transition">
                                            +
                                        </button>
                                    </div>
                                </div>
                                <button @click="removeTorta(item, index)"
                                        class="ml-auto bg-red-100 text-red-500 px-3 py-1 rounded-md hover:bg-red-200 transition">
                                    Eliminar
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <FormTextArea
                    id="details"
                    label="Detalle"
                    v-model="item.details"
                    :error="item.errors.details"
                />
            </template>
        </template>

        <template v-slot:msj_delete="{item}">
            Código: {{ item.order_code }}
        </template>
    </CrudLayout>
</template>
