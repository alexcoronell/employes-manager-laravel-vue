<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import { ref } from 'vue';
import SelectInput from '@/Components/SelectInput.vue';
import InputLabel from '@/Components/InputLabel.vue';
import DataTable from 'datatables.net-vue3';
//import '../../../../node_modules/datatables.net-dt/css/jquery.dataTables.min.css'
//import 'datatables.net-dt/css/jquery.dataTables.min.css';
import ButtomHtml5 from 'datatables.net-buttons/js/buttons.html5';
import 'datatables.net-buttons/js/buttons.print';
import 'datatables.net-responsive-dt';
//import 'datatables.net-responsive-dt/css/responsive.datatables.min.css';
import JsZip from 'jszip';
import pdfmake from 'pdfmake/build/vfs_fonts';
import * as pdfFonts from 'pdfmake/build/vfs_fonts';

pdfmake.vfs = pdfFonts-pdfmake ? pdfFonts.pdfmake.vfs : pdfmake.vfs;
window.JSZip = JsZip;
DataTable.use(ButtomHtml5)

const props = defineProps({
    employees: { type: Object },
    departments: { type: Object }
})

const columns1 = ref([]);
const columns2 = ref([]);
const buttons1 = ref([]);
const buttons2 = ref([]);
const report = ref('1');
const types = ref([{'id': '1', 'name': 'Employees'}, {'id': '2', 'name': 'Departments'}]);

columns1.value = 
    [
    { data:null , render: function(data, type, row, meta){return (meta.row + 1)}},
    { data: 'name' },
    { data: 'email' },
    { data: 'phone' },
    { data: 'department' },
    ]

columns2.value = 
    [
    { data:null , render: function(data, type, row, meta){return (meta.row + 1)}},
    { data: 'name' },
    ]

    buttons1.value = [
        {
            title: 'Employees', extends: 'excelHtml5',
            text: '<i class="fa-solid fa-file-excel"></i> Excel',
            className: 'inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 focus:bg-green-700 active:bg-green-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150'
        },
        {
            title: 'Employees', extends: 'pdfHtml5',
            text: '<i class="fa-solid fa-file-pdf"></i> PDF',
            className: 'inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-500 active:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-150'
        },
        {
            title: 'Employees', extends: 'print',
            text: '<i class="fa-solid fa-print"></i> Print',
            className: 'inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150'
        },
        {
            title: 'Employees', extends: 'copy',
            text: '<i class="fa-solid fa-copy"></i> Copy',
            className: 'inline-flex items-center px-4 py-2 bg-gray-200 border border-gray-800 rounded-md font-semibold text-xs uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150'
        }
    ]

    buttons2.value = [
        {
            title: 'Departments', extends: 'excelHtml5',
            text: '<i class="fa-solid fa-file-excel"></i> Excel',
            className: 'inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 focus:bg-green-700 active:bg-green-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150'
        },
        {
            title: 'Departments', extends: 'pdfHtml5',
            text: '<i class="fa-solid fa-file-pdf"></i> PDF',
            className: 'inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-500 active:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-150'
        },
        {
            title: 'Departments', extends: 'print',
            text: '<i class="fa-solid fa-print"></i> Print',
            className: 'inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150'
        },
        {
            title: 'Departments', extends: 'copy',
            text: '<i class="fa-solid fa-copy"></i> Copy',
            className: 'inline-flex items-center px-4 py-2 bg-gray-200 border border-gray-800 rounded-md font-semibold text-xs uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150'
        }
    ]

</script>

<template>
    <Head title="Reports" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Reports</h2>
        </template>

        <div class="py-12">
            <div class="mx-auto sm:px-6 lg:px-8">
                <div class="px-6 py-6 bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <InputLabel for="rep" value="Report: "></InputLabel>
                    <SelectInput id="rep" class="mt-1 block w-3/4" v-model="report" :options="types">
                    </SelectInput>
                </div>

                <div v-if="report == 1" class="px-6 py-6 bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <DataTable :data="employees" :columns="columns1" class="w-full border border-gray-400" :options="{responsive: true, autoWidth: false, dom:'Bfrtip', buttons:buttons1}">
                        <thead class="bg-gray-100">
                        <th class="p-2 text-left">#</th>
                        <th class="p-2 text-left">NAME</th>
                        <th class="p-2 text-left">EMAIL</th>
                        <th class="p-2 text-left">PHONE</th>
                        <th class="p-2 text-left">DEPARTMENT</th>
                    </thead>
                    </DataTable>
                </div>

                <div v-else class="px-6 py-6 bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <DataTable :data="departments" :columns="columns2" class="w-full border border-gray-400" :options="{responsive: true, autoWidth: false, dom:'Bfrtip', buttons:buttons2}">
                        <thead class="bg-gray-100">
                        <th class="p-2 text-left">#</th>
                        <th class="p-2 text-left">NAME</th>

                    </thead>
                    </DataTable>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
