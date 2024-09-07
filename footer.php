    <?php wp_footer(); ?>

    <footer class="bg-gray-800 text-white">
        <div class="container mx-auto px-4 py-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-8">
                <div class="col-span-1 md:col-span-2 lg:col-span-1">
                    <h2 class="text-xl font-bold mb-4"><?php echo get_bloginfo('name'); ?></h2>
                    <p class="text-sm"><?php echo get_bloginfo('description'); ?></p>
                    <h2 class="text-xl font-bold mb-4">Contact</h2>
                    <p>20 rue d'Anjou</p>
                    <p>49100 Angers</p>
                    <p>
                        <a class="hover:underline" href="tel:+33123456789">06 47 79 47 08</a>
                    </p>
                    <p>
                        <a class="hover:underline" href="mailto:<?php echo antispambot('therence.ferron@gmail.com'); ?>">
                            <?php echo antispambot('therence.ferron@gmail.com'); ?>
                        </a>
                    </p>
                </div>
                <div>
                    <h2 class="text-xl font-bold mb-4">Navigation</h2>
                    <?php
                    wp_nav_menu(array(
                        'theme_location' => 'footer',
                        'menu_class' => 'space-y-2',
                        'container' => '',
                        'fallback_cb' => false
                    ));
                    ?>
                </div>
                <div>
                    <h2 class="text-xl font-bold mb-4">Meilleurs articles</h2>
                    <?php
                        $articles = get_field('article_footer', 'option');
                    ?>
                    <ul class="space-y-2">
                        <?php foreach($articles as $article): ?>
                            <?php
                                $articleUrl = $article;
                                $article_id = url_to_postid($articleUrl);
                                $articleTitle = get_post($article_id)->post_title;

                            ?>
                            <li>
                                <a href="<?= $article ?>" class="hover:underline">
                                    <?= $articleTitle ?>
                                </a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
                <div>
                    <h2 class="text-xl font-bold mb-4">Réseaux sociaux</h2>
                    <ul class="flex space-x-4">
                        <?php $facebook = get_field('facebook', 'option'); ?>
                        <?php $youtube = get_field('youtube', 'option'); ?>
                        <?php $pinterest = get_field('pinterest', 'option'); ?>
                        <?php $twitter = get_field('twitter', 'option'); ?>
                        <?php $instagram = get_field('instagram', 'option'); ?>
                        <?php $linkedin = get_field('linkedin', 'option'); ?>
                        <?php if($facebook): ?>
                            <li>
                                <a href="<?= $facebook ?>" class="text-white hover:text-blue-500">
                                    Facebook
                                </a>
                            </li>
                        <?php endif; ?>
                        <?php if($youtube): ?>
                            <li>
                                <a href="<?= $youtube ?>" class="text-white hover:text-red-500">
                                    YouTube
                                </a>
                            </li>
                        <?php endif; ?>
                        <?php if($pinterest): ?>
                            <li>
                                <a href="<?= $pinterest ?>" class="text-white hover:text-red-500">
                                    <i class="fab fa-pinterest"></i>
                                </a>
                            </li>
                        <?php endif; ?>
                        <?php if($twitter): ?>
                            <li>
                                <a href="<?= $twitter ?>" class="text-white hover:text-blue-400">
                                    <i class="fab fa-twitter"></i>
                                </a>
                            </li>
                        <?php endif; ?>
                        <?php if($instagram): ?>
                            <li>
                                <a href="<?= $instagram ?>" class="text-white hover:text-red-500">
                                    <i class="fab fa-instagram"></i>
                                </a>
                            </li>
                        <?php endif; ?>
                        <?php if($linkedin): ?>
                            <li>
                                <a href="<?= $linkedin ?>" class="text-white hover:text-blue-700">
                                    <i class="fab fa-linkedin"></i>
                                </a>
                            </li>
                        <?php endif; ?>
                    </ul>
                </div>
                <div>
                    <h2 class="text-xl font-bold mb-4">Newsletter</h2>
                    <p>Recevez les dernières actualités du blog directement dans votre boîte mail.</p>
                    <form action="#" method="post" class="mt-4">
                        <input type="email" name="email" placeholder="Votre adresse e-mail" class="w-full px-4 py-2 rounded-md bg-gray-700 text-white">
                        <button type="submit" class="w-full py-2 mt-4 bg-blue-500 text-white font-bold rounded-md hover:bg-blue-600">S'inscrire</button>
                    </form>
                    <p class="mt-4 text-sm">Vous pouvez vous désinscrire à tout moment.</p>
                </div>
            </div>
        </div>
    </footer>

</body>
</html>