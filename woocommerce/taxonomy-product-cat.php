<?php
if (!defined('ABSPATH')) {
    exit; // Empêche l'accès direct au fichier.
}

get_header('shop'); // Utilise l'en-tête spécifique à la boutique WooCommerce.
?>

<div class="container mx-auto px-4 mt-8">
    <?php if (apply_filters('woocommerce_show_page_title', true)) : ?>
        <h1 class="text-4xl font-bold text-gray-700 mb-4 text-center"><?php woocommerce_page_title(); ?></h1>
    <?php endif; ?>

    <!-- Description de la catégorie -->
    <?php do_action('woocommerce_archive_description'); ?>

    <!-- Liste des produits -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
            <article class="relative group cursor-pointer overflow-hidden rounded-md border-[1px] border-gray-200 shadow-lg">
                <a href="<?php the_permalink(); ?>">
                    <?php if (has_post_thumbnail()) : ?>
                        <img src="<?php the_post_thumbnail_url('medium'); ?>" alt="<?php the_title(); ?>" class="w-full h-48 object-cover rounded-t-md group-hover:h-20 transition-all">
                    <?php else : ?>
                        <p class="w-full h-48 bg-gray-200 rounded-t-md group-hover:h-20 transition-all"></p>
                    <?php endif; ?>
                </a>
                <div class="p-4 h-60">
                    <h3 class="group-hover:text-gray-900 text-2xl font-bold text-gray-700 truncate mb-2">
                        <?php the_title(); ?>
                    </h3>
                    <div class="flex items-center justify-between w-full mb-4">
                        <span class="text-lg font-semibold text-blue-500"><?php echo $product->get_price_html(); ?></span>
                    </div>
                    <div class="text-gray-700 line-clamp-3 group-hover:line-clamp-5 transition-all"><?php the_excerpt(); ?></div>
                    <div class="absolute bottom-4 right-4 text-right mt-2">
                        <a href="<?php the_permalink(); ?>" class="block text-blue-500 hover:underline">Voir le produit</a>
                    </div>
                </div>
            </article>
        <?php endwhile; else : ?>
            <div class="col-span-3">
                <h2 class="text-2xl text-center text-gray-700">Aucun produit trouvé</h2>
            </div>
        <?php endif; ?>
    </div>

    <!-- Pagination -->
    <div class="mt-8">
        <?php woocommerce_pagination(); ?>
    </div>
</div>

<?php get_footer('shop'); ?>

