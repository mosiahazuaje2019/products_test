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
                        <PrimeButton class="p-mb-8" @click="createProduct">Nuevo</PrimeButton>
                        <DataTable :filters="filter" :value="products" dataKeu="id" responsiveLayaout="scroll" :paginator="true" :rows="20">
                            <Column field="name" header="Nombre"></Column>
                            <Column field="size" header="Talla"></Column>
                            <Column field="observation" header="Observación"></Column>
                            <Column field="count_inventory" header="Cantidad"></Column>
                            <Column field="date_boarding" header="Fecha de embarque"></Column>
                            <Column field="brand_id.name" header="Marca"></Column>
                            <template #paginatorLeft>
                                <PrimeButton type="button" icon="pi pi-refresh" class="p-button-text" />
                            </template>
                            <template #paginatorRight>
                                <PrimeButton type="button" icon="pi pi-cloud" class="p-button-text" />
                            </template>
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
import axios from 'axios';
import ProductForm from "@/Components/Products/ProductForm";

export default {
    data () {
      return {
          products: null,
          filter: null,
          editId: null,
          display: false
      }
    },
    components: {
        ProductForm,
        BreezeAuthenticatedLayout,
        Head,
    },
    methods: {
        getProducts() {
            axios.get('api/products').then((res) => {
                this.products = res.data
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
    },
    mounted() {
        this.getProducts()
        this.emitter.on('products_reload', () => {
            this.getProducts()
            this.display = false
            this.$toast.add({severity:'success', summary: 'Default Message'});
        })
    }
}
</script>
