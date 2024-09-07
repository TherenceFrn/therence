<?php get_header(); ?>

    <div class="h-[100vh] w-full relative overflow-hidden">
        <!-- Affichage de l'image de couverture -->
        <img src="<?= get_field('image', 'option'); ?>" alt="Cover" class="object-cover w-full h-full">

        <!-- Récupération et affichage des champs "title" et "subtitle" -->
        <?php
        $title = get_field('title', 'option');
        $subtitle = get_field('subtitle', 'option');
        ?>
        <!-- Ajouter une couche de texte centré -->
        <div class="absolute inset-0 flex items-center justify-start text-white text-left p-4">
            <div class="container mx-auto p-4 pt-40"> <!-- Ajout de pt-20 pour le padding-top -->
                <?php if ($title): ?>
                    <h1 class="text-6xl font-bold mb-4"><?= esc_html($title); ?></h1>
                <?php endif; ?>

                <?php if ($subtitle): ?>
                    <h2 class="text-2xl font-light"><?= esc_html($subtitle); ?></h2>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <div class="container mx-auto p-4">

        <h1 class="text-4xl font-bold my-8 text-gray-700">Bienvenue sur mon site</h1>

        <div class="grid grid-cols-3 gap-4">
            <?php if (have_posts()): while (have_posts()): the_post(); ?>
                <article class="rounded-md border-[1px] border-gray-200">
                    <a href="<?php the_permalink(); ?>">
                        <?php if(has_post_thumbnail()): ?>
                            <img src="<?php the_post_thumbnail_url('medium'); ?>" alt="<?php the_title(); ?>" class="w-full h-48 object-cover rounded-t-md">
                        <?php else: ?>
                            <p class="w-full h-48 bg-gray-200 rounded-t-md"></p>
                        <?php endif; ?>
                    </a>
                    <div class="p-4 h-60 relative">
                        <!-- Appliquer le style d'ellipse sur les titres -->
                        <h2 class="text-2xl font-bold text-gray-700 truncate mb-2"><?php the_title(); ?></h2>
                        <div class="flex items-center justify-between w-full mb-4">
                            <h3 class="text-md text-gray-500">
                                <?php the_category('/ '); ?>
                            </h3>
                            <time class="text-md block text-gray-500">Publié le <?php echo get_the_date(); ?></time>
                        </div>

                        <!-- Appliquer le style de texte tronqué sur trois lignes avec une hauteur fixe -->
                        <div class="text-gray-700 line-clamp-3"><?php the_excerpt(); ?></div>

                        <div class="absolute bottom-4 right-4 text-right mt-2">
                            <a href="<?php the_permalink(); ?>" class="block text-blue-500">Lire la suite ...</a>
                        </div>
                    </div>
                </article>
            <?php endwhile; else: ?>
                <div class="col-span-3">
                    <h2 class="text-2xl">Aucun article trouvé</h2>
                </div>
            <?php endif; ?>
        </div>
    </div>

<?php get_footer(); ?>