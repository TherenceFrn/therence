<?php
if (!defined('ABSPATH')) {
    exit; // Empêche l'accès direct au fichier.
}

get_header('shop'); // Utilise l'en-tête spécifique à la boutique WooCommerce.
?>

<div class="container mx-auto px-4 mt-8 mb-28">

    <!-- Filtre par Catégorie et Prix -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-8 mb-12">
        <!-- Sidebar des filtres -->
        <aside class="bg-white p-4 rounded-md border-[1px] border-gray-200">
            <h2 class="text-2xl font-bold text-gray-700 mb-4">Filtres</h2>

            <!-- Filtre par Catégorie -->
            <div class="mb-6">
                <h3 class="text-xl font-bold text-gray-700 mb-2">Catégories</h3>
                <ul>
                    <?php
                    $categories = get_terms('product_cat', array('hide_empty' => true));
                    foreach ($categories as $category) :
                        ?>
                        <li>
                            <a href="<?php echo get_term_link($category); ?>" class="block text-gray-500 hover:text-blue-500">
                                <?php echo esc_html($category->name); ?>
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>

            <!-- Filtre par Prix -->
            <div class="mb-6">
                <h3 class="text-xl font-bold text-gray-700 mb-2">Prix</h3>
                <form method="get" action="<?php echo esc_url(home_url('/')); ?>">
                    <div class="flex space-x-2 mb-2">
                        <input type="number" name="min_price" class="w-full p-2 border-[1px] border-gray-300 rounded" placeholder="Min">
                        <input type="number" name="max_price" class="w-full p-2 border-[1px] border-gray-300 rounded" placeholder="Max">
                    </div>
                    <button type="submit" class="w-full bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Filtrer</button>
                </form>
            </div>
        </aside>

        <!-- Affichage des Produits -->
        <div class="col-span-1 md:col-span-3">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <?php if (have_posts()) : ?>
                    <?php while (have_posts()) : the_post(); ?>
                        <?php wc_get_template_part('content', 'product'); ?>
                    <?php endwhile; ?>
                <?php else : ?>
                    <p class="text-gray-600">Aucun produit trouvé.</p>
                <?php endif; ?>
            </div>

            <!-- Pagination -->
            <div class="mt-8">
                <?php
                // Afficher la pagination
                woocommerce_pagination();
                ?>
            </div>
        </div>
    </div>

</div>

<?php get_footer('shop'); ?>
