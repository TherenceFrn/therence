<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta
            name="viewport"
            content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <?php wp_head(); ?>
</head>
<body class="relative">
<nav class="z-50 sticky top-0 w-full bg-blue-500 text-white">
    <div class="container mx-auto px-4">
        <div class="flex items-center justify-between h-16">
            <div class="flex items-center">
                <a href="<?php echo home_url(); ?>" class="text-white">
                    <img src="<?= get_field('logo', 'option'); ?>" alt="Logo" class="h-8">
                </a>
            </div>
            <div class="block">
                <!-- Affichage du menu dynamique avec les classes personnalisées -->
                <?php
                wp_nav_menu(array(
                    'theme_location' => 'header',  // Nom de l'emplacement de menu enregistré
                    'menu_class' => 'flex items-center space-x-4',  // Classes CSS à appliquer aux éléments du menu
                    'container' => '',  // Supprime le conteneur par défaut
                    'fallback_cb' => false  // Ne pas afficher de menu si aucun n'est défini
                ));
                ?>
            </div>
        </div>
    </div>
</nav>
