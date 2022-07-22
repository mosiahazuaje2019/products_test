<template>
    <Head title="Dashboard" />

    <BreezeAuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Productos
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <PrimeButton @click="createProduct" class="add-btn" icon="pi pi-plus" title="nuevo" />
                        <DataTable v-model:filters="filters1" :value="products" dataKey="id"
                                   responsiveLayaout="scroll"
                                   :paginator="true"
                                   :rows="20"
                                   :loading="loading1"
                                   :globalFilterFields="['global','name']">
                            <template #header>
                                <div class="flex justify-content-center">
                                <span class="p-input-icon-left w-full">
                                    <i class="pi pi-search" />
                                    <InputText v-model="filters1['global'].value" placeholder="Buscar" class="w-full" />
                                </span>
                                </div>
                            </template>
                            <Column field="name" header="Nombre"></Column>
                            <Column bodyStyle="text-align: center; overflow: visible" header="Acción"
                                    headerStyle="width: 14rem; text-align: center">
                                <template #body="slotProps">
                                        <PrimeButton class="edit_btn" @click="editProduct(slotProps.data.id)" icon="pi pi-pencil" title="editar" />
                                        <PrimeButton class="-right-2.5 del-btn" @click="destroyProduct(slotProps.data.id)" icon="pi pi-trash" title="borrar" />
                                </template>
                            </Column>
                        </DataTable>
                    </div>
                </div>
            </div>
            <Dialog :header="editId === null ? 'Crear Producto' : 'Editar Producto'" :style="{width: '50vw'}"
                    v-model:visible="display">
                <ProductForm :editId="editId" />
            </Dialog>
        </div>
    </BreezeAuthenticatedLayout>
</template>

<script>
import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue'
import { Head } from '@inertiajs/inertia-vue3';
import ProductForm from "@/Components/Products/ProductForm";
import Swal from 'sweetalert2'
import axios from 'axios';
import {FilterMatchMode, FilterOperator} from "primevue/api";

export default {
    data () {
      return {
          products: null,
          filter: null,
          filters1: null,
          filters2: {
              'global': {value:null, matchMode: FilterMatchMode.CONTAINS},
              'name': {value:null, matchMode: FilterMatchMode.STARTS_WITH}
          },
          editId: null,
          display: false,
          loading1: true
      }
    },
    components: {
        ProductForm,
        BreezeAuthenticatedLayout,
        Head,
    },
    methods: {
        async getProducts() {
            await axios.get('api/products').then((res) => {
                this.products = res.data
                this.loading1 = false;
            })
        },
        async createProduct () {
            this.editId = null
            this.display = true
        },
        async editProduct (id) {
            this.editId = id
            this.display = true
        },
        async destroyProduct(id) {
            Swal.fire( {
                title: 'Seguro de eliminar el producto?',
                showDenyButton: true,
                confirmButtonText: `Borrar`,
                denyButtonText: `No borrar`,
            }).then((result) => {
                if(result.isConfirmed) {
                    axios.delete(`/api/products/${id}`).then(() => {
                        return this.emitter.emit('products_reload')
                    }).catch(() => {
                        Swal.fire('No se logro eliminar', '', 'error')
                    })
                } else if (result.isDenied) {
                    Swal.fire('No se a borrado...', '', 'info')
                }
            })
        },
        initFilters1() {
            this.filters1 = {
                'global': {value:null, matchMode:FilterMatchMode.CONTAINS},
                'name':{operator: FilterOperator.AND, constraints: [{value:null, matchMode: FilterMatchMode.STARTS_WITH}]}
            }
        }
    },
    created() {
        this.initFilters1()
    },
    mounted() {
        this.getProducts()
        this.emitter.on('products_reload', () => {
            this.getProducts()
            this.display = false
            this.$toast.add({
                severity:'success', summary: 'SUCCESS!',
                detail: `Operación realizada con éxito!`, life:3000,
            })
        })
    }
}
</script>
<style scoped>
.del-btn{
    background-color: firebrick;
    border-bottom-width: 0px;
}
.edit_btn{
    background-color: blue;
}
.add-btn{
    margin-bottom: 20px;
    border-radius: 50%;
}
</style>
