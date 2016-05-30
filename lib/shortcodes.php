<?php

/* Section
-------------------------------------------------- */

function section_shortcode( $atts , $content = null ) {

    // Attributes
    extract( shortcode_atts(
        array(
            'id' => '',
            'title' => '',
            'tagline' => '',
            'class' => '',
            'image' => ''
        ), $atts )
    );

    if ($id) {
        $id = 'id = "' . $id . '"';
    }

    if ($class) {
        $class = 'section ' . $class;
    } else {
        $class = 'section';
    }

    if ($image) {
        $style = "background-image: url('" . $image . "')";
        $image = 'style = "' . $style . '"';
    }
	
	if ($title) {
		$title = '<h2 class="sectitle">' . $title . '</h2>';
	}

    $out = '<section ' . $id . ' class="' . $class . '" ' . $image . '>';
	$out .= $title;
    $out .= do_shortcode( $content );
    $out .= '</section>';

    return $out;

}
add_shortcode( 'section', 'section_shortcode' );

/* Container
-------------------------------------------------- */
function container_shortcode( $atts , $content = null ) {

    // Attributes
    extract( shortcode_atts(
        array(
        ), $atts )
    );

    $out = '<div class="container">';
    $out .= '<div class="row">';
    $out .= do_shortcode( $content );
    $out .= '</div>';
    $out .= '</div>';

    return $out;
}
add_shortcode( 'container', 'container_shortcode' );

/* Col12
-------------------------------------------------- */

function col12_shortcode( $atts , $content = null ) {
    // Attributes
    extract( shortcode_atts(
        array(
            'title' => '',
			'class' => '',
        ), $atts )
    );
	
	if ($title) {
		$sectitle = '<h2 class="sectitle">' . $title . '</h2>';
	}
	
	if ($class) {
		$class = 'col-md-12 ' . $class; 
	} else {
		$class = 'col-md-12';
	}

    $out = '<div class="' . $class . '">';
	$out .= $sectitle;
    $out .= do_shortcode( $content );
    $out .= '</div>';

    return $out;
}
add_shortcode( 'col12', 'col12_shortcode' );

/* Col8
-------------------------------------------------- */

function col8_shortcode( $atts , $content = null ) {

    // Attributes
    extract( shortcode_atts(
        array(
        ), $atts )
    );

    $out = '<div class="col-md-8">';
    $out .= do_shortcode( $content );
    $out .= '</div>';

    return $out;

}
add_shortcode( 'col8', 'col8_shortcode' );

/* Col6
-------------------------------------------------- */

function col6_shortcode( $atts , $content = null ) {

    // Attributes
    // Attributes
    extract( shortcode_atts(
		array(
			'class' => '',
		), $atts )
	);

    if ($class) {
        $class = 'col-md-6 ' . $class;
    } else {
        $class = 'col-md-6';
    }

    $out = '<div class="' . $class . '">';
    $out .= do_shortcode( $content );
    $out .= '</div>';

    return $out;

}
add_shortcode( 'col6', 'col6_shortcode' );


/* Col4
-------------------------------------------------- */

function col3_shortcode( $atts , $content = null ) {

    // Attributes
    extract( shortcode_atts(
		array(
			'class' => '',
			'title' => '',
		), $atts )
	);

    if ($class) {
        $class = 'col-md-3 ' . $class;
    } else {
        $class = 'col-md-3';
    }
	
	if ($title) {
		$title = '<h3>' . $title . '</h3>';
	}

    $out = '<div class="' . $class .'">';
	$out .= $title;
    $out .= do_shortcode( $content );
    $out .= '</div>';

    return $out;

}
add_shortcode( 'col3', 'col3_shortcode' );

/* Col3
-------------------------------------------------- */

function col4_shortcode( $atts , $content = null ) {

    // Attributes
    extract( shortcode_atts(
		array(
			'class' => '',
			'title' => '',
		), $atts )
	);

    if ($class) {
        $class = 'col-md-4 ' . $class;
    } else {
        $class = 'col-md-4';
    }
	
	if ($title) {
		$title = '<h3>' . $title . '</h3>';
	}

    $out = '<div class="' . $class . '">';
	$out .= $title;
    $out .= do_shortcode( $content );
    $out .= '</div>';

    return $out;

}
add_shortcode( 'col4', 'col4_shortcode' );


/* Home Section
-------------------------------------------------- */

function slider_shortcode() {

    $catID = $_GET['cat'];

    if (!$catID) {
        $catID = get_cat_ID('Speciality');
    }

    // WP_Query arguments
    $args = array (
        'cat'                    => $catID,
        'posts_per_page'         => '10',
        'meta_query'             => array(
            array(
                'key'       => 'slider_show_in_slider',
                'value'     => 'Yes',
            ),
        ),
    );


    // The Query
    $query = new WP_Query( $args );

    if (is_front_page()) {
        $out = '<div class="home-slider">';
    } else {
        $out = '<div class="home-slider hidden-xs hidden-sm">';
    }



    // The Loop
    if ( $query->have_posts() ) {

        while ( $query->have_posts() ) {

            $query->the_post();

            $thumb = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'slider' );
            $url = $thumb['0'];

            $out .= '<div>';
            $out .= '<a href="' . get_the_permalink() . '">';
            $out .= '<div class="image-ease">';
            $out .= '<img src="' . $url . '" alt="' . get_the_title() . '" class="img-responsive" />';
            $out .= '<div class="image-ease-overlay"></div>';
            $out .= get_media_type('medium');
            $out .= '</div>';
            $out .= '<h2 class="post-title">' . get_the_title() . '</h2>';
            $out .= '</a>';
            $out .= '</div>';
        }

    }

    wp_reset_postdata();

    $out .= '</div>';

    return $out;

}

add_shortcode( 'slider', 'slider_shortcode' );

/* Post Style
-------------------------------------------------- */

//post1

function post1_shortcode( $atts ) {

    // Attributes
    extract( shortcode_atts(
        array(
            'title' => '',
            'category' => '',
            'post' => '',
            'linktext' => '',
            'type'  => '',

        ), $atts )
    );

    if (!$category) {
        $category = 'Speciality';
    }

    $catID = get_cat_ID($category);

    if ($title) {
        $titleout = '<div class="sec-title clearfix">';
        $titleout .= '<h3>' . $title . '</h3>';

        if (!$linktext) {
            $linktext = 'View All';
        }

        $titleout .= '<a class="view-more" href="' . add_query_arg( array("type" => $type, "cat" => $catID), get_category_link($catID) ) . '">' . $linktext . '</a>';

        $titleout .= '</div>';
    }

    if (!$post) {
        $post = 9;
    }

    $out = '<div class="post-sep post1">';

        $out .= $titleout;

        $args = array(
            'cat'               => $catID,
            'posts_per_page'    => $post,
            'meta_query'        => array(
                array(
                    'key' => 'article_type_select_article_type',
                    'value' => $type,
                )
            )
        );

        // The Query
        $query = new WP_Query( $args );

        $out .= '<div class="row">';

            // The Loop
            if ( $query->have_posts() ) {

            $count = 1;

                while ( $query->have_posts() ) {

                    $query->the_post();

                     if ($count == 1) {

                        $out .= '<div class="col-md-8">';

                        $out .= '<div class="row">';

                            $out .= '<div class="col-md-12">';
                                $out .= get_post_image('col8', 'medium');
                                $out .= get_postmeta('category');
                                $out .= '<h2 class="post-title"><a href="' . get_the_permalink() . '">' . get_the_title() . '</a></h2>';
                                $out .= '<a href="' . get_the_permalink() . '" class="view-more hidden-md hidden-lg">Read More</a>';
                            $out .= '</div>';

                    }

                    if ( ($count > 1) && ($count <= 3)) {

                            $out .= '<div class="col-md-6">';

                                $out .= get_post_image('col4', 'medium');
                                $out .= get_postmeta('category');
                                $out .= '<h2 class="post-title"><a href="' . get_the_permalink() . '">' . get_the_title() . '</a></h2>';
                                $out .= '<a href="' . get_the_permalink() . '" class="view-more hidden-md hidden-lg">Read More</a>';

                            $out .= '</div>';
                    }

                    if ($count == 3) {
                        $out .= '</div>';
                        $out .= '</div>';
                    }

                    if ($count == 4) {
                        $out .= '<div class="col-md-4">';
                    }

                    if ($count >=4) {
                        $out .= '<div class="post-list">';
                        $out .= '<div class="hidden-md hidden-lg">';
                        $out .= get_post_image('col4', 'medium');
                        $out .= get_postmeta('category');
                        $out .= '</div>';
                        $out .= '<h2 class="post-title"><a href="' . get_the_permalink() . '">' . get_the_title() . '</a></h2>';
                        $out .= get_postmeta('category');
                        $out .= '<a href="' . get_the_permalink() . '" class="view-more hidden-md hidden-lg">Read More</a>';
                        $out .= '</div>';
                    }

                    $count++;

                }

            }

            wp_reset_postdata();

            $out .= '</div>';

        $out .= '</div>';

    $out .= '</div>';

    return $out;

}
add_shortcode( 'post1', 'post1_shortcode' );

// Post 2

function post2_shortcode( $atts ) {

    // Attributes
    extract( shortcode_atts(
        array(
            'title' => '',
            'category' => '',
            'post' => '',
            'linktext' => '',
            'type'  => '',
        ), $atts )
    );

    if (!$category) {
        $category = 'Speciality';
    }

    $catID = get_cat_ID($category);

    if ($title) {
        $titleout = '<div class="sec-title clearfix">';
        $titleout .= '<h3>' . $title . '</h3>';

        if (!$linktext) {
            $linktext = 'View All';
        }

        $titleout .= '<a class="view-more" href="' . add_query_arg( array("type" => $type, "cat" => $catID), get_category_link($catID) ) . '">' . $linktext . '</a>';


        $titleout .= '</div>';
    }

    if (!$post) {
        $post = 9;
    }

    $out = '<div class="post-sep post2">';

        $out .= $titleout;

        $args = array(
            'cat'               => $catID,
            'posts_per_page'    => $post,
            'meta_query'        => array(
                array(
                    'key' => 'article_type_select_article_type',
                    'value' => $type
                )
            )
        );

        // The Query
        $query = new WP_Query( $args );

        $out .= '<div class="row">';

            // The Loop
            if ( $query->have_posts() ) {

                $count = 1;

                while ( $query->have_posts() ) {

                    $query->the_post();

                    $out .= '<div class="col-md-4">';

                        $out .= get_post_image('col4', 'medium');
                        $out .= get_postmeta('category');

                        $out .= '<h2 class="post-title"><a href="' . get_the_permalink() . '">' . get_the_title() . '</a></h2>';
                        $out .= '<div class="entry">';
                            $out .= custom_excerpt(20);
                         $out .= '<a href="' . get_the_permalink() . '" class="view-more hidden-md hidden-lg">Read More</a>';
                        $out .= '</div>';

                    $out .= '</div>';

                    if (($count % 3) == 0) {
                        $out .= '<div class="clearfix"></div>';
                    }

                    $count++;

                }

            }

            wp_reset_postdata();

        $out .= '</div>';

    $out .= '</div>';

    return $out;

}
add_shortcode( 'post2', 'post2_shortcode' );


// Post 3

function post3_shortcode( $atts ) {

    // Attributes
    extract( shortcode_atts(
        array(
            'title'     => '',
            'category'  => '',
            'linktext'  => '',
            'type'      => '',
            'icon'      => '',
        ), $atts )
    );

    if (!$category) {
        $category = 'Speciality';
    }

    $catID = get_cat_ID($category);

    if ($title) {
        $title = '<h1>' . $title . '</h1>';
    }

    if ($icon) {
        $icon = '<div class="sec-icon hidden-xs hidden-sm"><img src="' . $icon . '" alt="' . $title . '" /></div>';
    }

    $out = '<div class="post3">';

        $out .= $icon;
        $out .= $title;

        $count = 1;
        $args = array(
            'cat'               => $catID,
            'posts_per_page'    => 4,
            'meta_query'        => array(
                array(
                    'key' => 'article_type_select_article_type',
                    'value' => $type
                )
            )
        );

        // The Query
        $query = new WP_Query( $args );

        // The Loop
        if ( $query->have_posts() ) {

            while ( $query->have_posts() ) {

                $query->the_post();

                $out .= '<div class="col-md-3">';

                    $out .= get_post_image('col4', 'medium');
                    $out .= get_postmeta('category');

                    $out .= '<h2 class="post-title"><a href="' . get_the_permalink() . '">' . get_the_title() . '</a></h2>';
                    $out .= '<div class="entry">';
                        $out .= custom_excerpt(20);
                    $out .= '<a href="' . get_the_permalink() . '" class="view-more hidden-md hidden-lg">Read More</a>';
                    $out .= '</div>';

                $out .= '</div>';

                if (($count % 4) == 0) {
                    $out .= '<div class="clearfix"></div>';
                }

                $count++;

            }

        }

        wp_reset_postdata();

        if (!$linktext) {
            $linktext = 'View All';
        }

        $out .= '<div class="btn-wrap">';
        $out .= '<a class="view-more-btn" href="' . add_query_arg( array("type" => $type, "cat" => $catID), get_category_link($catID) ) . '">' . $linktext . '</a>';
        $out .= '</div>';
    $out .= '</div>';

    return $out;

}
add_shortcode( 'post3', 'post3_shortcode' );

/* Recent Articles Widget
-------------------------------------------------- */

function recent_article_type_shortcode( $atts ) {

    // Attributes
    extract( shortcode_atts(
        array(
            'title' => '',
        ), $atts )
    );


    if ($title) {
        $title = '<div class="sec-title clearfix"><h3><span>' . $title . '</span></h3></div>';
    }

    $out = '<div class="widget recent-articles">';

        if (is_category()) {

            $catID = get_cat_id( single_cat_title("",false) );

        }

        $out .= $title;
        $out .= '<ul>';

            $out .= '<li><a href="' . add_query_arg( array("type" => "News", "cat" => $catID), get_category_link($catID) ) . '">News</a></li>';
            $out .= '<li><a href="' . add_query_arg( array("type" => "Publications", "cat" => $catID), get_category_link($catID) ) . '">Publications</a></li>';
            $out .= '<li><a href="' . add_query_arg( array("type" => "Procedures_and_Tips", "cat" => $catID), get_category_link($catID) ) . '">Procedures and Tips</a></li>';
            $out .= '<li><a href="' . add_query_arg( array("media" => "Video", "cat" => $catID), get_category_link($catID) ) . '">Videos</a></li>';

        $out .= '</ul>';

    $out .= '</div>';

    return $out;

}
add_shortcode( 'recent_article_type', 'recent_article_type_shortcode' );

/* Patient Recent Articles Widget
-------------------------------------------------- */

function patient_recent_article_type_shortcode( $atts ) {

    // Attributes
    extract( shortcode_atts(
        array(
            'title' => '',
        ), $atts )
    );


    if ($title) {
        $title = '<div class="sec-title clearfix"><h3><span>' . $title . '</span></h3></div>';
    }

    $out = '<div class="widget recent-articles">';

        $catID = get_cat_ID('Patient');

        $out .= $title;
        $out .= '<ul>';

            $out .= '<li><a href="' . add_query_arg( array("type" => "Patient_Education_Material", "cat" => $catID), get_category_link($catID) ) . '">Patient Education Material</a></li>';
            $out .= '<li><a href="' . add_query_arg( array("media" => "Video", "cat" => $catID), get_category_link($catID) ) . '">Videos</a></li>';

        $out .= '</ul>';

    $out .= '</div>';

    return $out;

}
add_shortcode( 'patient_recent_article_type', 'patient_recent_article_type_shortcode' );

/* Editors Pick
-------------------------------------------------- */

function editorpicks_shortcode( $atts ) {

    // Attributes
    extract( shortcode_atts(
        array(
            'title' => '',
            'post' => '',
            'link' => '',
            'linktext' => ''
        ), $atts )
    );

    if ($title) {

        $title = '<div class="sec-title clearfix"><h3><span>' . $title . '</span></h3></div>';

    } else {

        $title = '<div class="sec-title clearfix"><h3><span>Editor Picks</span></h3></div>';

    }

    $type = $_GET['type'];
    $media = $_GET['media'];
    $catID = $_GET['cat'];

    if (!$post) {
        $post = 1;
    }

    if (!$catID) {
        $catID = $catID = get_cat_ID('Speciality');
    }

    $out .= '<div class="widget cat-widget">';
    $out .= $title;
    $out .= '<ul>';

        // WP_Query arguments
        $args = array (

            'cat'                   => $catID,
            'posts_per_page'        => $post,
            'meta_query'            => array(
                array(
                    'key'           => 'editor_picks_show_in_editor_picks',
                    'value'         => 'Yes',
                ),
            ),
        );

        // The Query
        $query = new WP_Query( $args );

        // The Loop
        if ( $query->have_posts() ) {
            while ( $query->have_posts() ) {
                $query->the_post();
                $out .= '<li class="post-list clearfix">';

                    $out .= get_post_image('thumbsmall', '');
                    $out .= '<div class="widget-content-float">';
                    $out .= '<h2 class="post-title"><a href="' . get_the_permalink() . '">' . get_the_title() . '</a></h2>';
                    $out .= get_postmeta('category');
                    $out .= '</div>';

                $out .= '</li>';
            }
        } else {
            // no posts found
        }

        // Restore original Post Data
        wp_reset_postdata();


    $out .= '<a class="view-more" href="' . add_query_arg( array("type" => 'Editor_Picks', "cat" => $catID), get_category_link($catID) ) . '">' . $linktext . '</a>';

    $out .= '</ul>';

    $out .= '</div>';

    if ($type != "Editor_Picks") {

        return $out;

    }

}
add_shortcode( 'editorpicks', 'editorpicks_shortcode' );

/* Recommended Posts
-------------------------------------------------- */

function recommended_shortcode( $atts ) {

	// Attributes
	extract( shortcode_atts(
		array(
			'title' => '',
			'posts' => '',
		), $atts )
	);


    $widget_title = '<div class="sec-title clearfix">';
    $widget_title .= '<h3><span>';
    if ($title) {
        $widget_title .= $title;
    } else {
        $widget_title .= 'Recommended Posts';
    }
    $widget_title .= '</span></h3>';
    $widget_title .= '</div>';

    if ($posts) {
        $post_count = $posts;
    } else {
        $post_count = '5';
    }

    $categories = get_the_category();

    foreach ( $categories as $category ) {

        if (get_cat_name($category->category_parent) == 'Speciality') {

            if ($catcount == 1) {
                $cat_names = $category->name;
            } else {
                $cat_names = $cat_names . ', ' . $category->name;
            }

        } else {
            $cat_names = 'patient';
        }

        $catcount++;

    }

    $out = '<div class="widget cat-widget">';

        $out .= $widget_title;

        $out .= '<ul>';

            $args = array(
                'category_name' => $cat_names,
                'posts_per_page' => $post_count,
                'orderby'        => 'rand',
            );

            $query = new WP_Query( $args );

            if ( $query->have_posts() ) {

                while ( $query->have_posts() ) {

                    $query->the_post();

                     $out .= '<li class="post-list clearfix">';

                        $out .= get_post_image('thumbsmall', '');
                        $out .= '<div class="widget-content-float">';
                        $out .= '<h2 class="post-title"><a href="' . get_the_permalink() . '">' . get_the_title() . '</a></h2>';
                        $out .= get_postmeta('category');
                        $out .= '</div>';

                    $out .= '</li>';
                }

    }

        $out .= '</ul>';

    $out .= '</div>';

    return $out;

}

add_shortcode( 'recommended', 'recommended_shortcode' );

/* Speciality Widget
-------------------------------------------------- */

function specialities_shortcode( $atts ) {

    extract( shortcode_atts(
        array(
            'title' => '',
        ), $atts )
    );

    if (!$title) {
        $title = 'Choose the speciality';
    }

    $out .= '<div class="widget speciality-widget hidden-xs hidden-sm hidden-md hidden-lg">';
    $catID = get_cat_ID('Speciality');
    $out .= '<h3>' . $title . '</h3>';
    $out .= '<select name="event-dropdown"  class="dropdown" onchange="document.location.href=this.options[this.selectedIndex].value;">';
    $out .= '<option value="">Speciality</option>';
    $categories = get_categories(array('child_of' => $catID,));

    foreach ($categories as $category) {

        $out .= '<option value="' . add_query_arg( array("cat" => $category->term_id), get_category_link( $category->term_id ) ) . '">';
        $out .= $category->cat_name;
        $out .= ' ('.$category->category_count.')';
        $out .= '</option>';
    }

    $out .= '</select>';

    $out .= '</div>';

    return $out;
}
add_shortcode( 'specialities', 'specialities_shortcode' );

/* Social
-------------------------------------------------- */

function social_shortcode( $atts ) {

    // Attributes
    extract( shortcode_atts(
        array(
            'title' => '',
            'facebook' => '',
            'twitter' => '',
            'linkedin' => '',
            'youtube' => ''
        ), $atts )
    );

    if ($title) {
        $title = '<div class="sec-title clearfix"><h3><span>' . $title . '</span></h3></div>';
    }

    if ($facebook) {
        $facebook = '<li class="facebook"><a href="' . $facebook . '" target="_blank"></a></li>';
    }

    if ($twitter) {
        $twitter = '<li class="twitter"><a href="' . $twitter . '" target="_blank"></a></li>';
    }

    if ($linkedin) {
        $linkedin = '<li class="linkedin"><a href="' . $linkedin . '" target="_blank"></a></li>';
    }

    if ($youtube) {
        $youtube = '<li class="youtube"><a href="' . $youtube . '" target="_blank"></a></li>';
    }

    $out .= '<div class="widget social-widget">';
    $out .= $title;
    $out .= '<ul>';
    $out .= $facebook;
    $out .= $twitter;
    $out .= $linkedin;
    $out .= $youtube;
    $out .= '</ul>';
    $out .= '</div>';

    return $out;

}
add_shortcode( 'social', 'social_shortcode' );

/* Videos
-------------------------------------------------- */

function recentvideos_shortcode( $atts ) {
    // Attributes
    extract( shortcode_atts(
        array(
            'title' => '',
            'tagline' => '',
            'category' => '',
            'linktext' => '',
            'media' => ''
        ), $atts )
    );

    if (!$category) {
        $category = 'Speciality';
    }

    $catID = get_cat_ID($category);

    if ($title) {
        $title = '<h1>' . $title . '</h1>';

        if ($tagline) {
            $title .= '<span>' . $tagline . '</span>';
        }
    }

    $out = '<div class="recent-videos clearfix">';
    $out .= '<div class="video-title clearfix">';
    $out .= '<div class="col-md-12">' . $title . '</div>';
    $out .= '</div>';

    $args = array(
        'cat' => $catID,
        'posts_per_page' => '5',
        'meta_query' => array(
            array(
                'key' => 'media_select_media_type',
                'value' => $media,
            )
        )
    );

    // The Query
    $query = new WP_Query( $args ); $videocount = 1;

    // The Loop
    if ( $query->have_posts() ) {


        while ( $query->have_posts() ) {

            $query->the_post();

            if ($videocount == 1) {

                $out .= '<div class="video-main clearfix">';
                $out .= '<div class="col-md-8 col-md-offset-2">';
                $out .= get_post_image('col8', '');
                $out .= '<h2>' . get_the_title() . '</h2>';
                $out .= '</div>';
                $out .= '</div>';

            } else {

                $thumb = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'thumbmed' );
                $url = $thumb['0'];
                $out .= '<div class="video-nav col-xs-6 col-sm-3">';
                $out .= get_post_image('col4', '');
                $out .= '<h3>' . get_the_title() . '</h3>';
                $out .= '</div>';

            }

            $videocount++;

        }

    }

    wp_reset_postdata();

    if (!$linktext) {
        $linktext = 'View All';
    }

    $out .= '</div>';

    $out .= '<div class="btn-wrap btn-wrap-bg">';
    $out .= '<a class="view-more-btn" href="' . add_query_arg( array('media' => $media,'cat' => $catID), get_category_link($catID) ) . '">' . $linktext . '</a>';
    $out .= '</div>';

    return $out;
}
add_shortcode( 'recentvideos', 'recentvideos_shortcode' );

// Video

function insertvideo_shortcode( $atts ) {

    // Attributes
    extract( shortcode_atts(
        array(
            'type' => '',
            'url' => '',
        ), $atts )
    );

    switch ($type) {
        case 'html':
            $video .= '<div class="video-wrap">' . do_shortcode('[videojs mp4="' . $url . '"  height="350" width="100%"]') . '</div>';
            break;
        case 'youtube':
            $video .= '<div class="video-wrap"><iframe width="100%" height="350" src="' . $url . '" frameborder="0" allowfullscreen></iframe></div>';
            break;
        default:

    }

    return $video;

}
add_shortcode( 'insertvideo', 'insertvideo_shortcode' );

// Youtube
function youtube_shortcode( $atts ) {

	// Attributes
	extract( shortcode_atts(
		array(
			'videoid' => '',
			'width' => '',
			'height' => '',
		), $atts )
	);

    if (!$height) {
        $height = "315";
    }
	
	if (!$width) {
        $width = "100%";
    }

	// Code

    $out = '<div class="video-wrap"><iframe width="' . $width . '" height="' . $height . '" src="https://www.youtube.com/embed/' . $videoid . '" frameborder="0" allowfullscreen></iframe></div>';

    if ($videoid) {
        return $out;
    }
}
add_shortcode( 'youtube', 'youtube_shortcode' );

/* Content
-------------------------------------------------- */

// Emphasis

function em_shortcode( $atts , $content = null ) {

    // Attributes
    extract( shortcode_atts(
        array(
            'style' => '',
        ), $atts )
    );

    if ($style == 1) {

        $class = 'em style1';

    } elseif ($style == 2) {

        $class = 'em style2';

    } elseif ($style == 3) {

        $class = 'em style3';

    } else {
        $class = 'em style4';
    }

    $out = '<em class="' . $class . '">';
    $out .= do_shortcode( $content );
    $out .= '</em>';

    return $out;
}
add_shortcode( 'em', 'em_shortcode' );


// Quote

function quote_shortcode( $atts , $content = null ) {

    $out = '<p class="blockquote">';
    $out .= do_shortcode( $content );
    $out .= '</p>';

    return $out;

}
add_shortcode( 'quote', 'quote_shortcode' );

// Reference

function reference_shortcode( $atts , $content = null ) {

    // Attributes
    extract( shortcode_atts(
        array(
            'title' => '',
            'style' => '',
        ), $atts )
    );

    if ($style == 1) {

        $class = 'reference style1';

    } elseif ($style == 2) {

        $class = 'reference style2';

    } elseif ($style == 3) {

        $class = 'reference style3';

    } else {
        $class = 'reference style4';
    }

    $out = '<div class="' . $class . '">';
    if ($title) {
        $out .= '<div class="ref-title"><span>' . $title . '</span></div>';
    }
    $out .= do_shortcode( $content );
    $out .= '</div>';

    return $out;
}
add_shortcode( 'reference', 'reference_shortcode' );

// Highlight

function highlight_shortcode( $atts , $content = null ) {

    // Attributes
    extract( shortcode_atts(
        array(
            'style' => '',
        ), $atts )
    );

    if ($style == 1) {

        $class = 'highlight style1';

    } elseif ($style == 2) {

        $class = 'highlight style2';

    } elseif ($style == 3) {

        $class = 'highlight style3';

    } else {
        $class = 'highlight style4';
    }


    $out = '<span class="' . $class . '">';
    $out .= do_shortcode( $content );
    $out .= '</span>';

    return $out;
}
add_shortcode( 'highlight', 'highlight_shortcode' );

// H3

function h3_shortcode( $atts , $content = null ) {
    $out = '<h3>' . do_shortcode( $content ) . '</h3>';
    return $out;
}
add_shortcode( 'h3', 'h3_shortcode' );

// H4

function h4_shortcode( $atts , $content = null ) {
    $out = '<h4>' . do_shortcode( $content ) . '</h4>';
    return $out;
}
add_shortcode( 'h4', 'h4_shortcode' );

// App Features

function features_shortcode( $atts , $content = null ) {

    // Attributes
    extract( shortcode_atts(
        array(
            'title' => '',
            'image' => '',
            'appstore' => '',
            'playstore' => '',
        ), $atts )
    );

    if ($title) {
        $title='<h1>' . $title . '</h1>';
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

    $out = '<div class="app-features">';
    $out .= '<div class="image-sec col-md-6 hidden-xs hidden-sm">';
    $out .= '<img src="' . $image . '" alt="' . $title . '" />';
    $out .= '</div>';
    $out .= '<div class="col-md-6">';
    $out .= $title;
    $out .= '<div class="entry">';
    $out .= do_shortcode( $content);
    $out .= $app;
    $out .= '</div>';
    $out .= '</div>';
    $out .= '</div>';

    return $out;
}
add_shortcode( 'features', 'features_shortcode' );

// Login / Register / Forgot Password

function login_shortcode() {

    $out = '<div id="user-tab">';

        $out .= '<ul class="nav nav-tabs" role="tablist">';
            $out .= '<li role="presentation" class="active"><a href="#login" aria-controls="login" role="tab" data-toggle="tab">Login</a></li>';
            $out .= '<li role="presentation"><a href="#register" aria-controls="register" role="tab" data-toggle="tab">Register</a></li>';

        $out .= '</ul>';

        $out .= '<div class="tab-content">';

            $out .= '<div role="tabpanel" class="tab-pane  fade in active" id="login">';

                $out .= '<div class="login-wrap form-wrap">';

                    $out .= '<form id="form-login">';

                        $out .= '<h3>Login to your Account</h3>';

                        $out .= '<p>Use your Email and Password to access your DrBond account</p>';

                        $out .= '<div class="field-wrap">';

                        $out .= '<input type="text" name="username" class="login-username" placeholder="Email" />';

                        $out .= '</div>';

                        $out .= '<div class="field-wrap">';

                        $out .= '<input type="password" name="password" class="login-pass" placeholder="Password" />';

                        $out .= '</div>';

                        $out .= '<div class="field-wrap">';

                        $out .= '<button name="submit" class="login-submit">Login</button>';

                        $out .= '</div>';

                        $out .= '<a href="#lostpass" aria-controls="lostpass" role="tab" data-toggle="tab">Lost your password?</a>';

                        $out .= '<div class="ajax-loader"></div>';

                        $out .= '<div class="login-error"></div>';

                    $out .= '</form>';

                $out .= '</div>';

            $out .= '</div>';

            $out .= '<div role="tabpanel" class="tab-pane fade" id="lostpass">';

                $out .= '<div class="lostpass-wrap form-wrap">';

                    $out .= '<h3>Lost Your Password?</h3>';

                    $out .= '<p>Please enter your email address. You will receive your password via email.</p>';

                    $out .= '<form id="form-lost">';

                        $out .= '<div class="field-wrap">';

                            $out .= '<input type="text" name="email" class="lost-email" placeholder="Email *" />';

                        $out .= '</div>';

                        $out .= '<button name="submit" class="login-submit">Login</button>';

                        $out .= '<div class="login-error"></div>';

                    $out .= '</form>';

                $out .= '</div>';

            $out .= '</div>';

            $out .= '<div role="tabpanel" class="tab-pane fade" id="register">';

                $out .= '<div class="register-wrap form-wrap">';

                    $out .= '<form id="form-reg">';

                        $out .= '<h3>Create Your Account</h3>';

                        $out .= '<p>Registering on DrBond site is really easy. Just fill in the fields below and we’ll set up a new account for you in no time!</p>';

                        $out .= '<div class="field-wrap">';

                            $out .= '<div class="row">';

                                    $out .= '<div class="col-md-6">';

                                        $out .= '<input type="text" name="firstname" class="reg-firstname mob-btmspace" placeholder="First Name *" />';

                                    $out .= '</div>';

                                    $out .= '<div class="col-md-6">';

                                        $out .= '<input type="text" name="lastname" class="reg-lastname" placeholder="Last Name" />';

                                    $out .= '</div>';

                            $out .= '</div>';

                        $out .= '</div>';


                        $out .= '<div class="field-wrap">';

                            $catID = get_cat_ID('Speciality');
                            $out .= '<select name="speciality"  class="reg-speciality">';
                            $out .= '<option value="">Select Your Speciality *</option>';
                            $categories = get_categories(array('child_of' => $catID,));

                            foreach ($categories as $category) {

                                $out .= '<option value="' . $category->cat_name . '">';
                                $out .= $category->cat_name;
                                $out .= '</option>';
                            }

                            $out .= '</select>';

                        $out .= '</div>';

                        $out .= '<div class="field-wrap">';

                            $out .= '<input type="text" name="phone" class="reg-phone" placeholder="Phone No" />';

                        $out .= '</div>';

                        $out .= '<div class="field-wrap">';

                                $out .= '<input type="text" name="email" class="reg-email" placeholder="Email *" />';

                        $out .= '</div>';

                        $out .= '<div class="field-wrap">';

                            $out .= '<div class="row">';

                                $out .= '<div class="col-md-6">';

                                    $out .= '<input type="password" name="pass" class="reg-pass mob-btmspace" placeholder="Password *" />';

                                $out .= '</div>';

                                $out .= '<div class="col-md-6">';

                                    $out .= '<input type="password" name="confirmpass" class="reg-confirmpass" placeholder="Confirm Password *" />';

                                $out .= '</div>';

                            $out .= '</div>';

                        $out .= '</div>';

                        $out .= '<button name="submit" class="reg-submit">Register</button>';

                        $out .= '<div class="ajax-loader"></div>';

                        $out .= '<div class="login-error"></div>';

                    $out .= '</form>';

                $out .= '</div>';

            $out .= '</div>';

        $out .= '<div>';

    $out .= '</div>';

    return $out;

}
add_shortcode( 'login', 'login_shortcode' );

// Old Shortcodes to be removed

function textwrap_shortcode( $atts , $content = null ) {

	// Attributes
	extract( shortcode_atts(
		array(
			'image' => '',
            'alt' => '',
			'align' => '',
		), $atts )
	);


    $out .= do_shortcode( $content );

    return $out;

}
add_shortcode( 'textwrap', 'textwrap_shortcode' );


/* ---------- Reference ---------- */
function info_shortcode( $atts , $content = null ) {

	// Attributes
	extract( shortcode_atts(
		array(
			'title' => '',
		), $atts )
	);

    $out = do_shortcode($content);

    return $out;
}
add_shortcode( 'info', 'info_shortcode' );

/* ---------- List ---------- */

function list_shortcode( $atts , $content = null ) {

    $out = do_shortcode($content);
    return $out;
}

add_shortcode( 'list', 'list_shortcode' );


function item_shortcode( $atts , $content = null ) {

	// Attributes
	extract( shortcode_atts(
		array(
			'link' => '',
			'title' => '',
            'target' => '',
		), $atts )
	);

    $out = do_shortcode( $content );

    return $out;
}
add_shortcode( 'item', 'item_shortcode' );

/* ---------- Image ---------- */

function image_shortcode( $atts ) {

	// Attributes
	extract( shortcode_atts(
		array(
			'url' => '',
			'link' => '',
            'alt' => '',
            'align' => '',
		), $atts )
	);

	
	if ($url) {
		
		if ($link) {
			$out .= '<a href="' . $link . '">';
		}
		
		$out .= '<img src="' . $url . '" alt="' . $alt . '" class="img-responsive" />';
		
		if ($link) {
			$out .= '</a>';
		}
	}
  

    return $out;
}
add_shortcode( 'image', 'image_shortcode' );

/* ---------- Space 20px bottom ---------- */

function space_shortcode() {

    $out = do_shortcode( $content );

    return $out;
}
add_shortcode( 'space', 'space_shortcode' );


