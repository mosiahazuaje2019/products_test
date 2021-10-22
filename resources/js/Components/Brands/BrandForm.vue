<template>
    <div>
        <Card>
            <template #header></template>
            <template #title></template>
            <template #content>
                <div class="p-fluid">
                    <div class="p-field">
                        <label>Nombre</label>
                        <InputText v-model="form.name" class="w-100" />
                        <small class="text-red-500">{{ error_name }}</small>
                    </div>
                    <div class="p-field">
                        <PrimeButton icon="pi pi-save" label="Guardar" class="sm:-bottom-1.5" @click="submit" />
                    </div>
                </div>
            </template>
        </Card>
    </div>
</template>

<script>
import axios from "axios";

export default {
    name: "BrandForm",
    data () {
        return {
            form: {
                name: null,
                reference: null,
            },
            error_name: null,
            error_reference: null,
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
                    const res = await axios.post('/api/brands', this.form)
                    this.cleanForm()
                    return this.emitter.emit('brands_reload')
                }
                catch (e) {
                    if (e.response) {
                        switch (e.response.status) {
                            case 422:
                                let err = e.response.data.errors
                                this.error_name = err.name ? err.name[0] : null
                                this.error_reference = err.reference ? err.reference[0] : null
                        }
                    }
                    return null
                }
            }
            try {
                const res = await axios.put(`/api/brands/${this.$props.editId}`, this.form)
                this.cleanForm()
                return this.emitter.emit('brands_reload')
            }
            catch (e) {
                if (e.response) {
                    switch (e.response.status) {
                        case 422:
                            let err = e.response.data.errors
                            this.error_name = err.name ? err.name[0] : null
                            this.error_reference = err.reference ? err.reference[0] : null
                    }
                }
                return null
            }
        },
        async getEditData() {
            const res = await axios.get(`/api/brands/${this.$props.editId}`)
            this.form.name       = res.data.name
            this.form.reference  = res.data.reference
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
