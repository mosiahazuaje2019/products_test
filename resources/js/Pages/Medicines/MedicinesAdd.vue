<template>
    <div class="card">
        <div class="field">
            <span class="pi pi-plus-circle float-right cursor-pointer text-lime-600" label="Continuar" @click="add" />
        </div>
        <div class="formgrid grid">
            <div class="field col">
                <label class="font-bold text-teal-500">Seleccione Medicamento<span class="pi pi-plus-circle justify-center cursor-pointer text-lime-600" @click="viewCreateProduct" label="Nuevo"  /></label>
                <Dropdown class="w-full"
                    v-model="formprod.product_id"
                    :options="medicines"
                    optionLabel="full_name"
                    optionValue="id"
                    :filter="true"
                    filterPlaceholder="Buscar medicamento"
                    :showClear="true"
                />
            </div>
             <div class="field col">
                <label class="font-bold text-teal-500">Cantidad</label>
                <InputNumber v-model="formprod.prescription" class="w-full" placeholder="Ingrese una cantidad" :minFractionDigits="0" />
            </div>

        </div>


        <div>
            <DataTable :filters="filter" :value="details" dataKey="id" responsiveLayout="scroll" editMode="row"
                v-model:editingRows="editingRows" @row-edit-save="onRowEditSave" :paginate="true" :rows="20" class="editable-cells-table">

                <Column field="products.full_name" header="Medicamento"></Column>
                <Column field="prescription" header="Cantidad"></Column>
                <Column field="products.price" header="Precio" dataType="numeric">
                    <template #editor="{data}">
                    <!-- {{ data.products.price[field] }} -->
                        <InputText v-model="data.products.price" autofocus />
                    </template>
                </Column>
                <Column header="Total">
                    <template #body="{data}">
                        <span>{{ formatCurrency(data.products.price*data.prescription) }}</span>
                    </template>
                </Column>
                <Column :rowEditor="true" style="width:10%; min-width:8rem" bodyStyle="text-align:center"></Column>

            </DataTable>
        </div>
        <Dialog :header="'Nuevo medicamento'" :style="{width: '25vw'}"
                v-model:visible="displayCreateProduct" :maximizable="false" >
            <ProductForm :editId="editId" />
        </Dialog>
    </div>
</template>

<script>

import ProductForm from "@/Components/Products/ProductForm";

    export default {
        name: "MedicineAdd",
        components: {
            ProductForm
        },
        data() {
            return {
                editingRows: [],
                medicines: [],
                details: [],
                filter: [],
                formprod: {
                    product_id: null,
                    order_id: null,
                    patient_id: null,
                    prescription: null,
                },
                displayCreateProduct: false,
                editId: null
            }
        },
        props: {
            order_id: Number,
            patient_id: Number
        },
        methods: {
            onRowEditSave(event) {
                const price = event.data.products.price;

                const res = axios.patch(`api/update_price/${event.data.products.id}`, {
                    price: event.data.products.price
                }).then
                return this.emitter.emit('price_update_reload')
            },
            cleanFormMed () {
                console.log(Object.keys(this.formprod))
                Object.keys(this.formprod).map((val, index) => this.formprod[index] = '')
            },
            async getMedicines() {
                await axios.get('api/products').then((res) => {
                    this.medicines = res.data
                })
            },
            async add () {
                try {
                    const res = await axios.post('api/patient_lm_details', this.formprod)
                    this.cleanFormMed();
                    this.getDetailLms(this.formprod.order_id);
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
            },
            formatCurrency(value) {
                return value.toLocaleString('en-US', {style: 'currency', currency: 'USD', minimumFractionDigits:0});
            },
            viewCreateProduct() {
                this.displayCreateProduct = true;
            }
        },
        mounted(){
            this.getMedicines();
            this.formprod.order_id = this.$props.order_id;
            this.formprod.patient_id = this.$props.patient_id;

            this.emitter.on('products_reload', () => {
                this.getMedicines()
                this.displayCreateProduct = false;
                this.$toast.add({
                    severity:'success', summary: 'SUCCESS!',
                    detail: `Medicamento creado con exito!`, life:3000,
                })
            })
        }

    }
</script>
