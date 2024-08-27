export function siente_porciento(state, datos){
    if(datos === 'no')
    {
        state.siete_porciento = true
        state.tipo_plan_salud = ['PESOS', 'UF','PESO + UF','COTIZA 7% + UF','COTIZA 7% + PESO']
    }else{
        state.siete_porciento = false
    }

}

export function habilitarMonto(state, datos){
   if(datos =='PESOS' || datos =='COTIZA 7% + PESO' ){
       state.es_monto_peso=false;
       state.es_monto_uf=true;
   }
    if(datos =='UF' || datos =='COTIZA 7% + UF'){
        state.es_monto_peso=true;
        state.es_monto_uf=false;
    }
    if(datos =='PESO + UF'){
        state.es_monto_peso=false;
        state.es_monto_uf=false;
    }

}


export function cargarSaludEdit(state,data){

    console.log()

    state.salud = {
            salud_id:data.salud_id,
            cotiza_siete_porciento:data.cotiza_siete_porciento,
            tipo_plan_salud:data.tipo_plan_salud,
            monto_peso:data.monto_peso ? data.monto_peso : 0,
            monto_uf:data.monto_uf ? data.monto_uf:0
    }
}
