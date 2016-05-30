<?php use Roots\Sage\Titles; ?>

<?php if (!is_front_page()) { ?>

    <div class="page-header">

        <div class="container">

            <div class="row">

                <div class="col-xs-12">

                    <?php $type = $_GET['type'];
                    $media = $_GET['media'];

                    if (is_category) {

                        if ($type) { ?>

                            <h1><?php echo str_replace('_', ' ', $type); ?></h1>

                        <?php } elseif ($media) { ?>

                            <h1><?php echo $media; ?></h1>

                        <?php } else { ?>

                            <h1><?= Titles\title(); ?></h1>

                        <?php }

                    } else { ?>

                        <h1><?= Titles\title(); ?></h1>

                    <?php } ?>

                    <div class="breadcrumbs hidden-xs hidden-sm">

                        <?php if(function_exists('bcn_display')) {
                            bcn_display();
                        }?>

                    </div>

                </div>

            </div>

        </div>

    </div>

<?php } ?>
