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
                                    <PrimeButton @click="editInvoice(slotProps.data.id)" icon="pi pi-pencil" class="btn_edit" title="editar" />
                                    <a :href="`/api/export_orders/${slotProps.data.invoice_number}`"
                                       class="del-btn"
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

            <Dialog :header="editId === null ? 'Crear Factura' : 'Editar Factura'" :style="{width: '25vw'}"
                    v-model:visible="display">
                <InvoiceForm :editId="editId" />
            </Dialog>

        </div>
    </BreezeAuthenticatedLayout>
</template>

<script>
import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue'
import { Head } from '@inertiajs/inertia-vue3';
import InvoiceForm from './InvoiceForm.vue';

export default {
    name: "ListInvoice",
    components: {
        BreezeAuthenticatedLayout,
        Head,
        InvoiceForm
    },
    data() {
      return {
          invoices: [],
          editId: null,
          display: false
      }
    },
    methods: {
        async getInvoices() {
            await axios.get('api/invoices').then((res) => {
                this.invoices = res.data
            })
        },
        editInvoice(id){
            console.log(id);
            this.editId = id
            this.display = true
        }
    },
    mounted() {
        this.getInvoices()

        this.emitter.on('invoices_reload', () => {
            this.getInvoices()
            this.display = false
            this.$toast.add({
                severity:'success', summary: 'SUCCESS!',
                detail: `Factura cambiada`, life:3000,
            })
        })
    }
}
</script>

<style scoped>
.del-btn{
    margin-left: 10px;
    border-bottom-width: 0px;
}
</style>
