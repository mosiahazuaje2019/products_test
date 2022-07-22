<template>
    <div class="card">
        <div class="formgrid grid">
            <div class="field col">
                <InputText v-model="form.name" class="w-full" placeholder="Ingrese una presentación" />
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
    name: "CreatePresentation",
    data() {
        return {
            id: null,
            form: {
                name: null,
                product_id: null,
            },
            error_name: null,
        }
    },
    methods: {
        async add() {
            try {
                const res = await axios.post('api/presentations', this.form)
                return this.emitter.emit('createpresentation_reload');
            }
            catch (e) {
                if(e.response) {
                    switch (e.response.status) {
                        case 422:
                            let err = e.response.data.errors
                            this.error_name = err.name ? err.name[0]: null
                    }
                }
                return null
            }
        }
    },
    mounted() {
        console.log("IN");
    }
}
</script>

<style scoped>

</style>
