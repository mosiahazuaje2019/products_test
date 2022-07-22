<template>
    <div class="card">
        <div class="formgrid grid">
            <div class="field col">
                <InputText v-model="form.description" class="w-full" placeholder="Ingrese una diagnóstico" />
                <small class="text-red-500">{{ error_description }}</small>
            </div>
        </div>
        <div class="formgrid grid" v-if="save_action === true">
            <div class="field col">
                <PrimeButton icon="pi pi-save" label="Guardar" class="sm:-bottom-1.5" @click="add()" />
            </div>
        </div>

    </div>
</template>

<script>
    export default {
        name: "CreateDiagnostic",
        components: {},
        data() {
            return {
                id: null,
                form: {
                    description: null,
                    patient_id: null,
                },
                error_description: null,
                save_action:true
            }
        },
        props: {
            patient_id: Number
        },
        methods: {

            async add () {
                this.save_action = true
                try {
                    const res = await axios.post('/api/patient_diagnostics', this.form)
                    return this.emitter.emit('creatediagnostic_reload');
                }
                catch (e) {
                    console.log(e);
                    if (e.response) {
                        switch (e.response.status) {
                            case 422:
                                let err = e.response.data.errors
                                this.error_description = err.description ? err.description[0] : null
                        }
                    }
                    return null
                }
            },
        },
        mounted(){
            this.id = this.$props.patient_id;
            this.form.patient_id = this.id;
        }
    }
</script>
