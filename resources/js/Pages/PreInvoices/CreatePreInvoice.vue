<template>
    <div class="card">
        <DataTable  :value="orders" dataKey="id" responsiveLayout="scroll" :paginate="true" :rows="20">
            <Column field="lm_code" header="Código"></Column>
            <Column field="total_items" header="Items"></Column>
            <Column field="status" header="Status"></Column>
        </DataTable>
        <label>Ingrese  un número de factura</label>
        <InputText v-model="form.invoice_number" class="inputfield w-full" />
        <span class="text-red-500">{{ error_invoice }}</span>
        <PrimeButton icon="pi pi-save" class="p-button-rounded p-button-success mt-5 float-right" label="Guardar" @click="complete_invoice()" />
    </div>
</template>

<script>
import axios from "axios";

export default {
    name: "CreatePreInvoice",
    data() {
        return {
            orders: [],
            form: {
                invoice_number: null
            },
            error_invoice:null
        }
    },
    methods: {
        async getOrders() {
            await axios.get(`api/getInvoiceActive`).then((res) => {
                this.orders = res.data
            })
        },
        async complete_invoice() {
            try {
                await axios.patch(`api/update_preinvoice`, this.form);
                return this.emitter.emit('pre_invoice_reload');
            }
            catch (e) {
                if(e.response) {
                    switch (e.response.status) {
                        case 422:
                            let err = e.response.data.errors
                            this.error_invoice = err.invoice_number ? err.invoice_number[0] : null
                    }
                }
            }

        }
    },
    mounted() {
        this.getOrders();
    }
}
</script>

<style scoped>

</style>
