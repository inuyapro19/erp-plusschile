<template>
    <div>
        <CardComponent :title="'Reportes'">

              <template #body>
                  <div class="d-flex justify-content-around">
                      <div class="form-check form-switch form-check-custom form-check-solid mt-5">
                          <input class="form-check-input"
                                 type="checkbox"
                                 id="tripulante"
                                 v-model="IsTripulante"


                          />
                          <label class="form-check-label fw-semibold text-gray-400 ms-3" for="status">Reporte de vitacora tripulación</label>
                      </div>
                      <div class="form-check form-switch form-check-custom form-check-solid mt-5">
                          <input class="form-check-input"
                                 type="checkbox"
                                 id="buses"
                                 v-model="IsBus"


                          />
                          <label class="form-check-label fw-semibold text-gray-400 ms-3" for="status">Buses por viajes</label>
                      </div>
                      <div class="form-check form-switch form-check-custom form-check-solid mt-5">
                          <input class="form-check-input"
                                 type="checkbox"
                                 id="concepto"
                                 v-model="IsConcepto"

                          />
                          <label class="form-check-label fw-semibold text-gray-400 ms-3" for="status">Tripulacion por concepto</label>
                      </div>
                      <div class="form-check form-switch form-check-custom form-check-solid mt-5">
                          <input class="form-check-input"
                                 type="checkbox"
                                 id="busesPeridos"
                                 v-model="IsBusesPeriodos"
                          />
                          <label class="form-check-label fw-semibold text-gray-400 ms-3" for="status">Buses por periodos de viajes</label>
                      </div>
                      <div class="form-check form-switch form-check-custom form-check-solid mt-5">
                          <input class="form-check-input"
                                 type="checkbox"
                                 id="busesPeridos"
                                 v-model="IsCliente"
                          />
                          <label class="form-check-label fw-semibold text-gray-400 ms-3" for="status">Clientes</label>
                      </div>
                      <div class="form-check form-switch form-check-custom form-check-solid mt-5">
                          <input class="form-check-input"
                                 type="checkbox"
                                 id="busesPeridos"
                                 v-model="IsFolio"
                          />
                          <label class="form-check-label fw-semibold text-gray-400 ms-3" for="status">Viajes Por Folios</label>
                      </div>
                  </div>

              </template>


        </CardComponent>

        <BusesIndexComponent v-show="IsBus" @change-boolean-value="closeCard" />
        <IndexComponent v-show="IsTripulante"   @change-boolean-value="closeCard"/>
        <TripulacionIndexComponent v-show="IsConcepto"  @change-boolean-value="closeCard" />
        <BusesPeriodosIndexComponent v-show="IsBusesPeriodos"   @change-boolean-value="closeCard"/>
        <ViajesClienteIndexComponent v-show="IsCliente"  @change-boolean-value="closeCard"/>
        <FolioIndexComponent v-show="IsFolio" @change-boolean-value="closeCard" />
    </div>
</template>

<script>
import BusesIndexComponent from "./BusesIndexComponent.vue";
import IndexComponent from "./IndexComponent.vue";
import TripulacionIndexComponent from "./TripulacionIndexComponent.vue";
import BusesPeriodosIndexComponent from "./BusesPeriodosIndexComponent.vue";
import ViajesClienteIndexComponent from "./ViajesClienteIndexComponent.vue";
import FolioIndexComponent from "./FolioIndexComponent.vue";
import CardComponent from "../../components/CardComponent.vue";

export default {
   components: {
       CardComponent,
       BusesIndexComponent,
       IndexComponent,
       TripulacionIndexComponent,
       BusesPeriodosIndexComponent,
       ViajesClienteIndexComponent,
         FolioIndexComponent,
   },
    data() {
        return {
            informes: [
                'INFORME DE BUSES POR VIAJES',
                'HISTORIAL DE TRIPULANTE',
                'INFORME POR CONCEPTO',
            ],
            IsBus: false,
            IsTripulante: false,
            IsConcepto: false,
            IsBusesPeriodos: false,
            IsCliente: false,
            IsFolio: false,
        }
    },
    watch: {
        IsBus: function() {
            this.updateData();
        },
        IsTripulante: function() {
            this.updateData();
        },
        IsConcepto: function() {
            this.updateData();
        }
    },
    methods: {
        updateData() {
            // Actualizar los datos en función de las selecciones del usuario
            console.log(`IsBus: ${this.IsBus}, IsTripulante: ${this.IsTripulante}, IsConcepto: ${this.IsConcepto}`);
        },
        closeCard() {
            this.IsBus = false;
            this.IsTripulante = false;
            this.IsConcepto = false;
            this.IsBusesPeriodos = false;
            this.IsCliente = false;
            this.IsFolio = false;

        }
    },
}
</script>

<style scoped>

</style>
