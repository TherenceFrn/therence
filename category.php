<?php get_header(); ?>

<div class="container mx-auto px-4 mt-8 mb-28">
    <?php if (have_posts()) : ?>
        <header class="mb-8">
            <h1 class="text-4xl font-bold text-gray-700">
                <?php single_cat_title(); ?>
            </h1>
        </header>

        <?php $image = get_field('image', 'category_' . get_queried_object_id()); ?>

        <div class="w-full h-96 rounded-lg overflow-hidden mb-8">
            <?php if(has_post_thumbnail()): ?>
                <img src="<?= $image ?>" alt="<?php single_cat_title(); ?>" class="w-full h-full object-cover object-center">
            <?php else: ?>
                <p class="w-full h-full bg-gray-200"></p>
            <?php endif; ?>
        </div>

        <?php if (category_description()) : ?>
            <div class="mt-4 text-lg text-gray-600 mb-8">
                <?php echo category_description(); ?>
            </div>
        <?php endif; ?>

        <h2 class="text-2xl font-bold text-gray-700 mb-4">
            Articles récents
        </h2>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
                <div class="rounded-md border-[1px] border-gray-200">
                    <a href="<?php the_permalink(); ?>">
                        <?php if (has_post_thumbnail()) : ?>
                            <img src="<?php the_post_thumbnail_url('medium'); ?>" alt="<?php the_title(); ?>" class="w-full h-48 object-cover rounded-t-md">
                        <?php else : ?>
                            <p class="w-full h-48 bg-gray-200 rounded-t-md"></p>
                        <?php endif; ?>
                    </a>
                    <div class="p-4">
                        <h2 class="text-2xl font-bold text-gray-700"><?php the_title(); ?></h2>
                        <h3 class="text-lg text-gray-500"><?php the_category('/ '); ?></h3>
                        <p class="text-gray-500"><?php the_excerpt(); ?></p>
                        <a href="<?php the_permalink(); ?>" class="block mt-2 text-blue-500">Lire la suite</a>
                    </div>
                </div>
            <?php endwhile; else : ?>
                <div class="col-span-3">
                    <h2 class="text-2xl">Aucun article trouvé</h2>
                </div>
            <?php endif; ?>
        </div>

        <!-- Pagination -->
        <div class="mt-8">
            <?php
            the_posts_pagination(array(
                'mid_size' => 2,
                'prev_text' => __('&laquo; Précédent', 'textdomain'),
                'next_text' => __('Suivant &raquo;', 'textdomain'),
            ));
            ?>
        </div>

        <!-- Description longue de la catégorie -->
        <?php if (function_exists('get_field') && get_field('description_longue', 'category_' . get_queried_object_id())) : ?>
            <div class="mt-16 p-4">
                <h2 class="text-2xl font-bold text-gray-700 mb-4">À propos de cette catégorie</h2>
                <div class="text-gray-600">
                    <?php echo get_field('description_longue', 'category_' . get_queried_object_id()); ?>
                </div>
            </div>
        <?php endif; ?>

    <?php else : ?>
        <p class="text-gray-600">Aucun article trouvé dans cette catégorie.</p>
    <?php endif; ?>
</div>

<?php get_footer(); ?>
