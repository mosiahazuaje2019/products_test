<template>
    <Head title="Patient" />

    <BreezeAuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Pacientes
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <PrimeButton class="add-btn" @click="createBrand">Nuevo</PrimeButton>
                        <DataTable v-model:filters="filters1" :value="patients" dataKey="id"
                         :paginator="true" class="p-datatable-customers" showGridlines 
                         :rows="10" :loading="loading1" responsiveLayout="scroll"
                         :globalFilterFields="['global','first_name','last_name', 'personal_id']">

                        <template #header>
                            <div class="flex justify-content-center">
                                <Button type="button" icon="pi pi-filter-slash" label="Clear" class="p-button-outlined" @click="clearFilter1()"/>
                                <span class="p-input-icon-left">
                                    <i class="pi pi-search" />
                                    <InputText v-model="filters1['global'].value" placeholder="Buscar" />
                                </span>
                            </div>
                        </template>

                            <Column field="first_name" header="Nombre">
                                <template #filter="{filterModel,filterCallback}">
                                    <InputText type="text" v-model="filterModel.value" class="p-column-filter"
                                   placeholder="Buscar por nombre"/>
                                </template>
                            </Column>
                            <Column field="last_name" header="Apellido"></Column>
                            <Column field="personal_id" header="Cedula"></Column>
                        </DataTable>
                    </div>
                </div>
            </div>

        </div>
    </BreezeAuthenticatedLayout>
</template>

<script>
import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue'
import { Head } from '@inertiajs/inertia-vue3';
import Swal from "sweetalert2";
import axios from "axios";
import {FilterMatchMode,FilterOperator} from 'primevue/api';

export default {
    name: "PatientPage",
    components: {
        BreezeAuthenticatedLayout,
        Head,
    },
    data () {
        return {
            patients: null,
            filters1: null,
            filters2: {
                'global': {value: null, matchMode: FilterMatchMode.CONTAINS},
                'first_name': {value: null, matchMode: FilterMatchMode.STARTS_WITH},
                'last_name': {value: null, matchMode: FilterMatchMode.STARTS_WITH},
                'personal_id': {value: null, matchMode: FilterMatchMode.EQUALS},
            },            
            loading1: true,
            loading2: true
        }
    },
    methods: {
        async getPatients() {
            await axios.get('/api/patients').then((res) => {
                this.patients = res.data
                this.loading1 = false;
            })
        },
        initFilters1() {
            this.filters1 = {
                'global': {value: null, matchMode: FilterMatchMode.CONTAINS},
                'first_name': {operator: FilterOperator.AND, constraints: [{value: null, matchMode: FilterMatchMode.STARTS_WITH}]},
                'last_name': {operator: FilterOperator.AND, constraints: [{value: null, matchMode: FilterMatchMode.STARTS_WITH}]},
                'personal_id': {value: null, matchMode: FilterMatchMode.EQUALS},
            }
        }
    },
    created() {
        this.initFilters1()
    },
    mounted() {
        this.getPatients()
    }

}
</script>

<style scoped>
.del-btn{
    background-color: firebrick;
    border-bottom-width: 0px;
}
.edit_btn{
    background-color: green;
}
.add-btn{
    margin-bottom: 20px;
}
</style>
