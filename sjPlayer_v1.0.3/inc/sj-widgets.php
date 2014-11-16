<?php 

 /**
 * live broadcast widget
 */
 class sj_player_widget_live_stream extends WP_Widget
 {
   
   function __construct()
   {
      
      //widgets params
    $params =array(
        'description' => 'Audio player source',
        'name'        => 'Audio player',
      );

    parent::__construct('sj_player_widget_live_stream','',$params);

   }//construct

   public function form($instance){
   
    //print_r($instance);
     extract($instance);
    ?>

    <p>
        <label for="<?php echo $this->get_field_id('url'); ?>"><?php _e('Audio source:','jsPlayer'); ?> </label>

        <input 
          class="widefat" 
          id="<?php echo $this->get_field_id('url')."_url"; ?>"
          name="<?php echo $this->get_field_name('url'); ?>"
          value="<?php if(isset($url)) echo esc_attr($url) ?>"
        /> 
     </p> 
     <p>
        <input 
        id="<?php //echo uniqid(); 
        echo $this->get_field_id('url');
        ?>"
        type="button" 
        class="button-secondary sj_upload_audio_source"
        value="<?php _e('Upload/select audio','jsPlayer'); ?> " />  
      <br />
        
       
    <p>
        <label for="<?php echo $this->get_field_id('audio_title'); ?>"><?php _e('Audio title','jsPlayer'); ?> </label>
        <input 
          class="widefat" 
          id="<?php echo $this->get_field_id('audio_title'); ?>"
          name="<?php echo $this->get_field_name('audio_title'); ?>"
          value="<?php if(isset($audio_title)) echo esc_attr($audio_title) ?>"
        />

    </p>
     <p>
        <label for="<?php echo $this->get_field_id('audio_description'); ?>"><?php _e('Short description','jsPlayer'); ?> </label>
        <textarea 
          class="widefat" 
          id="<?php echo $this->get_field_id('audio_description'); ?>"
          name="<?php echo $this->get_field_name('audio_description'); ?>"
          ><?php if(isset($audio_description)) echo esc_attr($audio_description) ?>
        </textarea>

    </p>
    <p>
        <label for="<?php echo $this->get_field_id('sj_time_display'); ?>"><?php _e('Show time/duration','jsPlayer'); ?> </label>
        <select 
          class="widefat" 
          id="<?php echo $this->get_field_id('sj_time_display'); ?>"
          name="<?php echo $this->get_field_name('sj_time_display'); ?>">
            <option value="visible" <?php if($sj_time_display=='visible') echo 'selected="selected"'; ?>><?php _e('Visible','jsPlayer'); ?></option>
            <option value="hidden" <?php if($sj_time_display=='hidden') echo 'selected="selected"'; ?>><?php _e('Hidden','jsPlayer'); ?></option>
        </select>

    </p>

    <?php

   }//display form

    public function widget($args, $instance){
         // print_r($args); // wp available options for widget display
          // print_r($instance); // widgets values
         extract($args);
         extract($instance);
      //display widget
      ?>
      <div class="cp-jplayerwidget" >
                  <ul class="sj-player-display">
                    
                   <li class="sj-player-display-player">

                    <!-- ++++++++++++++++++++++++++++ jPlayer ++++++++++++++++++++++++++++ -->

                    <!-- The jPlayer div must not be hidden. Keep it at the root of the body element to avoid any such problems. -->
                    <div id="<?php echo $widget_id; ?>" class="cp-jplayer-live" song="<?php echo $url; ?>" style="width: 100% !important;"></div>

                    <!-- The container for the interface can go where you want to display it. Show and hide it as you need. -->

                    <div id="<?php echo $widget_id; ?>-live" class="cp-container">
                        <div class="cp-buffer-holder"> <!-- .cp-gt50 only needed when buffer is > than 50% -->
                            <div class="cp-buffer-1"></div>
                            <div class="cp-buffer-2"></div>
                        </div>
                        <div class="cp-progress-holder" style="display:none !important;"> <!-- .cp-gt50 only needed when progress is > than 50% -->
                            <div class="cp-progress-1"></div>
                            <div class="cp-progress-2"></div>
                        </div>

                        <div class="cp-circle-control"></div>
                        <ul class="cp-controls">
                            <li><a href="#" class="cp-play" tabindex="1"> </a></li>
                            <li><a href="#" class="cp-pause" style="display:none;" tabindex="1"></a></li> <!-- Needs the inline style here, or jQuery.show() uses display:inline instead of display:block -->
                        </ul>
                        <?php 
                            if ($sj_time_display=='visible'){
                                ?>   
                                <div class="time-duration-holder">               
                                  <div class="jp-current-time"></div>
                                  <div class="jp-duration"></div>
                                  <div class="clearfix" style="clear:both"></div>
                                </div>  
                                <?php    
                             }                          
                          ?>
                    </div>
                    <!-- ++++++++++++++++++++++++++++ jPlayer ++++++++++++++++++++++++++++ -->
                </li>

                    <!-- ++++++++ if vars title and description are not empty display them too++++++++++++++++ -->      
                    <?php 
                      if (!empty($audio_title))
                      {
                        ?>
                            <li class="sj-player-display-title"><p><?php echo $audio_title; ?></p></li>
                        <?php
                      }

                     ?>
                     <?php 
                      if (!empty($audio_description))
                      {
                        ?>
                            <li class="sj-player-display-description"><p><?php echo $audio_description; ?></p></li>
                        <?php
                      }

                     ?>        
                    <!-- ++++++++ /if vars title and description are not empty display them ++++++++++++++++ -->  
                  </ul>
        </div><!-- liveBroadcast -->
      <?php

   }//end of widget func
 }//end of class

add_action('widgets_init', 'call_widget_create_func');

function call_widget_create_func(){
  register_widget('sj_player_widget_live_stream');
 } 

function sjplayer_get_current_and_ref_page() {
    global $pagenow;
    if ( 'media-upload.php' == $pagenow || 'async-upload.php' == $pagenow ) {
        // Now we'll replace the 'Insert into Post Button' inside Thickbox
        add_filter( 'gettext', 'sjPlayer_replace_thickbox_text'  , 1, 3 );

    }


 
}
add_action( 'admin_init', 'sjplayer_get_current_and_ref_page' );

function sjPlayer_replace_thickbox_text($translated_text, $text, $domain) {
    if ('Insert into Post' == $text) {
        $referer = strpos( wp_get_referer(), 'js_plugin_options_ID' );
        if ( $referer != '' ) {
            return __('Add to sjPlayer', 'wptuts' );
        }
    }
    return $translated_text;
}

/*********************************************************************/

add_action( 'admin_init', 'sj_call_widget_media_upload');


function sj_call_widget_media_upload() {
      

      //search for js_plugin_options_ID
      $sj_referer = strpos( wp_get_referer(), 'js_plugin_options_ID' );
      
      //if referer has found searched value start media uplad funcion
      if(!empty($sj_referer))
      { 
        add_filter( 'media_send_to_editor', 'js_widget_send_to_editor',20, 3 );
       }
  }

function js_widget_send_to_editor( $html, $id, $caption ) {
    
     
          $attachment = get_post($id); //fetching attachment by $id passed through
          $src = wp_get_attachment_url( $id );
          $title = $attachment->post_title;
          $description =$attachment->post_content;

          //owerwrite oupte html 
          //this $html var  is sent to javascript send_to_editor 
          $html = '<a href="'.$src.'" alt="'.$description.'">'.$title.'</a>';
          return $html;
         
  }
 ?>