<nav id="main-nav" class="sticky-top navbar navbar-top navbar-expand-md d-block navbar-light shadow-sm p-0" aria-labelledby="main-nav-label" style="border-top: 2px solid #222">
    <div class="head-part-top bg-light shadow-sm">
        <div class="container secondary-menu position-relative" style="background-color: transparent">

            <button class="navbar-toggler ps-4" type="button" data-bs-toggle="offcanvas" data-bs-target="#navbarsecondarymenu" aria-controls="navbarsecondarymenu" aria-expanded="false" aria-label="<?php esc_attr_e('Toggle navigation', 'justg'); ?>">
                <span class="navbar-toggler-icon"></span>
                <small>Menu</small>
            </button>

            <div class="offcanvas bg-light offcanvas-start" tabindex="-1" id="navbarsecondarymenu">

                <div class="offcanvas-header justify-content-end">
                    <button type="button" class="btn-close btn-close-dark text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
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
</nav>