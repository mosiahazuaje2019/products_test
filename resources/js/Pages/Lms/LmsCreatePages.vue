<template>

    <div class="card">
        <div class="formgrid grid">
            <div class="field col">
                <label>Paciente - <span>{{patient.personal_id}}</span></label>
                <InputText v-model="patient.full_name" class="inputfield w-full" disabled="true" />
            </div>
            <div class="field col">
                <label>Fecha de generación</label>
                <Calendar id="icon" v-model="form.date_ini" :showIcon="true" class="w-full" dateFormat="dd/mm/yy" />
            </div>
        </div>
        <div class="field col">
            <label>Diagnóstico</label>
            <InputText v-model="form.diagnostic"  class="inputfield w-full"/>
        </div>

        <div class="formgrid grid" v-if="addressCount > 0">
            <label>Seleccione una direccion</label>
            <div class="field-radiobutton w-full" v-for="address in addreses"  v-bind:key="address.id">
                <RadioButton v-model="form.address" value="address.address" />
                <label for="city1">{{address.address}}</label>
            </div>
        </div>

        <MedicinesAdd v-if="display === true" :order_id="order_id" :patient_id="form.patient_id" />

        <div class="formgrid grid">
            <div class="field col">
                <label>Código autorización - LM | EC</label>
                <InputText v-model="form.lm_id" class="inputfield w-full" />
            </div>
            <div class="field col">
                <label>Autorizado por:</label>
                <InputText v-model="form.lm_id" class="inputfield w-full" />
            </div>
        </div>
        <div class="field col">
            <label>Observaciones</label>
            <InputText v-model="form.lm_id" class="inputfield w-full" />
        </div>

        <div class="field">
            <PrimeButton icon="pi pi-save" label="Guardar" class="sm:-bottom-1.5" @click="submit" />
        </div>

    </div>


</template>

<script>

import MedicinesAdd from "@/Pages/Medicines/MedicinesAdd";

export default {
    name: "LmsCreatePages",
    components: {
        MedicinesAdd
    },
    data () {
        return {
            patient:[],
            doctors: null,
            addreses: null,
            addressCount: 0,
            selectedDoctor: null,
            filterdDoctor: null,
            order_id: null,
            display: false,
            form:{
                lm_id: null,
                date_ini: null,
                date_end: null,
                addreses: {},
                diagnostic: null,
                doctor_id: null,
                patient_id: null
            },
            error_lm_id: null,
            saveLm: false,
        }
    },
    props: {
        createLm: Object,
        editId: Number,
    },
    methods: {
         async getDoctors() {
            await axios.get('api/doctors').then((res) => {
                this.doctors = res.data
            })
        },
        async getAddress(id) {
            await axios.get(`api/address_patient/${id}`).then((res) =>{
                this.addreses = res.data;
                this.addressCount = this.addreses.length;
            })
        },
        async submit () {
            this.form.patient_id = this.$props.createLm.id;
            if(!this.$props.editId) {
                try {
                    const res = await axios.post('api/patient_lm', this.form)
                    this.saveLm = true
                    this.order_id = res.data.id;
                    this.display = true;

                    return this.emitter.emit('patientLm_reload')
                }
                catch (e) {
                    if (e.response) {
                        switch (e.response.status) {
                            case 422:
                                let err = e.response.data.errors
                                this.error_lm_id = err.lm_id ? err.lm_id[0] : null
                        }
                    }
                    return null
                }
            }
            try {
                const res = await axios.put(`/api/patient_lm${this.$props.editId}`, this.form)
                return this.emitter.emit('patientLm_reload')
            }
            catch (e) {
                if (e.response) {
                    switch (e.response.status) {
                        case 422:
                            let err = e.response.data.errors
                            this.error_lm_id = err.lm_id ? err.lm_id[0]: null
                    }
                }
            }
        },
        searchDoctor(event) {
            setTimeout(() => {
                if (!event.query.trim().length) {
                    this.filteredDoctor = [...this.doctors];
                }
                else {
                    this.filteredDoctor = this.doctors.filter((doctor) => {
                        return `${doctor.complete_name}`.toLowerCase().startsWith(event.query.toLowerCase());
                    });
                }
            }, 250);
        },
    },
    mounted() {
        this.patient = this.$props.createLm;
        //this.getDoctors();
        this.getAddress(this.patient.id);

        this.emitter.on('patient_lm_detail_reload', () => {
            this.$toast.add({
                severity:'success', summary: 'SUCCESS!',
                detail: `Operación realizada con éxito!`, life:3000,
            })
        })

    }
}
</script>

<style scoped>
.p-inputtext{
    width: 100%;
}
</style>
