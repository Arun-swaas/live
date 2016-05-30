<?php use Roots\Sage\Titles;
$type = $_GET['type'];
$media = $_GET['media']; ?>

<div class="row">

    <div class="ajax-load col-md-8">

        <div class="sec-title clearfix hidden-xs hidden-sm">

            <?php if ($type) { ?>

                <h3><span><?php echo str_replace('_', ' ', $type); ?></span></h3>

            <?php } elseif ($media) { ?>

                <h3><span><?php echo $media; ?></span></h3>

            <?php } else { ?>

                <h3><span><?= Titles\title(); ?></span></h3>

            <?php } ?>

        </div>

        <div class="row">

            <?php

            $category = get_category( get_query_var( 'cat' ) );
            $catID = $category->cat_ID;


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

                    }

                }

                wp_reset_postdata();

            } ?>

        </div>

        <div class="ajax-loader"></div>

    </div>

    <div class="col-md-4">
        <?php dynamic_sidebar('sidebar-patient'); ?>
    </div>


</div>


