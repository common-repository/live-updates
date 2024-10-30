<?php
/*
Plugin Name: Live Updates
Plugin URI: http://fov.cc/wordpress-plugins/live-updates/
Description: Live updates for the sidebar
Author: Fov
Version: 1.0.0
Author URI: fov.cc
Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=10766432

*/

//Just some details
$liveupdates_db_version = "1.0.1";
$min_usr_level = 3;  //3 for editor, 10 for admin




/*
==================// Important Info //=======================================

Due to the live update being called by javascript the file messages.php (which 
pulls the data from the database to be updated by the javascript) needs some 
manual config. You need to edit the top part to make thing work.
Dont come crying to me when it doesnt work if you dont set that var!

==================// End of Info //==========================================
*/




function liveupdates_install () {
   global $wpdb;
   global $liveupdates_db_version;
      
   echo $liveupdates_db_version;

   $table_name = $wpdb->prefix . "liveupdates";
   if($wpdb->get_var("show tables like '$table_name'") != $table_name) {
      
      $sql = "CREATE TABLE " . $table_name . " (
	  id mediumint(9) NOT NULL AUTO_INCREMENT,
	  stream mediumint(9) NOT NULL DEFAULT '0',
	  message text NOT NULL,
	  user_login varchar(60) NOT NULL default 'pre v0.02',
	  userid bigint(20) unsigned NOT NULL default '1',
	  UNIQUE KEY id (id)
	);";

      require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
      dbDelta($sql);

      $welcome_text = "Congratulations you just completed the installation of live updates!";
      $usrname = "Fov";
      

      $insert = "INSERT INTO " . $table_name .
            " (message, user_login) " .
            "VALUES ('" . $wpdb->escape($welcome_text) . "','" . $wpdb->escape($usrname) . "')";

      $results = $wpdb->query( $insert );
 
      add_option("liveupdates_db_version", $liveupdates_db_version);
      update_option( "liveupdates_db_version", '1.0.1' );
      
      add_option("liveupdates_ideapad", "");
      
      

   
   }

}


function liveupdates_admin() {
//set some vars
   global $wpdb;
   global $current_user;
   global $liveupdates_db_version;
   global $min_usr_level;
   $table_name = $wpdb->prefix . "liveupdates";
   $installed_ver = get_option( "liveupdates_db_version" );
   $ideas = get_option( "liveupdates_ideapad" );
   
   
   //get and set the user details for later
   get_currentuserinfo();
   $username = $current_user->user_login;
   $userlevel = $current_user->user_level;
   $userid = $current_user->ID;
  
    
//lets fooking update the db as the install action is ghey

   
   if( $installed_ver != $liveupdates_db_version ) {
   echo "<B>Updated db to correct level</b>";

     $sql = "CREATE TABLE " . $table_name . " (
	  id mediumint(9) NOT NULL AUTO_INCREMENT,
	  stream mediumint(9) NOT NULL DEFAULT '0',
	  message text NOT NULL,
	  user_login varchar(60) NOT NULL default 'pre v0.02',
	  userid bigint(20) unsigned NOT NULL default '1',
	  UNIQUE KEY id (id)
	);";


           require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
      dbDelta($sql);

      update_option( "liveupdates_db_version", $liveupdates_db_version );
  }
  



if ($userlevel < $min_usr_level){echo "The cake is a lie";} else { 
if (isset($_POST['liveupdates_submit'])) {
check_admin_referer('liveupdates_admin_post_update');

$insert = "INSERT INTO " . $table_name .
            " (message, user_login, userid) " .
            "VALUES ('" . $wpdb->escape($_POST["message"]) . "','" . $wpdb->escape($username) . "','" . $wpdb->escape($userid) . "')";

      $results = $wpdb->query( $wpdb->prepare($insert));
      
update_option( "liveupdates_ideapad", $_POST["ideapad"] );
}
$ideas = get_option( "liveupdates_ideapad" );

?>
<div class="wrap">  
   <h2>Update!</h2> 
       
     <form name="liveupdates_form" method="post" action="<?php echo $PHP_SELF?>"> 
     <?php
     if ( function_exists('wp_nonce_field') ) 
     	wp_nonce_field('liveupdates_admin_post_update');
     	?>
         <p><?php _e("Update: " ); ?><BR><input type="text" name="message" value="" size="70"></p>  
         <p><?php _e("Idea Pad: " ); ?><BR><textarea name="ideapad" cols="70" rows="6"><?php echo $ideas; ?></textarea></p>  
         <label for="ideapad">The idea pad is for notes and thoughts for upcoming messages. Anything here will be saved as you post a message.</label>
         
      
        <p class="submit">  
        <input type="submit" name="liveupdates_submit" value="submit" />  
        </p>  
     </form>  
</div>


<div class="wrap">

<h2>Last 5 Updates...</h2>
<table class="widefat fluid" cellspacing="0">
	<thead>
	<tr>
    <th scope="col" id="message" class="manage-column" style="">Update</th>
	<th scope="col" id="by" class="manage-column" style="">By</th>
	</tr>
	</thead>
	
	<tfoot>
	<tr>
    <th scope="col" id="message" class="manage-column" style="">Update</th>
	<th scope="col" id="by" class="manage-column" style="">By</th>
	</tr>
	</tfoot>


<?php
		
		
$get = "SELECT `message`,`user_login` FROM " . $table_name . "
ORDER BY `id` DESC
LIMIT 5";

$lastfive = $wpdb->get_results($get);

foreach ($lastfive as $lastfive) {
	echo "<tr><td>";
	echo $lastfive->message;
	echo "</td><td>";
	echo $lastfive->user_login;
	echo "</td></tr>";
}
 
echo "</tbody></table></div>";		
		
		
		}//end user level if
	} //end function
	
	
	
function liveupdates_admin_actions() {
			add_posts_page("Live Updates", "Live Updates", 7, "Live Updates", "liveupdates_admin");
		}



add_action('admin_menu', 'liveupdates_admin_actions');





function liveupdates_headerjs () {
	echo "<script type=\"text/javascript\" src=\"". WP_PLUGIN_URL ."/live-updates/jquery.js\"></script>
	<script type=\"text/javascript\" src=\"". WP_PLUGIN_URL ."/live-updates/updater.js\"></script>

	";
	}

add_action('wp_head', 'liveupdates_headerjs');


function liveupdates_widget_admin() {

  $options_lu_title = get_option("widget_liveupdates");

  if ($_SERVER["REQUEST_METHOD"] == "POST") {

      $options_lu_title = array(

          "lu_title" => $_POST["lu_title"],

     						 );

      update_option("widget_liveupdates", $options_lu_title);

  }
  else {

      ?>

            <p>
                Title:
                <input type="text" name="lu_title" id="lu_title" value="<?php echo $options_lu_title["lu_title"]; ?>" style="width:99%;" />
            </p>

           
      <?php

  }

}

register_widget_control("Live Updates", 'liveupdates_widget_admin');



function LiveUpdates()
{
  echo "<div id=\"loading\"></div><div id=\"messages\">&nbsp;</div>";
}

function widget_LiveUpdates($args) {
 
 $options_lu_title = get_option("widget_liveupdates");
  extract($args);
  echo $before_title;
  echo $options_lu_title["lu_title"];
  echo $after_title;
  LiveUpdates();
}

function Liveupdates_init()
{
  register_sidebar_widget(__('Live Updates'), 'widget_LiveUpdates');    
}
add_action("plugins_loaded", "LiveUpdates_init");
register_activation_hook(__FILE__, 'liveupdates_install');



?> 