<?php
/**
 * Template Name: Profile
 */
?>

<?php global $current_user;
      get_currentuserinfo();


      $user_id =  $current_user->ID;
      $speciality = get_usermeta( $user_id, 'speciality', $_POST['speciality'] );
      $phone = get_usermeta( $user_id, 'phno', $_POST['phno'] );

?>

<div class="row">

   <div class="col-md-offset-3 col-md-6 form-wrap">

        <form id="form-profile">

        <h2>Edit Your Profile</h2>

        <div class="field-wrap">

            <div class="row">

                <div class="col-md-6">

                    <label for="firstname">First Name *</label>

                    <input type="text" name="firstname" class="pro-firstname mob-btmspace" value="<?php echo $current_user->user_firstname; ?>" />

                </div>

                <div class="col-md-6">

                    <label for="lastname">Last Name</label>

                    <input type="text" name="lastname" class="pro-lastname" value="<?php echo $current_user->user_lastname; ?>"/>

                </div>

            </div>

        </div>

        <div class="field-wrap">

            <label for="speciality">Speciality *</label>

            <?php $catID = get_cat_ID('Speciality'); ?>

            <select name="speciality"  class="pro-speciality">

                <option value="">Select Your Speciality *</option>
                <?php $categories = get_categories(array('child_of' => $catID,));

                foreach ($categories as $category) {

                    if ($speciality == $category->cat_name) { ?>
                        <option value="<?php echo $category->cat_name; ?>" selected >
                    <?php } else { ?>
                        <option value="<?php echo $category->cat_name; ?>" >
                    <?php }

                    echo $category->cat_name; ?>

                    </option>

                <?php } ?>

            </select>

        </div>

        <div class="field-wrap">

            <label for="phoneno">Phone No</label>

            <input type="text" name="phoneno" class="pro-phone" value="<?php echo $current_user->phno; ?>" />

        </div>

        <div class="field-wrap">

            <label for="email">Email *</label>

            <input type="text" name="email" class="pro-email" value="<?php echo $current_user->user_email; ?>" disabled />

        </div>

        <div class="field-wrap">

            <div class="row">

                <div class="col-md-6">

                    <label for="pass">Password</label>

                    <input type="password" name="pass" class="pro-pass mob-btmspace" />

                </div>

                <div class="col-md-6">

                    <label for="confirmpass">Confirm Password</label>

                    <input type="password" name="confirmpass" class="pro-confirmpass" />

                </div>

            </div>

        </div>

        <button name="submit" class="pro-submit">Update</button>

        <div class="ajax-loader"></div>

        <div class="login-error"></div>

        </form>

    </div>

</div>
