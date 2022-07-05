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
                                    <PrimeButton @click="editOrder(slotProps.data.id)" icon="pi pi-pencil" class="btn_lms" title="Editar orden" />
                                </template>
                            </Column>
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
import axios from 'axios';

export default {
    name: "OrderPage",
    components: {
        BreezeAuthenticatedLayout,
        Head,
    },
    data () {
        return {
            form: {
                search: null
            },
            orders: [],
            createLm: null,
            displayLm: false,
            filter: null
        }
    },
    methods:{
        async search(){
            const res = await axios.get(`/api/findOrders/${this.form.search}`).then((res) => {
                console.log(res.data);
                this.orders = res.data;
            })
        },
        async newLm(data){
            this.createLm = data.lm_code,
            this.displayLm = true
        },
        async editOrder(id){
            console.log(id)
            const res = await axios.get(`/api/`)
        }
    }
}
</script>
