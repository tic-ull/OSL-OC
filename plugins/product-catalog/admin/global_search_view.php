<?php
    if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
    if(function_exists('current_user_can'))
    if(!current_user_can('delete_pages')) {
        die(__("Access Denied","product-catalog"));
    }	
    if(!function_exists('current_user_can')){
        die(__("Access Denied","product-catalog"));
    }
?>
    <h1>¿Qué es global la funcionalidad buscador global?</h1>
        <p> El buscador global permite buscar los productos creados por el plugin Huge IT Product Catalog - ULL
        desde cualquier página de su sitio web. </p>

    <h1>Como usar el buscador global</h1>
        <p>Copie el siguiente shortcode <b>[huge-it-catalog-global-search]</b> en cualquier página de su
        sitio web.</p>