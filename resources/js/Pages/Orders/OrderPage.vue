<template>
    <Head title="Order" />

    <BreezeAuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Ordenes
            </h2>
        </template>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <div class="p-field">
                            <label>Buscar</label>
                            <InputText v-model="form.search" class="w-full" />
                            <small class="text-red-500"></small>
                        </div>
                        <div class="p-field">
                            <PrimeButton icon="pi pi-search" label="Buscar" class="sm:-bottom-1.5" @click="search" />
                        </div>
                        <DataTable :filters="filter" :value="orders" dataKey="id" responsiveLayout="scroll" :paginate="true" :rows="20" class="mt-5">
                            <Column field="first_name" header="Nombre"></Column>
                            <Column field="last_name" header="Apellido"></Column>
                            <Column field="personal_id" header="Identificación"></Column>
                            <Column field="lm_code" header="LM"></Column>
                            <Column bodyStyle="justify-center" header="Acción"
                                    headerStyle="width: 14rem; justify-center">
                                <template #body="slotProps">
                                    <PrimeButton @click="newLm(slotProps.data)" icon="pi pi-tags" class="btn_lms" title="Cargar Lm" />
                                    <PrimeButton @click="editOrder(slotProps.data.id,slotProps.data.patient_id)" icon="pi pi-pencil" class="btn_edit" title="Editar orden" />
                                </template>
                            </Column>
                        </DataTable>
                    </div>
                </div>
            </div>

            <Dialog :header="'Editando orden'" :style="{width: '50vw'}"
                    v-model:visible="displayOrderEdit" :maximizable="true" >
                <OrderEdit :editId="editId" :patient_id="patientId" />
            </Dialog>

        </div>
    </BreezeAuthenticatedLayout>
</template>

<script>
import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue'
import { Head } from '@inertiajs/inertia-vue3';
import axios from 'axios';
import OrderEdit from './OrderEdit.vue';

export default {
    name: "OrderPage",
    components: {
    BreezeAuthenticatedLayout,
    Head,
    OrderEdit
},
    data () {
        return {
            form: {
                search: null
            },
            orders: [],
            createLm: null,
            displayLm: false,
            displayOrderEdit: false,
            filter: null,
            editId: null,
            patientId: null
        }
    },
    methods:{
        async search(){
            const res = await axios.get(`/api/findOrders/${this.form.search}`).then((res) => {
                this.orders = res.data;
            })
        },
        async newLm(data){
            this.createLm = data.lm_code,
            this.displayLm = true
        },
        async editOrder(id, patientId){
            this.editId = id
            this.patientId = patientId
            this.displayOrderEdit = true
        }
    },
    mounted() {
        this.emitter.on('patientLm_reload', ()=> {
            this.search()
            this.$toast.add({
                severity:'success', summary: 'SUCCESS',
                detail: 'Se a actualizado la información de la orden correctamente', life:3000
            })
        })        
    }
}
</script>

<style scoped>
.btn_edit{
    background-color: green;
    margin-left: 2px;
}
</style>
