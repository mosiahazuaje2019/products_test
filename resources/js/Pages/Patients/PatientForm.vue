<template>
    <div>
        <div class="formgrid grid">
            <div class="field col">
                <label>Ciudad</label>
                <Dropdown class="w-full" v-model="form.city_id" :options="cities" optionLabel="city" optionValue="id" placeholder="Selecione ciudad" :filter="true" />
            </div>
            <div class="field col">
                <label>Nombre</label>
                <InputText v-model="form.first_name" class="w-full" />
                <small class="text-red-500">{{ error_first_name }}</small>
            </div>
            <div class="field col">
                <label>Apellido</label>
                <InputText v-model="form.last_name" class="w-full" />
                <small class="text-red-500">{{ error_last_name }}</small>
            </div>
        </div>
        <div class="formgrid grid">
            <div class="field col">
                <label>Identificacion</label>
                <InputText v-model="form.personal_id" class="w-full" />
                <small class="text-red-500">{{ error_personal_id }}</small>
            </div>
            <div class="field col">
                <label>Edad</label>
                <InputNumber v-model="form.age" class="w-full" />
            </div>
            <div class="field col mt-4">
                <PrimeButton icon="pi pi-save" label="Siguiente" class="sm:-bottom-1.5" @click="submit" />
            </div>
        </div>
    </div>
</template>

<script>
import axios from "axios";

export default {
    name: "PatientForm",
    data () {
        return {
            form: {
                first_name: null,
                last_name: null,
                personal_id: null,
                age: null,
                city_id:null
            },
            cities: [],
            error_first_name: null,
            error_last_name: null,
            error_personal_id: null,
            error_age: null,
            error_city_id: null,
        }
    },
    props: {
        editId: Number,
    },
    methods: {
        async getCities () {
            await axios.get('api/cities').then((res) => {
                this.cities = res.data
            })
        },

        cleanForm () {
            Object.keys(this.form).map((val, index) => this.form[index] = null)
        },
        async submit () {
            if (!this.$props.editId) {
                try {
                    const res = await axios.post('/api/patients', this.form)
                    this.cleanForm()
                    return this.emitter.emit('patients_reload', res.data)
                }
                catch (e) {
                    if (e.response) {
                        switch (e.response.status) {
                            case 422:
                                let err = e.response.data.errors
                                this.error_first_name = err.first_name ? err.first_name[0] : null
                                this.error_last_name = err.last_name ? err.last_name[0] : null
                                this.error_personal_id = err.personal_id ? err.personal_id[0] : null
                                this.error_city_id = err.city_id ? err.city_id[0] : null
                                this.error_age = err.age ? err.age[0] : null
                        }
                    }
                    return null
                }
            }
            try {
                const res = await axios.put(`/api/patients${this.$props.editId}`, this.form)
                this.cleanForm()
                return this.emitter.emit('patients_reload')
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
        async getEditData() {
            const res = await axios.get(`/api/patients/${this.$props.editId}`)
            this.form.first_name   = res.data.first_name
            this.form.last_name    = res.data.last_name
            this.form.personal_id  = res.data.personal_id
            this.form.age          = res.data.age
            this.form.phone        = res.data.phone
            this.form.address      = res.data.address
            this.form.email        = res.data.email
            this.form.city_id      = res.data.city_id
        }
    },
    mounted() {
        this.getCities();
        if (this.$props.editId) {
            this.getEditData()
        }
    }
}
</script>

<style scoped>

</style>
