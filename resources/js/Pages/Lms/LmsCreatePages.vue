<template>

    <div class="py-12">
        <Card>
            <template #header>Datos del paciente</template>
            <template #content>
                <div class="p-fluid">
                    <div class="p-field">
                        <label>Nombre</label>
                        <InputText v-model="patient.first_name" class="w-100" />
                    </div>
                    <div class="p-field">
                        <label>Apellido</label>
                        <InputText v-model="patient.last_name" class="w-100" />
                    </div>
                </div>
                <div class="p-fluid">
                    <div class="p-field">
                        <label>Identificacion</label>
                        <InputText v-model="patient.personal_id" class="w-100" />
                    </div>
                </div>
            </template>
        </Card>
    </div>

</template>

<script>

export default {
    name: "LmsCreatePages",
    components: {

    },
    data () {
        return {
            patient:[]
        }
    },
    props: {
        createLm: Object,
    },
    mounted() {
        this.patient = this.$props.createLm;
    }
}
</script>

