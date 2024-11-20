<script setup>
import {ref, watchEffect} from "vue";
import {usePage} from "@inertiajs/vue3";

const model = defineModel();
const {id, label, required, autofocus, type, error, accept} = defineProps({
    id: {type: String, default: 'id', required: true},
    label: {type: String},
    required: {type: Boolean, default: false},
    autofocus: {type: Boolean, default: false},
    type: {type: String, default: 'text'},
    error: {type: String, default: ''},
    accept: {type: String, default: ''}
});

const imagePreview = ref(null);
const isDragging = ref(false);

const handleFileChange = (event) => {
    console.log(event.target.files)
    const file = event.target.files[0];
    updateFile(file);
};

const handleDrop = (event) => {
    event.preventDefault();
    isDragging.value = false;
    const file = event.dataTransfer.files[0];
    updateFile(file);
};

const updateFile = (file) => {
    if (file) {
        model.value = file;
        if (file.type.startsWith("image/")) {
            imagePreview.value = URL.createObjectURL(file);
        } else {
            imagePreview.value = null;
        }
    }
};

const handleDragOver = (event) => {
    event.preventDefault();
    isDragging.value = true;
};

const handleDragLeave = () => {
    isDragging.value = false;
};

const page = usePage();
watchEffect(() => {
    const value = model.value;
    if (type === 'file' && typeof value === 'string' && value) {
        imagePreview.value = `${page.props.urls.storage_url}/${value}`;
    } else if (value instanceof File) {
        imagePreview.value = URL.createObjectURL(value);
    }
});
</script>

<template>
    <div>
        <label :for="id" class="block text-sm font-semibold text-gray-800 mb-1">{{ label }}</label>

        <div
            v-if="type === 'file'"
            class="flex flex-col items-center p-4 border-2 rounded-md bg-gray-50 transition"
            :class="{
                'border-dashed border-gray-300 hover:bg-gray-100': !isDragging,
                'border-solid border-primary bg-blue-50': isDragging,
            }"
            @dragover="handleDragOver"
            @dragleave="handleDragLeave"
            @drop="handleDrop"
        >
            <input
                :id="id"
                type="file"
                @change="handleFileChange"
                :accept="accept"
                class="hidden"
                :required="required"
            />

            <label :for="id" class="flex flex-col items-center cursor-pointer">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-gray-400 mb-2" viewBox="0 0 24 24"
                     fill="currentColor">
                    <path
                        d="M5 2a1 1 0 00-1 1v18a1 1 0 001 1h14a1 1 0 001-1V8l-6-6H5zm11 6V4.414L18.586 8H16zM6 20V4h8v6h6v10H6z"/>
                </svg>
                <p class="text-gray-600">Arrastra y suelta una imagen, o <span class="text-primary font-semibold">selecciona un archivo</span>
                </p>
            </label>

            <div v-if="imagePreview" class="mt-4 w-full flex justify-center">
                <img :src="imagePreview" alt="Vista previa de la imagen"
                     class="w-auto max-h-60 object-cover rounded-md border border-gray-300 shadow-md"/>
            </div>
        </div>

        <div v-else>
            <input
                :id="id"
                :type="type"
                v-model="model"
                :class="[
                    'mt-1 block w-full rounded-lg border border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50',
                    error ? 'border-red-500' : ''
                ]"
                :required="required"
            />
        </div>

        <p v-if="error" class="text-sm text-red-600 mt-1">{{ error }}</p>
    </div>
</template>

<style scoped>
input[type="file"] + label {
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 2rem;
    color: #4B5563;
    cursor: pointer;
    transition: background-color 0.2s;
}

input[type="file"] + label:hover {
    background-color: #f9fafb;
}
</style>
