<?php
/*

Plugin Name: form-actualizacion-osl
Description: Plugin que recibirá el id de un procucto del Huge-ID Catalog y precargará sus datos en el formulario con el objetivo de solicitar una actualización del producto
Version: 0.1
Author: Daniel Daher Pérez
License: GPL

*/

add_action('template_redirect', 'cargarDatos');


function cargarDatos(){
global $wpdb;
  
	if (is_page('actualizar')) {
	  
	  $idUpdate = $_GET['id'];
	
		if ($idUpdate > 37) { // despues de 37 empiezan los id de productos

		 $sql = "SELECT * FROM wp_huge_it_catalog_products WHERE id=" . $idUpdate;



		 $results = $wpdb->get_results($sql);


	foreach ( $results as $fila ) {

		      $app = $fila->name;
		      $idCategoria = $fila->catalog_id;
		      $descripcion = $fila->description;
		      $parametros = $fila->parameters;


		}

		  // para ver los acentos y caracteres especiales correctamente
		
	
		  // variable que contendra nuestro script de js
		  // los id usados aqui solo sirven para el formulario de actualizacion original, si se modifica
		  // el formulario, inspeccionar los input y cambiar los id necesarios
		  $fill = '<script type=\'text/javascript\'>
		  
		  window.onload = function() {
		  
		  document.getElementById("wdform_1_element14").value ="' . $app . '";
		  
		  // Descripción
		  document.getElementById("wdform_4_element14").value =`' . $descripcion . '`;
		  
		  // Categoría
		  var categoria = document.getElementById("wdform_2_element14");
		  
		  for (var i = 0; i < categoria.options.length; i++) {
		    if (categoria.options[i].value == '. $idCategoria . ') {
		      categoria.selectedIndex = i;
		    } // if
		  } // for 
		  
		  // Parse de parámetros
		  
		  var str = "' . $parametros . '";
		  var aux = str.split(\'*()*\').join(\'|\');
		  aux = aux.split(\'_()_\').join(\'|\');
		  
		  var params = aux.split(\'|\');
  
		  // Cargamos la página web
		  document.getElementById("wdform_3_element14").value = params[1];
	
		  // Cargamos la página de descargas
		  document.getElementById("wdform_5_element14").value = params[5];

		  // Cargamos la licencia
		  document.getElementById("wdform_7_element14").value = params[3];
		  
		  // Cargamos los requisitos
		  document.getElementById("wdform_8_element14").value = params[7];
		  };// onload
		  
		  </script>'; /**/
		  
		  echo $fill;
		  
		//  $conn->close();
		 

	      }
	}

}
?>
