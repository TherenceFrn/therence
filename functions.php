<?php

namespace App;

function therenceSupports(): void
{
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('author');
    add_theme_support('menus');
    add_theme_support('woocommerce'); // Ajouter le support WooCommerce
    register_nav_menu('header', 'En tête du menu');
    register_nav_menu('footer', 'Pied de page');
    add_post_type_support('post', 'author'); // Assure que les articles supportent les auteurs
}

function therenceEnqueueStyles(): void
{
    wp_enqueue_style('tailwind', get_template_directory_uri() . '/assets/css/style.css', [], '1.0', 'all');

    // Configuration personnalisée de Tailwind via un script inline
    wp_add_inline_script('tailwind', '
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: "#1D4ED8",
                        secondary: "#1E40AF",
                    }
                }
            }
        };
    ');

    // Enregistrer les styles WooCommerce personnalisés
    wp_register_style('therence-woocommerce', get_template_directory_uri() . '/assets/css/woocommerce.css', array(), '1.0');
    wp_enqueue_style('therence-woocommerce');
}


function therenceTitle($title): string
{
    if (is_front_page()) {
        return get_bloginfo('name');
    }
    return get_bloginfo('name') . ' | ' . $title;
}

function therenceAddMenuLinkClass($atts, $item, $args) {
    // Vérifie que le menu est celui de l'en-tête
    if ($args->theme_location == 'header' || $args->theme_location == 'footer') {
        // Ajoute la classe 'hover:underline' aux attributs de lien
        $atts['class'] = 'hover:underline';
    }
    return $atts;
}

if (class_exists('WooCommerce')) {
    add_action('after_setup_theme', 'App\therenceSupports', 10);
}

add_action('wp_enqueue_scripts', 'App\therenceEnqueueStyles', 10);
add_filter('wp_title', 'App\therenceTitle', 10, 1);
add_filter('nav_menu_link_attributes', 'App\therenceAddMenuLinkClass', 10, 3);
add_filter('woocommerce_enqueue_styles', '__return_empty_array');

if( function_exists( 'acf_add_options_page' ) ) {

    acf_add_options_page( array(
        'page_title' 	=> 'Options du thème',
        'menu_title'	=> 'Options',
        'menu_slug' 	=> 'theme-general-settings',
        'capability'	=> 'edit_posts',
        'redirect'		=> false,
        'position'    	=> 2
    ) );

    acf_add_options_sub_page( array(
        'page_title' 	=> 'Home',
        'menu_title'	=> 'Home',
        'parent_slug'	=> 'theme-general-settings',
    ) );

    acf_add_options_sub_page( array(
        'page_title' 	=> 'Couleurs du thème',
        'menu_title'	=> 'Couleurs',
        'parent_slug'	=> 'theme-general-settings',
    ) );

}