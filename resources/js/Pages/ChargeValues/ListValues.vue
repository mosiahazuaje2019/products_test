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
                    <div class="p-6 bg-white border-b border-gray-200">
                        <a :href="`/api/export_values/`"
                           class="-right-2.5 del-btn"
                           title="Exportar cargue"
                           target="_blank">
                            <i class="pi pi-print"></i>
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
            },            
        }
    },
    methods: {
        searchOrders() {
            let selectedDate = this.form.dates;
            let iniDate = new Date(selectedDate[0]).toLocaleDateString('en-CA');
            let endDate = new Date(selectedDate[1]).toLocaleDateString('en-CA');
                        
        }
    }
}
</script>

<style scoped>

</style>
