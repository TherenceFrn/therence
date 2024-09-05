<?php

namespace App;

function therenceSupports(): void
{
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');

}

function therenceEnqueueStyles(): void
{
    wp_register_script('tailwind', 'https://cdn.tailwindcss.com');
    wp_enqueue_script('tailwind');
}

function therenceTitle($title): string
{
    if(is_front_page()) {
        return get_bloginfo('name');
    }
    return get_bloginfo('name') . ' | ' . $title;
}

add_action('after_setup_theme', 'App\therenceSupports', 10);
add_action('wp_enqueue_scripts', 'App\therenceEnqueueStyles', 10);
add_filter('wp_title', 'App\therenceTitle', 10, 1);
