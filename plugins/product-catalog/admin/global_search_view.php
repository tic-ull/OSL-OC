<?php
    if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
    if(function_exists('current_user_can'))
    if(!current_user_can('delete_pages')) {
        die(__("Access Denied","product-catalog"));
    }	
    if(!function_exists('current_user_can')){
        die(__("Access Denied","product-catalog"));
    }
    echo "<h1>What is global search functionality?</h1>
        <p>The global search functionality allows to search the products created by the Huge IT 
        Product Catalog - ULL plugin from any page of the wordpress site.

        <h1>How to use the global search</h1>
        <p>Copy the following shortcode <b>[huge-it-catalog-global-search]</b> in any page
        of your wordpress site.</p>";
?>