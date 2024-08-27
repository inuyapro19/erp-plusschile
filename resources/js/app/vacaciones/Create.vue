<template>
    <div class="card pt-5">
        <div class="card-body pt-0">
            <div class="col-md-6 form-group">
                <label for="cargo">Trabajador</label>
                <select
                    name="trabajador_id"
                    class="form-select mb-2"
                    id="trabajador_id"
                    data-control="select2"
                    data-placeholder="Seleccione trabajador"
                    data-allow-clear="true">
                    <option value="">--------</option>
                    <option v-for="({id, rut , primer_nombre, segundo_nombre, primer_apellido, segundo_apellido}, index) in trabajadores"  :value="id">{{rut+' '+primer_nombre +' '+ segundo_nombre+' '+primer_apellido + ' ' +segundo_apellido}}</option>
                </select>
            </div>

            <form  @submit.prevent="enviarFormulario">
                <div class="row">
                    <div class="col-md-6 form-group">
                        <label class=" fs-6 fw-semibold mb-2" for="cargo">Rut</label>
                        <input type="text" v-model="rut" id="nombre" class="form-control" :disabled="true">

                    </div>
                    <div class="col-md-6 form-group">
                        <label class=" fs-6 fw-semibold mb-2" for="cargo">Nombre</label>
                        <input type="text" v-model="nombre_trabajador" id="nombre" class="form-control" :disabled="true">

                    </div>
                    <div  class="col-md-6 form-group">
                        <label class=" fs-6 fw-semibold mb-2" for="cargo">Cargo</label>
                        <input type="text" v-model="cargo_trabajador" id="cargo" class="form-control" :disabled="true">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 form-group">
                        <label class=" fs-6 fw-semibold mb-2" for="ubicacion">Ubicación</label>
                        <input type="text" v-model="ubicacion_trabajador" id="ubicacion" class="form-control" :disabled="true">
                    </div>
                    <div class="col-md-6 form-group">
                        <label class=" fs-6 fw-semibold mb-2" for="empleador">Empleador</label>
                        <input type="text" v-model="nombre_empleador" id="empleador" class="form-control" :disabled="true">
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4 form-group">
                        <label class="required fs-6 fw-semibold mb-2" for="dias_habiles_solicitados">Dias Habiles Solicitados</label>
                        <input type="number" v-model="dias_habiles_solicitados" id="dias_habiles_solicitados" class="form-control" >
                    </div>
                    <div class="col-md-4 form-group">
                        <label  class="required fs-6 fw-semibold mb-2" for="fecha_primer_dia">Fecha primer día</label>
                        <input type="date" v-model="fecha_primer_dia" id="fecha_primer_dia" class="form-control" >
                    </div>
                    <div class="col-md-4 form-group">
                        <label class="required fs-6 fw-semibold mb-2" for="saldo_previo_vacaciones">Saldo previo vacaciones</label>
                        <input type="number" v-model="saldo_previo_vacaciones" id="saldo_previo_vacaciones" class="form-control" >
                    </div>
                    <div class="col-md-4 form-group">
                        <label class="required fs-6 fw-semibold mb-2" for="saldo_despues_vacacaciones">Saldo despues vacaciones</label>
                        <input type="number" v-model="saldo_despues_vacaciones" id="saldo_despues_vacacaciones" class="form-control" >
                    </div>
                    <div class="col-md-4 form-group">
                        <label class="required fs-6 fw-semibold mb-2" for="dias_corridos_del_periodo_de_vac">Días corridos del periodo de Vac.</label>
                        <input type="number" v-model="dias_corridos_del_periodo_de_vac" id="dias_corridos_del_periodo_de_vac" class="form-control" >
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4 form-group">
                        <label class="required fs-6 fw-semibold mb-2" for="fecha_ultimo_dia">Fecha ultimo dia</label>
                        <input type="date" v-model="fecha_ultimo_dia" id="fecha_ultimo_dia" class="form-control" >
                    </div>
                    <div class="col-md-4 form-group">
                        <label class="required fs-6 fw-semibold mb-2" for="fecha_corte_calculo1">Fecha corte calculo #1</label>
                        <input type="date" v-model="fecha_corte_calculo1" id="fecha_corte_calculo1" class="form-control" >
                    </div>
                    <div class="col-md-4 form-group">
                        <label class="required fs-6 fw-semibold mb-2" for="fecha_corte_calculo2">Fecha corte calculo #2</label>
                        <input type="date" v-model="fecha_corte_calculo2" id="fecha_corte_calculo2" class="form-control" >
                    </div>
                </div>

                <div class="row mt-7">
                    <div class="col-md-12">
                        <a href="/vacaiones-trabajador" class="btn btn-default btn-sm">Volver</a>
                        <button type="submit" class="btn btn-primary btn-sm">Guardar</button>
                    </div>
                </div>

            </form>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            dias_habiles_solicitados:0,
            fecha_primer_dia:'',
            saldo_previo_vacaciones:0,
            saldo_despues_vacaciones:0 ,
            dias_corridos_del_periodo_de_vac:0 ,
            fecha_ultimo_dia:'' ,
            fecha_corte_calculo1:'',
            fecha_corte_calculo2:'',
            trabajador_id:0,
            estado:'',
            licencias:[],
            trabajadores:[],
            trabajador_selecionado:[],
            rut:'',
            mostrar_formulario:false,
            //mensaje de respuesta e errores
            mensaje:'',
            respuesta:false,
            alerta:'',
            mensajes:'',
            errors:[],
            inputClass:'form-control form-control-solid',
            errorsClass:'',
            nombre_trabajador:'',
            cargo_trabajador:'',
            nombre_empleador:'',
            ubicacion_trabajador:''
        }
    },
    mounted() {
        this.getTrabajadores()
    },
    updated() {
        //this.refrescar()
        $('#trabajador_id').on('select2:select',this.selectTrabajador)
    },
    methods: {
        refrescar: function () {
           // $(this.$refs.choferes1).selectpicker('refresh')
        },
        selectTrabajador:function (e){
             const id = e.params.data.id
            this.trabajador_id = parseInt(id)
            this.filtrarListaTrabajadorVacaciones()
        },
        async getTrabajadores() {
            try {
                const {data, status} = await axios.get('/lista-trabajadores').then((res) => {
                    this.trabajadores = res.data
                })
                if (status == 200) {
                    this.trabajadores = data
                }
            } catch (error) {
                console.log(error)
            }
        },
        filtrarListaTrabajador() {
            //primero un buscar al trabajador por el rut
            //segundo se despliega el formulario de ingreso de la licencia
            let rut = this.rut
            if (rut) {
                this.trabajador_selecionado = this.trabajadores.find(item => item.rut === rut)

                // console.log(this.trabajador_selecionado)
                //console.log( Object.keys(this.trabajador_selecionado).length)

                if (!(this.trabajador_selecionado === undefined)) {
                    this.trabajador_id = this.trabajador_selecionado.id
                    this.mostrar_formulario = true
                } else {
                    this.$swal('RUT NO ENCONTRADO');
                    this.mostrar_formulario = false
                }

            } else {
                this.$swal('DEBE INGRESAR UN RUT');
            }

        },
        filtrarListaTrabajadorVacaciones() {
            //primero un buscar al trabajador por el rut
            //segundo se despliega el formulario de ingreso de la licencia
            // let rut = this.rut
            if (this.trabajador_id !== 0) {

                this.trabajador_selecionado = this.trabajadores.find(item => item.id === this.trabajador_id)
                this.nombre_trabajador = this.trabajador_selecionado.primer_nombre + ' ' + this.trabajador_selecionado.primer_apellido
                this.rut = this.trabajador_selecionado.rut
                this.cargo_trabajador = this.trabajador_selecionado.contrato.cargo.nombre_cargo
                this.nombre_empleador = this.trabajador_selecionado.contrato.empleador.nombre_empleador
                this.ubicacion_trabajador = this.trabajador_selecionado.contrato.ubicacion.nombre_ubicacion
                // this.mostrar_formulario = true


            } else {
                this.$swal('DEBE INGRESAR UN RUT');
            }
        },
        async enviarFormulario() {
            try {
                let formData = new FormData

                formData.append('dias_habiles_solicitados', this.dias_habiles_solicitados)
                formData.append('fecha_primer_dia', this.fecha_primer_dia)
                formData.append('saldo_previo_vacaciones', this.saldo_previo_vacaciones)
                formData.append('saldo_despues_vacaciones', this.saldo_despues_vacaciones)
                formData.append('dias_corridos_del_periodo_de_vac', this.dias_corridos_del_periodo_de_vac)
                formData.append('fecha_ultimo_dia', this.fecha_ultimo_dia)
                formData.append('fecha_corte_calculo1', this.fecha_corte_calculo1)
                formData.append('fecha_corte_calculo2', this.fecha_corte_calculo2)

                formData.append('trabajador_id', this.trabajador_id)

                const {status} = await axios.post('/vaciones-trabajador', formData)

                if (status == 200) {
                    this.respuesta = true
                    this.alerta = 'alert-success'
                    this.mensajes = 'Vacaciones agregada exitosamente'
                    this.$swal.fire({
                        title: 'Vacaciones agregada exitosamente',
                        icon: 'success',
                        confirmButtonText: 'OK'
                    })
                    .then(() => {
                        this.limpiarFormulario()
                        window.location.href = '/vacaiones-trabajador'
                    })
                }

            } catch (error) {
                this.respuesta = true
                this.alerta = 'alert-danger'
                this.mensajes = 'Error al enviar el formulario'
                this.errorsClass = 'form-control is-invalid';
            }
        },
        limpiarFormulario(){
            this.dias_habiles_solicitados = ''
            this.fecha_primer_dia = ''
            this.saldo_previo_vacaciones = ''
            this.saldo_despues_vacaciones = ''
            this.dias_corridos_del_periodo_de_vac = ''
            this.fecha_ultimo_dia = ''
            this.fecha_corte_calculo1 = ''
            this.fecha_corte_calculo2 = ''
            this.trabajador_id = 0
            this.rut = ''
            this.mostrar_formulario = false
            this.trabajador_selecionado = []
            this.nombre_trabajador = ''
            this.cargo_trabajador = ''
            this.nombre_empleador = ''
            this.ubicacion_trabajador = ''
        }
    }
}
</script>

<style scoped>

</style>
