<?php
    if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
    if(function_exists('current_user_can'))
    if(!current_user_can('delete_pages')) {
        die(__("Access Denied","product-catalog"));
    }	
    if(!function_exists('current_user_can')){
        die(__("Access Denied","product-catalog"));
    }
    global $wpdb;
?>
<div id="huge-it-catalog-general" class="wrap">
    <h2> Como usar alternativas a </h2>
    <ol>
        <li>Para utilizar el buscador de alternativas copie el siguiente shortcode 
        <b>[huge-it-catalog-alternative-to]</b> en una página de su sitio web.</li>
        
        <li>Para añadir el software privativo haga clic sobre el botón "Añadir software"
        que se encuentra en esta misma página.</li>
        
        <li>Para asociar el software privativo al software libre seleccionar ir al submenu
        "Catalogs" y en la edición de cada software puede establecer la relación.
        </li>
    </ol>
    <?php 
        if ( empty( $_GET['id'] ) ) {
            $software_query = "SELECT * FROM " . $wpdb->get_blog_prefix();
            $software_query .= "huge_it_catalog_proprietary_software ORDER BY name ASC ";
            $all_items = $wpdb->get_results( $software_query, ARRAY_A );
            if ( isset( $_GET['page-number'] ) && !empty( $_GET['page-number'] ) ) {
                $page_number = $_GET['page-number'];
            } else {
                $page_number = 1;
            }
            $software_query .= "LIMIT " . ( $page_number - 1 ) * 20 . ", 20";
            $software_items = $wpdb->get_results( $software_query, ARRAY_A );
            
            $number_of_pages = ceil(count($all_items) / 20);
            
    ?>
            <?php 
                if ( isset( $_GET['message'] ) ) {
                    switch($_GET['message']) {
                        case 0:
                        ?>
                            <div id='message' class='updated fade'>
                                <p><strong>Se debe proporcionar un nombre.</strong></p>
                            </div>
                        <?php
                        break;
                        case 1:
                        ?>
                            <div id='message' class='updated fade'>
                                <p><strong>Software almacenado.</strong></p>
                            </div>
                        <?php
                        break;
                        case 2:
                        ?>
                            <div id='message' class='updated fade'>
                                <p><strong>Software actualizado.</strong></p>
                            </div>
                        <?php
                        break;
                        case 3:
                        ?>
                            <div id='message' class='updated fade'>
                                <p><strong>Software eliminado.</strong></p>
                            </div>  
                        <?php
                    }
                }
                ?>
                <h3>Gestión de software privativo</h3>
                <br />
                <a class="add-new-h2" href="<?php echo add_query_arg ( array ( 
                    'page' => 'huge-it-alternative-to',
                    'id' => 'new' ), 'admin.php' ); ?>">
                    Añadir software
                </a>
                    <div style="width: 50%">
                        <div style="text-align: right; margin-right: 0.5%; font-size: medium">
                            <?php
                                for ($i = 1; $i <= $number_of_pages; $i++) {
                                    echo "<a href=" . add_query_arg( array (
                                            'page' => 'huge-it-alternative-to',
                                            'page-number' => $i
                                        ), 'admin.php' ) . " style='margin:0.3%'>" . $i . "</a>"; 
                                } 
                            ?>
                        </div>
                        <form method="post"
                            action="<?php echo add_query_arg ( array ( 'page' => 'huge-it-alternative-to',), 
                                                                    'admin.php' ); ?>">
                            <input type="hidden" name="delete" value="delete_huge_it_software" /> 
                            <table class="wp-list-table widefat fixed">
                                <thead>
                                    <tr>
                                        <th style="width: 30%">ID</th>
                                        <th style="width: 40%">Nombre</th>
                                        <th style="width: 30%"></th>
                                    </tr>
                                </thead>
                                <?php
                                    if ( $software_items ) {
                                        foreach ( $software_items as $software_item ) {
                                            echo '<tr style="background: #FFF">';
                                                echo '<td>' . $software_item['id'] . '</td>';
                                                echo '<td><a href="';
                                                echo add_query_arg( array(
                                                        'page' => 'huge-it-alternative-to',
                                                        'id' => $software_item['id'] ),
                                                        'admin.php'
                                                    );
                                                echo '">' . $software_item['name'] . '</a></td>';
                                                echo '<td><input type="checkbox" name="items[]" value="';
                                                        echo intval( $software_item["id"] ) . '" /></td>';
                                            echo '</tr>';
                                        }
                                    } else {
                                        echo '<tr style="background: #FFF">';
                                        echo '<td colspan="4">No existe software privativo en la base de datos.';
                                    }
                                ?>
                            </table>
                            <br />
                            <input style="float: right;" type="submit" value="Eliminar seleccionados" class="button-primary" />
                        </form>
                    </div>
                    <br />
            <?php

        } elseif ( isset( $_GET['id'] ) && ( 'new' == $_GET['id'] || is_numeric ( $_GET['id'] ) ) ) {
            $software_id = intval( $_GET['id'] );
            $mode = 'new';

            if ( $software_id > 0 ) {
                $software_query = "SELECT * FROM " . $wpdb->get_blog_prefix();
                $software_query .= "huge_it_catalog_proprietary_software WHERE id = %d";
                $software_data = $wpdb->get_row( $wpdb->prepare ( $software_query, $software_id ), ARRAY_A );
                if ( $software_data ) {
                    $mode = 'edit';
                }
            }

            if ( $mode == 'new' ) {
                $software_data = array(
                    'name' => '',
                    'id' => 0
                );
            }

            if ( $mode == 'new' ) {
                echo '<h3>Añadir nuevo software privativo</h3>';
            } elseif ( 'edit' == $mode ) {
                echo '<h3>Editar ' . $software_data['name'];
            }
        ?>
            <form method="post"
                    action="<?php echo add_query_arg ( array ( 
                    'page' => 'huge-it-alternative-to',
                    ), 'admin.php' ); ?>">
                <input type="hidden" name="save" value="true" />
                <input type="hidden" name="software_id" value="<?php echo $software_id; ?>" />
                <table>
                    <tr>
                        <td style="width: 150px">Titulo</td>
                        <td><input type="text" name="software_name" size="60"
                                    value = "<?php echo esc_html( $software_data['name'] ); ?>"/>
                        </td>
                    </tr>
                </table>
                <input type="submit" value="Enviar" class="button-primary" />
            </form>
        <?php
        }
        ?>
</div>
<?php
    if ( isset($_POST['save']) && ($_POST['save'] == 'true') ) {
        global $wpdb;
        if ( !empty ($_POST['software_name'])) {
            $software_name = sanitize_text_field($_POST['software_name']);
            if ( $_POST['software_id'] == 0 ) {
                $wpdb->insert('wp_huge_it_catalog_proprietary_software',
                    array( 'name' => $_POST['software_name']),
                    array('%s')
                );
                $message = 1;
            } elseif ( !empty( $_POST['software_id'] ) && $_POST['software_id'] > 0 ) {
                $wpdb->update( $wpdb->get_blog_prefix() . 'huge_it_catalog_proprietary_software', 
                            array( 'name' => $software_name), 
                            array( 'id' => intval ( $_POST['software_id'] ) ) );
                $message = 2;
            }
        } else {
            $message = 0;
        }
        wp_redirect( add_query_arg( 
                        array( 'page' => 'huge-it-alternative-to',
                               'message' => $message ),
                        'admin.php' ) );
    }

    if ( isset($_POST['delete']) && $_POST['delete'] == 'delete_huge_it_software' ) {
        if ( !empty( $_POST['items'] ) ) {
            $items_to_delete = $_POST['items'];
            global $wpdb;

            foreach ( $items_to_delete as $item_to_delete ) {
                echo $item_to_delete;
                $query = "DELETE FROM " . $wpdb->prefix;
                $query .= "huge_it_catalog_alternative_to WHERE id_proprietary_software = %d";
                $wpdb->query( $wpdb->prepare( $query, intval( $item_to_delete ) ) );
            }

            foreach ( $items_to_delete as $item_to_delete ) {
                echo $item_to_delete;
                $query = "DELETE FROM " . $wpdb->prefix;
                $query .= "huge_it_catalog_proprietary_software WHERE id = %d";
                $wpdb->query( $wpdb->prepare( $query, intval( $item_to_delete ) ) );
            }
            $message = 3;
        }
        wp_redirect( add_query_arg( 
            array( 'page' => 'huge-it-alternative-to',
                   'message' => $message ),
            'admin.php' ) );
    }
?>