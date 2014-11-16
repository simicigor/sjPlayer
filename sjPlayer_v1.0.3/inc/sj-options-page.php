<?php 

//add  options sections
function sj_plugin_options_func() {

	add_theme_page(
		'sjPlayer Options', 				// The title to be displayed in the browser window for this page.
		'sjPlayer Options',					// The text to be displayed for this menu item
		'administrator',					// Which type of users can see this menu item
		'sj_plugin_options_ID',				// The unique ID - that is, the slug - for this menu item
		'sj_plugin_display_func'			// The name of the function to call when rendering this menu's page
	);

	add_menu_page(
		'sjPlayer Options',					// The value used to populate the browser's title bar when the menu page is active
		'sjPlayer Options',					// The text of the menu in the administrator's sidebar
		'administrator',					// What roles are able to access the menu
		'sj_plugin_options_ID',				// The ID used to bind submenu items to this menu 
		'sj_plugin_display_func'				// The callback function used to render this menu
	);


	//register settings group
	register_setting('sjplayer-main-settings', 'sjplayer-main-settings');//,'sjplayer_settings_validate_func'


	//add section -> header
	add_settings_section('sjplayer-first-section', 'Main settings', 'sjplayer_section_func', 'sj_plugin_options_ID');
	


	//select size
    add_settings_field('jplayer-player-size',  __( 'Player size', 'sj_plugin_options_ID' ), 'sjplayer_generate_display_size_func', 'sj_plugin_options_ID', 'sjplayer-first-section');

    //select background color
    add_settings_field('jplayer-back-color',  __( 'Background player color', 'sj_plugin_options_ID' ), 'sjplayer_generate_back_color_func', 'sj_plugin_options_ID', 'sjplayer-first-section');

    //select play/duration time font color
    add_settings_field('jplayer-time-color',  __( 'Current time/duration font color', 'sj_plugin_options_ID' ), 'sjplayer_generate_time_color_func', 'sj_plugin_options_ID', 'sjplayer-first-section');

    //select shortcode font color
    add_settings_field('jplayer-shortcode-font-color',  __( 'Shortcode font color', 'sj_plugin_options_ID' ), 'sjplayer_generate_shortcode_color_func', 'sj_plugin_options_ID', 'sjplayer-first-section');

    //select shortcode font color
    add_settings_field('jplayer-widget-font-color',  __( 'Widget font color', 'sj_plugin_options_ID' ), 'sjplayer_generate_widget_color_func', 'sj_plugin_options_ID', 'sjplayer-first-section');

    //set audio title font size
    add_settings_field('jplayer-song-title-font-size',  __( 'Audio title font size', 'sj_plugin_options_ID' ), 'sjplayer_generate_song_title_font_size_func', 'sj_plugin_options_ID', 'sjplayer-first-section');

    //set audio description font size
    add_settings_field('jplayer-song-description-font-size',  __( 'Audio description font size', 'sj_plugin_options_ID' ), 'sjplayer_generate_song_description_font_size_func', 'sj_plugin_options_ID', 'sjplayer-first-section');

    //set audio time font size
    add_settings_field('jplayer-song-time-font-size',  __( 'Audio time font size', 'sj_plugin_options_ID' ), 'sjplayer_generate_song_time_font_size_func', 'sj_plugin_options_ID', 'sjplayer-first-section');
 

    /*add admin css parameters for colorpicker*/
    function custom_colors() {
	   echo '<style type="text/css">
	           .sj_player_color_box{margin-left:140px; height: 24px; width:26px;border-radius:5px;}
	           .sjplayer-colorpicker{cursor:pointer;}
	         </style>';
	}

	add_action('admin_head', 'custom_colors');
	/*generate display site option*/
	function sjplayer_generate_display_size_func(){

		$sjplayer_options = get_option( 'sjplayer-main-settings' ); 
   	  
 			?>
			<select 
          		id="sjplayer-main-settings[sj-player-size]"
          		name="sjplayer-main-settings[sj-player-size]">
            	<option value="small" <?php if($sjplayer_options['sj-player-size']=='small') echo 'selected="selected"'; ?>><?php _e('Small','jsPlayer'); ?></option>
            	<option value="medium" <?php if($sjplayer_options['sj-player-size']=='medium') echo 'selected="selected"'; ?>><?php _e('Medium','jsPlayer'); ?></option>
        	    <option value="normal" <?php if($sjplayer_options['sj-player-size']=='normal') echo 'selected="selected"'; ?>><?php _e('Normal','jsPlayer'); ?></option>

        	</select>
        	<span class="description">Player comes in three different sizes: small,medium and normal. Please choose one that best fit your theme!</span>
        	<?php
      
	}/*sjplayer_generate_display_size_func*/

	function sjplayer_generate_back_color_func(){
		$sjplayer_options = get_option( 'sjplayer-main-settings' ); 
		?>

		<input type="text" id="sj_player_back_color" style="float:left;"  class="sjplayer-colorpicker" style="background-color:<?php echo $sjplayer_options['sj-player-back-color']; ?>" name="sjplayer-main-settings[sj-player-back-color]" value="<?php echo $sjplayer_options['sj-player-back-color']; ?>" />
		<div class="sj_player_color_box" style="background-color:<?php echo $sjplayer_options['sj-player-back-color']; ?>;"></div>

		<span class="description">Player progress bar color and color of play/pause button on mouseover state</span>
		<?php
	}/*sjplayer_generate_back_color_func*/	

	function sjplayer_generate_time_color_func(){
		$sjplayer_options = get_option( 'sjplayer-main-settings' ); 
		?>

		<input type="text" id="sj_player_time_color" class="sjplayer-colorpicker" style="float:left;" name="sjplayer-main-settings[sj-player-time-color]" value="<?php echo $sjplayer_options['sj-player-time-color']; ?>" />
		
		<div class="sj_player_color_box" style=" background-color:<?php echo $sjplayer_options['sj-player-time-color']; ?>;  "></div>

		<span class="description">Text color of played time and duration info</span>
		<?php
	}/*sjplayer_generate_time_color_func*/

	function sjplayer_generate_shortcode_color_func(){
		$sjplayer_options = get_option( 'sjplayer-main-settings' ); 
		?>

		<input type="text" id="sj_player_shortcode_color" class="sjplayer-colorpicker"  style="float:left;" name="sjplayer-main-settings[sj_player_shortcode_color]" value="<?php echo $sjplayer_options['sj_player_shortcode_color']; ?>" />
		<div class="sj_player_color_box" style=" background-color:<?php echo $sjplayer_options['sj_player_shortcode_color']; ?>; "></div>

		<span class="description">Text color of title and description bellow the player, when player is added as <strong>shortcode</strong> (in post or page)</span>  
		<?php
	}/*sjplayer_generate_shortcode_color_func*/

	function sjplayer_generate_widget_color_func(){
		$sjplayer_options = get_option( 'sjplayer-main-settings' ); 
		?>

		<input type="text" id="sj_player_widget_color" class="sjplayer-colorpicker"  style="float:left;" name="sjplayer-main-settings[sj_player_widget_color]" value="<?php echo $sjplayer_options['sj_player_widget_color']; ?>" />
		<div class="sj_player_color_box" style="background-color:<?php echo $sjplayer_options['sj_player_widget_color']; ?>;"></div>
		<span class="description">Text color of title and description bellow the player, when player is added as <strong>widget</strong> (in post or page)</span>  
		<?php
	}/*sjplayer_generate_shortcode_color_func*/

	
	//song title font size
	function sjplayer_generate_song_title_font_size_func(){
		$sjplayer_options = get_option( 'sjplayer-main-settings' );
		?>
		<input
            type="number" 
            class="widefat" 
            style="width:40px;" 
            id="sjplayer-main-settings[sj-player-title-font-size]"
            name="sjplayer-main-settings[sj-player-title-font-size]" 
            min="1" 
            max="30" 
            value="<?php echo $sjplayer_options['sj-player-title-font-size']; ?>" />
            <span class="description">Audio title font size in pixels</span>  

        <?php
	}/*sjplayer_generate_song_title_font_size_func*/

	//song description font size
	function sjplayer_generate_song_description_font_size_func(){
		$sjplayer_options = get_option( 'sjplayer-main-settings' );
		?>
		<input
            type="number" 
            class="widefat" 
            style="width:40px;" 
            id="sjplayer-main-settings[sj-player-description-font-size]"
            name="sjplayer-main-settings[sj-player-description-font-size]" 
            min="1" 
            max="30" 
            value="<?php echo $sjplayer_options['sj-player-description-font-size']; ?>" />
            <span class="description">Audio description font size in pixels</span>  

        <?php
	}/*sjplayer_generate_song_description_font_size_func*/

	//song time font size
	function sjplayer_generate_song_time_font_size_func(){
		$sjplayer_options = get_option( 'sjplayer-main-settings' );
		?>
		<input
            type="number" 
            class="widefat" 
            style="width:40px;" 
            id="sjplayer-main-settings[sj-player-time-font-size]"
            name="sjplayer-main-settings[sj-player-time-font-size]" 
            min="1" 
            max="30" 
            value="<?php echo $sjplayer_options['sj-player-time-font-size']; ?>" />
            <span class="time">Audio time/duration font size in pixels</span>  

        <?php
	}/*sjplayer_generate_song_time_font_size_func*/

	//add settings function cb
    function sjplayer_section_func(){

    	/*emptyyy*/
    }


//display options content

function sj_plugin_display_func(){
	?>
	<div class="wrap">

		<?php screen_icon('themes');  //USE THIS OR LINE ABOVE ?>

		<h2><?php _e( 'sjPlayer Options','sjPlayer'); ?></h2>

		<!-- If we have any error by submiting the form, they will appear here -->
		<?php settings_errors( 'sjPlayerOptions-settings-errors' ); ?>

		<form id="form-sjplayer-options" action="options.php" method="post" enctype="multipart/form-data">

				<!-- Header Settings <div class="adminSectionToggleButton ">| x |</div> -->
				<!-- Header settings -->
				<div class="sidebar-name">
					<div class="sidebar-name-arrow">
						<br>
					</div>
						<h3>Main settings</h3>
					</div>
				<div id="sjplayer-header-settings-section" class="adminToggleSection">

					<?php
						settings_fields('sjplayer-main-settings');
						do_settings_sections('sj_plugin_options_ID');
					?>
				</div><!-- crc-header-settings-section -->

				 

				<p class="submit">
					<input name="sjplayer-main-settings[submit]" id="submit_options_form" type="submit" class="button-primary" value="<?php esc_attr_e('Save Settings', 'sjplayer-first-section'); ?>" />
 				</p>

			</form>

	</div> <!-- class wrap -->
	<?php
	}// sj_plugin_display_func
}// end sj_plugin_options_func


//atach to hook
add_action( 'admin_menu', 'sj_plugin_options_func' );