<?php
if (!defined('ABSPATH')) {
    exit; // Empêche l'accès direct au fichier.
}

get_header('shop'); // Utilise l'en-tête spécifique à la boutique WooCommerce.
?>

<div class="container mx-auto p-4">

    <?php while (have_posts()) : the_post(); ?>

        <?php
        global $product;
        $author_id = get_post_field('post_author', $post->ID);
        $author_display_name = get_the_author_meta('display_name', $author_id);
        ?>

        <!-- Titre du Produit -->
        <h1 class="text-4xl font-bold my-8 text-gray-700 text-center">
            <?php the_title(); ?>
        </h1>

        <!-- Image du Produit -->
        <div class="max-w-3xl mx-auto">
            <!-- Image du Produit avec un design personnalisé -->
            <div class="w-full h-96 rounded-lg overflow-hidden shadow-lg relative">
                <?php if (has_post_thumbnail()) : ?>
                    <img src="<?php the_post_thumbnail_url('large'); ?>" alt="<?php the_title(); ?>" class="w-full h-full object-cover transition-transform duration-300 hover:scale-105">
                <?php else : ?>
                    <p class="w-full h-full bg-gray-200 flex items-center justify-center text-gray-500">Aucune image disponible</p>
                <?php endif; ?>
                <!-- Ajouter une légende d'image superposée -->
                <div class="absolute bottom-0 left-0 bg-black bg-opacity-50 text-white p-4 w-full">
                    <span><?php the_title(); ?></span>
                </div>
            </div>

            <!-- Prix du Produit et Bouton d'Achat avec des styles améliorés -->
            <div class="mt-8 bg-white p-6 rounded-lg shadow-md flex items-center justify-between">
                <!-- Affichage du prix avec un style personnalisé -->
                <span class="text-3xl text-blue-500 font-semibold">
                    <?php echo $product->get_price_html(); ?>
                </span>
                <!-- Bouton d'ajout au panier personnalisé -->
                <div class="flex items-center">
                    <?php if ($product->is_in_stock()) : ?>
                        <form class="flex items-center" action="<?php echo esc_url(apply_filters('woocommerce_add_to_cart_form_action', $product->get_permalink())); ?>" method="post" enctype='multipart/form-data'>
                            <?php woocommerce_quantity_input(array(
                                'min_value'   => apply_filters('woocommerce_quantity_input_min', $product->get_min_purchase_quantity(), $product),
                                'max_value'   => apply_filters('woocommerce_quantity_input_max', $product->get_max_purchase_quantity(), $product),
                                'input_value' => isset($_POST['quantity']) ? wc_stock_amount($_POST['quantity']) : $product->get_min_purchase_quantity(),
                            )); ?>
                            <button type="submit" name="add-to-cart" value="<?php echo esc_attr($product->get_id()); ?>" class="ml-4 bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 transition-colors">
                                <?php echo esc_html($product->single_add_to_cart_text()); ?>
                            </button>
                        </form>
                    <?php else : ?>
                        <span class="text-red-500">En rupture de stock</span>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Détails du Produit -->
            <div class="mt-4 text-gray-700">
                <?php the_content(); ?>
            </div>

            <!-- Métadonnées du Produit (Catégorie, Auteur, etc.) -->
            <div class="flex items-start justify-between mt-8">
                <div>
                    <!-- Affichage des Catégories de Produits -->
                    <div class="mt-4 text-gray-500">
                        <?php
                        $terms = get_the_terms($post->ID, 'product_cat');
                        if (!empty($terms) && !is_wp_error($terms)) {
                            $last_term = end($terms);
                            foreach ($terms as $term) {
                                $term_link = get_term_link($term->term_id, 'product_cat');
                                echo '<a href="' . esc_url($term_link) . '" class="hover:underline ' . ($term->term_id === $last_term->term_id ? 'text-blue-500' : '') . '">' . esc_html($term->name) . '</a> / ';
                            }
                        }
                        ?>
                    </div>
                </div>
            </div>

            <!-- Partage sur les Réseaux Sociaux -->
            <div class="mt-8">
                <strong>Partager ce produit :</strong>
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

            <!-- Produits Associés -->
            <div class="mt-8">
                <h2 class="text-2xl font-bold text-gray-700 mb-4">Vous pourriez aussi aimer</h2>
                <?php woocommerce_output_related_products(array('posts_per_page' => 3)); ?>
            </div>
        </div>
    <?php endwhile; ?>
</div>

<?php get_footer('shop'); ?>
