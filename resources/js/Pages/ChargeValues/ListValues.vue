<template>
    <Head title="Cargue de valores" />
    <BreezeAuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Cargue de valores
            </h2>
        </template>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="formgroup-inline p-6">
                        <div class="field">
                            <label>Buscar por fecha</label>
                            <Calendar v-model="form.dates" selectionMode="range" dateFormat="yy-mm-dd" :showIcon="true" class="w-full" />
                        </div>
                        <div class="field float-right mt-3">
                            <PrimeButton label="Buscar" icon="pi pi-search" iconPos="right" class="sm:-bottom-1.5" @click="searchOrders()" />
                        </div>
                        <div class="field float-right mt-3" v-if="order_checks > 0">
                            <PrimeButton label="Revisar factura" icon="pi pi-check" iconPos="right" class="sm:-bottom-1.5" />
                        </div>
                    </div>                    
                    <div class="p-6 bg-white border-b border-gray-200 grid grid-cols-12 justify-center" v-if="iniDate !== null">
                        <a :href="`/api/export_values/${iniDate}/${endDate}}`"
                           class="bg-blue-500 hover:bg-blue-700 text-white font-bold p-6 rounded"
                           title="Exportar cargue"
                           target="_blank">
                            <i class="pi pi-print grid grid-cols-12 justify-center text-8xl mb-4"></i>
                            <p>Cargue de valores correspondiente a las fechas: ({{iniDate}} / {{endDate}})</p>
                        </a>
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
    name: "ListValues",
    components: {
        BreezeAuthenticatedLayout,
        Head,
    },
    data() {
        return {
            form: {
                dates: null,
                orders: null
            },
            iniDate: null,
            endDate: null,           
        }
    },
    methods: {
        async searchOrders() {
            let selectedDate = this.form.dates;
            this.iniDate = new Date(selectedDate[0]).toLocaleDateString('en-CA');
            this.endDate = new Date(selectedDate[1]).toLocaleDateString('en-CA');
            
/*             const res = await axios.get(`/api/export_values/${iniDate}/${endDate}`).then((res) => {
                this.orders = res.data;
            }) */
        }
    }
}
</script>

<style scoped>

</style>
