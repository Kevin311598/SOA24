<script setup>

import PrimaryInput from "@/Components/PrimaryInput.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import {usePage} from "@inertiajs/vue3";
import FormTextArea from "@/Components/FormTextArea.vue";

const form = defineModel()
const page = usePage()
const tortas = page.props.tortas
const emits = defineEmits(['submit'])

const submit = () => {
    emits("submit")
}

function selectTorta(torta) {
    const existing = form.value.tortas.find((t) => t.id === torta.id);
    if (!existing) {
        form.value.tortas.push({...torta, pivot: {quantity: 1}});
        form.value.total = parseFloat(form.value.total) + parseFloat(torta.precio);

    }
}

function removeTorta(index) {
    const torta = form.value.tortas[index];
    form.value.total = parseFloat(form.value.total) - torta.pivot.quantity * parseFloat(torta.precio);
    form.value.tortas.splice(index, 1);
}

function increaseQuantity(torta) {
    torta.pivot.quantity += 1;
    form.value.total = parseFloat(form.value.total) + parseFloat(torta.precio);
}

function decreaseQuantity(torta) {
    if (torta.pivot.quantity > 1) {
        torta.pivot.quantity -= 1;
        form.value.total = parseFloat(form.value.total) - parseFloat(torta.precio)
    }
}

const formattedTotal = () => {
    const total = parseFloat(form.value.total);
    return isNaN(total) ? '0.00' : total.toFixed(2);
};
</script>

<template>
    <div class="col-span-6 xl:col-span-6 w-full lg:w-3/4 mx-auto py-3 px-5 flex flex-col">
        <div class="mb-4">
            <h3 class="text-2xl lg:text-3xl xl:text-4xl text-gray-700 font-bold mb-2">
                <slot name="title"/>
            </h3>
            <p class="text-sm text-gray-500">
                <slot name="subtitle"/>
            </p>
        </div>
        <div class="flex-grow flex flex-col gap-4 mb-5">
            <PrimaryInput v-model="form.event_date" :error="form.errors.event_date"
                          label="Fecha de Evento" type="date"/>
            <PrimaryInput v-model="form.shipping_address" :error="form.errors.shipping_address"
                          label="Direccion de envio" type="text"/>
            <div class="mt-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">Tortas</label>

                <div class="flex overflow-x-scroll space-x-4 p-4 border rounded-lg bg-gray-50 shadow-inner">
                    <div v-for="torta in tortas" :key="torta.id"
                         class="flex-shrink-0 w-48 border rounded-lg p-2 cursor-pointer transition transform hover:shadow-xl hover:scale-105"
                         @click="selectTorta(torta)">
                        <img :src="$page.props.urls.storage_url+'/'+torta.imagen_url" alt="Imagen de torta"
                             class="h-24 w-full object-cover rounded"/>
                        <div class="text-center mt-2">
                            <p class="font-semibold text-gray-800">{{ torta.nombre }}</p>
                            <p class="text-sm text-gray-500">{{ torta.precio }}</p>
                        </div>
                    </div>
                </div>

                <div v-if="form.tortas.length" class="mt-6">
                    <div class="flex justify-between">
                        <p class="text-base font-semibold text-gray-700 mb-4">Tortas seleccionadas:</p>
                        <p class="text-base font-semibold text-gray-700 mb-4">{{ formattedTotal() }}</p>

                    </div>
                    <div class="space-y-4">
                        <div v-for="(torta, index) in form.tortas" :key="index"
                             class="flex items-center border rounded-lg shadow-sm p-4 bg-white">
                            <img :src="$page.props.urls.storage_url+'/'+torta.imagen_url"
                                 alt="Imagen de torta" class="h-16 w-16 rounded mr-4 shadow"/>
                            <div class="flex-grow">
                                <p class="font-semibold text-gray-800">{{ torta.nombre }}</p>
                                <div class="flex items-center mt-1">
                                    <button @click="decreaseQuantity(torta)"
                                            class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-bold py-1 px-3 rounded-l transition">
                                        -
                                    </button>
                                    <span class="px-4 font-semibold text-gray-700">{{ torta.pivot.quantity }}</span>
                                    <button @click="increaseQuantity(torta)"
                                            class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-bold py-1 px-3 rounded-r transition">
                                        +
                                    </button>
                                </div>
                            </div>
                            <button @click="removeTorta(index)"
                                    class="ml-auto bg-red-100 text-red-500 px-3 py-1 rounded-md hover:bg-red-200 transition">
                                Eliminar
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <FormTextArea
            id="details"
            label="Detalle"
            v-model="form.details"
            :error="form.errors.details"
        />
        <PrimaryButton @click="submit">Enviar</PrimaryButton>
    </div>
</template>

<style scoped>

</style>
