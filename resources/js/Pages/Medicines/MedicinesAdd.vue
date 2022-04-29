<template>
    <div class="card">
        <div class="field">
            <span class="pi pi-plus-circle float-right cursor-pointer text-lime-600" label="Continuar" @click="add" />
        </div>
        <div class="formgrid grid">
            <div class="field col">
                <label>Seleccione Medicamento</label>
                <Dropdown class="w-full"
                    v-model="form.product_id"
                    :options="medicines"
                    optionLabel="full_name"
                    optionValue="id"
                    :filter="true"
                    filterPlaceholder="Buscar medicamento"
                    :showClear="true"
                />
            </div>
             <div class="field col">
                <label>Cantidad</label>
                <InputNumber v-model="form.prescription" class="w-full" placeholder="Ingrese una cantidad" :minFractionDigits="0" />
            </div>

        </div>


        <div>
            <DataTable :filters="filter" :value="details" dataKey="id" responsiveLayout="scroll" :paginate="true" :rows="20">
                <Column field="products.full_name" header="Medicamento"></Column>
                <Column field="prescription" header="Cantidad"></Column>
                <Column field="products.price" header="Precio"></Column>
                <Column header="Total">
                    <template #body="slotProps">
                        <span>{{ slotProps.data.products.price*slotProps.data.prescription }}</span>
                    </template>
                </Column>
            </DataTable>
        </div>
    </div>
</template>

<script>
    export default {
        name: "MedicineAdd",
        components: {},
        data() {
            return {
                medicines: [],
                details: [],
                filter: [],
                form: {
                    product_id: null,
                    order_id: null,
                    patient_id: null,
                    prescription: null,
                }
            }
        },
        props: {
            order_id: Number,
            patient_id: Number
        },
        methods: {
            cleanFormMed () {
                Object.keys(this.form).map((val, index) => this.form[index] = null)
            },
            async getMedicines() {
                await axios.get('api/products').then((res) => {
                    this.medicines = res.data
                })
            },
            async add () {
                try {
                    const res = await axios.post('api/patient_lm_details', this.form)
                    this.cleanFormMed();
                    this.getDetailLms(this.form.order_id);
                    return this.emitter.emit('patient_lm_detail_reload')
                }
                catch (e) {
                    if (e.response) {
                        switch (e.response.status) {
                            case 422:
                                let err = e.response.data.errors
                                //this.error_lm_id = err.lm_id ? err.lm_id[0] : null
                        }
                    }
                    return null
                }
            },
            async getDetailLms(id) {
                await axios.get(`api/showlmdetail/${id}`).then((res) => {
                    this.details = res.data;
                })
            }
        },
        mounted(){
            this.getMedicines();
            this.form.order_id = this.$props.order_id;
            this.form.patient_id = this.$props.patient_id;
            console.log(this.form.patient_id);
        }

    }
</script>
