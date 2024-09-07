<?php
if (!defined('ABSPATH')) {
    exit; // Empêche l'accès direct au fichier.
}

get_header('shop'); // Utilise l'en-tête spécifique à la boutique WooCommerce.
?>

<div class="container mx-auto px-4 mt-8">
    <h1 class="text-4xl font-bold text-gray-700 mb-8 text-center">Votre Panier</h1>

    <!-- Démarre la boucle WooCommerce pour afficher le contenu du panier -->
    <div class="woocommerce-cart-form">
        <?php if (WC()->cart->get_cart_contents_count() > 0) : ?>
            <form class="bg-white p-6 rounded-lg shadow-md" action="<?php echo esc_url(wc_get_cart_url()); ?>" method="post">

                <?php do_action('woocommerce_before_cart_table'); ?>

                <table class="shop_table shop_table_responsive cart woocommerce-cart-form__contents w-full mb-6" cellspacing="0">
                    <thead>
                    <tr>
                        <th class="product-thumbnail">Image</th>
                        <th class="product-name">Produit</th>
                        <th class="product-price">Prix</th>
                        <th class="product-quantity">Quantité</th>
                        <th class="product-subtotal">Sous-total</th>
                        <th class="product-remove">Supprimer</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php do_action('woocommerce_before_cart_contents'); ?>
                    <?php foreach (WC()->cart->get_cart() as $cart_item_key => $cart_item) :
                        $_product   = apply_filters('woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key);
                        $product_id = apply_filters('woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key);
                        ?>
                        <tr class="woocommerce-cart-form__cart-item">
                            <td class="product-thumbnail">
                                <?php echo $_product->get_image(); ?>
                            </td>
                            <td class="product-name">
                                <a href="<?php echo esc_url(get_permalink($product_id)); ?>"><?php echo $_product->get_name(); ?></a>
                            </td>
                            <td class="product-price">
                                <?php echo WC()->cart->get_product_price($_product); ?>
                            </td>
                            <td class="product-quantity">
                                <?php woocommerce_quantity_input(array(
                                    'input_name'  => "cart[{$cart_item_key}][qty]",
                                    'input_value' => $cart_item['quantity'],
                                    'max_value'   => $_product->get_max_purchase_quantity(),
                                    'min_value'   => '0'
                                ), $_product, false); ?>
                            </td>
                            <td class="product-subtotal">
                                <?php echo WC()->cart->get_product_subtotal($_product, $cart_item['quantity']); ?>
                            </td>
                            <td class="product-remove">
                                <?php echo apply_filters('woocommerce_cart_item_remove_link', sprintf(
                                    '<a href="%s" class="text-red-500 hover:underline" aria-label="%s" data-product_id="%s" data-product_sku="%s">Supprimer</a>',
                                    esc_url(wc_get_cart_remove_url($cart_item_key)),
                                    __('Remove this item', 'woocommerce'),
                                    esc_attr($product_id),
                                    esc_attr($_product->get_sku())
                                ), $cart_item_key); ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    <?php do_action('woocommerce_cart_contents'); ?>
                    </tbody>
                </table>

                <?php do_action('woocommerce_cart_actions'); ?>
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 transition-colors" name="update_cart" value="<?php esc_attr_e('Update cart', 'woocommerce'); ?>"><?php esc_html_e('Update cart', 'woocommerce'); ?></button>

                <?php wp_nonce_field('woocommerce-cart'); ?>
                <?php do_action('woocommerce_after_cart_contents'); ?>
            </form>
        <?php else : ?>
            <p class="text-center text-gray-700">Votre panier est vide.</p>
        <?php endif; ?>
    </div>

    <!-- Affichage du total et des boutons de commande -->
    <div class="cart-collaterals mt-8">
        <?php woocommerce_cart_totals(); ?>
    </div>

    <!-- Bouton de commande -->
    <div class="flex justify-end mt-4">
        <a href="<?php echo wc_get_checkout_url(); ?>" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600 transition-colors">
            Procéder au paiement
        </a>
    </div>
</div>

<?php get_footer('shop'); ?>
