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
                        <label>Presentacion</label>
                        <Dropdown v-model="form.presentation" :options="presentations" optionLabel="name" optionValue="code"
                        placeholder="Seleccione una presentacion" class="w-100" />
                        <small class="text-red-500">{{ error_presentation }}</small>
                    </div>
                    <div class="p-field">
                        <label>Precio</label>
                        <InputNumber v-model="form.price" placeholder="Ingrese un precio" :minFractionDigits="0" />
                        <small class="text-red-500">{{ error_price }}</small>
                    </div>
                    <div class="p-field">
                        <label>Marca</label>
                        <Dropdown v-model="form.brand_id" :options="brands" optionLabel="name" optionValue="id"
                        placeholder="Seleccione una marca" class="w-100" />
                        <small class="text-red-500">{{ error_brand_id }}</small>
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
    name: "ProductForm",
    data () {
        return {
            form: {
                name: null,
                price: null,
                presentation: null,
                observation: null,
                brand_id: null
            },
            presentations: [
                { name:'CJAX14', code: 'CJAX14'},
                { name:'FCOX120 ML', code: 'FCOX120 ML'},
                { name:'CJAX30', code: 'CJAX30'},
                { name:'CJAX28', code: 'CJAX28'},
                { name:'120 DOSIS', code: '120 DOSIS'}
            ],
            brands: [],
            error_name: null,
            error_presentation: null,
            error_price: null,
            error_brand_id: null,
        }
    },
    props: {
        editId: Number,
    },
    methods: {
        async getBrands () {
            await axios.get('api/brands').then((res) => {
                this.brands = res.data
            })
        },
        cleanForm () {
            Object.keys(this.form).map((val, index) => this.form[index] = null)
        },
        async submit () {
            if (!this.$props.editId) {
                try {
                    const res = await axios.post('/api/products', this.form)
                    this.cleanForm()
                    return this.emitter.emit('products_reload')
                }
                catch (e) {
                    if (e.response) {
                        switch (e.response.status) {
                            case 422:
                                let err = e.response.data.errors
                                this.error_name = err.name ? err.name[0] : null
                                this.error_brand_id = err.brand_id ? err.brand_id[0] : null
                        }
                    }
                    return null
                }
            }
            try {
                const res = await axios.put(`/api/products/${this.$props.editId}`, this.form)
                this.cleanForm()
                return this.emitter.emit('products_reload')
            }
            catch (e) {
                if (e.response) {
                    switch (e.response.status) {
                        case 422:
                            let err = e.response.data.errors
                            this.error_name = err.name ? err.name[0] : null
                            this.error_presentation = err.presentacion ? err.presentacion[0] : null
                            this.error_price = err.price ? err.price[0] : null
                            this.error_brand_id = err.brand_id ? err.brand_id[0] : null
                    }
                }
                return null
            }
        },
        async getEditData() {
            const res = await axios.get(`/api/products/${this.$props.editId}`)
            this.form.name             = res.data.name
            this.form.size             = res.data.size
            this.form.observation      = res.data.observation
            this.form.count_inventory  = res.data.count_inventory
            this.form.date_boarding    = res.data.date_boarding
            this.form.brand_id         = res.data.brand_id.id
        }
    },
    mounted() {
        this.getBrands()
        if (this.$props.editId) {
            this.getEditData()
        }
    }
}
</script>

<style scoped>

</style>
