<?php
/**
 * Sage includes
 *
 * The $sage_includes array determines the code library included in your theme.
 * Add or remove files to the array as needed. Supports child theme overrides.
 *
 * Please note that missing files will produce a fatal error.
 *
 * @link https://github.com/roots/sage/pull/1042
 */
$sage_includes = [
  'lib/assets.php',     // Scripts and stylesheets
  'lib/extras.php',     // Custom functions
  'lib/setup.php',      // Theme setup
  'lib/titles.php',     // Page titles
  'lib/wrapper.php',    // Theme wrapper class
  'lib/customizer.php', // Theme customizer
  'lib/shortcodes.php', // Theme customizer
  'lib/widgets.php'  // Theme customizer
];

foreach ($sage_includes as $file) {
  if (!$filepath = locate_template($file)) {
    trigger_error(sprintf(__('Error locating %s for inclusion', 'sage'), $file), E_USER_ERROR);
  }

  require_once $filepath;
}
unset($file, $filepath);

/* Include Scripts
-------------------------------------------------- */

function add_scripts() {

    if (is_front_page() || is_category()) {
        wp_enqueue_script( 'slickr', get_stylesheet_directory_uri() . '/assets/scripts/slick.min.js', array( 'jquery' ), '', true );
    }
   // wp_enqueue_script( 'modernizr.custom', get_stylesheet_directory_uri() . '/assets/scripts/modernizr.custom.js', array( 'jquery' ), '', true );
    wp_enqueue_script( 'classie', get_stylesheet_directory_uri() . '/assets/scripts/classie.js', array( 'jquery' ), '', true );
    wp_enqueue_script( 'validate', 'http://cdn.jsdelivr.net/jquery.validation/1.14.0/jquery.validate.min.js', array( 'jquery' ), '', true );
    wp_localize_script( 'ajax-script', 'ajax_object', array( 'ajax_url' => admin_url( 'admin-ajax.php' ) ) );
    wp_register_style('opensans', 'https://fonts.googleapis.com/css?family=Open+Sans:400,400italic,600,600italic,700,700italic');
    wp_register_style('signika', 'https://fonts.googleapis.com/css?family=Signika:400,600,700');
    wp_enqueue_style( 'opensans');
    wp_enqueue_style( 'signika');
}

add_action( 'wp_enqueue_scripts', 'add_scripts' );


function pluginname_ajaxurl() { ?>

    <script type="text/javascript">
        var ajaxurl = '<?php echo admin_url('admin-ajax.php'); ?>';
    </script>

<?php }

add_action('wp_head','pluginname_ajaxurl');


/* Show admin bar
-------------------------------------------------- */

function remove_admin_bar() {
    if (!current_user_can('administrator') && !is_admin()) {
      show_admin_bar(false);
    }
}

add_action('after_setup_theme', 'remove_admin_bar');

/* Remove Shortcode P
-------------------------------------------------- */

if ( !function_exists('wpex_fix_shortcodes') ) {
    function wpex_fix_shortcodes($content){
        $array = array (
            '<p>[' => '[',
            ']</p>' => ']',
            ']<br />' => ']'
        );
        $content = strtr($content, $array);
        return $content;
    }
    add_filter('the_content', 'wpex_fix_shortcodes');
}

/* Custom Excerpt Length
-------------------------------------------------- */

function custom_excerpt($new_length = 20, $new_more = '') {
  add_filter('excerpt_length', function () use ($new_length) {
    return $new_length;
  }, 999);
  add_filter('excerpt_more', function () use ($new_more) {
    return $new_more;
  });
  $output = get_the_excerpt();
  $output = apply_filters('wptexturize', $output);
  $output = apply_filters('convert_chars', $output);
  $output = '<p>' . $output . '</p>';
  return $output;
}

/* Post View
-------------------------------------------------- */

function getPostViews($postID){
    $count_key = 'post_views_count';
    $count = get_post_meta($postID, $count_key, true);
    if($count==''){
        delete_post_meta($postID, $count_key);
        add_post_meta($postID, $count_key, '0');
        return "0 View";
    }
    return $count.' Views';
}

function setPostViews($postID) {
    $count_key = 'post_views_count';
    $count = get_post_meta($postID, $count_key, true);
    if($count==''){
        $count = 0;
        delete_post_meta($postID, $count_key);
        add_post_meta($postID, $count_key, '0');
    }else{
        $count++;
        update_post_meta($postID, $count_key, $count);
    }
}

remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0);

/* Doctor Article Type
-------------------------------------------------- */

function article_type_get_meta( $value ) {
    global $post;

    $field = get_post_meta( $post->ID, $value, true );
    if ( ! empty( $field ) ) {
        return is_array( $field ) ? stripslashes_deep( $field ) : stripslashes( wp_kses_decode_entities( $field ) );
    } else {
        return false;
    }
}

function article_type_add_meta_box() {
    add_meta_box(
        'article_type-article-type',
        __( 'Article Type', 'article_type' ),
        'article_type_html',
        'post',
        'side',
        'high'
    );
}
add_action( 'add_meta_boxes', 'article_type_add_meta_box' );

function article_type_html( $post) {
    wp_nonce_field( '_article_type_nonce', 'article_type_nonce' ); ?>

    <p>
        <label for="article_type_select_article_type"><?php _e( 'Select Doctor Article Type', 'article_type' ); ?></label><br>
        <select name="article_type_select_article_type" id="article_type_select_article_type" style="width: 100%">
            <option <?php echo (article_type_get_meta( 'article_type_select_article_type' ) === 'News' ) ? 'selected' : '' ?>>News</option>
            <option <?php echo (article_type_get_meta( 'article_type_select_article_type' ) === 'Publications' ) ? 'selected' : '' ?>>Publications</option>
            <option <?php echo (article_type_get_meta( 'article_type_select_article_type' ) === 'Procedures_and_Tips' ) ? 'selected' : '' ?>>Procedures_and_Tips</option>
        </select>
    </p><?php
}

function article_type_save( $post_id ) {
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
    if ( ! isset( $_POST['article_type_nonce'] ) || ! wp_verify_nonce( $_POST['article_type_nonce'], '_article_type_nonce' ) ) return;
    if ( ! current_user_can( 'edit_post', $post_id ) ) return;

    if ( isset( $_POST['article_type_select_article_type'] ) )
        update_post_meta( $post_id, 'article_type_select_article_type', esc_attr( $_POST['article_type_select_article_type'] ) );
}
add_action( 'save_post', 'article_type_save' );

/*
    Usage: article_type_get_meta( 'article_type_select_article_type' )
*/

/* Patient Media Type
-------------------------------------------------- */

function patient_article_type_get_meta( $value ) {
    global $post;

    $field = get_post_meta( $post->ID, $value, true );
    if ( ! empty( $field ) ) {
        return is_array( $field ) ? stripslashes_deep( $field ) : stripslashes( wp_kses_decode_entities( $field ) );
    } else {
        return false;
    }
}

function patient_article_type_add_meta_box() {
    add_meta_box(
        'patient_article_type-patient-article-type',
        __( 'Patient Article Type', 'patient_article_type' ),
        'patient_article_type_html',
        'post',
        'side',
        'high'
    );
}
add_action( 'add_meta_boxes', 'patient_article_type_add_meta_box' );

function patient_article_type_html( $post) {
    wp_nonce_field( '_patient_article_type_nonce', 'patient_article_type_nonce' ); ?>

    <p>
        <label for="patient_article_type_patient_article_type"><?php _e( 'Select Patient Article Type', 'patient_article_type' ); ?></label><br>
        <select name="patient_article_type_patient_article_type" id="patient_article_type_patient_article_type">
            <option <?php echo (patient_article_type_get_meta( 'patient_article_type_patient_article_type' ) === 'Patient_Education_Material' ) ? 'selected' : '' ?>>Patient_Education_Material</option>
        </select>
    </p><?php
}

function patient_article_type_save( $post_id ) {
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
    if ( ! isset( $_POST['patient_article_type_nonce'] ) || ! wp_verify_nonce( $_POST['patient_article_type_nonce'], '_patient_article_type_nonce' ) ) return;
    if ( ! current_user_can( 'edit_post', $post_id ) ) return;

    if ( isset( $_POST['patient_article_type_patient_article_type'] ) )
        update_post_meta( $post_id, 'patient_article_type_patient_article_type', esc_attr( $_POST['patient_article_type_patient_article_type'] ) );
}
add_action( 'save_post', 'patient_article_type_save' );

/*
    Usage: patient_article_type_get_meta( 'patient_article_type_patient_article_type' )
*/

/* Media Type
-------------------------------------------------- */

function media_get_meta( $value ) {
    global $post;

    $field = get_post_meta( $post->ID, $value, true );
    if ( ! empty( $field ) ) {
        return is_array( $field ) ? stripslashes_deep( $field ) : stripslashes( wp_kses_decode_entities( $field ) );
    } else {
        return false;
    }
}

function media_add_meta_box() {
    add_meta_box(
        'media-media',
        __( 'Media', 'media' ),
        'media_html',
        'post',
        'side',
        'high'
    );
}
add_action( 'add_meta_boxes', 'media_add_meta_box' );

function media_html( $post) {
    wp_nonce_field( '_media_nonce', 'media_nonce' ); ?>

    <p>
        <label for="media_select_media_type"><?php _e( 'Select Media Type', 'media' ); ?></label><br>
        <select name="media_select_media_type" id="media_select_media_type" style="width: 100%">
            <option <?php echo (media_get_meta( 'media_select_media_type' ) === 'Audio' ) ? 'selected' : '' ?>>Audio</option>
            <option <?php echo (media_get_meta( 'media_select_media_type' ) === 'Document' ) ? 'selected' : '' ?>>Document</option>
            <option <?php echo (media_get_meta( 'media_select_media_type' ) === 'Podcast' ) ? 'selected' : '' ?>>Podcast</option>
            <option <?php echo (media_get_meta( 'media_select_media_type' ) === 'Video' ) ? 'selected' : '' ?>>Video</option>

        </select>
    </p><?php
}

function media_save( $post_id ) {
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
    if ( ! isset( $_POST['media_nonce'] ) || ! wp_verify_nonce( $_POST['media_nonce'], '_media_nonce' ) ) return;
    if ( ! current_user_can( 'edit_post', $post_id ) ) return;

    if ( isset( $_POST['media_select_media_type'] ) )
        update_post_meta( $post_id, 'media_select_media_type', esc_attr( $_POST['media_select_media_type'] ) );
}
add_action( 'save_post', 'media_save' );

/*
    Usage: media_get_meta( 'media_select_media_type' )
*/

/* Show in Slider
-------------------------------------------------- */

function slider_get_meta( $value ) {
	global $post;

	$field = get_post_meta( $post->ID, $value, true );
	if ( ! empty( $field ) ) {
		return is_array( $field ) ? stripslashes_deep( $field ) : stripslashes( wp_kses_decode_entities( $field ) );
	} else {
		return false;
	}
}

function slider_add_meta_box() {
	add_meta_box(
		'slider-slider',
		__( 'Slider', 'slider' ),
		'slider_html',
		'post',
		'side',
		'high'
	);
}
add_action( 'add_meta_boxes', 'slider_add_meta_box' );

function slider_html( $post) {
	wp_nonce_field( '_slider_nonce', 'slider_nonce' ); ?>

	<p>

		<input type="radio" name="slider_show_in_slider" id="slider_show_in_slider_0" value="No" <?php echo ( slider_get_meta( 'slider_show_in_slider' ) === 'No' ) ? 'checked' : 'checked'; ?>>
<label for="slider_show_in_slider_0">No</label><br>

		<input type="radio" name="slider_show_in_slider" id="slider_show_in_slider_1" value="Yes" <?php echo ( slider_get_meta( 'slider_show_in_slider' ) === 'Yes' ) ? 'checked' : ''; ?>>
<label for="slider_show_in_slider_1">Yes</label><br>
	</p><?php
}

function slider_save( $post_id ) {
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
	if ( ! isset( $_POST['slider_nonce'] ) || ! wp_verify_nonce( $_POST['slider_nonce'], '_slider_nonce' ) ) return;
	if ( ! current_user_can( 'edit_post', $post_id ) ) return;

	if ( isset( $_POST['slider_show_in_slider'] ) )
		update_post_meta( $post_id, 'slider_show_in_slider', esc_attr( $_POST['slider_show_in_slider'] ) );
}
add_action( 'save_post', 'slider_save' );

/*
	Usage: slider_get_meta( 'slider_show_in_slider' )
*/


/* Show in Editor Picks
-------------------------------------------------- */

function editor_picks_get_meta( $value ) {
	global $post;

	$field = get_post_meta( $post->ID, $value, true );
	if ( ! empty( $field ) ) {
		return is_array( $field ) ? stripslashes_deep( $field ) : stripslashes( wp_kses_decode_entities( $field ) );
	} else {
		return false;
	}
}

function editor_picks_add_meta_box() {
	add_meta_box(
		'editor_picks-editor-picks',
		__( 'Editor Picks', 'editor_picks' ),
		'editor_picks_html',
		'post',
		'side',
		'high'
	);
}
add_action( 'add_meta_boxes', 'editor_picks_add_meta_box' );

function editor_picks_html( $post) {
	wp_nonce_field( '_editor_picks_nonce', 'editor_picks_nonce' ); ?>

	<p>

		<input type="radio" name="editor_picks_show_in_editor_picks" id="editor_picks_show_in_editor_picks_0" value="No" <?php echo ( editor_picks_get_meta( 'editor_picks_show_in_editor_picks' ) === 'No' ) ? 'checked' : 'checked'; ?>>
<label for="editor_picks_show_in_editor_picks_0">No</label><br>

		<input type="radio" name="editor_picks_show_in_editor_picks" id="editor_picks_show_in_editor_picks_1" value="Yes" <?php echo ( editor_picks_get_meta( 'editor_picks_show_in_editor_picks' ) === 'Yes' ) ? 'checked' : ''; ?>>
<label for="editor_picks_show_in_editor_picks_1">Yes</label><br>
	</p><?php
}

function editor_picks_save( $post_id ) {
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
	if ( ! isset( $_POST['editor_picks_nonce'] ) || ! wp_verify_nonce( $_POST['editor_picks_nonce'], '_editor_picks_nonce' ) ) return;
	if ( ! current_user_can( 'edit_post', $post_id ) ) return;

	if ( isset( $_POST['editor_picks_show_in_editor_picks'] ) )
		update_post_meta( $post_id, 'editor_picks_show_in_editor_picks', esc_attr( $_POST['editor_picks_show_in_editor_picks'] ) );
}
add_action( 'save_post', 'editor_picks_save' );

/*
	Usage: editor_picks_get_meta( 'editor_picks_show_in_editor_picks' )
*/

// Post Functions

function get_media_type($size) {

    $media = media_get_meta( 'media_select_media_type' );

    if ($size == 'small') {
        $defaultClass="media-type media-type-small";
    }

    if ($size == 'medium') {
        $defaultClass="media-type media-type-medium";
    }

    switch ($media) {

        case 'Audio':
            $mediaTypeClass = 'audio';
            break;
        case 'Document':
            $mediaTypeClass = 'document';
            break;
        case 'Podcast':
            $mediaTypeClass = 'podcast';
            break;
        case 'Video':
            $mediaTypeClass = 'video';
            break;

        default:

    }

    $mediaType = '<div class="' . $defaultClass . ' ' . $mediaTypeClass . '"></div>';

    if ($size) {
        return $mediaType;
    }

}

function get_post_image ($size, $type) {

    if ( has_post_thumbnail() ) {
        $thumb = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), $size );
        $url = $thumb['0'];
    }
    $out .= '<a href="' . get_the_permalink() . '">';
    $out .= '<div class="image-ease">';
    $out .= '<img src="' . $url . '" class="img-responsive" alt="' . get_the_title() . '" />';
    $media = media_get_meta( 'media_select_media_type' );
    $out .= '<div class="image-ease-overlay"></div>';
    if ($type) {
        $out .= get_media_type($type);
    }
    $out .= '</div>';
    $out .= '</a>';

    return $out;

}

function get_postmeta ($cat) {

    $out = '<ul class="post-meta">';
    $out .= '<li class="date"><time class="updated" datetime="' . get_post_time("c", true) . '">'. get_the_time("M j, Y") . '</time></li>';
    //$out .= '<li class="author">' . get_the_author() . '</li>';
    $out .= '<li class="views">' . getPostViews(get_the_ID()) . '</li>';
    $out .= '</ul>';

    if ( ( strpos( $_SERVER['HTTP_USER_AGENT'], 'Mobile/' ) !== false ) && ( strpos ( $_SERVER['HTTP_USER_AGENT'], 'Safari/' ) == false ) ) {

    } else if ($_SERVER['HTTP_X_REQUESTED_WITH'] == "net.swaas.hidoctorapp") {

    } else {

        if ($cat) {
        $categories = get_the_category();
        $out .= '<ul class="cat-list">';
        foreach ( $categories as $category ) {
            if (get_cat_name($category->category_parent) == 'Speciality') {
                $out .= '<li><a href="' . add_query_arg( array("cat" => $category->term_id), get_category_link( $category->term_id ) ) . '">' . $category->name . '</a></li>';


            }
        }
        $out .= '</ul>';
    }

    }

    return $out;

}

// Category Title

add_filter( 'get_the_archive_title', function ( $title ) {

    if( is_category() ) {

        $title = single_cat_title( '', false );

    }

    return $title;

});

//Gets post cat slug and looks for single-[cat slug].php and applies it
add_filter('single_template', create_function(
	'$the_template',
	'foreach( (array) get_the_category() as $cat ) {
		if ( file_exists(TEMPLATEPATH . "/single-{$cat->slug}.php") )
		return TEMPLATEPATH . "/single-{$cat->slug}.php"; }
	return $the_template;' )
);

// On Scroll load Content

function load_post_onscroll() {

    if ( isset($_REQUEST) ) {

        $type = $_REQUEST['type'];
        $media = $_REQUEST['media'];
        $catID = $_REQUEST['cat'];
        $page = $_REQUEST['page'];
    }

    $args = array(
        'cat'               => $catID,
        'posts_per_page'    => '10',
        'paged'             => $page,
    );

    if ($type) {

        $args = array(
            'cat'               => $catID,
            'paged'             => $page,
            'posts_per_page'    => '10',
            'meta_query'        => array(
                array(
                    'key' => 'article_type_select_article_type',
                    'value' => $type,
                )
            )
        );

    }

    if ($media) {

        $args = array(
            'cat'               => $catID,
            'posts_per_page'    => '10',
            'paged'             => $page,
            'meta_query'        => array(
                array(
                    'key' => 'media_select_media_type',
                    'value' => $media,
                )
            )
        );

    }

    // The Query

    $count = 1;

    $query = new WP_Query( $args );

    // The Loop
    if ( $query->have_posts() ) {

        while ( $query->have_posts() ) {

            $query->the_post();

            $append .= '<div class="grid col-md-6">';
            $append .= get_post_image('col8', 'medium');
            $append .= get_postmeta('category');
            $append .= '<h2 class="post-title"><a href="' . get_the_permalink() . '">' . get_the_title() . '</a></h2>';
            $append .= '<div class="entry">';
            $append .= custom_excerpt(30);
            $append .= '<a href="' . get_the_permalink() . '?id=' .$catID . '" class="view-more">Read More</a>';
            $append .= '</div>';
            $append .= '</div>';

            if (($count%2) == 0) {

                $append .= '<div class="hidden-xs hidden-sm clearfix"></div>';

            }

            $count++;
        }

        echo $append;

    } else {

        if ($page == 1) {
            echo "0";
        } else {
            echo "1";
        }
    }


    // Restore original Post Data
    wp_reset_postdata();

   die();
}

add_action( 'wp_ajax_load_post_onscroll', 'load_post_onscroll' );
add_action( 'wp_ajax_nopriv_load_post_onscroll', 'load_post_onscroll' );

// User Login

function user_login_request() {

    // The $_REQUEST contains all the data sent via ajax
    if ( isset($_REQUEST) ) {

        $username = $_REQUEST['username'];
        $password = $_REQUEST['password'];

        $creds = array();
	    $creds['user_login'] = $username;
	    $creds['user_password'] = $password;
	    $creds['remember'] = false;
	    $user = wp_signon( $creds, false );

        if ( is_wp_error($user) ) {
            echo "Error";
        } else {
            echo get_site_url();
        }
    }

    die();
}

add_action( 'wp_ajax_user_login_request', 'user_login_request' );
add_action( 'wp_ajax_nopriv_user_login_request', 'user_login_request' );

// User Lost Password

function user_lostpass_request() {

    // The $_REQUEST contains all the data sent via ajax
    if ( isset($_REQUEST) ) {

        $email = $_REQUEST['email'];

        $user = get_user_by( 'email', $email );

        if (!$user) {
            echo "Invalid";
        } else {
            echo "Valid";
        }
    }

    die();
}

add_action( 'wp_ajax_user_lostpass_request', 'user_lostpass_request' );
add_action( 'wp_ajax_nopriv_user_lostpass_request', 'user_lostpass_request' );

// User Registration

function user_register_request() {

    // The $_REQUEST contains all the data sent via ajax
    if ( isset($_REQUEST) ) {

        $firstname = $_REQUEST['firstname'];
        $lastname = $_REQUEST['lastname'];
        $speciality = $_REQUEST['speciality'];
        $phone = $_REQUEST['phone'];
        $email = $_REQUEST['email'];
        $password = $_REQUEST['password'];

        $userdata = array(
            'first_name'    => $firstname,
            'last_name'     => $lastname,
            'user_login'    => $email,
            'user_email'    => $email,
            'user_pass'     => $password,
            'role'          => 'subscriber',
        );

        $user_id = wp_insert_user( $userdata );

        if ( ! is_wp_error( $user_id ) ) {

            update_usermeta( $user_id, 'speciality', $speciality );
            update_usermeta( $user_id, 'phno', $phone );
            $creds = array();
            $creds['user_login'] = $email;
            $creds['user_password'] = $password;
            $creds['remember'] = false;
            $user = wp_signon( $creds, false );

            if ( is_wp_error($user) ) {
                echo "Error";
            } else {
                $catID = get_cat_ID($speciality);
                $redirecturl = get_site_url() . '/category/speciality/' . $speciality . '/?cat=' . $catID;
                echo $redirecturl;
                //wp_redirect( $redirecturl, 301 );
            }

        } else {
            if ($user_id->get_error_message() == "Sorry, that username already exists!") {
                echo "Exist";
            } else {
                echo "Error";
            }
        }

        die();
    }

}

add_action( 'wp_ajax_user_register_request', 'user_register_request' );
add_action( 'wp_ajax_nopriv_user_register_request', 'user_register_request' );


// User Profile Update

function user_profile_update_request() {

    // The $_REQUEST contains all the data sent via ajax
    if ( isset($_REQUEST) ) {

        $firstname = $_REQUEST['firstname'];
        $lastname = $_REQUEST['lastname'];
        $speciality = $_REQUEST['speciality'];
        $phone = $_REQUEST['phone'];
        $password = $_REQUEST['password'];

        $user_id =  get_current_user_id();

        $user_id = wp_update_user( array( 'ID' => $user_id, 'first_name' => $firstname, 'last_name' => $lastname, 'speciality' => $speciality, 'phone' => $phone, 'user_pass' => $password,  ) );

        if ( is_wp_error( $user_id ) ) {

            echo "Error";

        }

        die();
    }

}

add_action( 'wp_ajax_user_profile_update_request', 'user_profile_update_request' );
add_action( 'wp_ajax_nopriv_user_profile_update_request', 'user_profile_update_request' );


// User Custom Fields

function my_show_extra_profile_fields( $user ) { ?>

	<h3>UserSpeciality</h3>

	<table class="form-table">

		<tr>
			<th><label for="speciality">Speciality</label></th>

			<td>
				<input type="text" name="speciality" id="speciality" value="<?php echo esc_attr( get_the_author_meta( 'speciality', $user->ID ) ); ?>" class="regular-text" /><br />
				<span class="description">Please enter your Speciality</span>
			</td>
		</tr>

	</table>

    <h3>Phone Number</h3>

	<table class="form-table">

		<tr>
			<th><label for="phno">Phone Number</label></th>

			<td>
				<input type="phno" name="phno" id="phno" value="<?php echo esc_attr( get_the_author_meta( 'phno', $user->ID ) ); ?>" class="regular-text" /><br />
				<span class="description">Please enter your Phone Number</span>
			</td>
		</tr>

	</table>


<?php }

add_action( 'show_user_profile', 'my_show_extra_profile_fields' );
add_action( 'edit_user_profile', 'my_show_extra_profile_fields' );

function my_save_extra_profile_fields( $user_id ) {

	if ( !current_user_can( 'edit_user', $user_id ) )
		return false;

    update_usermeta( $user_id, 'speciality', $_POST['speciality'] );
    update_usermeta( $user_id, 'phno', $_POST['phno'] );
}

add_action( 'personal_options_update', 'my_save_extra_profile_fields' );
add_action( 'edit_user_profile_update', 'my_save_extra_profile_fields' );

// Page Redirect

function redirect_to_specific_page() {

    if ( is_page('profile') && !is_user_logged_in() ) {

        wp_redirect( get_site_url(), 301 );
        exit;

    }

    if (is_page('user-account') && is_user_logged_in() ) {

        global $current_user;
        get_currentuserinfo();
        $user_id =  $current_user->ID;
        $speciality = get_usermeta( $user_id, 'speciality', $_POST['speciality'] );

        $catID = get_cat_ID($speciality);

        $redirecturl = get_site_url() . '/category/speciality/cardiology/?cat=' . $catID;

        wp_redirect( $redirecturl, 301 );

    }

}

add_action( 'template_redirect', 'redirect_to_specific_page' );


//Add login/logout link to naviagation menu

function add_loginout_link( $items, $args ) {

    if (is_user_logged_in() && $args->theme_location == 'primary_navigation') {

        $items .= '<li><a href="' . site_url() . '/profile">My Profile</a></li>';

        $items .= '<li><a href="' . wp_logout_url( get_permalink() ) . '">Logout</a></li>';

    }
    return $items;
}

add_filter( 'wp_nav_menu_items', 'add_loginout_link', 10, 2 );
