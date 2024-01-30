<?php

/**
 * The template for displaying all single posts
 *
 * @package justg
 */

// Exit if accessed directly.
defined('ABSPATH') || exit;

get_header();
$container  = velocitytheme_option('justg_container_type', 'container');
$full_url   = get_the_post_thumbnail_url(get_the_ID(), 'full');
$format     = get_post_format() ?: 'standard';
?>

<div class="wrapper" id="single-wrapper">

    <div class="<?php echo esc_attr($container); ?>" id="content" tabindex="-1">

        <div class="card shadow-sm bg-light pt-2 px-3 mb-3">
            <?php echo justg_breadcrumb(); ?>
        </div>

        <div class="row">

            <!-- Do the left sidebar check -->
            <?php do_action('justg_before_content'); ?>

            <main class="site-main col order-2" id="main">

                <?php

                while (have_posts()) {
                    the_post();
                ?>

                    <?php the_title('<h1 class="entry-title h4 fw-bold">', '</h1>'); ?>


                    <div class="d-flex mt-2 justify-content-between align-items-center py-1 px-2 border-bottom border-top text-muted bg-light mb-3">
                        <div>
                            <small>
                                Posted by : <?php echo get_the_author(); ?>
                            </small>
                            <small class="ms-2">
                                <?php echo get_the_date(); ?>
                            </small>
                            <?php $gettags = get_the_tags(get_the_ID()); ?>
                            <?php if ($gettags) : ?>
                                <small class="ms-2">
                                    Tags :
                                    <?php foreach ($gettags as $index => $tag) : ?>
                                        <?php echo $index === 0 ? '' : ','; ?>
                                        <a href="<?php echo get_tag_link($tag->term_id); ?>"> <?php echo $tag->name; ?> </a>
                                        <?php if ($index > 1) {
                                            break;
                                        } ?>
                                    <?php endforeach; ?>
                                </small>
                            <?php endif; ?>
                        </div>
                        <div class="d-none d-md-inline-block">
                            <a class="btn btn-sm btn-light border shadow-sm" style="--bs-btn-font-size: .65rem;" href="<?php echo get_the_permalink(); ?>#respond">
                                <?php echo get_comments_number() == 0 ? 'Reply' : get_comments_number() . ' comments'; ?>
                            </a>
                        </div>
                    </div>

                    <div class="entry-content">

                        <?php
                        if ($full_url && $format !== 'video') {
                            echo '<img class="img-fluid w-100 mb-2" src="' . $full_url . '" loading="lazy">';
                        }
                        ?>

                        <?php the_content(); ?>

                        <?php get_berita_iklan('iklan_content'); ?>

                        <?php
                        wp_link_pages(
                            array(
                                'before' => '<div class="page-links">' . __('Pages:', 'justg'),
                                'after'  => '</div>',
                            )
                        );
                        ?>
                    </div><!-- .entry-content -->

                    <div class="related-post">
                        <div class="related-post-title border-bottom border-color-theme border-3 mb-2">
                            <span class="bg-color-theme text-white py-2 px-3 d-inline-block">RELATED POSTS</span>
                        </div>
                        <div class="related-post-carousel overflow-hidden">
                            <?php
                            module_vdposts(array(
                                'post_type'         => 'post',
                                'posts_per_page'    => 5,
                                'post__not_in'      => [get_the_ID()],
                                'category__in'      => wp_get_post_categories(get_the_ID()),
                            ), 'carousel');
                            ?>
                        </div>
                    </div>

                    <div class="single-post-nav d-md-flex justify-content-between border-top border-bottom pt-1 my-3">
                        <div class="share-post">
                            <?php echo justg_share(); ?>
                        </div>
                        <div class="nav-post">
                            <div class="btn-group" role="group" aria-label="Navigation Post">
                                <?php
                                $prev_post = get_adjacent_post(false, '', true);
                                if (!empty($prev_post)) {
                                    echo '<a href="' . get_permalink($prev_post->ID) . '" class="btn btn-sm btn-light border" title="' . $prev_post->post_title . '">Prev</a>';
                                }
                                $next_post = get_adjacent_post(false, '', false);
                                if (!empty($next_post)) {
                                    echo '<a href="' . get_permalink($next_post->ID) . '" class="btn btn-sm btn-light border" title="' . $next_post->post_title . '">Next</a>';
                                }
                                ?>
                            </div>
                        </div>
                    </div>

                    <div class="mostview-post">
                        <div class="row">
                            <div class="col-md-6 col-xl-7">
                                <h6 class="mb-3">MOST VIEW ARTICLE</h6>
                                <div class="mostview-post-loop">
                                    <?php
                                    
                                    $categories = wp_get_post_categories($post_id);

                                    $category_ids = array();
                                    foreach ($categories as $category) {
                                        $category_ids[] = $category;
                                    }
                                    $post1_args = array(
                                        'post_type'     => 'post',
                                        'post__not_in'  => [get_the_ID()],
                                        'posts_per_page' => 5,
                                    );
                                    module_vdposts($post1_args, 'posts4');
                                    ?>
                                </div>
                            </div>
                            <div class="col-md-6 col-xl-5">
                                <?php get_berita_iklan('iklan_content_2'); ?>
                            </div>
                        </div>
                    </div>

                    <div class="sosmed-single alert alert-light rounded-0 shadow-sm my-3">
                        <h6 class="fw-bold">FOLLOW US</h6>
                        <div class="row">
                            <?php
                            $sosmed = ['facebook' => '#2d59a1', 'twitter' => '#079be3', 'instagram' => '#e72283', 'youtube' => '#DD2C26'];
                            foreach ($sosmed as $key => $color) {
                                $datalink  = velocitytheme_option('link_sosmed_' . $key);
                                if ($datalink) {
                                    echo '<div class="col-3 pb-2">';
                                    echo '<a class="btn border-0 shadow-sm rounded-0 w-100 btn-secondary" style="--bs-btn-bg:' . $color . '" href="' . $datalink . '" target="_blank"><i class="fa fa-' . $key . '"></i></a>';
                                    echo '</div>';
                                }
                            }
                            ?>
                        </div>
                    </div>

                <?php

                    // If comments are open or we have at least one comment, load up the comment template.
                    if (comments_open() || get_comments_number()) {
                        do_action('justg_before_comments');
                        comments_template();
                        do_action('justg_after_comments');
                    }
                }
                ?>

            </main><!-- #main -->

            <!-- Do the right sidebar check. -->
            <?php do_action('justg_after_content'); ?>

        </div><!-- .row -->

    </div><!-- #content -->

</div><!-- #single-wrapper -->

<?php
get_footer();
