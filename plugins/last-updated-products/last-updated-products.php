<?php
    /*
    Plugin Name: Productos Recientes - ULL
    Plugin URI: 
    Description: Widget de últimos comentarios
    Version: 0.1
    Author: OSL
    Author URI:
    License: GNU/GPLv3 https://www.gnu.org/licenses/gpl-3.0.html
    */
    add_action( 'widgets_init', 'last_updated_products_create_widgets' );
    function last_updated_products_create_widgets() {
        register_widget( 'Last_Updated_Products' );
    }

    class Last_Updated_Products extends WP_Widget {
		
		function __construct() {
            parent::__construct( 'last_updated_products', 'Last Updated Products', 
                                array('description' => 'Displays list of last products' ) );
		}
		
        function widget() {
			global $wpdb;
		  	$sql_query = "SELECT p1.name, p1.image_url, p1.description, p1.id, p2.single_product_url_type
			  		FROM " . $wpdb->prefix . "huge_it_catalog_products AS p1, "
					. $wpdb->prefix . "huge_it_catalog_products AS p2, "
					. $wpdb->prefix . "huge_it_catalogs AS catalogs
					WHERE ((p1.catalog_id = catalogs.id)
			  		AND (p2.name = catalogs.name))
					ORDER BY p1.id DESC";
			
			$product_items = $wpdb->get_results( $sql_query, ARRAY_A );
			  
			if ( !empty( $product_items ) ) {
				$unique_product_items = array();
				$aux = array();
				$it = 0;
				while ( sizeof($unique_product_items) != 5 ) {
					if ( !in_array( $product_items[$it]['name'], $aux )) {
						$aux[] = $product_items[$it]['name'];
						if ( strlen($product_items[$it]["description"]) > 125) {
							$product_items[$it]["description"] = substr($product_items[$it]["description"], 0, 125) . '...';
						}
						$unique_product_items[] = $product_items[$it];
					}
					$it++;
				}
				$output = "<div id='productos' class='panel-group'>";
				$aux = 0;
				foreach ($unique_product_items as $product) {
					if ( $aux % 2 == 0) {
						$output .= "<div class='panel panel-default'>";
					} else {
						$output .= "<div class='panel panel-info'>";
					}
					$aux++;
					$output .= "<div class='panel-heading'>
										<img src='" . $product['image_url'] . "' alt='p1' height='30px' width='30px'/> | 
										<a style='color:#7a3b7a;' href='" . $product['single_product_url_type'] .
											"?single_prod_id=" . $product['id'] . "'>" . $product['name'] . 
										"</a>
									</div>
									<div class='panel-body'>"
										. $product['description'] .
									"</div>
								</div>";
				}
				$output .= "</div>"; 
					echo $output;
		  	} else {
				echo "<p>No hay elementos que mostrar</p>";
		  	}
		}
	}
?>