<?php

/**
 * Plugin Name: openpyme-plugin
 * Plugin URI:  http://aaronreimann.com/wordpress
 * Version:     1.1.4
 * Description: plugin personalizado para el proyecto OpenPyme ULL a partir de blank-slate; un famoso plug-in en blanco que ya aporta la jerarquía de ficheros para centrarse en comenzar el desarrollo
 * Author:      Alexis Rodríguez Casañas
 * License:     GPL2
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: openpyme-plugin
 * Domain Path: /languages
 */

require __DIR__ . '/functions.php';

add_action( 'plugins_loaded', 'blank_slate_bootstrap' );

/**
 * Así se añaden estilos y scripts en Wordpress
 */
function namespace_theme_stylesheets() {
    wp_enqueue_style( 'page-template-menu',  get_template_directory_uri() .'/template.css', array(), null, 'all' );
    wp_enqueue_style( 'page-template-body',  get_template_directory_uri() .'/style.css', array(), null, 'all' );
    wp_enqueue_style( 'font-awesome',  'https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css', array(), null, 'all');
    wp_enqueue_style( 'bootstrap',  'https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css', array(), null, 'all');
wp_enqueue_style( 'ull-font',  'https://fonts.googleapis.com/css?family=Rubik&display=swap', array(), null, 'all');
wp_enqueue_style( 'ull-font',  'https://fonts.googleapis.com/css?family=Open+Sans|Raleway|Candal', array(), null, 'all');

}
add_action( 'wp_enqueue_scripts', 'namespace_theme_stylesheets' );



function wpb_custom_new_menu() {
    register_nav_menus(
      array(
        'my-custom-menu' => __( 'My Custom Menu' ),
        'extra-menu' => __( 'Extra Menu' )
      )
    );
  }
  add_action( 'init', 'wpb_custom_new_menu' );
  
