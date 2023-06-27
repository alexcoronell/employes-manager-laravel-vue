<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';

const props = defineProps({ department: {type: Object}})

const form = useForm({
    name: props.department.name
})

</script>


<template>
    <Head title="Edit Department" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Create Departments</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-4">
                    <form @submit.prevent="$event => form.patch(route('departments.update', department))" class="mt-6 space-y-6 max-w-xl">
                        <InputLabel for="name" value="Department"></InputLabel>
                        <TextInput type="text" id="name" v-model="form.name" autofocus required class="mt-1 block w-full"></TextInput>
                        <InputError :message="form.errors.name" class="mt-2"></InputError>
                        <PrimaryButton :disable="form.processing"><i class="fa-solid fa-save"></i> Save</PrimaryButton>
                    </form>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
