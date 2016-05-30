<?php

if ( ( strpos( $_SERVER['HTTP_USER_AGENT'], 'Mobile/' ) !== false ) && ( strpos ( $_SERVER['HTTP_USER_AGENT'], 'Safari/' ) == false ) ) {

} else if ($_SERVER['HTTP_X_REQUESTED_WITH'] == "net.swaas.hidoctorapp") {

} else { ?>

    <header class="banner navbar-fixed-top">

        <div class="container">

            <div class="row">

                <div class="col-xs-12">

                    <a class="brand" href="<?= esc_url(home_url('/')); ?>">

                        <img src="<?php bloginfo('template_directory') ?>/assets/images/logo.png" alt="<?php bloginfo('name') ?>" height="60" width="150" />

                    </a>

                    <ul class="header-icons">

                        <?php if (!is_user_logged_in()) { ?>

                            <li class="icon-login">

                                <a href="<?php echo get_site_url(); ?>/user-account" role="button" data-toggle="modal"></a>

                            </li>

                        <?php } ?>

                        <li class="icon-search hidden-xs hidden-sm"></li>

                    </ul>

                    <nav class="nav-primary">

                        <?php if (has_nav_menu('primary_navigation')) :
                            wp_nav_menu(['theme_location' => 'primary_navigation', 'menu_class' => 'primary-nav clearfix hidden-xs hidden-sm']);
                        endif; ?>

                    </nav>

                    <div class="navbar-mobile hidden-md hidden-lg">

                        <button type="button" data-target="#navbarCollapse" data-toggle="collapse" class="navbar-toggle collapsed">
                            <span class="sr-only">Toggle navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>

                    </div>

                </div>

            </div>

        </div>

    </header>



    <?php if (has_nav_menu('primary_navigation')) :
        wp_nav_menu(['theme_location' => 'primary_navigation', 'container_class' => 'collapse hidden-md hidden-lg', 'container_id' => 'navbarCollapse']);
    endif; ?>

    <div class="mobile-search-wrap hidden-md hidden-lg">

        <form method="get" id="searchform" action="<?php bloginfo('url'); ?>/">

            <div class="searchform-wrap">

                <div class="search-bg clearfix">
                    <input type="text" value="<?php the_search_query(); ?>" name="s" id="s" class="search-text" placeholder="Search" />
                    <input type="submit" id="searchsubmit" value=" " class="search-submit" />
                </div>

            </div>

        </form>

    </div>

<?php } ?>

    <?php get_template_part('templates/page-header');

    if (is_category()) {
        echo do_shortcode( '[slider /]' );
    }
?>
