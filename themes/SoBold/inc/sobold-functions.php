<?php 

/**
 * _s Additional default theme functions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package _s
 */

 
// Changes footer credits in admin panel

function remove_footer_admin () 
{
    echo '<span id="footer-thankyou">Website Developed by <a href="https://www.sobold.co.uk" target="_blank">SoBold</a></span> | Theme Version 1.3.2';
}
add_filter('admin_footer_text', 'remove_footer_admin');

// Changes howdy text admin panel

function sobold_replace_howdy( $wp_admin_bar ) {
	date_default_timezone_set('Europe/London');
	$Hour = date('G');
	$msg = "";
	if ( $Hour >= 5 && $Hour <= 11 ) {
	    $msg="Good morning,";
	} else if ( $Hour >= 12 && $Hour <= 18 ) {
	    $msg="Good afternoon,";
	} else if ( $Hour >= 19 || $Hours <= 4 ) {
	    $msg="Good evening,";
	}
	$my_account=$wp_admin_bar->get_node('my-account');
	$newtitle = str_replace( 'Howdy,', $msg, $my_account->title );
	$wp_admin_bar->add_node( array(
		'id' => 'my-account',
	 	'title' => $newtitle,
		)
	);
}
add_filter( 'admin_bar_menu', 'sobold_replace_howdy',20 );

add_action('admin_head', 'my_custom_fonts');

function my_custom_fonts() {
  echo '<style>
    #setting-error-tgmpa {
	    border-left-color: #00c1c4;
	}
	#setting-error-tgmpa a {
	    color: #00c1c4;
	    text-decoration: none;
	} 
  </style>';
}

function change_role_name() {
    global $wp_roles;

    if ( ! isset( $wp_roles ) )
        $wp_roles = new WP_Roles();

    //You can replace "administrator" with any other role "editor", "author", "contributor" or "subscriber"...
    $wp_roles->roles['administrator']['name'] = 'SoBold Admin';
    $wp_roles->role_names['administrator'] = 'SoBold Admin';           
}
add_action('init', 'change_role_name');


function filter_editable_roles( $all_roles ) {
  if ( ! is_super_admin( get_current_user_id() ) ) {
    unset( $all_roles['administrator'] );
  }

  return $all_roles;
}

add_filter( 'editable_roles', 'filter_editable_roles' );

add_role('client_admin', __(
    'Client Admin'),
    array(
        'read'              			=> true,
        'publish_posts'     			=> true,
        'edit_posts'        			=> true,
        'delete_posts' 					=> true,
        'edit_published_posts'  		=> true,
        'edit_others_posts' 			=> true,
        'read_private_posts' 			=> true, 
        'edit_private_posts'  			=> true, 
        'delete_private_posts' 			=> true, 
        'manage_categories' 			=> true, 
        'upload_files'  				=> true, 
        'edit_attachments' 				=> true,
        'delete_attachments' 			=> true, 
        'read_others_attachments' 		=> true, 
        'edit_others_attachments'  		=> true, 
        'delete_others_attachments' 	=> true, 
        'publish_pages' 				=> true, 
        'edit_pages' 					=> true, 
        'delete_pages'  				=> true, 
        'edit_published_pages' 			=> true,
        'delete_published_pages' 		=> true, 
        'edit_others_pages' 			=> true, 
        'delete_others_pages'  			=> true, 
        'read_private_pages' 			=> true,
        'edit_private_pages' 			=> true, 
        'delete_private_pages' 			=> true, 
        'moderate_comments'  			=> true, 
        'activate_plugins' 				=> true, 
        'install_plugins' 				=> true, 
        'update_plugins' 				=> true, 
        'list_users'  					=> true, 
        'create_users' 					=> true,
        'unfiltered_html' 				=> true, 
        'manage_links' 					=> true, 
        'level_0' 						=> true, 
        'level_1'  						=> true, 
        'level_2' 						=> true,
        'level_3' 						=> true,
        'level_4' 						=> true, 
        'level_5' 						=> true, 
        'level_6' 						=> true, 
        'level_7'  						=> true, 
        'publish_blocks' 				=> true,
        'edit_blocks' 					=> true, 
        'delete_blocks'  				=> true, 
        'edit_published_blocks' 		=> true,
        'delete_published_blocks' 		=> true,
        'edit_others_blocks' 			=> true, 
        'delete_others_blocks' 			=> true, 
        'read_private_blocks' 			=> true, 
        'edit_private_blocks'  			=> true, 
        'delete_private_blocks' 		=> true, 
        'create_blocks' 				=> true, 
        'read_blocks'  					=> true, 
        'edit_comment' 					=> true, 
    )
);

function remove_dashboard_widgets () {

    remove_meta_box('dashboard_primary','dashboard','side'); //WordPress.com Blog
    remove_meta_box('dashboard_secondary','dashboard','side'); //Other WordPress News
    remove_meta_box('dashboard_quick_press','dashboard','side'); //Quick Press widget

  
}
  
add_action('wp_dashboard_setup', 'remove_dashboard_widgets');
  
if ( is_admin() && isset($_GET['activated'] ) && $pagenow == "themes.php" ) {
    add_action( 'admin_notices', 'my_theme_activation_notice' );
}

function my_theme_activation_notice(){
    ?>
    <div class="updated notice is-dismissible">
        <p><strong>Important!</strong> - Remember to mark the site as non-indexable to search engines when in development.</p>
    </div>
    <?php
}

?>