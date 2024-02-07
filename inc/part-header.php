<div CLASS="row pt-2 align-items-center">
    <div class="col-12 col-md-3 inside-w-100 text-center text-md-start">
        <?php echo the_custom_logo(); ?>
    </div>
    <div class="col-12 col-md-9">
        <?php echo get_berita_iklan('iklan_header'); ?>
    </div>
</div>
<nav id="main-nav" class="navbar navbar-expand-md d-block navbar-light shadow-sm p-0" aria-labelledby="main-nav-label">

    <h2 id="main-nav-label" class="screen-reader-text">
        <?php esc_html_e('Main Navigation', 'justg'); ?>
    </h2>
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
