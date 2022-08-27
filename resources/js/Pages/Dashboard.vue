<template>
    <Head title="Dashboard" />

    <BreezeAuthenticatedLayout>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="grid">
                        <div class="col">
                            <Card>
                                <template #header>
                                </template>
                                <template #title>
                                    <span class="text-center">
                                        
                                        <h4>Administrar Medicamentos</h4>
                                    </span>
                                </template>
                                <template #content>
                                </template>
                                <template #footer>
                                    <PrimeButton icon="fa-solid fa-capsules" label="Abrir" class="p-button-secondary w-full" style="margin-left: .5em" @click="activateProducts" />
                                </template>
                            </Card>
                        </div>
                        <div class="col">
                            <Card>
                                <template #header>

                                </template>
                                <template #title>
                                    <span class="text-center">
                                        <h4>Administrar Diagnósticos</h4>
                                    </span>
                                </template>
                                <template #content>
                                </template>
                                <template #footer>
                                    <PrimeButton icon="pi pi-arrow-right" label="Abrir" class="p-button-secondary w-full" style="margin-left: .5em" @click="activateDiagnostic" />
                                </template>
                            </Card>
                        </div>
                        <div class="col">
                            <Card>
                                <template #header>

                                </template>
                                <template #title>
                                    <span class="text-center">
                                        <h4>Administrar Direcciones</h4>
                                    </span>
                                </template>
                                <template #content>
                                </template>
                                <template #footer>
                                    <PrimeButton icon="pi pi-arrow-right" label="Abrir" class="p-button-secondary w-full" style="margin-left: .5em" @click="activateAddress" />
                                </template>
                            </Card>
                        </div>
                        <div class="col">
                            <Card>
                                <template #header>

                                </template>
                                <template #title>
                                    <span class="text-center">
                                        <h4>Administrar Presentaciones</h4>
                                    </span>
                                </template>
                                <template #content>
                                </template>
                                <template #footer>
                                    <PrimeButton icon="pi pi-arrow-right" label="Abrir" class="p-button-secondary w-full" style="margin-left: .5em" @click="activatePresentation" />
                                </template>
                            </Card>
                        </div>
                    </div>
                    <div class="grid">
                        <div class="col p-6" v-if="product === true">
                            <ListProducts />
                        </div>
                        <div class="col p-6" v-if="diagnostic === true">
                            <ListDiagnostic />
                        </div>
                        <div class="col p-6" v-if="address  === true">
                            <ListAddress />
                        </div>
                        <div class="col p-6" v-if="presentation === true">
                            <ListPresentation />
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </BreezeAuthenticatedLayout>
</template>

<script>
import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue'
import { Head } from '@inertiajs/inertia-vue3';
import ListProducts from "@/Pages/Products/ListProducts";
import ListDiagnostic from "@/Pages/Diagnostics/ListDiagnostic";
import ListAddress from "@/Pages/Address/ListAddress";
import ListPresentation from "@/Pages/Presentations/ListPresentation";

export default {
    components: {
        ListProducts,
        ListDiagnostic,
        ListAddress,
        ListPresentation,
        BreezeAuthenticatedLayout,
        Head,
    },
    data() {
        return {
            product: false,
            diagnostic: false,
            address: false,
            presentation: false
        }
    },
    methods: {
        activateProducts() {
            this.address = false;
            this.diagnostic = false;
            this.presentation = false;
            this.product = true;
        },
        activateDiagnostic() {
            this.address = false;
            this.product = false;
            this.presentation = false;
            this.diagnostic = true;
        },
        activateAddress() {
            this.diagnostic = false;
            this.product = false;
            this.presentation = false;
            this.address= true;
        },
        activatePresentation() {
            this.diagnostic = false;
            this.product = false;
            this.address= false;
            this.presentation = true;
        }
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
