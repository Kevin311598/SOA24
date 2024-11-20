<script setup>
import { ref, computed } from 'vue';
import { Head } from "@inertiajs/vue3";
import { Line } from 'vue-chartjs';
import {
    Chart as ChartJS,
    Title,
    Tooltip,
    Legend,
    LineElement,
    CategoryScale,
    LinearScale,
    PointElement,
    Filler
} from 'chart.js';
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";

ChartJS.register(Title, Tooltip, Legend, LineElement, CategoryScale, LinearScale, PointElement, Filler);

const { orders } = defineProps({
    orders: {
        type: Array,
        default: []
    }
});

const selectedYear = ref('2024');
const selectedMonth = ref('');

const filteredOrders = computed(() => {
    return orders.filter(order => {
        const orderDate = new Date(order.created_at.split('T')[0]);
        const orderYear = orderDate.getFullYear();
        const orderMonth = orderDate.getMonth() + 1;
        if (selectedMonth.value) {
            return orderYear === parseInt(selectedYear.value) && orderMonth === parseInt(selectedMonth.value);
        } else {
            return orderYear === parseInt(selectedYear.value);
        }
    });
});

const monthsInSpanish = [
    "Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio",
    "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"
];

const generateMonthLabels = (year) => {
    const months = [];
    for (let month = 1; month <= 12; month++) {
        months.push(`${monthsInSpanish[month - 1]} ${year}`);
    }
    return months;
};

const chartData = computed(() => {
    const months = generateMonthLabels(selectedYear.value);
    const orderCounts = months.map(month => {
        const monthNumber = monthsInSpanish.indexOf(month.split(' ')[0]) + 1;
        const count = filteredOrders.value.filter(order => {
            const orderDate = new Date(order.created_at.split('T')[0]);
            return orderDate.getFullYear() === parseInt(selectedYear.value) && orderDate.getMonth() + 1 === monthNumber;
        }).length;
        return Math.round(count);
    });

    return {
        labels: months,
        datasets: [{
            label: 'Pedidos por mes',
            data: orderCounts,
            borderColor: 'rgba(75, 192, 192, 1)',
            backgroundColor: 'rgba(75, 192, 192, 0.2)',
            fill: true,
        }]
    };
});

const chartOptions = {
    responsive: true,
    scales: {
        y: {
            ticks: {
                beginAtZero: true,
                callback: function (value) {
                    return value % 1 === 0 ? value : '';
                }
            }
        }
    },
    plugins: {
        legend: {
            position: 'top',
        },
        tooltip: {
            mode: 'index',
            intersect: false,
        },
    },
};

const ruta = (reporte) => {
    if (selectedYear.value) {
        return `/${reporte}/${selectedYear.value}/${selectedMonth.value}`;
    }
};
</script>

<template>
    <Head title="Dashboard"/>
    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-dark">
                Dashboard
            </h2>
        </template>
        <div class="flex flex-wrap justify-center w-[90%] mx-auto pt-20 gap-10">
            <div class="flex gap-4 mb-6">
                <div>
                    <input type="number" v-model="selectedYear" class="border px-4 py-2 rounded shadow-sm"
                           placeholder="Año" min="2020"/>
                </div>
                <div>
                    <select v-model="selectedMonth" class="border px-4 py-2 rounded shadow-sm">
                        <option value="">Todos los meses</option>
                        <option v-for="(month, index) in monthsInSpanish" :key="index" :value="index + 1">
                            {{ month }}
                        </option>
                    </select>
                </div>
            </div>
            <div class="w-full max-w-4xl">
                <Line :data="chartData" :options="chartOptions"/>
            </div>
            <div class="w-full max-w-4xl">
                <table class="min-w-full table-auto border-collapse bg-white shadow-lg">
                    <thead>
                    <tr>
                        <th class="border-b p-2 text-left text-gray-700 font-medium">Cliente</th>
                        <th class="border-b p-2 text-left text-gray-700 font-medium">Evento</th>
                        <th class="border-b p-2 text-left text-gray-700 font-medium">Fecha de Pedido</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="order in filteredOrders" :key="order.id">
                        <td class="border-b p-2">{{ order.customer.full_name }}</td>
                        <td class="border-b p-2">{{ order.event.name }}</td>
                        <td class="border-b p-2">{{ order.created_at.split('T')[0] }}</td>
                    </tr>
                    </tbody>
                </table>
            </div>
            <div class="mt-6">
                <a :href="ruta('reporte')" target="_blank"
                   class="px-6 py-3 bg-blue-600 text-white font-semibold rounded-lg shadow-md hover:bg-blue-700">
                    Exportar a Excel
                </a>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
