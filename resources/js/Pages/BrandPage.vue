<template>
    <Head title="Brand" />

    <BreezeAuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Marcas
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <PrimeButton class="add-btn" @click="createBrand">Nuevo</PrimeButton>
                        <DataTable :filters="filter" :value="brands" dataKey="id" responsiveLayout="scroll" :paginate="true" :rows="20">
                            <Column field="name" header="Nombre"></Column>
                            <Column field="reference" header="Referencia"></Column>
                            <Column bodyStyle="text-align: center; overflow: visible" header="Acción"
                                    headerStyle="width: 14rem; text-align: center">
                                <template #body="slotProps">
                                    <PrimeButton label="Editar" class="edit_btn" @click="editBrand(slotProps.data.id)" />

                                    <PrimeButton label="Eliminar" class="-right-2.5 del-btn" @click="destroyBrand(slotProps.data.id)" />
                                </template>
                            </Column>
                        </DataTable>
                    </div>
                </div>
            </div>
            <Dialog :header="editId === null ? 'Crear Marca' : 'Editar Marca'" :style="{width:'50vw'}" v-model:visible="display">
                <BrandForm :editId="editId" />
            </Dialog>
        </div>
    </BreezeAuthenticatedLayout>
</template>

<script>
import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue'
import { Head } from '@inertiajs/inertia-vue3';
import BrandForm from "@/Components/Brands/BrandForm";
import Swal from "sweetalert2";
import axios from "axios";

export default {
    name: "BrandPage",
    components: {
        BreezeAuthenticatedLayout,
        Head,
        BrandForm
    },
    data () {
        return {
            brands: null,
            filter: null,
            editId: null,
            display: false,
        }
    },
    methods: {
        async getBrands() {
            await axios.get('/api/brands').then((res) => {
                this.brands = res.data
            })
        },
        async createBrand() {
            this.editId = null
            this.display = true
        },
        async editBrand(id) {
            this.editId = id
            this.display = true
        },
        async destroyBrand(id) {
            Swal.fire( {
                title: 'Seguro de eliminar la marca?',
                showDenyButton: true,
                confirmButtonText: `Borrar`,
                denyButtonText: `No borrar`,
            }).then((result) => {
                if(result.isConfirmed) {
                    axios.delete(`/api/brands/${id}`).then(() => {
                        return this.emitter.emit('brands_reload')
                    }).catch(() => {
                        Swal.fire('No se logro eliminar', '', 'error')
                    })
                } else if (result.isDenied) {
                    Swal.fire('No se a borrado...', '', 'info')
                }
            })
        }
    },
    mounted() {
        this.getBrands()
        this.emitter.on('brands_reload', () => {
            this.getBrands()
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
    background-color: green;
}
.add-btn{
    margin-bottom: 20px;
}
</style>
