<template>
    <Head title="Facturados" />
    <BreezeAuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Facturados
            </h2>
        </template>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <DataTable :value="invoices" dataKey="id"
                        responsiveLayout="scroll"
                        :paginator="true"
                        :rows="10"
                        :loading="loading1">
                            <Column field="invoice_number" header="Numero de factura" />
                            <Column bodyStyle="text-align: center; overflow: visible" header="Acción"
                                    headerStyle="width: 14rem; text-align: center">
                                <template #body="slotProps">
                                    <a :href="`/api/export_orders/${slotProps.data.invoice_number}`"
                                       class="-right-2.5 del-btn"
                                       title="Exportar factura"
                                       target="_blank">
                                        <i class="pi pi-print"></i>
                                    </a>
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

export default {
    name: "ListInvoice",
    components: {
        BreezeAuthenticatedLayout,
        Head
    },
    data() {
      return {
          invoices: []
      }
    },
    methods: {
        async getInvoices() {
            await axios.get('api/invoices').then((res) => {
                this.invoices = res.data
            })
        }
    },
    mounted() {
        this.getInvoices()
    }
}
</script>

<style scoped>

</style>
