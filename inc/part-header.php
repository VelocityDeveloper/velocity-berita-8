<nav id="main-nav" class="navbar navbar-expand-md d-block navbar-light shadow-sm p-0" aria-labelledby="main-nav-label">

    <h2 id="main-nav-label" class="screen-reader-text">
        <?php esc_html_e('Main Navigation', 'justg'); ?>
    </h2>

    <div class="head-part-top bg-color-theme">
        <div class="row align-items-start">
            <div class="col-md-5 col-xl-4">
                <div class="py-2 px-3">
                    <?php echo the_custom_logo(); ?>
                </div>
            </div>
            <div class="col-md">
                <div class="datenow text-end d-none d-md-block">
                    <small class="bg-light px-2 py-1 d-inline-block position-relative">
                        <?php echo date('l jS F Y', current_time('timestamp', 0)); ?>
                    </small>
                </div>
                <div class="ticker-news text-end text-white p-2 d-none d-md-block">
                    <?php
                    // The Query
                    $args = array(
                        'post_type'     => 'post',
                        'posts_per_page' => 5
                    );
                    $the_query = new WP_Query($args);

                    // The Loop
                    $nm = 1;
                    if ($the_query->have_posts()) {
                        echo '<div id="carouselTickerNews" class="carousel slide carousel-fade" data-bs-ride="carousel">';
                        echo '<div class="carousel-inner">';
                        while ($the_query->have_posts()) {
                            $the_query->the_post();
                            if (get_the_title()) {
                                echo '<div class="carousel-item' . ($nm == 1 ? ' active' : '') . '">';
                                echo '<a class="text-white" href="' . get_the_permalink() . '" title="' . get_the_title() . '">' . vdberita_limit_text(get_the_title(), 6) . '</a>';
                                echo '</div>';
                            }
                            $nm++;
                        }
                        echo '</div>';
                        echo '</div>';
                    }
                    /* Restore original Post Data */
                    wp_reset_postdata();
                    ?>
                </div>
                <div class="secondary-menu position-relative bg-secondary">

                    <button class="navbar-toggler ps-4" type="button" data-bs-toggle="offcanvas" data-bs-target="#navbarsecondarymenu" aria-controls="navbarsecondarymenu" aria-expanded="false" aria-label="<?php esc_attr_e('Toggle navigation', 'justg'); ?>">
                        <span class="navbar-toggler-icon"></span>
                        <small>Menu</small>
                    </button>

                    <div class="offcanvas bg-dark offcanvas-start" tabindex="-1" id="navbarsecondarymenu">

                        <div class="offcanvas-header justify-content-end">
                            <button type="button" class="btn-close btn-close-white text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                        </div><!-- .offcancas-header -->

                        <!-- The WordPress Menu goes here -->
                        <?php
                        wp_nav_menu(
                            array(
                                'theme_location'  => 'secondary',
                                'container_class' => 'secondary-menu-body',
                                'container_id'    => '',
                                'menu_class'      => 'navbar-nav navbar-dark justify-content-start flex-grow-1 px-2',
                                'fallback_cb'     => '',
                                'menu_id'         => 'secondary-menu',
                                'depth'           => 1,
                                'walker'          => new justg_WP_Bootstrap_Navwalker(),
                            )
                        );
                        ?>
                    </div><!-- .offcanvas -->
                </div>
            </div>
        </div>
    </div>
    <div class="container head-part-menu navbar-dark bg-dark">
        <div class="menu-header">

            <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#navbarNavOffcanvas" aria-controls="navbarNavOffcanvas" aria-expanded="false" aria-label="<?php esc_attr_e('Toggle navigation', 'justg'); ?>">
                <span class="navbar-toggler-icon"></span>
                <small>Menu</small>
            </button>

            <div class="offcanvas bg-dark offcanvas-start" tabindex="-1" id="navbarNavOffcanvas">

                <div class="offcanvas-header justify-content-end">
                    <button type="button" class="btn-close btn-close-white text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                </div><!-- .offcancas-header -->

                <!-- The WordPress Menu goes here -->
                <?php
                wp_nav_menu(
                    array(
                        'theme_location'  => 'primary',
                        'container_class' => 'offcanvas-body',
                        'container_id'    => '',
                        'menu_class'      => 'navbar-nav justify-content-start flex-grow-1 pe-3',
                        'fallback_cb'     => '',
                        'menu_id'         => 'main-menu',
                        'depth'           => 4,
                        'walker'          => new justg_WP_Bootstrap_Navwalker(),
                    )
                );
                ?>
            </div><!-- .offcanvas -->
        </div>
        <div class="search-header">
            <form action="" method="get" class="d-flex overflow-hidden border border-dark my-1 bg-light">
                <input type="text" name="s" placeholder="Search" style="max-width: 7rem;" class="form-control-sm bg-light border-0 rounded-0">
                <button type="submit" class="btn btn-link text-secondary py-1 px-2">
                    <i class="fa fa-search"></i>
                </button>
            </form>
        </div>
    </div>


</nav><!-- .site-navigation -->
