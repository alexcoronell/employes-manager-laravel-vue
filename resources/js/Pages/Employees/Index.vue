<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import DangerButton from '@/Components/DangerButton.vue';
import Swal from 'sweetalert2'
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import SelectInput from '@/Components/SelectInput.vue';
import WarningButton from '@/Components/WarningButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import Modal from '@/Components/Modal.vue';
import { nextTick, ref } from 'vue';
import VueTailwindPagination from '../../../../node_modules/vue-tailwind-pagination';

const nameInput = ref(null);
const modal = ref(false);
const title = ref('');
const operation = ref(1);
const id = ref('');

const props = defineProps({
    employees: { type: Object },
    departments: { type: Object }
});

const formPage = useForm({});

const onPageClick = event => {
    formPage.get(route('employees.index', { page: event}));
};

const openModal = (op, name, email, phone, department, employee) => {
    modal.value = true;
    nextTick(() => nameInput.value.focus());
    operation.value = op;
    id.value = employee;
    if(op === 1) {
        title.value = 'Create employee'
    } else {
        title.value = 'Edit employee'
        form.name = name;
        form.email = email;
        form.phone = phone;
        form.department_id = department;
    }
};

const closeModal = () => {
    modal.value = false;
    form.reset();
}

const form = useForm({
    name: '',
    email: '',
    phone: '',
    department_id: ''
})

const save = () => {
    if(operation.value === 1) {
        form.post(route('employees.store'), {
            onSuccess: () => {ok('Employee created')}
        });
    } else {
        form.put(route('employees.update', id.value), {
            onSuccess: () => {ok('Employee updated')}
        });
    }
}

const ok = (msj) => {
    form.reset()
    closeModal();
    Swal.fire({title: msj, icon: 'success'})
}

const deleteEmployee = (id) => {
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
            form.delete(route('employees.destroy', id), {
                onSuccess: () => {ok('Employee deleted')}
            });
        }
    })
}


</script>

<template>
    <Head title="Employees" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Employees</h2>
        </template>

        <div class="py-12">
            <div class="bg-white grid v-screen place-items-center">
                <div class="mt-3 mb-3 flex">
                    <PrimaryButton @click="$event => openModal(1)" :class="'px-4 py-2 bg-gray-800 text-white border rounded-md font-semibold text-xs'">
                        <i class="fa-solid fa-plus-circle"></i> Add
                    </PrimaryButton>
                </div>
            </div>
            <div class="bg-white grid v-screen place-items-center overflow-x-auto">
                <table class="table-auto border border-gray-400">
                    <thead class="bg-gray-100">
                        <th class="p-2">#</th>
                        <th class="p-2">NAME</th>
                        <th class="p-2">EMAIL</th>
                        <th class="p-2">PHONE</th>
                        <th class="p-2">DEPARTMENT</th>
                        <th class="p-2"></th>
                        <th class="p-2"></th>
                    </thead>

                    <tbody>
                        <tr v-for="emp, i in employees.data" :key="emp.id">
                            <td class="border border-gray-400 p-2">{{ (i+1) }}</td>
                            <td class="border border-gray-400 p-2">{{ emp.name }}</td>
                            <td class="border border-gray-400 p-2">{{ emp.email }}</td>
                            <td class="border border-gray-400 p-2">{{ emp.phone }}</td>
                            <td class="border border-gray-400 p-2">{{ emp.department }}</td>
                            <td class="border border-gray-400 p-2">
                                <WarningButton @click="openModal(2, emp.name, emp.email, emp.phone, emp.department_id, emp.id)" :class="'px-4 py-2 bg-yellow-400 text-white border rounded-md font-semibold text-xs'">
                                    <i class="fa-solid fa-plus-edit"></i>
                                </WarningButton>
                            </td>
                            <td class="border border-gray-400 p-4">
                                <DangerButton @click="$event => deleteEmployee(emp.id)">
                                    <i class="fa-solid fa-plus-trash py-2"></i>
                                </DangerButton>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="bg-white grid v-screen place-items-center">
                <!-- <VueTailwindPagination :current="employees.currentPage" :total="employees.total" :per-page="employees.perPage" @page-changed="$event => onPageClick($event)"></VueTailwindPagination> -->
            </div>
        </div>

        <Modal :show="modal" @close="closeModal">
            <h2 class="p-3 text-lg font mendium text-gray-900">{{ title }}</h2>
            <div class="p-3">
                <InputLabel for="name" value="Name:"></InputLabel>
                <TextInput id="name" ref="nameInput" v-model="form.name" type="text" class="mt-1 block w-3/4" placeholder="Name"></TextInput>
                <InputError :message="form.errors.name" class="mt-2"></InputError>
            </div>

            <div class="p-3">
                <InputLabel for="email" value="Email:"></InputLabel>
                <TextInput id="email" ref="nameInput" v-model="form.email" type="email" class="mt-1 block w-3/4" placeholder="Email"></TextInput>
                <InputError :message="form.errors.email" class="mt-2"></InputError>
            </div>

            <div class="p-3">
                <InputLabel for="phone" value="Phone:"></InputLabel>
                <TextInput id="phone" ref="nameInput" v-model="form.phone" type="text" class="mt-1 block w-3/4" placeholder="Phone"></TextInput>
                <InputError :message="form.errors.phone" class="mt-2"></InputError>
            </div>

            <div class="p-3">
                <InputLabel for="department_id" value="Department:"></InputLabel>
                <SelectInput id="department_id" ref="nameInput" v-model="form.department_id" class="mt-1 block w-3/4" :options="departments" ></SelectInput>
                <InputError :message="form.errors.department_id" class="mt-2"></InputError>
            </div>

            <div class="p-3 mt-3">
                <PrimaryButton type="submit" :disabled="form.processing" @click="save()">
                    <i class="fa-solid fa-save"></i> Save
                </PrimaryButton>
            </div>
            <div class="p-3 mt-6 flex justify-end">
                <SecondaryButton @click="closeModal" class="ml-3" :disabled="form.processing">
                    Cancel
                </SecondaryButton>
            </div>
        </Modal>
    </AuthenticatedLayout>
</template>
