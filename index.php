<?php get_header(); ?>

    <div class="h-[100vh] w-full relative overflow-hidden">
        <!-- Affichage de l'image de couverture -->
        <img src="<?= get_field('image', 'option'); ?>" alt="Cover" class="object-cover w-full h-full">

        <div class="w-full h-full absolute top-0 left-0 bg-gradient-to-t from-gray-900 to-transparent"></div>


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

                <div class="mt-8">
                    <a href="#content" class="border-[1px] border-white p-2 text white hover:bg-white hover:text-blue-500">
                        Découvrir nos articles
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="container mx-auto px-4 mb-28" id="content">

        <h2 class="text-4xl font-bold mt-8 mb-4 text-gray-700">
            Articles récents
        </h2>

        <p class="text-xl mb-8 text-gray-500">
            Retrouvez les derniers articles publiés sur le blog.
        </p>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
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
                    <article class="relative group cursor-pointer overflow-hidden rounded-md border-[1px] border-gray-200">
                        <a href="<?php the_permalink(); ?>">
                            <?php if(has_post_thumbnail()): ?>
                                <img src="<?php the_post_thumbnail_url('medium'); ?>" alt="<?php the_title(); ?>" class="w-full h-48 object-cover rounded-t-md group-hover:h-20 transition-all">
                            <?php else: ?>
                                <p class="w-full h-48 bg-gray-200 rounded-t-md group-hover:h-20 transition-all"></p>
                            <?php endif; ?>
                        </a>
                        <div class="p-4 h-60">
                            <!-- Appliquer le style d'ellipse sur les titres -->
                            <h3 class="group-hover:text-gray-900 text-2xl font-bold text-gray-700 truncate mb-2">
                                <?php the_title(); ?>
                            </h3>
                            <div class="flex items-center justify-between w-full mb-4">
                                <h4 class="text-md text-gray-500">
                                    <?php the_category('/ '); ?>
                                </h4>
                                <time class="text-md block text-gray-500">Publié le <?php echo get_the_date(); ?></time>
                            </div>

                            <!-- Appliquer le style de texte tronqué sur trois lignes avec une hauteur fixe -->
                            <div class="text-gray-700 line-clamp-3 group-hover:line-clamp-5 transition-all"><?php the_excerpt(); ?></div>

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

        <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
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
                        <h3 class="text-md md:text-2xl font-bold text-white truncate mb-2"><?= $category->name; ?></h3>
                        <div class="max-h-0 group-hover:max-h-40 transition-max-height duration-300 ease-in-out overflow-hidden flex items-center justify-between w-full">
                            <h4 class="text-sm md:text-lg text-white truncate">
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

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8">
                    <?php
                    if (!empty($section['article'])) :
                        foreach ($section['article'] as $article_url) :
                            // Récupérer l'ID de l'article à partir de l'URL
                            $article_id = url_to_postid($article_url);

                            if ($article_id) :
                                $post = get_post($article_id); // Récupérer les informations de l'article
                                setup_postdata($post); // Préparer les données de l'article pour WordPress
                                ?>
                                <article class="relative group cursor-pointer overflow-hidden rounded-md border-[1px] border-gray-200">
                                    <a href="<?php the_permalink(); ?>">
                                        <?php if(has_post_thumbnail()): ?>
                                            <img src="<?php the_post_thumbnail_url('medium'); ?>" alt="<?php the_title(); ?>" class="w-full h-48 object-cover rounded-t-md group-hover:h-20 transition-all">
                                        <?php else: ?>
                                            <p class="w-full h-48 bg-gray-200 rounded-t-md group-hover:h-20 transition-all"></p>
                                        <?php endif; ?>
                                    </a>
                                    <div class="p-4 h-60">
                                        <!-- Appliquer le style d'ellipse sur les titres -->
                                        <h3 class="group-hover:text-gray-900 text-2xl font-bold text-gray-700 truncate mb-2">
                                            <?php the_title(); ?>
                                        </h3>
                                        <div class="flex items-center justify-between w-full mb-4">
                                            <h4 class="text-md text-gray-500">
                                                <?php the_category('/ '); ?>
                                            </h4>
                                            <time class="text-md block text-gray-500">Publié le <?php echo get_the_date(); ?></time>
                                        </div>

                                        <!-- Appliquer le style de texte tronqué sur trois lignes avec une hauteur fixe -->
                                        <div class="text-gray-700 line-clamp-3 group-hover:line-clamp-5 transition-all"><?php the_excerpt(); ?></div>

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

        <h2 class="text-4xl font-bold mt-8 mb-4 text-gray-700">
            Qui sommes-nous ?
        </h2>

        <div class="mx-auto container grid gap-4 grid-cols-1 md:grid-cols-2 mb-8">
            <div class="">
                <h3 class="text-2xl text-gray-500 font-bold truncate mb-2">
                    Une équipe de passionnés
                </h3>
                <p class="text-xl mb-8 text-gray-500">
                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed etiam, ut ait Accius, in oculis quidem exercitus. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed etiam, ut ait Accius, in oculis quidem exercitus.
                </p>
            </div>
            <div>
                <div class="w-full h-64 rounded-lg overflow-hidden">
                    <img src="https://www.bar-bisou.fr/wp-content/uploads/2024/06/voyage-bar-bisous-1024x683.png.webp" alt="" class="w-full h-full object-cover">
                </div>
            </div>
        </div>
    </div>

    <?php
    $sections = get_field('section_categories', 'option');
    if ($sections) :
        foreach ($sections as $index => $section) : // Utilisez l'index pour déterminer l'ordre
            ?>
            <?php
            $categoryId = $section['category'];
            $categoryLink = get_category_link($categoryId);
            $categoryName = get_cat_name($categoryId);

            // Définir la classe d'ordre en fonction de l'index
            $orderClass = ($index % 2 === 0) ? 'md:order-last' : 'md:order-first';
            ?>
            <div class="odd:bg-gray-100 ">
                <div class="mx-auto px-4 container grid gap-4 grid-cols-1 md:grid-cols-2 mb-8 py-8">
                    <!-- Ordre par défaut -->
                    <div class="relative flex flex-col justify-between h-full">
                        <div class="relative rounded-md overflow-hidden">
                            <?php $image = get_field('image', 'category_' . $categoryId); ?>
                            <?php if ($image): ?>
                                <img src="<?= esc_url($image); ?>" alt="<?= esc_attr($categoryName); ?>" class="w-full h-48 object-cover">
                            <?php else: ?>
                                <p class="w-full h-96 bg-gray-200 rounded-md"></p>
                            <?php endif; ?>
                            <a href="<?= esc_url($categoryLink); ?>" class="w-full h-full absolute top-0 left-0 bg-gradient-to-t from-gray-700 to-transparent"></a>
                            <div class="bottom-4 left-4 absolute">
                                <h3 class="text-2xl font-bold text-white truncate mb-2"><?= esc_html($categoryName); ?></h3>
                            </div>
                        </div>

                        <div class="p-4">
                            <h2 class="text-4xl font-bold mt-8 mb-4 text-gray-700">
                                <?= esc_html($section['title']); ?>
                            </h2>

                            <p class="text-xl mb-8 text-gray-500">
                                <?= esc_html($section['description']); ?>
                            </p>
                        </div>

                        <!-- Cette partie sera toujours collée en bas -->
                        <div class="p-4 flex items-center justify-end mt-auto">
                            <a href="<?= esc_url($categoryLink); ?>" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                                Voir plus
                            </a>
                        </div>
                    </div>

                    <!-- Contenu des articles -->
                    <div class="<?php echo esc_attr($orderClass); ?>">
                        <?php
                        // Récupérer 4 articles random de la catégorie
                        $args = array(
                            'post_type' => 'post',
                            'posts_per_page' => 4,
                            'orderby' => 'rand',
                            'cat' => $categoryId
                        );

                        $query = new WP_Query($args);
                        ?>
                        <div class="grid grid-cols-2 gap-4">
                            <?php if ($query->have_posts()) : ?>
                                <?php while ($query->have_posts()) : $query->the_post(); ?>
                                    <article class="group rounded-md border-[1px] h-72 border-gray-200 overflow-hidden">
                                        <a href="<?php the_permalink(); ?>">
                                            <?php if (has_post_thumbnail()): ?>
                                                <img src="<?php the_post_thumbnail_url('medium'); ?>" alt="<?php the_title(); ?>" class="w-full h-48 object-cover rounded-t-md group-hover:h-20 transition-all">
                                            <?php else: ?>
                                                <p class="w-full h-48 bg-gray-200 rounded-t-md group-hover:h-20 transition-all"></p>
                                            <?php endif; ?>
                                        </a>
                                        <div class="bg-white p-4 h-24 relative group-hover:h-52">
                                            <a href="<?php the_permalink(); ?>" class="block">
                                                <h2 class="group-hover:text-gray-900 text-2xl font-bold text-gray-700 line-clamp-2 group-hover:line-champ-3">
                                                    <?php the_title(); ?>
                                                </h2>
                                                <div class="max-h-0 group-hover:max-h-40 transition-all overflow-hidden w-full">
                                                    <p class="text-sm md:text-lg line-camp-3">
                                                        <?php the_excerpt() ?>
                                                    </p>
                                                </div>
                                            </a>
                                        </div>
                                    </article>
                                <?php endwhile; ?>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        <?php
        endforeach;
    endif;
    ?>
<?php get_footer(); ?>