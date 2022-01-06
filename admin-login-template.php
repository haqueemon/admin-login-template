<?php
/*
Plugin Name: Admin Login Template
Plugin URI: https://github.com/haqueemon/admin-login-template
Description: Change wp-admin login/forgot-password layout. Also you can change dynamically all the lebels of login/forgot-password form by install this plugin.
Version: 1.0.0
Author: Enamul Haque Emon
Author URI: https://www.fiverr.com/emon7_7_7
License: GPl V2
Text Domain: admin-login-template
*/


function alt_load_textdomain(){
	load_plugin_textdomain('admin-login-template',false,dirname(__FILE__)."/languages");
}
add_action('plugins_loaded','alt_load_textdomain');


function alt_admin_load_assets(){
	wp_enqueue_media();
	wp_enqueue_style( 'alt-main-css',plugin_dir_url(__FILE__).'assets/admin/css/alt-main.css', null, time() );
	wp_enqueue_script('alt-main-js',plugin_dir_url(__FILE__).'assets/admin/js/alt-main.js',array('jquery'),time(),true);
    wp_localize_script('alt-main-js', 'alt', array(
        'sl' => __('Select Logo', 'admin-login-template'),
        'il' => __('Insert Logo', 'admin-login-template'),
    ));

}
add_action('admin_enqueue_scripts','alt_admin_load_assets');


function alt_dynamic_css_data() {

    $alt_logo_url = get_option('alt_logo_url');
    $alt_backlog_visibility = get_option('alt_backlog_visibility'); ?>

    <style type="text/css">
        <?php if(!empty($alt_logo_url)){ ?>
        #login h1 a, .login h1 a {background-image: url(<?php echo $alt_logo_url; ?>);}
        <?php } ?>
        <?php if($alt_backlog_visibility==="No"){ ?>
        #backtoblog{display: none;}
        <?php } ?>
    </style>

<?php }
add_action( 'login_enqueue_scripts', 'alt_dynamic_css_data' );

function alt_login_stylesheet() {
    $alt_template = get_option('alt_template');
    if($alt_template==="1"){
        wp_enqueue_style( 'admin-login-template-css-t1', plugin_dir_url(__FILE__). 'assets/front/css/alt-t1.css' );
    }else if($alt_template==="2"){
        wp_enqueue_style( 'admin-login-template-css-t2', plugin_dir_url(__FILE__). 'assets/front/css/alt-t2.css' );
    }
    wp_enqueue_script( 'admin-login-template-js', plugin_dir_url(__FILE__). 'assets/front/js/alt-login.js',['jquery'],true );
}
add_action( 'login_enqueue_scripts', 'alt_login_stylesheet' );



function alt_admin_menu_func(){
	add_menu_page(
		__('Admin Login Template','admin-login-template'),
		__('Admin Login Template','admin-login-template'),
		'manage_options',
		'admin-login-template',
		'alt_admin_page_callback'
	);
}
add_action('admin_menu','alt_admin_menu_func');


function alt_admin_page_callback(){
?>


    <div class="alt-form-wrapper">

        <?php if(isset($_GET['status']) && (sanitize_text_field($_GET['status'])==='success') ){ ?>
            <div class="notice notice-success is-dismissible"> 
                <p><strong><?php _e('Saved successfully!','admin-login-template'); ?></strong></p>
            </div>
        <?php } ?>
        <?php if(isset($_GET['status']) && (sanitize_text_field($_GET['status'])==='error') ){ ?>
            <div class="notice notice-error is-dismissible"> 
                <p><strong><?php _e('Unauthorized access!','admin-login-template'); ?></strong></p>
            </div>
        <?php } ?>
        <?php if(isset($_GET['status']) && (sanitize_text_field($_GET['status'])==='permission-error') ){ ?>
            <div class="notice notice-error is-dismissible"> 
                <p><strong><?php _e('Sorry! You have no permission to edit!','admin-login-template'); ?></strong></p>
            </div>
        <?php } ?>

        <div class="alt-form-title">
            <h4><?php _e('Admin Login Template Options', 'admin-login-template'); ?></h4>
            <h5><?php _e('Make your admin login page more attractive by changing any labels or content from your login form.', 'admin-login-template'); ?></h5>
        </div>

        <div class='alt-form-container'>
            <div class="alt-form">
                <form action='<?php echo esc_url(admin_url('admin-post.php')); ?>' class='alt-form alt-form-aligned' method='POST'>
                    <fieldset>

						<input type="hidden" name="action" value="alt_form">
						<?php wp_nonce_field('alt_form', 'alt_form_nonce'); ?>

                        <div class='alt-control-group'>
                            
							<label for='alt-logo-url' style="float: left;"><a href="javascript:void(0);" class="button" id="upload_image"><?php _e('Upload Logo', 'admin-login-template'); ?></a></label>
							<input type="hidden" name="alt_logo_url" id="alt-logo-url" value="<?php echo get_option('alt_logo_url'); ?>" />
							<div id="alt-logo-container"></div>

                        </div>

                        <div class='alt-control-group'>
                            <label for='alt_username'><?php _e('Username or Email Address', 'admin-login-template'); ?></label>
                            <input class='alt-control' name='alt_username' id='alt_username' type='text' placeholder='<?php _e('Username/Email Label', 'admin-login-template'); ?>' value='<?php echo get_option('alt_username'); ?>'>
                        </div>

                        <div class='alt-control-group'>
                            <label for='alt_logo_click_url'><?php _e('Logo href URL', 'admin-login-template'); ?></label>
                            <input class='alt-control' name='alt_logo_click_url' id='alt_logo_click_url' type='text' placeholder='<?php echo home_url(); ?>' value='<?php echo get_option('alt_logo_click_url'); ?>'>
                        </div>


                        <div class='alt-control-group'>
                            <label for='alt_password'><?php _e('Password Label', 'admin-login-template'); ?></label>
                            <input class='alt-control' name='alt_password' id='alt_password' type='text' placeholder='<?php _e('Password', 'admin-login-template'); ?>' value='<?php echo get_option('alt_password'); ?>'>
                        </div>

                        <div class='alt-control-group'>
                            <label for='alt_button'><?php _e('Button Label', 'admin-login-template'); ?></label>
                            <input class='alt-control' name='alt_button' id='alt_button' type='text' placeholder='<?php _e('Login', 'admin-login-template'); ?>' value='<?php echo get_option('alt_button'); ?>'>
                        </div>

                        <div class='alt-control-group'>
                            <label for='alt_remember_button'><?php _e('Remember Label', 'admin-login-template'); ?></label>
                            <input class='alt-control' name='alt_remember_button' id='alt_remember_button' type='text' placeholder='<?php _e('Remember Me', 'admin-login-template'); ?>' value='<?php echo get_option('alt_remember_button'); ?>'>
                        </div>

                        <div class='alt-control-group'>
                            <label for='alt_lost_password'><?php _e('Lost Password Label', 'admin-login-template'); ?></label>
                            <input class='alt-control' name='alt_lost_password' id='alt_lost_password' type='text' placeholder='<?php _e('Lost your password?', 'admin-login-template'); ?>' value='<?php echo get_option('alt_lost_password'); ?>'>
                        </div>

                        <div class='alt-control-group'>
                            <label for='alt_success'><?php _e('Logout Success Label', 'admin-login-template'); ?></label>
                            <input class='alt-control' name='alt_success' id='alt_success' type='text' placeholder='<?php _e('You are now logged out.', 'admin-login-template'); ?>' value='<?php echo get_option('alt_success'); ?>'>
                        </div>

                        <div class='alt-control-group'>
                            <label for='alt_username_error'><?php _e('Invalid Username Label', 'admin-login-template'); ?></label>
                            <input class='alt-control' name='alt_username_error' id='alt_username_error' type='text' placeholder='<?php _e('Invalid username', 'admin-login-template'); ?>' value='<?php echo get_option('alt_username_error'); ?>'>
                        </div>

                        <div class='alt-control-group'>
                            <label for='alt_password_error'><?php _e('Incorrect Password Label', 'admin-login-template'); ?></label>
                            <input class='alt-control' name='alt_password_error' id='alt_password_error' type='text' placeholder='<?php _e('Incorrect Password', 'admin-login-template'); ?>' value='<?php echo get_option('alt_password_error'); ?>'>
                        </div>

                        <div class='alt-control-group'>
                            <label for='alt_empty_username'><?php _e('Empty Username Label', 'admin-login-template'); ?></label>
                            <input class='alt-control' name='alt_empty_username' id='alt_empty_username' type='text' placeholder='<?php _e('Please Enter Valid Username', 'admin-login-template'); ?>' value='<?php echo get_option('alt_empty_username'); ?>'>
                        </div>

                        <div class='alt-control-group'>
                            <label for='alt_empty_password'><?php _e('Empty Password Label', 'admin-login-template'); ?></label>
                            <input class='alt-control' name='alt_empty_password' id='alt_empty_password' type='text' placeholder='<?php _e('Please Enter Correct Password', 'admin-login-template'); ?>' value='<?php echo get_option('alt_empty_password'); ?>'>
                        </div>

                        <div class='alt-control-group'>
                            <label for='alt_template'><?php _e('Choose Template', 'admin-login-template'); ?></label>
                            <?php $template = get_option('alt_template'); ?>
                            <select class='alt-control' name='alt_template' id='alt_template' required>
                                <option value="0" <?php if($template==0){echo 'selected';} ?> ><?php _e('Default', 'admin-login-template'); ?></option>
                                <option value="1" <?php if($template==1){echo 'selected';} ?> ><?php _e('Black Template', 'admin-login-template'); ?></option>
                                <option value="2" <?php if($template==2){echo 'selected';} ?> ><?php _e('Background Image Template', 'admin-login-template'); ?></option>
                            </select>
                        </div>

                        <div class='alt-control-group'>
                            <label for='alt_backlog_visibility'><?php _e('Backlog Visibility', 'admin-login-template'); ?></label>
                            <?php $alt_backlog = get_option('alt_backlog_visibility'); ?>
                            <select class='alt-control' name='alt_backlog_visibility' id='alt_backlog_visibility' required>
                                <option value="No" <?php if($alt_backlog=="No"){echo 'selected';} ?> ><?php _e('No', 'admin-login-template'); ?></option>
                                <option value="Yes" <?php if($alt_backlog=="Yes"){echo 'selected';} ?> ><?php _e('Yes', 'admin-login-template'); ?></option>
                            </select>
                        </div>

                        <div class='alt-control-group' style='margin-top:20px;'>
                            <label></label>
                            <button type='submit' name='submit' class='button button-primary button-hero'>
                                <?php _e('Save', 'admin-login-template'); ?>
                            </button>
                        </div>

                    </fieldset>
                </form>
            </div>

            <div class="alt-info"></div>
            <div class="alt-clearfix"></div>
        </div>
    </div>

<?php
}

function alt_form_submit_func(){


	if(isset($_POST['submit'])){

        if(current_user_can('manage_options')){
            $nonce = sanitize_text_field($_POST['alt_form_nonce']);
            if(wp_verify_nonce($nonce,'alt_form')){

                $alt_logo_click_url = isset($_POST['alt_logo_click_url']) ? sanitize_text_field($_POST['alt_logo_click_url']) : "";
                $alt_backlog_visibility = isset($_POST['alt_backlog_visibility']) ? sanitize_text_field($_POST['alt_backlog_visibility']) : "";
                $alt_logo_url = isset($_POST['alt_logo_url']) ? sanitize_text_field($_POST['alt_logo_url']) : "";
                $alt_logo_url = isset($_POST['alt_logo_url']) ? sanitize_text_field($_POST['alt_logo_url']) : "";
                $alt_username = isset($_POST['alt_username']) ? sanitize_text_field($_POST['alt_username']) : "";
                $alt_password = isset($_POST['alt_password']) ? sanitize_text_field($_POST['alt_password']) : "";
                $alt_button = isset($_POST['alt_button']) ? sanitize_text_field($_POST['alt_button']) : "";
                $alt_remember_button = isset($_POST['alt_remember_button']) ? sanitize_text_field($_POST['alt_remember_button']) : "";
                $alt_lost_password = isset($_POST['alt_lost_password']) ? sanitize_text_field($_POST['alt_lost_password']) : "";
                $alt_success = isset($_POST['alt_success']) ? sanitize_text_field($_POST['alt_success']) : "";
                $alt_username_error = isset($_POST['alt_username_error']) ? sanitize_text_field($_POST['alt_username_error']) : "";
                $alt_password_error = isset($_POST['alt_password_error']) ? sanitize_text_field($_POST['alt_password_error']) : "";
                $alt_empty_username = isset($_POST['alt_empty_username']) ? sanitize_text_field($_POST['alt_empty_username']) : "";
                $alt_empty_password = isset($_POST['alt_empty_password']) ? sanitize_text_field($_POST['alt_empty_password']) : "";
                $alt_template = isset($_POST['alt_template']) ? sanitize_key($_POST['alt_template']) : 0;

                update_option('alt_logo_click_url',$alt_logo_click_url);
                update_option('alt_backlog_visibility',$alt_backlog_visibility);
                update_option('alt_logo_url',$alt_logo_url);
                update_option('alt_username',$alt_username);
                update_option('alt_password',$alt_password);
                update_option('alt_button',$alt_button);
                update_option('alt_remember_button',$alt_remember_button);
                update_option('alt_lost_password',$alt_lost_password);
                update_option('alt_success',$alt_success);
                update_option('alt_username_error',$alt_username_error);
                update_option('alt_password_error',$alt_password_error);
                update_option('alt_empty_username',$alt_empty_username);
                update_option('alt_empty_password',$alt_empty_password);
                update_option('alt_template',$alt_template);

                $status = 'success';

            }else{
                $status = 'error';
            }
        }else{
            $status = 'permission-error';
        }

		wp_safe_redirect(
			esc_url_raw(
				add_query_arg('status', $status, admin_url('admin.php?page=admin-login-template'))
			)
		);
	}

}
add_action('admin_post_alt_form','alt_form_submit_func');


function alt_change_label_func(){
	add_filter('gettext', function( $new_text, $old_text, $textdomain ){

    	$alt_username = get_option('alt_username');
    	$alt_password = get_option('alt_password');
    	$alt_button = get_option('alt_button');
    	$alt_remember_button = get_option('alt_remember_button');
    	$alt_lost_password = get_option('alt_lost_password');

        if ( ('Username or Email Address' == $old_text) && (!empty($alt_username)) ) {
            $new_text = $alt_username;
        }else if ( ('Password' == $old_text) && (!empty($alt_password)) ) {
            $new_text = $alt_password;
        }else if ( ('Log In' == $old_text) && (!empty($alt_button)) ) {
            $new_text = $alt_button;
        }else if ( ('Remember Me' == $old_text) && (!empty($alt_remember_button)) ) {
            $new_text = $alt_remember_button;
        }else if ( ('Lost your password?' == $old_text) && (!empty($alt_lost_password)) ) {
            $new_text = $alt_lost_password;
        }

		return $new_text;
	}, 10, 3);
}
add_action('login_head','alt_change_label_func');


function alt_login_logo_url() {
    $alt_logo_click_url = get_option('alt_logo_click_url');
    if(!empty($alt_logo_click_url)){
        return $alt_logo_click_url;
    }else{
        return home_url();
    }
}
add_filter( 'login_headerurl', 'alt_login_logo_url' );


function alt_login_logo_url_title() {
    return get_bloginfo('name');
}
add_filter( 'login_headertext', 'alt_login_logo_url_title' );


function alt_custom_messages( $errors ){

	$alt_success = get_option('alt_success');
	$alt_username_error = get_option('alt_username_error');
	$alt_password_error = get_option('alt_password_error');
	$alt_empty_username = get_option('alt_empty_username');
	$alt_empty_password = get_option('alt_empty_password');

    if ( isset( $errors->errors['loggedout'] ) && !empty($alt_success) ){
        $errors->errors['loggedout'][0] = __($alt_success,'alt');
    }

    if ( isset( $errors->errors['invalid_username'] ) && !empty($alt_username_error) ){
        $errors->errors['invalid_username'][0] = __($alt_username_error,'alt');
    }

    if ( isset( $errors->errors['incorrect_password'] ) && !empty($alt_password_error) ){
        $errors->errors['incorrect_password'][0] = __($alt_password_error,'alt');
    }


    if ( isset( $errors->errors['empty_username'] ) && !empty($alt_empty_username) ){
        $errors->errors['empty_username'][0] = __($alt_empty_username,'alt');
    }

    if ( isset( $errors->errors['empty_password'] ) && !empty($alt_empty_password) ){
        $errors->errors['empty_password'][0] = __($alt_empty_password,'alt');
    }

    return $errors;
}
add_filter( 'wp_login_errors', 'alt_custom_messages' );
