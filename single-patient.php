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

    <?php endwhile; wp_reset_query(); ?>

</div>

<div class="col-md-4">

    <?php dynamic_sidebar('sidebar-patient-single'); ?>

</div>
