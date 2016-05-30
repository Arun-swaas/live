<?php use Roots\Sage\Titles; ?>

<div class="row">

    <div class="ajax-load col-md-8">

        <div class="sec-title clearfix hidden-xs hidden-sm">

            <?php $type = $_GET['type'];
            $media = $_GET['media'];

            if ($type) { ?>

                <h3><span><?php echo str_replace('_', ' ', $type); ?></span></h3>

            <?php } elseif ($media) { ?>

                <h3><span><?php echo $media; ?></span></h3>

            <?php } else { ?>

                <h3><span><?= Titles\title(); ?></span></h3>

            <?php } ?>

        </div>

        <div class="row">

            <?php $type = $_GET['type'];
            $media = $_GET['media'];
            $catID = $_GET['cat'];

            if (($type) || ($media)) {

                get_template_part('templates/content', 'query');

            } else {

                $args = array(
                    'cat'       => $catID,
                );

                $query = new WP_Query( $args );

                if ( $query->have_posts() ) {

                    $count = 1;

                    while ( $query->have_posts() ) {

                        $query->the_post(); ?>

                        <div class="grid col-md-6">

                            <?php echo get_post_image('col8', 'medium');
                            echo  get_postmeta('category'); ?>

                            <h2 class="post-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>

                            <div class="entry">

                                <?php echo custom_excerpt(30); ?>

                                <a href="<?php the_permalink(); ?>" class="view-more">Read More</a>

                            </div>

                        </div>

                        <?php if (($count%2) == 0) { ?>

                            <div class="hidden-xs hidden-sm clearfix"></div>

                        <?php }

                        $count++;

                        } ?>

                        <button class="load-more hidden-md hidden-lg">Load More</button>

                    <?php }

                wp_reset_postdata();  wp_reset_query();

            } ?>

        </div>

        <div class="ajax-loader"></div>

    </div>

    <div class="col-md-4">
        <?php dynamic_sidebar('sidebar-doctor'); ?>
    </div>


</div>


