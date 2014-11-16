<?php 

/*
Plugin Name: sjPlayer
Plugin URI: http://s-coder.com/jplayer-circle-player-wordpress-plugin/
Description: Audio player(mp3 & m4a) based on Circular jPlayer 
Version: 1.0.3
Author: s-coder
Author URI: http://s-coder.com
*/


/* ++++++++++++++++++++++++ Check WP version +++++++++++++++++++++++ */
 global $wp_version;
 if(!version_compare($wp_version,'3.0','>='))
 {
 	die('You need at least Wordpress 3.0 to use jsPlayer plugin');
 }
/* ++++++++++++++++++++++++ /Check WP version ++++++++++++++++++++++++ */


 //create options page and settings
include('inc/sj-options-page.php');

 //create widgets
include('inc/sj-widgets.php');

 //create shortcode
include('inc/sj-shortcode.php');



/* ++++++++++++++++++++++++ include js & css files +++++++++++++++++++++++ */

//include css & java script
 
 $sjplayer_options = get_option( 'sjplayer-main-settings');
function sj_load_scripts($sjplayer_options){
    
     //wp_enqueue_script('jquery');
     
     /*++++++++++++++++++++++++++++ jplayer ++++++++++++++++++++++++++++ */
      
     wp_register_script('sjqueryPlayer', plugin_dir_url(__FILE__).'js/jquery.jplayer.min.js',array('jquery'));
     wp_enqueue_script('sjqueryPlayer');
     wp_register_script('sjtransform', plugin_dir_url(__FILE__).'js/jquery.transform.js',array('jquery'));
     wp_enqueue_script('sjtransform');
     wp_register_script('sjgrab', plugin_dir_url(__FILE__).'js/jquery.grab.js',array('jquery'));
     wp_enqueue_script('sjgrab');
     wp_register_script('sjcsstransforms', plugin_dir_url(__FILE__).'js/mod.csstransforms.min.js',array('jquery'));
     wp_enqueue_script('sjcsstransforms');
     wp_register_script('sjcplayer', plugin_dir_url(__FILE__).'js/circle.player.js',array('jquery'));
     wp_enqueue_script('sjcplayer');
     
     /*++++++++++++++++++++++++++++ /jplayer ++++++++++++++++++++++++++++ */

     //register and include sjscript.js
	 wp_register_script('sjScript', plugin_dir_url(__FILE__).'js/sjscript.js',array('jquery'));
     wp_enqueue_script('sjScript');

     
    //register and include sjstyle.css
     wp_register_style('sjStyle',plugin_dir_url(__FILE__).'css/sjstyle.css');
	 wp_enqueue_style('sjStyle' );
        
        $sjplayer_options = get_option( 'sjplayer-main-settings');
         if($sjplayer_options['sj-player-size']=="small"){
            wp_register_style('sjSkin',plugin_dir_url(__FILE__).'skin/circle.skin.half/circle.player.css');

          }elseif($sjplayer_options['sj-player-size']=="medium"){
            wp_register_style('sjSkin',plugin_dir_url(__FILE__).'skin/circle.skin.medium/circle.player.css');

        }else{
            wp_register_style('sjSkin',plugin_dir_url(__FILE__).'skin/circle.skin/circle.player.css');

        }
     wp_enqueue_style('sjSkin' );

     /* ++++++++++++++++++++++++ add vars to javascript +++++++++++++++++++++++ */

//get widget vars
$sjOptions=get_option('widget_sj_player_widget_live_stream'); //widget_sj_player_widget_live_stream is from options.php page
// echo "<PRE>";
// print_r($sjOptions);
// echo "</PRE>";
// echo "<br>first:".$sjOptions[0]['url']."<br>second: ".$sjOptions[1]['url'];
wp_localize_script(
    'sjScript', 
    'sjsitevars', array(
                         'sj_pluginurl'    => plugin_dir_url(__FILE__) ,
                         'sj_streamURL'  => $sjOptions[5]['url'] //use url for livestream from widget vars
                         ));


  
 
/* ++++++++++++++++++++++++ /add vars to javascript +++++++++++++++++++++++ */

}

    add_action('wp_enqueue_scripts', 'sj_load_scripts');
 

 //custom player size and color dependent on user selection

    function sj_player_css(){
        $sjplayer_options = get_option( 'sjplayer-main-settings' );

        $sj_player_color=$sjplayer_options['sj-player-back-color'];          /*background and progress bar player color*/
        if(empty($sj_player_color)){$sj_player_color="#ff9900";}
 
        $sj_player_time_color=$sjplayer_options['sj-player-time-color'];     /*current time and duration text color*/
        if(empty($sj_player_time_color)){$sj_player_time_color="#000000";}
  
        $sj_player_shortcode_font_color=$sjplayer_options['sj_player_shortcode_color'];    /*title and text description color*/
        if(empty($sj_player_shortcode_font_color)){$sj_player_shortcode_font_color="#000000";}
        
        $sj_player_widget_font_color=$sjplayer_options['sj_player_widget_color'];   /*title and text description color*/
         if(empty($sj_player_widget_font_color)){$sj_player_widget_font_color="#000000";}

         $sj_player_title_font_size=$sjplayer_options['sj-player-title-font-size'];
         if(empty($sj_player_title_font_size)){$sj_player_title_font_size="10";}

         $sj_player_description_font_size=$sjplayer_options['sj-player-description-font-size'];
         if(empty($sj_player_description_font_size)){$sj_player_description_font_size="10";}

         $sj_player_time_font_size=$sjplayer_options['sj-player-time-font-size'];
         if(empty($sj_player_time_font_size)){$sj_player_time_font_size="10";}


        sj_player_color_css_func($sj_player_color,$sj_player_time_color,$sj_player_shortcode_font_color,$sj_player_widget_font_color,$sj_player_title_font_size,$sj_player_description_font_size,$sj_player_time_font_size);
       
    }
   
    function sj_player_color_css_func($sj_player_color,$sj_player_time_color,$sj_player_shortcode_font_color,$sj_player_widget_font_color,$sj_player_title_font_size,$sj_player_description_font_size,$sj_player_time_font_size){
         /**
            dynamic CSS settings/from wp settings page
         */
         echo '<style type="text/css">
                .cp-container{
                    margin: 0 auto;
                }
                .cp-progress-1,
                .cp-progress-2 {
                  background-color:'.$sj_player_color.';
                }
                .cp-controls .cp-play:hover{
                      background-color: '.$sj_player_color.';
                    }
                .cp-controls .cp-pause{
                 background-color: '.$sj_player_color.';
                 }

                 .jp-current-time,.jp-duration{
                color: '.$sj_player_time_color.';
                font-size: '.$sj_player_time_font_size.'px;
                }

                .cp-jplayershortcode{
                color: '.$sj_player_shortcode_font_color.';

                }
                .cp-jplayerwidget{
                color: '.$sj_player_widget_font_color.';
                display: inline-block;
                }
                .sj-player-display-title{
                    font-size:'.$sj_player_title_font_size.'px;
                }

                .sj-player-display-description{
                    font-size:'.$sj_player_description_font_size.'px;
                }

                .time-duration-holder {
                        background: none repeat scroll 0 0;
                        height: auto;
                        margin-top: 2%;
                        padding: 0 0%;
                        width: 100%;
                        margin-bottom:2%;
                    }
                .jp-current-time {
                    background: none repeat scroll 0 0 ;
                    width: 50%;
                    float: left;
                }
                .jp-duration {
                    float: right;
                }
                .sj-player-display li p {
                      text-align:center;
                    }
             </style>';

    }

    add_action('wp_head', 'sj_player_css');

 

function sj_enqueue_admin_scripts() {  
 
      /*media upload*/
        //wp_enqueue_script('jquery');  
  
        wp_enqueue_script('thickbox');  
        wp_enqueue_style('thickbox');  
  
        wp_enqueue_script('media-upload');  

        


        /*color picker*/

        wp_register_script('sjColorpicker', plugin_dir_url(__FILE__).'colorpicker/js/colorpicker.js');
        wp_enqueue_script('sjColorpicker');

        wp_register_script('sjColorpicker-eye', plugin_dir_url(__FILE__).'colorpicker/js/eye.js');
        wp_enqueue_script('sjColorpicker-eye');

        wp_register_script('sjColorpicker-layout', plugin_dir_url(__FILE__).'colorpicker/js/layout.js');
        wp_enqueue_script('sjColorpicker-layout');

        wp_register_script('sjColorpicker-utils', plugin_dir_url(__FILE__).'colorpicker/js/utils.js');
        wp_enqueue_script('sjColorpicker-utils');

        wp_register_style('sjColorpicker-style', plugin_dir_url(__FILE__).'colorpicker/css/colorpicker.css');
        wp_enqueue_style('sjColorpicker-style'); 

        


        wp_register_script('sjScriptAdmin', plugin_dir_url(__FILE__).'js/sjscript-admin.js');
        wp_enqueue_script('sjScriptAdmin');


        //send reffrer to javascript

        /**
            IF we are on the media uploader page called from my audio widget then send the sj_refferer var to javascript to use custom uploader
            because, default post uploader will try to use these setings and will not work
        

        */
            // global $pagenow;
            // echo "current page:".$pagenow;
            //  $referer = strpos( wp_get_referer(), 'js_plugin_options_ID' );
            //     if ( $pagenow == 'widgets.php' ||  $referer != '') {
            //             wp_localize_script(
            //             'sjScriptAdmin', 
            //             'sjsitevars', array(
            //                                  'sj_refferer'    => 'useCustomUploader'
            //                                  ));
            //     }else{
            //         wp_localize_script(
            //             'sjScriptAdmin', 
            //             'sjsitevars', array(
            //                                  'sj_refferer'    => 'dontUseCustomUploader'
            //                                  ));
            //     }/*end if we are available to use custom uploader*/
            

  }  

add_action('admin_enqueue_scripts', 'sj_enqueue_admin_scripts');

/* ++++++++++++++++++++++++ /include js & css files +++++++++++++++++++++++ */








// // this seems to run generically for any media item from the 'Upload' tab
// add_filter('media_send_to_editor', 'my_filter_mste', 20, 3);

// function my_filter_mste($html, $send_id, $attachment) {
//     if (substr($attachment->post_mime_type, 0, 5) == 'audio') {
//         $href = wp_get_attachment_url($attachment->ID);
//         $html = '[audio src="'.$href.'"]';
//     }
//     $post = get_post($send_id);
//     $html="kurax".$post;
//     return $html;
// }
// add_filter('media_send_to_editor', 'my_filter_mste', 20, 3);

// add_filter('media_send_to_editor', 'media_editor', 20, 3);
// function media_editor($html, $send_id, $attachment ){
//     //get the media's guid and append it to the html
//     $post = get_post($send_id);
//     $html .= '<media>'.$post->guid.'</media>';
//     return $html;
// }

/************************************************************************************************************************/
/**

automatically add shortcodes
**/
// // [attachments]
// function attachmentUrl($atts) {
//   extract(shortcode_atts(array(
//       "src" => ''
//   ), $atts));
//   /* $filename_match = preg_match("/([a-zA-Z0-9_\.\-]+\.[a-zA-Z]+)$/", $src, $filename); */
//   $filename_match = preg_match("/\/([^\/]*$)/", $src, $filename);
//   return '<div class="attachments"><h4>Attachments</h4><ul class="attachments_list attachment"><li><a href="'.$src.'" target="_blank">'.$filename[1].'</a></li></ul></div>';
// }
// add_shortcode("attachment", "attachmentUrl");

// // Audio shortcode
// function audioURL($atts) {
//   extract(shortcode_atts(array(
//       "src" => ''
//   ), $atts));
//   return '<audio src="'.$src.'" type="audio/mp3" controls="controls"></audio>';
// }
// add_shortcode("audio", "audioURL");

// // Video shortcode
// function videoURL($atts) {
//   extract(shortcode_atts(array(
//       "src" => ''
//   ), $atts));
//   return '<video controls="controls" preload="none"><source src="'.$src.'" type="video/mp4" /></video>';
// }
// add_shortcode("video", "videoURL");

// // Customize the 'insert into Post' action

// add_filter('media_send_to_editor', 'my_filter_iste', 20, 3);

// function my_filter_iste($html, $id, $caption, $title, $align, $url, $size, $alt) {
//     $attachment = get_post($id); //fetching attachment by $id passed through
//     $src = wp_get_attachment_url( $id );
//     $videoext = '.mp4';
//     $audioext = '.mp3';

//     $mime_type = $attachment->post_mime_type; //getting the mime-type

//     if ((substr($mime_type, 0, 5) == 'video') || (substr_compare($src, $videoext, strlen($str)-strlen($videoext), strlen($videoext)) === 0)) { //checking mime-type
//         $html = '[video src="'.$src.'"]';
//     } elseif ((substr($mime_type, 0, 5) == 'audio') || (substr_compare($src, $audioext, strlen($str)-strlen($audioext), strlen($audioext)) === 0)) { //checking mime-type
//         $html = '[audio src="'.$src.'"]';
//     } else {
//       $html = '[attachment src="'.$src.'"]';
//     }
//     return $html; // return new $html
// }
?>