<?php get_header(); ?>

<div class="container mx-auto">

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
                <div class="p-4">
                    <h2 class="text-2xl font-bold text-gray-700"><?php the_title() ?></h2>
                    <h3 class="text-lg text-gray-500"><?php the_category('/ '); ?></h3>
                    <p class="text-gray-500"><?php the_excerpt(); ?></p>
                    <a href="<?php the_permalink(); ?>" class="block mt-2 text-blue-500">Lire la suite</a>
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