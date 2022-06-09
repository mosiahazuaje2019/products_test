<template>
    <div class="card">
        <div class="formgrid grid">
            <div class="field col">
                <InputText v-model="form.name" class="w-full" placeholder="Ingrese una dirección" />
                <small class="text-red-500">{{ error_name }}</small>
            </div>
        </div>
        <div class="formgrid grid">
            <div class="field col">
                <PrimeButton icon="pi pi-save" label="Guardar" class="sm:-bottom-1.5" @click="add()" />
            </div>
        </div>

    </div>
</template>

<script>
    export default {
        name: "CreateAddress",
        components: {},
        data() {
            return {
                id: null,
                form: {
                    name: null,
                    category: null,
                    patient_id: null,
                },
                error_name: null,
            }
        },
        props: {
            patient_id: Number
        },
        methods: {

            async add () {
                try {
                    const res = await axios.post('/api/address', this.form)
                    return this.emitter.emit('createaddress_reload');
                }
                catch (e) {
                    console.log(e);
                    if (e.response) {
                        switch (e.response.status) {
                            case 422:
                                let err = e.response.data.errors
                                this.error_name = err.name ? err.name[0] : null
                        }
                    }
                    return null
                }
            },
        },
        mounted(){
            this.id = this.$props.patient_id;
            this.form.patient_id = this.id;
            this.form.category = 'address';
        }

    }
</script>
