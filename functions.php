<?php

namespace App;

function therenceSupports(): void
{
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('author');
    add_post_type_support('post', 'author'); // Assure que les articles supportent les auteurs
}

function therenceEnqueueStyles(): void
{
    wp_register_script('tailwind', 'https://cdn.tailwindcss.com');
    wp_enqueue_script('tailwind');
}

function therenceTitle($title): string
{
    if (is_front_page()) {
        return get_bloginfo('name');
    }
    return get_bloginfo('name') . ' | ' . $title;
}

add_action('after_setup_theme', 'App\therenceSupports', 10);
add_action('wp_enqueue_scripts', 'App\therenceEnqueueStyles', 10);
add_filter('wp_title', 'App\therenceTitle', 10, 1);

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