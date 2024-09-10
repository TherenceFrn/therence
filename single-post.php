<?php get_header(); ?>

<div class="container mx-auto p-4 mb-24 relative">

    <?php
        global $post; // S'assurer que l'objet $post est disponible

        $author_id = $post->post_author;

        $author_display_name = get_the_author_meta('display_name', $author_id);
    ?>

    <h1 class="text-4xl font-bold my-8 text-gray-700 text-center">
        <?php the_title(); ?>
    </h1>

    <div class="max-w-3xl mx-auto">

        <!-- Image en vedette -->
        <div class="w-full h-96 rounded-lg overflow-hidden">
            <?php if (has_post_thumbnail()): ?>
                <img src="<?php the_post_thumbnail_url('large'); ?>" alt="<?php the_title(); ?>" class="w-full h-full object-cover">
            <?php else: ?>
                <p class="w-full h-full bg-gray-200"></p>
            <?php endif; ?>
        </div>

        <!-- Informations sur l'auteur et les catégories -->
        <div class="flex items-start justify-between">
            <!-- Votre code existant ici -->
        </div>

        <!-- Contenu de l'article avec les titres modifiés -->
        <div class="mt-4 text-gray-700 prose max-w-none relative">
            <!-- Sommaire Dynamique et le Contenu -->
            <?php
            // Extraire le sommaire et le contenu
            $toc_content = App\generateTableOfContent(get_the_content());
            echo $toc_content['toc']; // Affiche le sommaire

            // Afficher le contenu avec les légendes d'images
            $content = $toc_content['content'];

            // Ajouter la logique pour afficher la légende des images
            $content = preg_replace_callback('/<img.*?wp-image-([0-9]+).*?>/i', function ($matches) {
                $attachment_id = $matches[1];
                $caption = wp_get_attachment_caption($attachment_id); // Récupère la légende
                $image_html = $matches[0]; // Le HTML de l'image
                if ($caption) {
                    $caption_html = '<figcaption class="text-center text-sm text-gray-500 mt-2">' . esc_html($caption) . '</figcaption>';
                    return '<figure>' . $image_html . $caption_html . '</figure>'; // Retourne l'image avec la légende
                }
                return $image_html; // Si pas de légende, retourner simplement l'image
            }, $content);

            // Vérifier si le champ ACF "seemore" est rempli
            $seemore_post = get_field('seemore')[0]; // Utilise ACF pour récupérer l'article lié
            if ($seemore_post) {
                $seemore_title = get_the_title($seemore_post->ID);
                $seemore_link = get_permalink($seemore_post->ID);
                $seemore_excerpt = get_the_excerpt($seemore_post->ID);
                $seemore_image = get_the_post_thumbnail_url($seemore_post->ID, 'medium');

                // Bloc CTA HTML
                $cta_block = '<div class="mt-8 p-6 bg-blue-50 rounded-md grid items-center grid-cols-[1fr_5fr] gap-8">
                        ' . ($seemore_image ? '<div href="' . esc_url($seemore_link) . '" class="m-0 w-32 h-32 overflow-hidden rounded-md">
                            <img src="' . esc_url($seemore_image) . '" alt="' . esc_attr($seemore_title) . '" class="not-prose object-cover w-full h-full">
                        </div>' : '') . '
                        <div class="flex-1 h-fit">
                            <h3 class="not-prose text-2xl font-bold text-gray-800 mb-2">' . esc_html($seemore_title) . '</h3>
                            <p class="not-prose text-gray-600 mb-4 line-clamp-3">
                                Cet article pourrait vous intéresser ! Découvrez-en plus sur : "' . esc_html($seemore_excerpt) . '"
                            </p>
                        </div>
                    </a>
                </div>';

                // Trouver les titres (<h2> ou <h3>) et insérer le CTA de manière aléatoire
                $pattern = '/(<h[2-3][^>]*>)/i';
                preg_match_all($pattern, $content, $matches, PREG_OFFSET_CAPTURE);
                if (!empty($matches[0])) {
                    // Choisir un titre aléatoire pour insérer le bloc CTA avant
                    $random_index = array_rand($matches[0]);
                    $offset = $matches[0][$random_index][1];
                    // Insérer le CTA avant le titre choisi
                    $content = substr_replace($content, $cta_block, $offset, 0);
                } else {
                    // Si aucun titre trouvé, ajouter le bloc à la fin du contenu
                    $content .= $cta_block;
                }
            }

            echo $content; // Affiche le contenu modifié
            ?>
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

        <div class="mt-8 mb-24">
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
</div>

<?php get_footer(); ?>
