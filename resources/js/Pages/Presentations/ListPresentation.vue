<template>
    <Card>
        <template #title>
            <h4>Presentaciones</h4>
        </template>
        <template #content>
            <DataTable :value="presentations" dataKey="id"
                       v-model:filters="filters1"
                       responsiveLayout="scroll"
                       :paginator="true"
                       :rows="10"
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
                <Column field="id" header="Id"/>
                <Column field="name" header="Nombre" />
                <Column bodyStyle="text-align: center; overflow: visible" header="Acción"
                        headerStyle="width: 14rem; text-align: center">
                    <template #body="slotProps">
                        <PrimeButton class="-right-2.5 del-btn" @click="destroyPresentation(slotProps.data.id)" icon="pi pi-trash" title="borrar" />
                    </template>
                </Column>
            </DataTable>
        </template>
    </Card>
</template>

<script>
import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue'
import { Head } from '@inertiajs/inertia-vue3';
import axios from 'axios';
import Swal from 'sweetalert2'
import {FilterMatchMode, FilterOperator} from "primevue/api";

export default {
    name: "ListPresentation",
    components: {
        BreezeAuthenticatedLayout,
        Head
    },
    data() {
        return {
            presentations: [],
            loading1: null,
            filter: null,
            filters1: null,
            filters2: {
                'global': {value:null, matchMode: FilterMatchMode.CONTAINS},
                'name': {value:null, matchMode: FilterMatchMode.STARTS_WITH}
            },
        }
    },
    methods: {
        async getPresentations() {
            await axios.get('api/presentations').then((res) => {
                this.presentations = res.data
            })
        },
        async destroyPresentation(id) {
            Swal.fire({
                title: 'Seguro de eliminar la presentación',
                showDenyButton: true,
                confirmationButtonText: 'Borrar',
                denyButtonText: 'No borrar',
            }).then((result) => {
                if(result.isConfirmed) {
                    axios.delete(`/api/presentations/${id}`).then(() => {
                        return this.emitter.emit('presentation_reload')
                    }).catch(() => {
                        Swal.fire('No se logro eliminar', '', 'error')
                    })
                }else if (result.isDenied) {
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
        this.getPresentations();
        this.emitter.on('presentation_reload', () => {
            this.getPresentations()
            this.$toast.add({
                severity:'success', summary: 'SUCCESS!',
                detail: `Se a borrado correctamente el registro`, life:3000
            })
        })
    }
}
</script>
