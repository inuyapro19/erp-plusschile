<template>
    <template>
        <div>

            <ul class="nav nav-tabs  mb-3 mt-3" id="simpletab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="afp-tab" data-toggle="tab" href="#cuotas" role="tab" aria-controls="home" aria-selected="true">Cuotas</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="anticipo-tab" data-toggle="tab" href="#prestamos" role="tab" aria-controls="home" aria-selected="true">Prestamos</a>
                </li>
            </ul>
            <div class="tab-content" id="simpletabContent">
                <div class="tab-pane fade show active" id="cuotas" role="tabpanel" aria-labelledby="ficha-tab">
                    <cuotas/>
                </div>
                <div class="tab-pane fade" id="prestamos" role="tabpanel" aria-labelledby="anticipo-tab">
                    <Prestamos/>
                </div>
            </div>
        </div>
    </template>

    <script>
       import Prestamos from "./prestamos";
       import cuotas from "./cuotas";
        export default {
            name: "Index",
            components:{
              Prestamos,
                cuotas
            }
        }
    </script>

    <style scoped>

    </style>
</template>

<script>
export default {
    name: "Index",
    components: {}

}
</script>

<style scoped>

</style>
