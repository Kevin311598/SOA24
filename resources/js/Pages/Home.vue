<script setup>
import { ref, onMounted, onBeforeUnmount } from 'vue';
import { Head } from '@inertiajs/vue3';
import MainLayout from "@/Layouts/MainLayout.vue";
import Delivery from '@/assets/slider/delivery.jpg';
import Birthday from '@/assets/slider/birthday.jpg';
import Wedding from '@/assets/slider/wedding.webp';

const currentSlide = ref(0);

const images = [
    { src: Delivery, alt: 'Delivery', subtitle: 'Servicio de Delivery' },
    { src: Birthday, alt: 'Cumpleaños', subtitle: 'Celebra tu Cumpleaños' },
    { src: Wedding, alt: 'Matrimonio', subtitle: 'Tortas para Matrimonios' },
];

const next = () => {
    currentSlide.value = (currentSlide.value + 1) % images.length;
};

const go = (index) => {
    currentSlide.value = index;
};

let sliderInterval;
onMounted(() => {
    sliderInterval = setInterval(next, 5000);
});

onBeforeUnmount(() => {
    clearInterval(sliderInterval);
});
</script>

<template>
    <Head title="Inicio" />
    <MainLayout>
        <div class="relative w-full h-[90vh] max-w-full mx-auto overflow-hidden">
            <div class="flex transition-transform duration-700 ease-in-out h-full"
                 :style="{ transform: `translateX(-${currentSlide * 100}%)` }">
                <div v-for="(image, index) in images" :key="index" class="w-full flex-shrink-0 h-full relative">
                    <img :src="image.src" :alt="image.alt" class="w-full h-full object-cover" />

                    <div class="absolute inset-0 bg-black/60 flex items-center justify-start">
                        <h2 class="text-white text-2xl lg:text-4xl font-bold ml-10">
                            {{ image.subtitle }}
                        </h2>
                    </div>
                </div>
            </div>

            <div class="absolute bottom-4 left-1/2 transform -translate-x-1/2 flex gap-2">
                <span v-for="(image, index) in images" :key="index"
                      @click="go(index)"
                      class="h-3 w-3 rounded-full cursor-pointer transition-all duration-300"
                      :class="{ 'bg-primary-default': index === currentSlide, 'bg-gray-300': index !== currentSlide }">
                </span>
            </div>
        </div>
    </MainLayout>
</template>

<style scoped>
.slider img {
    height: 100%;
    object-fit: cover;
}
</style>
