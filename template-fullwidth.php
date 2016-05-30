<?php
/**
 * Template Name: Full Width
 */

while (have_posts()) : the_post();

    get_template_part('templates/content', 'full');

endwhile; ?>
