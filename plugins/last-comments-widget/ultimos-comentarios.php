<?php
    /*
    Plugin Name: Últimos Comentarios - ULL
    Plugin URI: 
    Description: Widget de últimos comentarios
    Version: 0.1
    Author: OSL
    Author URI:
    License: GNU/GPLv3 https://www.gnu.org/licenses/gpl-3.0.html
    */

    add_action( 'widgets_init', 'last_comments_create_widgets' );

    function last_comments_create_widgets() {
        register_widget( 'Last_Comments' );
    }

    class Last_Comments extends WP_Widget {
        function __construct() {
            parent::__construct( 'last_comments', 'Last Comments',
                                array( 'description' => 'Displays list of last comments' ) );
        }
        function widget() {
            echo "<div class = 'panel-group' id = 'comentarios'></div>";
            $servername = DB_HOST;
		    $username = DB_USER;
            $password = DB_PASSWORD;
            $dbname = DB_NAME;
            $conn = new mysqli($servername, $username, $password, $dbname);
            
            if ($conn->connect_error) {
		        die("Connection failed: " . $conn->connect_error);
		    }
		    $sql = "SELECT id, name, content, product_id, date
			        FROM `wp_huge_it_catalog_reviews`
                    GROUP BY id
                    HAVING COUNT( * ) <=5
                    ORDER BY id DESC";  
            
            $comentario = array();
		    $IdProducto = array();
		    $nombre = array();
		    $producto = array();
            $fechas = array();
		    $result = $conn->query($sql);
		
		    if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                $com = $row["content"];
                    if (strlen($row["content"]) > 150)
                        $com = substr($com,0,150).'...';
                    array_push($comentario, utf8_encode($com));
                    array_push($IdProducto, $row["product_id"]);
                    array_push($nombre, utf8_encode($row["name"]));
                    array_push($fechas, $row["date"]);
                } 
		    } else {
		        echo "0 results";
		    }
            $catalogos = array("10"=>"bi", "11"=>"cms", "12"=>"crm", "13"=>"dist-emp", "14"=>"dms", 
                                "15"=>"ecommerce", "16"=>"erp", "17"=>"gf", "18"=>"si", "19"=>"gw", 
                                "20"=>"internet", "21"=>"ofi", "22"=>"gp", "23"=>"pv", "24"=>"util", 
                                "25" => "diseno", "26" => "multimedia", "28" => "arquitectura", 
                                "29" => "bio", "30" => "edu", "31" => "elec", "32" => "fisica", 
                                "33" => "informatica", "34" => "matematicas", "35" => "medicina");
		    for ($x = 0; $x < count($IdProducto); $x++) {
                $sql = "SELECT name, catalog_id
			            FROM `wp_huge_it_catalog_products`
			            WHERE id =" . $IdProducto[$x];
                $result = $conn->query($sql);
                
		        if ($result->num_rows > 0) { 
		            $row = $result->fetch_assoc(); 
                    $productoAux = '<a style=\"color:#7a3b7a; \" href= \"' . site_url() . '/catalogo/' . 
                                    $catalogos[$row["catalog_id"]] .'/?single_prod_id=' . $IdProducto[$x] . '\">'
                                    . $row["name"] . '</a>';
                    array_push($producto, $productoAux);
                } else {
                    echo "0 name results";
                }
		    }
            $comentarios = '<script type=\'text/javascript\'>
                                document.getElementById("comentarios").innerHTML ="<div class=\"panel panel-default\">" +
                                "<div class=\"panel-heading\">'. $nombre[0] .' | ' .  $fechas[0] . ' | ' . $producto[0] . ' </div>" +
                                "<div class=\"panel-body\">" +
                                    "  '. $comentario[0].'" +
                                "</div></div>" +
                                "<div class=\"panel panel-info\">" +
                                "<div class=\"panel-heading\">'. $nombre[1] .' | ' . $fechas[1] . ' | ' .  $producto[1] . '</div>" +
                                "<div class=\"panel-body\">" +
                                    "  '.$comentario[1].'" +
                                "</div></div>" +
                                "<div class=\"panel panel-default\">" +
                                    "<div class=\"panel-heading\">'. $nombre[2] .' | ' . $fechas[2] . ' | ' . $producto[2] . '</div>"+
                                "<div class=\"panel-body\">" +
                                    "  '. $comentario[2] .'" +
                                "</div></div>" +
                                "<div class=\"panel panel-info\">" +
                                    "<div class=\"panel-heading\">'. $nombre[3] .' | ' . $fechas[3] . ' | ' . $producto[3] . '</div>" +
                                "<div class=\"panel-body\">" +
                                    "  '. $comentario[3] .'" +
                                "</div></div>" +
                                "<div class=\"panel panel-default\">" +
                                    "<div class=\"panel-heading\">'. $nombre[4] .' | ' . $fechas[4] . ' | ' . $producto[4] . '</div>" +
                                "<div class=\"panel-body\">" +
                                    "  '. $comentario[4] .'"+
                                "</div>" +
                                "</div>";
                            </script>';
            echo $comentarios;
        }
    }
?>