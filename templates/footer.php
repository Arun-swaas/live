<?php if ( ( strpos( $_SERVER['HTTP_USER_AGENT'], 'Mobile/' ) !== false ) && ( strpos ( $_SERVER['HTTP_USER_AGENT'], 'Safari/' ) == false ) ) {

} else if ($_SERVER['HTTP_X_REQUESTED_WITH'] == "net.swaas.hidoctorapp") {

} else { ?>

    <footer class="content-info">

        <div class="container widget-wrap">

            <?php dynamic_sidebar('sidebar-footer'); ?>

        </div>

        <div class="container copyrights">

            <div class="row">

                <div class="col-md-6">
                    Copyrights &copy; <?php echo get_bloginfo('name') . ' ' . date('Y'); ?>
                </div>

                <div class="col-md-6">
                    <?php if (has_nav_menu('footer_navigation')) :
                        wp_nav_menu(['theme_location' => 'footer_navigation', 'menu_class' => 'footer-nav clearfix']);
                    endif; ?>
                </div>

            </div>

        </div>

    </footer>

    <div class="search-wrap">

        <div class="overlay"></div>


        <form method="get" id="searchform" action="<?php bloginfo('url'); ?>/">

            <div class="searchform-wrap">

                <span>What do you need help with?</span>

                <div class="search-bg clearfix">
                    <input type="text" value="<?php the_search_query(); ?>" name="s" id="s" class="search-text" placeholder="Search" />
                    <input type="submit" id="searchsubmit" value="Search" class="search-submit" />
                </div>

            </div>

        </form>

    </div>

<?php } ?>

<nav class="cbp-spmenu cbp-spmenu-vertical cbp-spmenu-right" id="cbp-spmenu-s1">

    <?php $catID = get_cat_ID('Speciality'); ?>

    <div class="slide-head clearfix">

        <h3>Select the Speciality</h3>

        <span class="spe-close"></span>

    </div>



    <ul>
    <?php $categories = get_categories(array('child_of' => $catID,));

    foreach ($categories as $category) {

        echo '<li><a href="' . add_query_arg( array("cat" => $category->term_id), get_category_link( $category->term_id ) ) . '">';
        echo $category->cat_name;
        echo ' ('.$category->category_count.')';
        echo '</a></li>';
    } ?>

    </ul>

</nav>
