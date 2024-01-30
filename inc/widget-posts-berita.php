<?php
/**
 * WIDGET POST BERITA 3
 */
if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly.
}

class Posts_Berita_3_Widget extends WP_Widget {
    function __construct() {
        parent::__construct(
            'posts_berita_3_widget',
            __('Posts Berita 3', 'velocity'),
            array( 'description' => __( 'Menampilkan postingan template berita 3', 'velocity' ), )
        );
    }

    public function form( $instance ) {
        $title      = ! empty( $instance['title'] ) ? $instance['title'] : '';
        $style      = isset( $instance['style'] ) ? $instance['style'] : 'style1';
        $urutkan    = isset( $instance['urutkan'] ) ? $instance['urutkan'] : 'recent';
        $jumlah     = isset( $instance['jumlah'] ) ? $instance['jumlah'] : '5';
        ?>
        <p>
            <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Judul:' ); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
        </p>
        <p>
            <label for="<?php echo $this->get_field_id( 'style' ); ?>"><?php _e( 'Style:' ); ?></label>
            <select class="widefat" id="<?php echo $this->get_field_id( 'style' ); ?>" name="<?php echo $this->get_field_name( 'style' ); ?>">
                <option value="1" <?php selected( $style, '1' ); ?>><?php _e( 'Style 1' ); ?></option>
                <option value="2" <?php selected( $style, '2' ); ?>><?php _e( 'Style 2' ); ?></option>
                <option value="3" <?php selected( $style, '3' ); ?>><?php _e( 'Style 3' ); ?></option>
                <option value="4" <?php selected( $style, '4' ); ?>><?php _e( 'Style 4' ); ?></option>
                <option value="5" <?php selected( $style, '5' ); ?>><?php _e( 'Style 5' ); ?></option>
            </select>
        </p>
        <p>
            <label for="<?php echo $this->get_field_id( 'urutkan' ); ?>"><?php _e( 'Urutkan berdasarkan:' ); ?></label>
            <select class="widefat" id="<?php echo $this->get_field_id( 'urutkan' ); ?>" name="<?php echo $this->get_field_name( 'urutkan' ); ?>">
                <option value="recent" <?php selected( $urutkan, 'recent' ); ?>><?php _e('Terbaru' ); ?></option>
                <option value="popular" <?php selected( $urutkan, 'popular' ); ?>><?php _e( 'Terpopuler' ); ?></option>
            </select>
        </p>
        <p>
            <label for="<?php echo $this->get_field_id( 'jumlah' ); ?>"><?php _e( 'Jumlah:' ); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id( 'jumlah' ); ?>" name="<?php echo $this->get_field_name( 'jumlah' ); ?>" type="number" min="1" value="<?php echo esc_attr( $jumlah ); ?>">
        </p>
        <?php
    }

    public function update( $new_instance, $old_instance ) {
        $instance = array();
        $instance['title'] = ( ! empty( $new_instance['title'] ) ) ? sanitize_text_field( $new_instance['title'] ) : '';
        $instance['style'] = ( ! empty( $new_instance['style'] ) ) ? sanitize_text_field( $new_instance['style'] ) : 'style1';
        $instance['urutkan'] = ( ! empty( $new_instance['urutkan'] ) ) ? sanitize_text_field( $new_instance['urutkan'] ) : 'recent';
        $instance['jumlah'] = ( ! empty( $new_instance['jumlah'] ) ) ? sanitize_text_field( $new_instance['jumlah'] ) : '5';

        return $instance;
    }
    public function widget( $args, $instance ) {
        $title      = apply_filters( 'widget_title', $instance['title'] );
        $style      = isset( $instance['style'] ) ? $instance['style'] : 'style1';
        $urutkan    = isset( $instance['urutkan'] ) ? $instance['urutkan'] : 'recent';
        $jumlah     = isset( $instance['jumlah'] ) ? $instance['jumlah'] : '5';

        echo $args['before_widget'];

            if ( ! empty( $title ) ) {
                echo $args['before_title'] . $title . $args['after_title'];
            }

            $args_post = array(
                'post_type' => 'post',
                'posts_per_page' => $jumlah,
            );

            if ( $urutkan == 'popular' ) {
                $args_post['orderby'] = 'meta_value_num';
                $args_post['meta_key'] = 'hit';
            }

            $posts = new WP_Query( $args_post );

            module_vdposts($args_post, 'posts'.$style);

        echo $args['after_widget'];
    }

}

function register_posts_berita_3_widget() {
    register_widget( 'Posts_Berita_3_Widget' );
}
add_action( 'widgets_init', 'register_posts_berita_3_widget' );