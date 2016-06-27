<?php

	/*
	Plugin Name: Simple Post Manager
	Description: Delete All Post
	Author: Ugur Gunes
	Version: 0.1
	Tags: drafts, posts
	*/

// ░░░░░░░░░░░░░░░░░░░░░░█████████░░░░░░░░░
// ░░███████░░░░░░░░░░███▒▒▒▒▒▒▒▒███░░░░░░░
// ░░█▒▒▒▒▒▒█░░░░░░░███▒▒▒▒▒▒▒▒▒▒▒▒▒███░░░░
// ░░░█▒▒▒▒▒▒█░░░░██▒▒▒▒▒▒▒▒▒▒▒▒▒▒▒▒▒▒▒██░░
// ░░░░█▒▒▒▒▒█░░░██▒▒▒▒▒██▒▒▒▒▒▒██▒▒▒▒▒███░
// ░░░░░█▒▒▒█░░░█▒▒▒▒▒▒████▒▒▒▒████▒▒▒▒▒▒██
// ░░░█████████████▒▒▒▒▒▒▒▒▒▒▒▒▒▒▒▒▒▒▒▒▒▒██
// ░░░█▒▒▒▒▒▒▒▒▒▒▒▒█▒▒▒▒▒▒▒▒▒█▒▒▒▒▒▒▒▒▒▒▒██
// ░██▒▒▒▒▒▒▒▒▒▒▒▒▒█▒▒▒██▒▒▒▒▒▒▒▒▒▒██▒▒▒▒██
// ██▒▒▒███████████▒▒▒▒▒██▒▒▒▒▒▒▒▒██▒▒▒▒▒██
// █▒▒▒▒▒▒▒▒▒▒▒▒▒▒▒█▒▒▒▒▒▒████████▒▒▒▒▒▒▒██
// ██▒▒▒▒▒▒▒▒▒▒▒▒▒▒█▒▒▒▒▒▒▒▒▒▒▒▒▒▒▒▒▒▒▒▒██░
// ░█▒▒▒███████████▒▒▒▒▒▒▒▒▒▒▒▒▒▒▒▒▒▒▒██░░░
// ░██▒▒▒▒▒▒▒▒▒▒████▒▒▒▒▒▒▒▒▒▒▒▒▒▒▒▒▒█░░░░░
// ░░████████████░░░█████████████████░░░░░░
add_action('admin_menu', 'spm_SimplePostManager');

// Here you can check if plugin is configured (e.g. check if some option is set). If not, add new hook. 
// In this example hook is always added.

	defined( 'ABSPATH' ) || exit;
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
						</form>
						This button deletes all post
					</td>
				</tr>
			</table>
		</div>
	</div>

	<?php
					if(isset($_POST['postdraft'])){
						include("../wp-load.php");
						$args = array('fields' => 'id=>post_status','numberposts' => -1);
						$the_query = get_posts( $args );
						if(!$the_query){
							echo "no published post";
						}
						foreach($the_query as $post){
						  $my_post = array();
						  $my_post['ID'] = $post->ID;
						  $my_post['post_status'] = 'draft';
						  $ekle=wp_update_post( $my_post );
						 if($ekle){echo "Successfully updated<br>";}	 
						 else{echo "update failed";} 
						}
					}
					if(isset($_POST['postdelete'])){
						include("../wp-load.php");
						$args = array('fields' => 'id=>post_status');
						$the_query = get_posts( $args );
						if(!$the_query)
						{
							echo "no published post";
						}
						foreach($the_query as $post)
						{
						  $delete= wp_delete_post($post->ID,true);
						 if($delete){echo "Successfully updated<br>";}	 
						 else{echo "delete failed";}
						}				
					}
					?>					
	 <div class="wrap">
		<div class="card pressthis">	
			<center><h3>Comming Soon</h3></center>	
		<img style="height: 100px; width: 520px;" src="http://www.zwani.com/graphics/animated/images/5animated203.gif" alt="Simple Post manager"  title="Simple Post Manager"/>
		</div>
	</div>									
<?php
}
	


