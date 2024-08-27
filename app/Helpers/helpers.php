<?php
if (! function_exists('get_nodos_pagina')) {
    function get_nodos_pagina($str)
    {
        $curl = curl_init();
        $url = "https://www.previred.com/web/previred/indicadores-previsionales";

        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER,TRUE);

        $resultado = curl_exec($curl);


        $doc = new DOMDocument();
        $doc->loadHTML($resultado);

        return $doc->getElementsByTagName($str);

    }
}

/*
 * El índice de los nodos está determinado por la posición de la etiqueta pasada como parámetro en get_nodos_pagina()
 *
 */



// Obtener UF
function get_UF()
{
    $nodos = get_nodos_pagina("td");
    return substr($nodos->item(2)->nodeValue,2);
}

// Obtener UTM
function get_UTM()
{
    $nodos = get_nodos_pagina("td");
    return substr($nodos->item(9)->nodeValue,2);

}

// Obtener UTA
function get_UTA()
{
    $nodos = get_nodos_pagina("td");
    return substr($nodos->item(10)->nodeValue,2);
}

// Rentas topes imponibles:

function get_RTI_AFP()
{
    $nodos = get_nodos_pagina("td");
    return substr($nodos->item(13)->nodeValue,2);
}

function get_RTI_IPS()
{
    $nodos = get_nodos_pagina("td");
    return substr($nodos->item(15)->nodeValue,2);
}

function get_RTI_seguro_cesantia()
{
    $nodos = get_nodos_pagina("td");
    return substr($nodos->item(17)->nodeValue,2);
}

// Rentas mínimas imponibles
function get_RMI_dependientes_independientes()
{
    $nodos = get_nodos_pagina("td");
    return substr($nodos->item(20)->nodeValue,2);
}

function get_RMI_menores_mayores()
{
    $nodos = get_nodos_pagina("td");
    return substr($nodos->item(22)->nodeValue,2);
}

function get_RMI_casa_particular()
{
    $nodos = get_nodos_pagina("td");
    return substr($nodos->item(24)->nodeValue,2);
}

function get_RMI_fines_no_remuneracionales()
{
    $nodos = get_nodos_pagina("td");
    return substr($nodos->item(26)->nodeValue,2);
}

// ahorro previsional voluntario

function get_APV_mensual()
{
    $nodos = get_nodos_pagina("td");
    return substr($nodos->item(29)->nodeValue,2);
}

function get_APV_anual()
{
    $nodos = get_nodos_pagina("td");
    return substr($nodos->item(31)->nodeValue,2);
}

// DEPÓSITO CONVENIDO
function get_deposito_convenido()
{
    $nodos = get_nodos_pagina("td");
    return substr($nodos->item(34)->nodeValue,2);
}

// Seguro de cesantia (AFC)
function get_AFC_contrato_indefinido_empleador(){
    $nodos = get_nodos_pagina("td");
    return substr($nodos->item(41)->nodeValue,0,-6);
}

function get_AFC_contrato_indefinido_trabajador(){
    $nodos = get_nodos_pagina("td");
    return substr($nodos->item(42)->nodeValue,0,-6);
}


function get_AFC_contrato_plazo_fijo(){
    $nodos = get_nodos_pagina("td");
    return substr($nodos->item(44)->nodeValue,0,-6);
}

function get_AFC_contrato_plazo_indefinido_mas(){
    $nodos = get_nodos_pagina("td");
    return substr($nodos->item(47)->nodeValue,0,-6);
}

// AFP - TASA TRABAJADORES

function get_tasa_AFP_DEP_capital(){
    $nodos = get_nodos_pagina("td");
    return substr($nodos->item(58)->nodeValue,0,-1);
}
function get_tasa_AFP_INDEP_capital(){
    $nodos = get_nodos_pagina("td");
    return substr($nodos->item(60)->nodeValue,0,-1);
}
function get_tasa_AFP_DEP_cuprum(){
    $nodos = get_nodos_pagina("td");
    return substr($nodos->item(62)>nodeValue,0,-1);
}
function get_tasa_AFP_INDEP_cuprum(){
    $nodos = get_nodos_pagina("td");
    return substr($nodos->item(64)->nodeValue,0,-1);
}

function get_tasa_AFP_DEP_habitat(){
    $nodos = get_nodos_pagina("td");
    return substr($nodos->item(66)->nodeValue,0,-1);
}

function get_tasa_AFP_INDEP_habitat(){
    $nodos = get_nodos_pagina("td");
    return substr($nodos->item(68)->nodeValue,0,-1);
}

function get_tasa_AFP_DEP_planvital(){
    $nodos = get_nodos_pagina("td");
    return substr($nodos->item(70)->nodeValue,0,-1);
}

function get_tasa_AFP_INDEP_planvital(){
    $nodos = get_nodos_pagina("td");
    return substr($nodos->item(72)->nodeValue,0,-1);
}

function get_tasa_AFP_DEP_provida(){
    $nodos = get_nodos_pagina("td");
    return substr($nodos->item(74)->nodeValue,0,-1);
}

function get_tasa_AFP_INDEP_provida(){
    $nodos = get_nodos_pagina("td");
    return substr($nodos->item(76)->nodeValue,0,-1);
}

function get_tasa_AFP_DEP_modelo(){
    $nodos = get_nodos_pagina("td");
    return substr($nodos->item(78)->nodeValue,0,-1);
}

function get_tasa_AFP_INDEP_modelo(){
    $nodos = get_nodos_pagina("td");
    return substr($nodos->item(80)->nodeValue,0,-1);
}

if (! function_exists('eliminar_cero_rut')) {
    function eliminar_cero_rut($rut){
        $new_rut = ltrim($rut, '0');
        return $new_rut;
    }
}


/*
 * zero_fill
 *
 * Rellena con ceros a la izquierda
 *
 * @param $valor valor a rellenar
 * @param $long longitud total del valor
 * @return valor rellenado
 */

if (!function_exists('zero_fill')){

    function zero_fill ($valor, $long = 0)
    {
        return str_pad($valor, $long, '0', STR_PAD_LEFT);
    }

}
