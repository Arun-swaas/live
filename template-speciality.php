<?php
/**
 * Template Name: Speciality
 */
?>

<div class="row">

   <div class="col-xs-12 mob-speciality">

       <ul>
            <?php $catID = get_cat_ID('Speciality');
            $categories = get_categories(array('child_of' => $catID,));

            foreach ($categories as $category) {

               echo '<li><a href="' . add_query_arg( array("cat" => $category->term_id), get_category_link( $category->term_id ) ) . '">';
               echo $category->cat_name;
               echo ' ('.$category->category_count.')';
               echo '</a></li>';
           } ?>

       </ul>

    </div>

</div>
