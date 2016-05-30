<?php $type = $_GET['type'];
$media = $_GET['media'];

$catID = get_cat_id( single_cat_title("",false) );

if ($type) {

    if (single_cat_title("",false) == 'Patient') {
        $key = 'patient_article_type_patient_article_type';
    } else {
        $key = 'article_type_select_article_type';
    }

    $args = array(
        'cat'       => $catID,
        'meta_query'    => array(
            array(
                'key' => $key,
                'value' => $type,
            )
        )
    );

    if ($type == 'Editor_Picks') {

        $args = array(
            'cat'       => $catID,
            'meta_query'    => array(
                array(
                    'key' => 'editor_picks_show_in_editor_picks',
                    'value' => 'Yes',
                )
            )
        );
    }

}

if ($media) {

    $args = array(
        'cat'       => $catID,
        'meta_query'    => array(
            array(
                'key' => 'media_select_media_type',
                'value' => $media,
            )
        )
    );

}

$query = new WP_Query( $args );

if ( $query->have_posts() ) {

    $count = 1;

    while ( $query->have_posts() ) {

        $query->the_post(); ?>

        <div class="grid col-md-6">

            <?php echo get_post_image('col8', 'medium'); ?>
            <?php echo get_postmeta('category'); ?>

            <h2 class="post-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>

            <div class="entry">

                <?php echo custom_excerpt(30); ?>

                <a href="<?php the_permalink(); ?>?id=' .$catID . '" class="view-more">Read More</a>

            </div>

        </div>

        <?php if (($count%2) == 0) { ?>

            <div class="hidden-xs hidden-sm clearfix"></div>

        <?php }

        $count++;
    }

} else {

    echo ('<h2 class="no-videos">No content Available at the moment</h2>');

}

wp_reset_postdata(); ?>
