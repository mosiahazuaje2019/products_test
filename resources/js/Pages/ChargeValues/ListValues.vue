<template>
    <Head title="Cargue de valores" />
    <BreezeAuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Cargue de valores
            </h2>
        </template>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <a :href="`/api/export_values/`"
                           class="-right-2.5 del-btn"
                           title="Exportar cargue"
                           target="_blank">
                            <i class="pi pi-print"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </BreezeAuthenticatedLayout>
</template>

<script>
import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue'
import { Head } from '@inertiajs/inertia-vue3';

export default {
    name: "ListValues",
    components: {
        BreezeAuthenticatedLayout,
        Head
    }
}
</script>

<style scoped>

</style>
