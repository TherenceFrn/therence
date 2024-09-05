<?php get_header(); ?>

<div class="container mx-auto">

    <?php
        global $post; // S'assurer que l'objet $post est disponible

        $author_id = $post->post_author;

        $author_display_name = get_the_author_meta('display_name', $author_id);
    ?>

    <h1 class="text-4xl font-bold my-8 text-gray-700 text-center">
        <?php the_title(); ?>
    </h1>

    <div class="w-full h-96 rounded-lg overflow-hidden">
        <?php if(has_post_thumbnail()): ?>
            <img src="<?php the_post_thumbnail_url('large'); ?>" alt="<?php the_title(); ?>" class="w-full h-full object-cover">
        <?php else: ?>
            <p class="w-full h-full bg-gray-200"></p>
        <?php endif; ?>
    </div>

    <div class="flex items-start justify-between">
        <div>
            <div class="mt-4 text-gray-500">
                Publié le <?= get_the_date(); ?> par
                <?php
                if ($author_id && $author_display_name) {
                    ?>
                    <a href="<?= get_author_posts_url($author_id); ?>" class="hover:underline">
                        <?= esc_html($author_display_name); ?>
                    </a>
                    <?php
                } else {
                    echo "Auteur inconnu";
                }
                ?>
            </div>
            <div class="text-sm text-gray-400 flex items-center">
                <svg class="w-4 h-4 mr-1 text-gray-500" fill="currentColor" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M10 2C5.589 2 2 5.589 2 10s3.589 8 8 8 8-3.589 8-8-3.589-8-8-8zm0 14c-3.309 0-6-2.691-6-6s2.691-6 6-6 6 2.691 6 6-2.691 6-6 6zm.5-9H9v5l4.285 2.575.72-1.205-3.505-2.125V7z"/></svg>
                <?php
                $word_count = str_word_count(strip_tags(get_the_content()));
                $reading_time = ceil($word_count / 200); // Estimation basée sur 200 mots par minute
                echo 'Temps de lecture estimé : ' . $reading_time . ' minute(s)';
                ?>
            </div>

        </div>
        <div class="mt-4 text-gray-500">
            <?php
            $categories = get_the_category();
            if (!empty($categories)) {
                $last_category = end($categories); // Récupère la dernière catégorie
                foreach ($categories as $category) {
                    $category_link = get_category_link($category->term_id); // Obtient le lien de la catégorie
                    // Appliquer une classe CSS spéciale à la dernière catégorie
                    if ($category->term_id == $last_category->term_id) {
                        echo '<a href="' . esc_url($category_link) . '" class="hover:underline text-blue-500">' . esc_html($category->name) . '</a>';
                    } else {
                        echo '<a href="' . esc_url($category_link) . '" class="hover:underline">' . esc_html($category->name) . '</a> / ';
                    }
                }
            }
            ?>
        </div>
    </div>

    <div class="mt-4 text-gray-700">
        <?php the_content(); ?>
    </div>

    <div class="mt-8">
        <strong>Partager cet article :</strong>
        <div class="flex space-x-4">
            <a href="https://www.facebook.com/sharer.php?u=<?php echo urlencode(get_permalink()); ?>" class="text-blue-600 hover:underline">
                <i class="fab fa-facebook"></i> Facebook
            </a>
            <a href="https://twitter.com/intent/tweet?text=<?php echo urlencode(get_the_title() . ' ' . get_permalink()); ?>" class="text-blue-400 hover:underline">
                <i class="fab fa-twitter"></i> Twitter
            </a>
            <a href="https://www.linkedin.com/shareArticle?mini=true&url=<?php echo urlencode(get_permalink()); ?>&title=<?php echo urlencode(get_the_title()); ?>" class="text-blue-700 hover:underline">
                <i class="fab fa-linkedin"></i> LinkedIn
            </a>
        </div>
    </div>

    <div class="mt-8 p-4 bg-gray-100 rounded-lg">
        <div class="flex items-center">
            <div class="w-16 h-16 rounded-full overflow-hidden">
                <?php

                // Afficher l'avatar de l'auteur
                echo get_avatar($author_id, 64);
                ?>
            </div>
            <div class="ml-4">
                <?php
                // Récupérer et afficher le nom et la description de l'auteur
                $author_display_name = get_the_author_meta('display_name', $author_id);
                $author_description = get_the_author_meta('description', $author_id);
                ?>
                <a class="text-xl font-bold hover:underline" href="<?php echo get_author_posts_url($author_id); ?>">
                    <?php echo esc_html($author_display_name); ?>
                </a>
                <?php if ($author_description): ?>
                    <p><?php echo nl2br(esc_html($author_description)); ?></p>
                <?php else: ?>
                    <p>Aucune biographie disponible pour cet auteur.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <div class="mt-8">
        <h2 class="text-2xl font-bold text-gray-700 mb-4">
            Ces articles pourraient vous intéresser
        </h2>
        <ul>
            <?php
            $related_posts = new WP_Query(array(
                'category__in' => wp_get_post_categories($post->ID),
                'post__not_in' => array($post->ID),
                'posts_per_page' => 3
            ));

            if ($related_posts->have_posts()) {
                while ($related_posts->have_posts()) {
                    $related_posts->the_post(); ?>
                    <li class="mb-2 flex items-center">
                        <?php if (has_post_thumbnail()) : ?>
                            <div class="w-16 h-16 rounded overflow-hidden">
                                <a href="<?php the_permalink(); ?>">
                                    <img src="<?php the_post_thumbnail_url('thumbnail'); ?>" alt="<?php the_title(); ?>" class="object-cover w-full h-full">
                                </a>
                            </div>
                        <?php else : ?>
                            <div class="w-16 h-16 bg-gray-200"></div>
                        <?php endif; ?>
                        <div class="ml-4">
                            <a href="<?php the_permalink(); ?>" class="font-bold text-blue-500 hover:underline"><?php the_title(); ?></a>
                        </div>
                    </li>
                <?php }
                wp_reset_postdata();
            } else {
                echo '<li>Aucun article connexe</li>';
            }
            ?>
        </ul>
    </div>
</div>

<?php get_footer(); ?>
