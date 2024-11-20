<script setup>
import TrashSvg from "@/Components/Svg/TrashSvg.vue";
import PlusSvg from "@/Components/Svg/PlusSvg.vue";
import {watchEffect} from "vue";

const items = defineModel()
const generateUid = () => `${Date.now()}-${Math.floor(Math.random() * 1000)}`;
const {model} = defineProps({
    model: Object
})
const pushStory = () => {
    items.value.push({...model, uid:Date.now()})
}

const removeStory = (index) => {
    if (items.value.length > 1) {
        items.value.splice(index, 1);
    }
};

watchEffect(() => {
    items.value.forEach(item => {
        if (!item.uid) {
            item.uid = generateUid();
        }
    });
})
</script>

<template>
    <div class="space-y-4">
        <div class="flex justify-end">
            <button
                @click="pushStory"
                class="inline-flex items-center gap-2 bg-success text-white p-2 rounded-md shadow-md hover:bg-primary-dark transition-all
                        duration-300 ease-in-out transform hover:scale-105"
            >
                <PlusSvg fill="fill-white" class="w-8 h-8"/>
                Agregar
            </button>
        </div>
        <TransitionGroup name="list">
            <div v-for="(item, index) in items" :key="item.uid"
                 class="transition-opacity duration-500 ease-in-out">
                <div class="flex gap-2 items-center mb-4 opacity-100">
                    <slot :obj="{item,index}"/>
                    <button
                        @click="removeStory(index)"
                        class="text-red-600 hover:text-red-800 transition-all duration-200"
                    >
                        <TrashSvg stroke="stroke-danger" class="w-8 h-8"/>
                    </button>
                </div>
            </div>
        </TransitionGroup>
    </div>
</template>

<style scoped>
.list-enter-active,
.list-leave-active {
    transition: all 0.5s ease;
}

.list-enter-from,
.list-leave-to {
    opacity: 0;
    transform: translateX(30px);
}
</style>
