<?php

/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package justg
 */

// Exit if accessed directly.
defined('ABSPATH') || exit;

get_header();

$container = velocitytheme_option('justg_container_type', 'container');
?>

<div class="wrapper" id="index-wrapper">

    <div class="<?php echo esc_attr($container); ?>" id="content" tabindex="-1">

        <div class="row">

            <!-- Do the left sidebar check -->
            <?php do_action('justg_before_content'); ?>

            <div class="col-md">
            <?php
                // Carousel utama: 5 berita terbaru.
                $posts_query = new WP_Query(
                    array(
                        'post_type'           => 'post',
                        'posts_per_page'      => 5,
                        'ignore_sticky_posts' => true,
                    )
                );
                if ($posts_query->have_posts()) {
                    $nm = 0;
                    echo '<div id="carouselHome" class="carousel slide carousel-fade mb-2" data-bs-ride="carousel">';
                    echo '<div class="carousel-inner">';
                    while ($posts_query->have_posts()) {
                        $posts_query->the_post();
                ?>
                        <div class="slideshow-post-item carousel-item <?php echo ($nm === 0 ? 'active' : ''); ?>">
                            <a class="d-block position-relative" href="<?php echo esc_url(get_permalink()); ?>">
                                <div class="ratio ratio-16x9 bg-light overflow-hidden">
                                    <?php
                                    if (has_post_thumbnail()) {
                                        the_post_thumbnail('large', array(
                                            'class'         => 'w-100 h-100 berita-cover',
                                            'alt'           => esc_attr(get_the_title()),
                                            'loading'       => $nm === 0 ? 'eager' : 'lazy',
                                            'fetchpriority' => $nm === 0 ? 'high' : 'auto',
                                        ));
                                    } else {
                                        echo '<span class="berita-tanpa-gambar" aria-hidden="true"><i class="fa fa-picture-o"></i></span>';
                                    } ?>
                                </div>
                                <div class="carousel-caption text-md-start text-center">
                                    <span class="bg-dark d-inline-block p-2" style="--bs-bg-opacity: 0.90;">
                                        <?php echo esc_html(get_the_title()); ?>
                                    </span>
                                </div>
                            </a>
                        </div>
                <?php
                        $nm++;
                    }
                    echo '</div>';
                    echo '<div class="carousel-indicators">';
                    for ($i = 0; $i < $nm; $i++) {
                        echo '<button type="button" data-bs-target="#carouselHome" data-bs-slide-to="' . $i . '"' . ($i === 0 ? ' class="active" aria-current="true"' : '') . ' aria-label="Slide ' . ($i + 1) . '"></button>';
                    }
                    echo '</div>';
                    echo '</div>';
                }
                wp_reset_postdata();
                ?>

                <?php $carousel_cat = velocity_berita8_kategori('carousel_home'); ?>
                <?php if ($carousel_cat !== 'disable') : ?>
                    <div class="part_carousel_home">
                        <div class="part-carousel-home pt-1 pb-3">
                            <?php
                            module_vdposts(array(
                                'post_type'      => 'post',
                                'posts_per_page' => 6,
                                'cat'            => $carousel_cat,
                            ), 'carousel');
                            ?>
                        </div>
                    </div>
                <?php endif; ?>

                <main class="site-main" id="main">

                    <?php foreach (array('posts_home_1', 'posts_home_2') as $blok) : ?>
                        <?php $blok_cat = velocity_berita8_kategori($blok); ?>
                        <div class="widget part_<?php echo esc_attr($blok); ?>">
                            <?php velocity_berita8_kepala_blok($blok); ?>
                            <div class="row">
                                <div class="col-md-6">
                                    <?php
                                    module_vdposts(array(
                                        'post_type'      => 'post',
                                        'cat'            => $blok_cat,
                                        'posts_per_page' => 1,
                                    ), 'posts1');
                                    ?>
                                </div>
                                <div class="col-md">
                                    <?php
                                    module_vdposts(array(
                                        'post_type'      => 'post',
                                        'cat'            => $blok_cat,
                                        'posts_per_page' => 5,
                                        'offset'         => 1,
                                    ), 'posts2');
                                    ?>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>

                    <div class="part-home-2">
                        <div class="row">
                            <div class="col-md-6">
                                <?php get_berita_iklan('iklan_home_2'); ?>
                                <?php $post3_cat = velocity_berita8_kategori('posts_home_3'); ?>
                                <div class="widget part_posts_home_3">
                                    <?php velocity_berita8_kepala_blok('posts_home_3'); ?>
                                    <div class="col-post-first">
                                        <?php
                                        module_vdposts(array(
                                            'post_type'      => 'post',
                                            'cat'            => $post3_cat,
                                            'posts_per_page' => 1,
                                        ), 'posts1');
                                        ?>
                                    </div>
                                    <div class="col-post">
                                        <?php
                                        module_vdposts(array(
                                            'post_type'      => 'post',
                                            'cat'            => $post3_cat,
                                            'posts_per_page' => 5,
                                            'offset'         => 1,
                                        ), '');
                                        ?>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <?php $post4_cat = velocity_berita8_kategori('posts_home_4'); ?>
                                <div class="widget part_posts_home_4">
                                    <?php velocity_berita8_kepala_blok('posts_home_4'); ?>
                                    <div class="col-posts-first">
                                        <?php
                                        module_vdposts(array(
                                            'post_type'      => 'post',
                                            'cat'            => $post4_cat,
                                            'posts_per_page' => 2,
                                        ), 'posts3');
                                        ?>
                                    </div>
                                    <div class="col-posts">
                                        <?php
                                        module_vdposts(array(
                                            'post_type'      => 'post',
                                            'cat'            => $post4_cat,
                                            'posts_per_page' => 3,
                                            'offset'         => 2,
                                        ), 'posts4');
                                        ?>
                                    </div>
                                </div>

                                <div class="widget part_posts_home_5">
                                    <?php velocity_berita8_kepala_blok('posts_home_5'); ?>
                                    <?php
                                    module_vdposts(array(
                                        'post_type'      => 'post',
                                        'cat'            => velocity_berita8_kategori('posts_home_5'),
                                        'posts_per_page' => 5,
                                    ), 'posts5');
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>

                </main><!-- #main -->
            </div>
            <!-- Do the right sidebar check. -->
            <?php do_action('justg_after_content'); ?>
        </div><!-- .row -->

        <div class="row">
            <div class="col-md-6">
                <?php get_berita_iklan('iklan_home_bawah_1'); ?>
            </div>
            <div class="col-md-6">
                <?php get_berita_iklan('iklan_home_bawah_2'); ?>
            </div>
        </div>

    </div><!-- #content -->

</div><!-- #index-wrapper -->

<?php
get_footer();
