<?php

	/*
	Plugin Name: Simple Post Manager
	Description: Delete All Post
	Author: Ugur Gunes
	Version: 0.1
	Tags: drafts, posts
	*/

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if access directly
add_action('admin_menu', 'spm_SimplePostManager');

// Here you can check if plugin is configured (e.g. check if some option is set). If not, add new hook. 
// In this example hook is always added.


function spm_SimplePostManager() {
	// Add the new admin menu and page and save the returned hook suffix
	$hook_suffix = add_posts_page('Simple Post Manager', 'Simple Post Manager', 'manage_options', 'spm_SimplePostManager', 'spm_SimplePostManager_options');
	// Use the hook suffix to compose the hook and register an action executed when plugin's options page is loaded
}
function spm_SimplePostManager_options() {
	if (!current_user_can('manage_options'))  
	{
		wp_die( __('You do not have sufficient permissions to access this page.') );
	}

	?>
	<div class="wrap">
		<div class="card pressthis">	
			<center><h3>Simple Post Manager v0.1</h3></center>	
			<table class="form-table">
				<tr valign="top">
					<th scope="row">Change all post to draft</th>
					<td>
						<form method="post">
							<?php  wp_nonce_field( 'postdraft_action', 'postdraft_nonce' ); ?>	
							<input type="submit" class="button-primary" name="postdraft" value="Apply"/>			
						</form>
						All Post => (post_status=>'Draft')
					</td>
				</tr>
				<tr valign="top">
					<th scope="row">Delete All Post</th>
					<td>
						<form method="post">
							<input type="submit" class="button-primary" name="postdelete" value="Apply"/>
							<?php wp_nonce_field( 'postdelete_action', 'postdelete_nonce' ); ?>		
						</form>
						This button deletes all post
					</td>
				</tr>
			</table>
		</div>
	</div>

<?php
	if( current_user_can( 'administrator' ) ){
		if(isset($_POST['postdraft'])){
				if (check_admin_referer( 'postdraft_action', 'postdraft_nonce' ) && wp_verify_nonce($_POST['postdraft_nonce'], 'postdraft_action') ){
			
			$args = array('fields' => 'id=>post_status','numberposts' => -1);
			$the_query = get_posts( $args );

				if(!$the_query){echo "no published post";}
					foreach($the_query as $post){
					  $my_post = array();
					  $my_post['ID'] = $post->ID;
					  $my_post['post_status'] = 'draft';
					  $ekle=wp_update_post( $my_post );

						 if($ekle){echo "Successfully updated<br>";}	 
						 else{echo "update failed";} 
						 
					}

			    }//end check_admin...
		}//end İsset($_POst..

		if(isset($_POST['postdelete'])){
			if (check_admin_referer( 'postdelete_action', 'postdelete_nonce' ) && wp_verify_nonce($_POST['postdelete_nonce'], 'postdelete_action') ){
				$args = array('fields' => 'id=>post_status','numberposts' => -1);
				$the_query = get_posts( $args );

				if(!$the_query){echo "no published post";}

				foreach($the_query as $post){
				 $delete= wp_delete_post($post->ID,true);	

					 if($delete){echo "Successfully deleted<br>";}	 
					 else{echo "delete failed";}
				}//end foreach

			}//end if (check_admin_refe			
		}//end if(isset($_POST['po


	}//end current_user_can
?>					
	 <div class="wrap">
		<div class="card pressthis">	
			<center><h3>Click And Enjoy</h3></center>	
		</div>
	</div>									
<?php
}//spm_SimplePostManager_options
	
?>

