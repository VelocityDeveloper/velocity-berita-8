<footer class="site-footer container bg-dark text-white py-2 px-3" id="colophon">
    <div class="row align-items-center">
        <div class="col-md-6">
            <div class="site-info">
                <small>
                    © <?php echo date("Y"); ?> <?php echo get_bloginfo('name'); ?>. All Rights Reserved.
                    <br>
                    Design by <a class="text-secondary" href="https://velocitydeveloper.com" target="_blank" rel="noopener noreferrer"> Velocity Developer </a>
                </small>
            </div>
            <!-- .site-info -->
        </div>
        <div class="col-md-6 text-md-end pt-2 pt-md-0">
            <?php
            $sosmed = ['facebook', 'twitter', 'instagram', 'youtube'];
            foreach ($sosmed as $key) {
                $datalink  = velocitytheme_option('link_sosmed_' . $key);
                if ($datalink) {
                    echo '<a class="btn btn-sm btn-secondary ms-1" href="' . $datalink . '" target="_blank"><i class="fa fa-' . $key . '"></i></a>';
                }
            }
            ?>
            <a class="btn btn-sm btn-secondary" href="<?php echo get_site_url(); ?>/feed" target="_blank"><i class="fa fa-rss"></i></a>
        </div>
    </div>
</footer>