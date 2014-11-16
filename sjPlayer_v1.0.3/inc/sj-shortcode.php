<?php 

//create shortcode
add_shortcode('sjPlayer', 'sj_display_sjPlayer_func');

//display shortcode function
function sj_display_sjPlayer_func($atts){
	 extract($atts);
  
     if($align=="left"){
        $align='style="float:left;"';
     }elseif($align=="right"){
            $align='style="float:right;"';
    }elseif($align=="center"){
            $align='align="center"';
        }else{
            $align='';
        }

	 //get unique id for unique div id names
	$sj_unique_id=uniqid();

	$sj_content='<div class="cp-jplayershortcode" '.$align.'>
                  <ul class="sj-player-display">
                    
                   <li class="sj-player-display-player">
 					 <div id="'.$sj_unique_id.'" class="cp-jplayer-live" song="'.$url.'" ></div>
						<div id="'.$sj_unique_id.'-live" class="cp-container">
                        <div class="cp-buffer-holder">  
                            <div class="cp-buffer-1"></div>
                            <div class="cp-buffer-2"></div>
                        </div>
                        <div class="cp-progress-holder" style="display:none !important;"> 
                            <div class="cp-progress-1"></div>
                            <div class="cp-progress-2"></div>
                        </div>

                        <div class="cp-circle-control"></div>
                        <ul class="cp-controls">
                            <li><a href="#" class="cp-play" tabindex="1"> </a></li>
                            <li><a href="#" class="cp-pause" style="display:none;" tabindex="1"></a></li> 
                        </ul>';

                        if($time=='visible'){
                            $sj_content.='
                            <div class="time-duration-holder">
                            <div class="jp-current-time"></div>
                            <div class="jp-duration"></div>
                            </div>';
                        }
                        

                 $sj_content.='   </div>
                 </li>';
 					
 					if(!empty($title)){
 						$sj_content.='<li class="sj-player-display-title"><p>'.$title.'</p></li>';
 					}
 					if(!empty($description)){
 						$sj_content.='<li class="sj-player-display-description"><p>'.$description.'</p></li>';
 					}
        $sj_content.='                                  
              	</ul>
                
        </div>';

	return($sj_content);
 

}

//automatically insert shortcode when inserting audio files

$sj_referer = strpos( wp_get_referer(), 'post' );

//if we are on post page go for it
if(!empty($sj_referer))
{      
    add_filter('media_send_to_editor', 'js_insert_audio_shortcode', 20, 3);
}
 

//function insert_audio_shortcode($html, $id, $caption, $title, $align, $url, $size, $alt) {

function js_insert_audio_shortcode($html, $id,$title) {
    $attachment = get_post($id); //fetching attachment by $id passed through
    //print_r($attachment );
    $src = wp_get_attachment_url( $id );
    $title = $attachment->post_title;
    $description =$attachment->post_content;
   

    $mime_type = $attachment->post_mime_type; //getting the mime-type
 
    if (substr($mime_type, 0, 5) == 'audio') { //checking mime-type
        $html = '[sjPlayer url='.$src.' title="'.$title.'"  description="'.$description.'" time="visible" align="left"]';
    }
    return $html; // return new $html
}


?>

