<div class="col-md-8">
    <?php while (have_posts()) : the_post(); setPostViews(get_the_ID());


        if ( has_post_thumbnail() ) { ?>

            <div class="media-single">

                <?php the_post_thumbnail( 'col8', array( 'class' => 'img-responsive' )); ?>

            </div>

        <?php }

        echo get_postmeta('category'); ?>

        <div class="entry">

            <?php the_content(); ?>

        </div>

    <?php endwhile; wp_reset_query(); $catcount = 1;

    $categories = get_the_category();

    foreach ( $categories as $category ) {

        if (get_cat_name($category->category_parent) == 'Speciality') {

            if ($catcount == 1) {
                $cat_names = $category->name;
            } else {
                $cat_names = $cat_names . ', ' . $category->name;
            }

        }

        $catcount++;

    }

    if ( ( strpos( $_SERVER['HTTP_USER_AGENT'], 'Mobile/' ) !== false ) && ( strpos ( $_SERVER['HTTP_USER_AGENT'], 'Safari/' ) == false ) ) {

    } else if ($_SERVER['HTTP_X_REQUESTED_WITH'] == "net.swaas.hidoctorapp") {

    } else {
        comments_template('/templates/comments.php');
    } ?>

</div>

<div class="col-md-4">

    <?php dynamic_sidebar('sidebar-doctor-single'); ?>

</div>
