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

                        <PrimeButton class="add-btn" @click="createPatient">Nuevo</PrimeButton>
                        <DataTable v-model:filters="filters1" :value="patients" dataKey="id"
                         :paginator="true"
                         :rows="5"
                         :loading="loading1"
                         responsiveLayout="scroll"
                         :globalFilterFields="['global','first_name','last_name', 'personal_id']">

                        <template #header>
                            <div class="flex justify-content-center">
                                <span class="p-input-icon-left w-full">
                                    <i class="pi pi-search" />
                                    <InputText v-model="filters1['global'].value" placeholder="Buscar" class="w-full" />
                                </span>
                            </div>
                        </template>

                            <Column field="first_name" header="Nombre" />
                            <Column field="last_name" header="Apellido" />
                            <Column field="personal_id" header="Cedula" />
                            <Column field="lms" header="LM" >
                                <template #body="slotProps">
                                    <div>{{slotProps.data.lms.map(lms => lms.lm_id).join(', ')}}</div>
                                </template>
                            </Column>
                            <Column bodyStyle="justify-center" header="Acción"
                                    headerStyle="width: 14rem; justify-center">
                                <template #body="slotProps">
                                    <PrimeButton @click="goHistory(slotProps.data.personal_id)" icon="pi pi-chevron-circle-up" title="historico" />
                                    <PrimeButton @click="editPatient(slotProps.data.id)" icon="pi pi-pencil" class="btn_edit" title="editar" />
                                    <PrimeButton @click="newLm(slotProps.data)" icon="pi pi-tags" class="btn_lms" title="Cargar Lm" />
                                </template>

                            </Column>
                        </DataTable>
                    </div>
                </div>
            </div>
            <Dialog :header="editId === null ? 'Crear Paciente' : 'Editar Paciente'" :style="{width: '50vw'}"
                    v-model:visible="display">
                <PatientForm :editId="editId" />
            </Dialog>
            <Dialog :header="'Crear Lm'" :style="{width: '50vw'}"
                    v-model:visible="displayLm">
                <LmsCreatePages :createLm="createLm" />
            </Dialog>
        </div>
    </BreezeAuthenticatedLayout>
</template>

<script>
import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue'
import { Head } from '@inertiajs/inertia-vue3';
import Swal from "sweetalert2";
import axios from "axios";
import {FilterMatchMode,FilterOperator} from 'primevue/api';
import PatientForm from "@/Pages/Patients/PatientForm";
import LmsCreatePages from "@/Pages/Lms/LmsCreatePages";
import { Link } from '@inertiajs/inertia-vue3';

export default {
    name: "PatientPage",
    components: {
        BreezeAuthenticatedLayout,
        Head,
        PatientForm,
        Link,
        LmsCreatePages
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
            loading2: true,
            editId: null,
            display: false,
            createLm: null,
            displayLm: false
        }
    },
    methods: {
        createPatient(){
            this.editId = null
            this.display=true;
        },
        async getPatients() {
            await axios.get('/api/patients').then((res) => {
                this.patients = res.data
                this.loading1 = false;
            })
        },
        async editPatient (id) {
            this.editId = id
            this.display = true
        },
        async newLm(id){
            this.createLm = id,
            this.displayLm = true
        },
        initFilters1() {
            this.filters1 = {
                'global': {value: null, matchMode: FilterMatchMode.CONTAINS},
                'first_name': {operator: FilterOperator.AND, constraints: [{value: null, matchMode: FilterMatchMode.STARTS_WITH}]},
                'last_name': {operator: FilterOperator.AND, constraints: [{value: null, matchMode: FilterMatchMode.STARTS_WITH}]},
                'personal_id': {value: null, matchMode: FilterMatchMode.EQUALS},
            }
        },
        goHistory(id){
            window.open("http://asispharma.com/app_pharma/public/formulas?lm_code=&fecha-gen=&fecha-disp=&personal_id="+id);
        }
    },
    created() {
        this.initFilters1()
    },
    mounted() {
        this.getPatients()

        this.emitter.on('patients_reload', () => {
            this.getPatients()
            this.display = false
            this.$toast.add({
                severity:'success', summary: 'SUCCESS!',
                detail: `Operación realizada con éxito!`, life:3000,
            })
        })
    }

}
</script>

<style scoped>
.del-btn{
    background-color: firebrick;
    border-bottom-width: 0px;
}
.btn_edit{
    background-color: green;
    margin-left: 2px;
}
.btn_lms{
    background-color: blueviolet;
    margin-left: 2px;
}
.add-btn{
    margin-bottom: 20px;
}
</style>
