<template>
    <div class="card">
        <DataTable  :value="orders" dataKey="id" responsiveLayout="scroll" :paginate="true" :rows="20">
            <Column field="lm_code" header="Código"></Column>
            <Column field="total_items" header="Items"></Column>
            <Column field="status" header="Status"></Column>
        </DataTable>
        <label>Ingrese  un número de factura</label>
        <InputText v-model="form.invoice_number" class="inputfield w-full" />
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
            }
        }
    },
    methods: {
        async getOrders() {
            await axios.get(`api/getInvoiceActive`).then((res) => {
                this.orders = res.data
            })
        },
        async complete_invoice() {
            await axios.patch()
        }
    },
    mounted() {
        this.getOrders();
    }
}
</script>

<style scoped>

</style>
