<template>
    <Head title="Reports" />

    <BreezeAuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Reportes
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
                            <PrimeButton label="Buscar" icon="pi pi-search" iconPos="right" @click="searchEvents()" class="sm:-bottom-1.5" />
                        </div>
                        <div class="field float-right mt-3" v-if="orders.length > 0">
                            <PrimeButton label="Calcular facturas" icon="pi pi-check" iconPos="right" @click="calculateInvoice($event)" class="sm:-bottom-1.5" />
                        </div>
                    </div>
                    <div class="p-6 bg-white border-b border-gray-200" v-if="orders.length > 0">
                        <DataTable  :value="orders" dataKey="id" responsiveLayout="scroll" :paginate="true" :rows="20">
                            <Column field="lm_code" header="LM"></Column>
                            <Column field="total_detail"  header="Total"></Column>
                            <Column>
                                <template #body="slotProps">
                                    <PrimeButton icon="pi pi-check" class="p-button-rounded p-button-success mr-2" @click="selectLm(slotProps.data.lm_code)" />
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
import Label from '@/Components/Label.vue';

export default {
    name: "ReportPage",
    components: {
        BreezeAuthenticatedLayout,
        Head,
        Label
    },
    data () {
        return {
            form: {
                dates: null,
                lm_result: null
            },
            orders: [],
            lms: []
        }
    },
    methods: {
        async searchEvents(){
            let selectedDate = this.form.dates;
            let iniDate = new Date(selectedDate[0]).toLocaleDateString('en-CA');
            let endDate = new Date(selectedDate[1]).toLocaleDateString('en-CA');

            const res = await axios.get(`/api/getOrdersLm/${iniDate}/${endDate}`).then((res) => {
                console.log(res.data);
                this.orders = res.data;
            })
        },
        async calculateInvoice(){
            let selectedDate = this.form.dates;
            let iniDate = new Date(selectedDate[0]).toLocaleDateString('en-CA');
            let endDate = new Date(selectedDate[1]).toLocaleDateString('en-CA');

            const res = await axios.get(`/api/getOrdersDetail/${iniDate}/${endDate}`).then((res) => {
                this.lms = res.data;
            })
        },
        async selectLm(id) {
            const res = await axios.patch(`/api/update_lmcode/${id}`, {
                status: 'proccess'
            })
            return this.emitter.emit('lms_reload')
        }
    },
    mounted(){
        this.emitter.on('lms_reload', () => {
            this.searchEvents();
            this.$toast.add({
                severity:'success', summary: 'SUCCESS!',
                detail: `Lm anexado a la factura`, life:3000,
            })
        });
    }
}
</script>
