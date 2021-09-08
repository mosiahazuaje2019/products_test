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
                    </div>
                    <div class="p-field">
                        <label>Talla</label>
                        <Dropdown v-model="form.size" :options="sizes" optionLabel="name" optionValue="code"
                                  placeholder="Seleccione talla" class="w-100" />
                    </div>
                    <div class="p-field">
                        <label>Observación</label>
                        <TextArea v-model="form.observation" rows="5" cols="30" :autoResize="true" />
                    </div>
                    <div class="p-field">
                        <label>Cantidad en inventario</label>
                        <InputNumber v-model="form.count_inventory" placeholder="Ingrese una cantidad" :minFractionDigits="0" />
                    </div>
                    <div class="p-field">
                        <label>Fecha de embarque</label>
                        <Calendar v-model="form.date_boarding" />
                    </div>
                    <div class="p-field">
                        <label>Marca</label>
                        <Dropdown v-model="form.brand_id" :options="brands" optionLabel="name" optionValue="id"
                        placeholder="Seleccione una marca" class="w-100" />
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
                size: null,
                observation: null,
                count_inventory: null,
                date_boarding: null,
                brand_id: null
            },
            sizes: [
                { name:'Small', code: 'S'},
                { name:'Medium', code: 'M'},
                { name:'Large', code: 'L'}
            ],
            brands: [],
            error_name: null,
            error_size: null,
            error_observation: null,
            error_count_inventory: null,
            error_date_boarding: null,
            error_brand_id: null,
        }
    },
    props: {
        editId: Number,
    },
    methods: {
        getBrands () {
            axios.get('api/brands').then((res) => {
                this.brands = res.data
                console.log(this.brands)
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
                                this.error_size = err.size ? err.size[0] : null
                                this.error_observation = err.observation ? err.observation[0] : null
                                this.error_count_inventory = err.count_inventory ? err.count_inventory[0] : null
                                this.error_date_boarding = err.date_boarding ? err.date_boarding[0] : null
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
                            this.error_size = err.size ? err.size[0] : null
                            this.error_observation = err.observation ? err.observation[0] : null
                            this.error_count_inventory = err.count_inventory ? err.count_inventory[0] : null
                            this.error_date_boarding = err.date_boarding ? err.date_boarding[0] : null
                            this.error_brand_id = err.brand_id ? err.brand_id[0] : null
                    }
                }
                return null
            }
        },
    },
    mounted() {
        this.getBrands()
    }
}
</script>

<style scoped>

</style>
