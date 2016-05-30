<?php if (!have_posts()) : ?>

    <div class="alert alert-warning">

        <?php _e('Sorry, no results were found.', 'sage'); ?>

    </div>

    <?php get_search_form();

endif;

$count = 1;

while (have_posts()) : the_post(); ?>

    <div class="grid col-md-4">

        <?php echo get_post_image('col4', 'medium'); ?>
        <?php echo get_postmeta('category'); ?>

        <h2 class="post-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>

        <div class="entry">

            <?php echo custom_excerpt(30); ?>

            <a href="<?php the_permalink(); ?>?id=' .$catID . '" class="view-more">Read More</a>

        </div>

    </div>

    <?php if (($count%3) == 0) { ?>

        <div class="hidden-xs hidden-sm clearfix"></div>

    <?php }

    $count++;

endwhile;

wp_pagenavi(); ?>
