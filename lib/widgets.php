<?php

/*---------- Header Widget ----------*/

class ino_app_widget extends WP_Widget {

    function __construct() {

        parent::__construct(

            // Base ID of your widget
            'ino_app_widget',

            // Widget name will appear in UI
            __('DrBond - App Widget', 'ino_widget_domain'),

            // Widget description
            array( 'description' => __( 'App widget for DrBond', 'ino_widget_domain' ), )
        );
    }

    // Creating widget front-end
    // This is where the action happens
    public function widget( $args, $instance ) {

        $title = apply_filters( 'widget_title', $instance['title'] );
        $desc = apply_filters( 'widget_desc', $instance['desc'] );
        $appstore = apply_filters( 'widget_appstore', $instance['appstore'] );
        $playstore = apply_filters( 'widget_playstore', $instance['playstore'] );

        // before and after widget arguments are defined by themes

        if ($title) {
            $title = '<h3 class="widget-title">' . $title . '</h3>';
        } else {
            $title = '<h3 class="widget-title">Get DrBond</h3>';
        }

        if (($appstore) || ($playstore)) {
            $app = '<div class="app-wrap">';
            if ($appstore) {
                $app .= '<span>';
                $app .= '<a href="' . $appstore . '" target="_blank"><img src="'. get_template_directory_uri() . '/dist/images/app-store.png" alt="Apps Store" width="130" height="40" /></a>';
                $app .= '</span>';
            }

            if ($playstore) {
                $app .= '<span>';
                $app .= '<a href="' . $playstore . '" target="_blank"><img src="'. get_template_directory_uri() . '/dist/images/play-store.png" alt="Play Store" width="130" height="40" /></a>';
                $app .= '</span>';
            }

            $app .= '</div>';
        }

        $out = $args['before_widget'];
        $out .= '<section class="app-widget widget %1$s %2$s">';
        $out .= $title;
        $out .= $desc;
        $out .= $app;
        $out .= '</section>';
        $out .= $args['after_widget'];

        echo $out;

    }

    // Widget Backend
    public function form( $instance ) {

    if ( isset( $instance[ 'title' ] ) ) {
        $title = $instance[ 'title' ];
    }

    if ( isset( $instance[ 'desc' ] ) ) {
        $desc = $instance[ 'desc' ];
    }

    if ( isset( $instance[ 'appstore' ] ) ) {
        $appstore = $instance[ 'appstore' ];
    }

    if ( isset( $instance[ 'playstore' ] ) ) {
        $playstore = $instance[ 'playstore' ];
    }

    // Widget admin form
    ?>

    <p>
        <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label>
        <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
    </p>

    <p>
        <label for="<?php echo $this->get_field_id( 'desc' ); ?>"><?php _e( 'Description:' ); ?></label>
        <textarea rows="6" class="widefat" id="<?php echo $this->get_field_id( 'desc' ); ?>" name="<?php echo $this->get_field_name( 'desc' ); ?>"><?php echo esc_attr( $desc ); ?></textarea>
    </p>

    <p>
        <label for="<?php echo $this->get_field_id( 'appstore' ); ?>"><?php _e( 'App Store URL:' ); ?></label>
        <input class="widefat" id="<?php echo $this->get_field_id( 'appstore' ); ?>" name="<?php echo $this->get_field_name( 'appstore' ); ?>" type="text" value="<?php echo esc_attr( $appstore ); ?>" />
    </p>

    <p>
        <label for="<?php echo $this->get_field_id( 'playstore' ); ?>"><?php _e( 'Play Store URL:' ); ?></label>
        <input class="widefat" id="<?php echo $this->get_field_id( 'playstore' ); ?>" name="<?php echo $this->get_field_name( 'playstore' ); ?>" type="text" value="<?php echo esc_attr( $playstore ); ?>" />
    </p>

    <?php
    }

    // Updating widget replacing old instances with new
    public function update( $new_instance, $old_instance ) {
        $instance = array();
        $instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
        $instance['desc'] = ( ! empty( $new_instance['desc'] ) ) ? $new_instance['desc'] : '';
        $instance['appstore'] = ( ! empty( $new_instance['appstore'] ) ) ? strip_tags( $new_instance['appstore'] ) : '';
        $instance['playstore'] = ( ! empty( $new_instance['playstore'] ) ) ? strip_tags( $new_instance['playstore'] ) : '';
        return $instance;
    }

} // Class ino_widget ends here


/*---------- Footer Widget ----------*/

class ino_contact_widget extends WP_Widget {

    function __construct() {

        parent::__construct(

            // Base ID of your widget
            'ino_contact_widget',

            // Widget name will appear in UI
            __('DrBond - Contact Widget', 'ino_widget_domain'),

            // Widget description
            array( 'description' => __( 'Contact widget for DrBond', 'ino_widget_domain' ), )
        );
    }

    // Creating widget front-end
    // This is where the action happens
    public function widget( $args, $instance ) {

        $title = apply_filters( 'widget_title', $instance['title'] );
        $facebook = apply_filters( 'widget_facebook', $instance['facebook'] );
        $twitter = apply_filters( 'widget_twitter', $instance['twitter'] );
        $linkedin = apply_filters( 'widget_linkedin', $instance['linkedin'] );
        $youtube = apply_filters( 'widget_youtube', $instance['youtube'] );
        $address = apply_filters( 'widget_address', $instance['address'] );
        $phone = apply_filters( 'widget_phone', $instance['phone'] );
        $email = apply_filters( 'widget_email', $instance['email'] );

        // before and after widget arguments are defined by themes

        if ($title) {
            $title = '<h3 class="widget-title">' . $title . '</h3>';
        }

        if ($facebook) {
            $facebook = '<li class="facebook"><a  href=' . $facebook .' target="_blank"></a></li>';
        }

        if ($linkedin) {
            $linkedin = '<li class="linkedin"><a href=' . $linkedin .' target="_blank"></a></li>';
        }

        if ($twitter) {
            $twitter = '<li class="twitter"><a href=' . $twitter .' target="_blank"></a></li>';
        }

        if ($youtube) {
            $youtube = '<li class="youtube"><a href=' . $youtube .' target="_blank"></a></li>';
        }

        if ($address) {
            $address = '<address>' . $address . '</address>';
        }

        if ($phone) {
            $phone = '<span>Phone: ' . $phone . '</span>';
        }

        if ($email) {
            $email = '<span>Email: <a href="mailto:' . $email . '">' . $email . '</a></span>';
        }

        $out .= $args['before_widget'];
        $out = '<section class="contact-widget widget %1$s %2$s col-md-4">';
        $out .= $title;
        $out .= '<ul class="mb foo-social-icons clearfix">';
        $out .= $facebook;
        $out .= $linkedin;
        $out .= $twitter;
        $out .= $youtube;
        $out .= '</ul>';
        $out .= $address;
        $out .= $phone;
        $out .= $email;
        $out .= '</section>';
        $out .= $args['after_widget'];

        echo $out;

    }

    // Widget Backend
    public function form( $instance ) {

    if ( isset( $instance[ 'title' ] ) ) {
        $title = $instance[ 'title' ];
    }

     if ( isset( $instance[ 'facebook' ] ) ) {
        $facebook = $instance[ 'facebook' ];
    }

    if ( isset( $instance[ 'twitter' ] ) ) {
        $twitter = $instance[ 'twitter' ];
    }

    if ( isset( $instance[ 'linkedin' ] ) ) {
        $linkedin = $instance[ 'linkedin' ];
    }

    if ( isset( $instance[ 'youtube' ] ) ) {
        $youtube = $instance[ 'youtube' ];
    }

    if ( isset( $instance[ 'address' ] ) ) {
        $address = $instance[ 'address' ];
    }

    if ( isset( $instance[ 'phone' ] ) ) {
        $phone = $instance[ 'phone' ];
    }

    if ( isset( $instance[ 'email' ] ) ) {
        $email = $instance[ 'email' ];
    }

    // Widget admin form
    ?>
    <p>
        <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Tilte:' ); ?></label>
        <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
    </p>

    <p>
        <label for="<?php echo $this->get_field_id( 'facebook' ); ?>"><?php _e( 'Facebook:' ); ?></label>
        <input class="widefat" id="<?php echo $this->get_field_id( 'facebook' ); ?>" name="<?php echo $this->get_field_name( 'facebook' ); ?>" type="text" value="<?php echo esc_attr( $facebook ); ?>" />
    </p>

    <p>
        <label for="<?php echo $this->get_field_id( 'twitter' ); ?>"><?php _e( 'Twitter:' ); ?></label>
        <input class="widefat" id="<?php echo $this->get_field_id( 'twitter' ); ?>" name="<?php echo $this->get_field_name( 'twitter' ); ?>" type="text" value="<?php echo esc_attr( $twitter ); ?>" />
    </p>

    <p>
        <label for="<?php echo $this->get_field_id( 'linkedin' ); ?>"><?php _e( 'LinkedIn:' ); ?></label>
        <input class="widefat" id="<?php echo $this->get_field_id( 'linkedin' ); ?>" name="<?php echo $this->get_field_name( 'linkedin' ); ?>" type="text" value="<?php echo esc_attr( $linkedin ); ?>" />
    </p>

    <p>
        <label for="<?php echo $this->get_field_id( 'youtube' ); ?>"><?php _e( 'Youtube:' ); ?></label>
        <input class="widefat" id="<?php echo $this->get_field_id( 'youtube' ); ?>" name="<?php echo $this->get_field_name( 'youtube' ); ?>" type="text" value="<?php echo esc_attr( $youtube ); ?>" />
    </p>


    <p>
        <label for="<?php echo $this->get_field_id( 'address' ); ?>"><?php _e( 'Address:' ); ?></label>
        <textarea class="widefat" id="<?php echo $this->get_field_id( 'address' ); ?>" name="<?php echo $this->get_field_name( 'address' ); ?>"><?php echo esc_attr( $address ); ?></textarea>
    </p>

    <p>
        <label for="<?php echo $this->get_field_id( 'phone' ); ?>"><?php _e( 'Phone:' ); ?></label>
        <input class="widefat" id="<?php echo $this->get_field_id( 'phone' ); ?>" name="<?php echo $this->get_field_name( 'phone' ); ?>" type="text" value="<?php echo esc_attr( $phone ); ?>" />
    </p>

    <p>
        <label for="<?php echo $this->get_field_id( 'email' ); ?>"><?php _e( 'Email:' ); ?></label>
        <input class="widefat" id="<?php echo $this->get_field_id( 'email' ); ?>" name="<?php echo $this->get_field_name( 'email' ); ?>" type="text" value="<?php echo esc_attr( $email ); ?>" />
    </p>

    <?php
    }

    // Updating widget replacing old instances with new
    public function update( $new_instance, $old_instance ) {
        $instance = array();
        $instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
        $instance['facebook'] = ( ! empty( $new_instance['facebook'] ) ) ? strip_tags( $new_instance['facebook'] ) : '';
        $instance['twitter'] = ( ! empty( $new_instance['twitter'] ) ) ? strip_tags( $new_instance['twitter'] ) : '';
        $instance['linkedin'] = ( ! empty( $new_instance['linkedin'] ) ) ? strip_tags( $new_instance['linkedin'] ) : '';
        $instance['youtube'] = ( ! empty( $new_instance['youtube'] ) ) ? strip_tags( $new_instance['youtube'] ) : '';
        $instance['address'] = ( ! empty( $new_instance['address'] ) ) ? $new_instance['address'] : '';
        $instance['phone'] = ( ! empty( $new_instance['phone'] ) ) ? strip_tags( $new_instance['phone'] ) : '';
        $instance['email'] = ( ! empty( $new_instance['email'] ) ) ? strip_tags( $new_instance['email'] ) : '';
        return $instance;
    }

} // Class ino_widget ends here

// Register and load the widget
function ino_load_widget() {
    register_widget( 'ino_app_widget' );
    register_widget( 'ino_contact_widget' );
}
add_action( 'widgets_init', 'ino_load_widget' );




