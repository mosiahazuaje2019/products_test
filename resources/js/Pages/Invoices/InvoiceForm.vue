<template>
    <div>
        <div class="formgrid grid">
            <div class="field col">
                <label>Número de Factura</label>
                <InputText v-model="form.invoice_number" class="w-full" />
                <small class="text-red-500">{{ error_invoice_number }}</small>
            </div>

            <div class="field col mt-4">
                <PrimeButton label="Guardar" class="sm:-bottom-1.5" @click="submit" />
            </div>
        </div>
    </div>
</template>

<script>
import axios from "axios";

export default {
    name: "InvoicetForm",
    data () {
        return {
            form: {
                invoice_number: null,
            },
            error_invoice_number: null,
        }
    },
    props: {
        editId: Number,
    },
    methods: {
        cleanForm () {
            Object.keys(this.form).map((val, index) => this.form[index] = null)
        },
        async submit () {
            if (!this.$props.editId) {
                try {
                    const res = await axios.post('/api/invoices', this.form)
                    this.cleanForm()
                    return this.emitter.emit('invoices_reload', res.data)
                }
                catch (e) {
                    if (e.response) {
                        switch (e.response.status) {
                            case 422:
                                let err = e.response.data.errors
                                this.error_invoice_number = err.invoice_number ? err.invoice_number[0] : null
                        }
                    }
                    return null
                }
            }
            try {
                const res = await axios.put(`/api/invoices/${this.$props.editId}`, this.form)
                return this.emitter.emit('invoices_reload')
            }
            catch (e) {
                if (e.response) {
                    switch (e.response.status) {
                        case 422:
                            let err = e.response.data.errors
                            this.error_invoice_number = err.invoice_number ? err.invoice_number[0] : null
                    }
                }
                return null
            }
        },
        async getEditData() {
            const res = await axios.get(`/api/invoices/${this.$props.editId}`)
            this.form.invoice_number   = res.data.invoice_number
        }
    },
    mounted() {
        if (this.$props.editId) {
            this.getEditData()
        }
    }
}
</script>

<style scoped>

</style>
