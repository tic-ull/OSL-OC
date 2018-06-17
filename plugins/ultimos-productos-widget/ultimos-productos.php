<?php
    /*
    Plugin Name: Últimos productos - ULL
    Plugin URI: 
    Description: Widget de últimos comentarios
    Version: 0.1
    Author: OSL
    Author URI:
    License: GNU/GPLv3 https://www.gnu.org/licenses/gpl-3.0.html
    */
    add_action( 'widgets_init', 'last_updated_products_create_widgets' );
    function last_updated_products_create_widgets() {
        register_widget( 'Last_Products' );
    }

    class Last_Products extends WP_Widget {
		
		function __construct() {
            parent::__construct( 'last_updated_products', 'Últimos productos', 
								array('description' => 'Widget que muestra los últimos productos registrados
													   en el catálogo' ) );
		}

		function form ( $instance ) {
            $render_widget = ( !empty( $instance['render_widget'] ) ? $instance['render_widget'] : 'true' );
            $nb_last_products = ( !empty( $instance['nb_last_products'] ) ? $instance['nb_last_products'] : 5 );
            $widget_title = ( !empty( $instance['widget_title'] ) ? esc_attr( $instance['widget_title'] ) : 
                            'Últimos productos');
            ?>
            <p>
                <label for="<?php echo $this->get_field_id( 'render_widget' ); ?>">
                <?php echo 'Mostrar Widget'; ?>
                    <select id="<?php echo $this->get_field_id( 'render_widget' ); ?>"name="<?php echo
                        $this->get_field_name( 'render_widget' ) ; ?>">
                        <option value="true" <?php selected( $render_widget, 'true' ); ?>>Si</option>
                        <option value="false" <?php selected( $render_widget, 'false' ); ?>>No</option>
                    </select>
                </lable>
            </p>
            <p>
                <label for="<?php echo $this->get_field_id( 'widget_title' ); ?>">
                    <?php echo 'Título del Widget:';?>
                    <input type="text" id="<?php echo $this->get_field_id( 'widget_title' ); ?>"
                           name="<?php echo $this->get_field_name( 'widget_title' ); ?>"
                           value="<?php echo $widget_title; ?>" />
                </label>
            </p>
            <p>
                <label for="<?php echo $this->get_field_id( 'nb_last_products' ); ?>">
                    <?php echo 'Número de comentarios a mostrar:';?>
                    <input type="text" id="<?php echo $this->get_field_id( 'nb_last_products' ); ?>"
                           name="<?php echo $this->get_field_name( 'nb_last_products' ); ?>"
                           value="<?php echo $nb_last_products; ?>" />
                </label>
            </p>
        <?php
		}
		
		function update( $new_instance, $instance ) {
            if ( is_numeric ( $new_instance['nb_last_comments'] ) ) {
                $instance['nb_last_comments'] = intval($new_instance['nb_last_comments']);
            } else {
                $instance['nb_last_comments'] = $instance['nb_last_comments'];
            }
            $instance['widget_title'] = sanitize_text_field( $new_instance['widget_title'] );
            $instance['render_widget'] = sanitize_text_field( $new_instance['render_widget'] );

            return $instance;
        }
		
        function widget( $args, $instance ) {
			if ( 'true' == $instance['render_widget'] ) {
                extract( $args );
                // Obtenemos las opciones de configuración del widget
                $render_widget = ( !empty( $instance['render_widget'] ) ? $instance['render_widget'] : 'true' );
                $nb_last_comments = ( !empty( $instance['nb_last_comments'] ) ? $instance['nb_last_comments'] : 5 );
                $widget_title = ( !empty( $instance['widget_title'] ) ? esc_attr( $instance['widget_title'] ) : 
                                'Últimos productos');
				global $wpdb;
				$sql_query = "SELECT p1.name, p1.image_url, p1.description, p1.id, p2.single_product_url_type
						FROM " . $wpdb->prefix . "huge_it_catalog_products AS p1, "
						. $wpdb->prefix . "huge_it_catalog_products AS p2, "
						. $wpdb->prefix . "huge_it_catalogs AS catalogs
						WHERE ((p1.catalog_id = catalogs.id)
                        AND (p2.name = catalogs.name)
                        AND (p1.published = 'on'))
                        GROUP BY p1.name
						ORDER BY p1.id DESC LIMIT 0, " . $nb_last_comments;
				
				$product_items = $wpdb->get_results( $sql_query, ARRAY_A );

				if ( !empty( $product_items ) ) {
                    $output = "<div id='productos' class='panel-group'>";
                    echo $before_widget . $before_title;
                    echo apply_filters( 'widget_title', $widget_title );
                    echo $after_title;
					$aux = 0;
					foreach ( $product_items as $product ) {
                        
                        if ( strlen($product["description"]) > 125) {
                            $product["description"] = substr($product["description"], 0, 125) . '...';
                        }
						if ( $aux % 2 == 0) {
							$output .= "<div class='panel panel-default'>";
						} else {
							$output .= "<div class='panel panel-info'>";
						}
						$aux++;
						$output .= "<div class='panel-heading'>
                                            <img src='" . $product['image_url'] . "' alt='logo " . $product['name'] . 
                                            "' height='30px' width='30px'/> | 
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
                echo $after_widget;
			}
		}
	}
?>