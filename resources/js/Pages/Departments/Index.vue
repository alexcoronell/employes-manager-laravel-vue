<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import DangerButton from '@/Components/DangerButton.vue';
import Swal from 'sweetalert2'

const props = defineProps({
    departments: { type: Object }
})

const form = useForm({
    id: ''
})

const deleteDepartment = () => {
    const alertMessage = Swal.mixin({
        buttonsStyling: true
    });
    alertMessage.fire({
        title: 'Are you sure delete ' +name+ '?',
        icon: 'question', showCancelButton: true,
        confirmButtonText: '<i class="fa-solid fa-check"></i> Yes, delete',
        cancelButtonText: '<i class="fa-solid fa-ban"></i> Cancel'
    }).then(result => {
        if(result.isConfirmed) {
            form.delete(route('departments.destroy', id));
        }
    })
}

</script>

<template>
    <Head title="Departments" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Departments</h2>
        </template>

        <div class="py-12">
            <div class="bg-white grid v-screen place-items-center">
                <div class="mt-3 mb-3 flex">
                    <Link :href="route('departments.create')" :class="'px-4 py-2 bg-gray-800 text-white border rounded-md font-semibold text-xs'">
                        <i class="fa-solid fa-plus-circle"></i> Add
                    </Link>
                </div>
            </div>
            <div class="bg-white grid v-screen place-items-center">
                <table class="table-auto border border-gray-400">
                    <thead class="bg-gray-100">
                        <th class="p-4">#</th>
                        <th class="p-4">Department</th>
                        <th class="p-4"></th>
                        <th class="p-4"></th>
                    </thead>

                    <tbody>
                        <tr v-for="dep, i in departments" :key="dep.id">
                            <td class="border border-gray-400 p-4">{{ (i+1) }}</td>
                            <td class="border border-gray-400 p-4">{{ dep.name }}</td>
                            <td class="border border-gray-400 p-4">
                                <Link :href="route('departments.edit', dep.id)" :class="'px-4 py-2 bg-yellow-400 text-white border rounded-md font-semibold text-xs'">
                                    <i class="fa-solid fa-plus-edit"></i>
                                </Link>
                            </td>
                            <td class="border border-gray-400 p-4">
                                <DangerButton @click="$event => deleteDepartment(dep.id, dep.name)">
                                    <i class="fa-solid fa-plus-trash py-2"></i>
                                </DangerButton>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
