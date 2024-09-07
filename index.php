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

    <div class="container mx-auto p-4 mb-28">

        <h2 class="text-4xl font-bold mt-8 mb-4 text-gray-700">
            Articles récents
        </h2>

        <p class="text-xl mb-8 text-gray-500">
            Retrouvez les derniers articles publiés sur le blog.
        </p>

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

        <?php $categories = get_categories(array('number' => 3, 'orderby' => 'rand')); ?>
         <h2 class="text-4xl font-bold mt-8 mb-4 text-gray-700">
            Catégories
        </h2>

        <p class="text-xl mb-8 text-gray-500">
            Retrouvez les catégories du blog.
        </p>

        <div class="grid grid-cols-3 gap-4">
            <?php foreach ($categories as $category) : ?>
                <article class="group rounded-md overflow-hidden border-[1px] border-gray-200 relative cursor-pointer">
                    <div>
                        <?php $image = get_field('image', 'category_' . $category->term_id); ?>
                        <?php if($image): ?>
                            <img src="<?= $image; ?>" alt="<?= $category->name; ?>" class="w-full h-36 object-cover rounded-t-md">
                        <?php else: ?>
                            <p class="w-full h-36 bg-gray-200 rounded-t-md"></p>
                        <?php endif; ?>
                    </div>
                    <a
                        href="<?= get_category_link($category->term_id); ?>"
                        class="w-full h-full absolute top-0 left-0 bg-gradient-to-t from-gray-700 to-transparent"
                    >
                    </a>
                    <div class="bottom-4 left-4 absolute">
                        <h3 class="text-2xl font-bold text-white truncate mb-2"><?= $category->name; ?></h3>
                        <div class="max-h-0 group-hover:max-h-40 transition-max-height duration-300 ease-in-out overflow-hidden flex items-center justify-between w-full">
                            <h4 class="text-lg text-white truncate">
                                <?= $category->description; ?>
                            </h4>
                        </div>
                    </div>
                </article>
            <?php endforeach; ?>
        </div>

        <?php
        $sections = get_field('sections', 'option');
        if ($sections) :
            foreach ($sections as $section) :
                ?>
                <h2 class="text-4xl font-bold mt-8 mb-4 text-gray-700">
                    <?= esc_html($section['title']); ?>
                </h2>

                <p class="text-xl mb-8 text-gray-500">
                    <?= esc_html($section['subtitle']); ?>
                </p>

                <div class="grid grid-cols-3 gap-4">
                    <?php
                    if (!empty($section['article'])) :
                        foreach ($section['article'] as $article_url) :
                            // Récupérer l'ID de l'article à partir de l'URL
                            $article_id = url_to_postid($article_url);

                            if ($article_id) :
                                $post = get_post($article_id); // Récupérer les informations de l'article
                                setup_postdata($post); // Préparer les données de l'article pour WordPress
                                ?>
                                <article class="rounded-md border-[1px] border-gray-200">
                                    <a href="<?php the_permalink(); ?>">
                                        <?php if (has_post_thumbnail()): ?>
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
                            <?php
                            endif;
                        endforeach;
                        wp_reset_postdata();
                    else :
                        ?>
                        <div class="col-span-3">
                            <h2 class="text-2xl">Aucun article trouvé</h2>
                        </div>
                    <?php endif; ?>
                </div>
            <?php endforeach;
        endif; ?>
    </div>

<?php get_footer(); ?>