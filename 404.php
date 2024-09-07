<?php get_header(); ?>

<div class="container mx-auto p-4">

    <div class="h-80 flex items-center justify-center">
        <div>
            <h1 class="text-4xl font-bold my-8 text-gray-700 text-center">
                404 - Page introuvable
            </h1>

            <h2 class="text-2xl font-bold my-8 text-gray-700 text-center">
                Désolé, la page que vous recherchez n'existe pas.
            </h2>

            <p class="text-lg text-gray-700 text-center">
                <a href="<?php echo home_url(); ?>" class="text-blue-500 hover:underline">Retourner à l'accueil</a>
            </p>
        </div>
    </div>

    <h2 class="text-4xl font-bold my-8 text-gray-700">
        Articles récents
    </h2>

    <div class="grid grid-cols-3 gap-4">
        <?php
            $args = array(
                'post_type' => 'post',
                'posts_per_page' => 3,
                'orderby' => 'date',
                'order' => 'DESC'
            );

            $query = new WP_Query($args);

            if ($query->have_posts()):
                while ($query->have_posts()):
                    $query->the_post();
                        ?>
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
                                <h3 class="text-2xl font-bold text-gray-700 truncate mb-2"><?php the_title(); ?></h3>
                                <div class="flex items-center justify-between w-full mb-4">
                                    <h4 class="text-md text-gray-500">
                                        <?php the_category('/ '); ?>
                                    </h4>
                                    <time class="text-md block text-gray-500">Publié le <?php echo get_the_date(); ?></time>
                                </div>

                                <!-- Appliquer le style de texte tronqué sur trois lignes avec une hauteur fixe -->
                                <div class="text-gray-700 line-clamp-3"><?php the_excerpt(); ?></div>

                                <div class="absolute bottom-4 right-4 text-right mt-2">
                                    <a href="<?php the_permalink(); ?>" class="block text-blue-500">Lire la suite ...</a>
                                </div>
                            </div>
                        </article>
                    <?php
                endwhile;
            endif;

        ?>
    </div>
</div>

<?php get_footer(); ?>