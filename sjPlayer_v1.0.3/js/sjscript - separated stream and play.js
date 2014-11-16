var sjPlayer=(function ($) {
$(document).ready(function() {
 
    /*++++++++++++++++++++++ jPlayer ++++++++++++++++++++++ */
    /*
   * Instance CirclePlayer inside jQuery doc ready
   *
   * CirclePlayer(jPlayerSelector, media, options)
   *   jPlayerSelector: String - The css selector of the jPlayer div.
   *   media: Object - The media object used in jPlayer("setMedia",media).
   *   options: Object - The jPlayer options.
   *
   * Multiple instances must set the cssSelectorAncestor in the jPlayer options. Defaults to "#cp_container_1" in CirclePlayer.
   *
   * The CirclePlayer uses the default supplied:"m4a, oga" if not given, which is different from the jPlayer default of supplied:"mp3"
   * Note that the {wmode:"window"} option is set to ensure playback in Firefox 3.6 with the Flash solution.
   * However, the OGA format would be used in this case with the HTML solution.
   */
   jQuery(".cp-jplayer").each(function(){
    
    var jplayerID=jQuery(this).attr('id');
    var songPath=jQuery(this).attr('song');
    var counter = jQuery(this).attr('currentID');
    var songExtension;

    /*GET EXTENSION OF SONG*/
    function getExtension(songPath) {
    return songPath.split('.').pop().toLowerCase();
    }

    function openFile(songPath) { 
        switch(getExtension(songPath)) {
            //if .jpg/.gif/.png do something
            case 'mp3':  
                songExtension="mp3"
                break;
                case 'm4a':  
                songExtension="m4a"
                break
             
        }
    }

     songExtension=getExtension(songPath);
      
      if(songExtension=='mp3'){
        new CirclePlayer("#"+jplayerID,
        {
          
         mp3: songPath
         //m4a: songPath
          //mp3: "http://77.68.106.224:8018/;stream/1"
        }, {
          supplied: 'mp3',
          cssSelectorAncestor: "#cp_container_"+counter,
          swfPath: sj_siteVars.sj_pluginurl+"js/jPlayer.swf",
          wmode: "window"
        });
      }else if(songExtension=='m4a'){
         new CirclePlayer("#"+jplayerID,
        {
          
         //mp3: songPath,
         m4a: songPath
          //mp3: "http://77.68.106.224:8018/;stream/1"
        }, {
          supplied: 'm4a',
          cssSelectorAncestor: "#cp_container_"+counter,
          swfPath: sj_siteVars.sj_pluginurl+"js/jPlayer.swf",
          wmode: "window"
        });
      }// end if is mp3 or m4a


    counter++;
   })
 
 
   jQuery("#jquery_jplayer_live").jPlayer("play");
 
  var myCirclePlayerive = new CirclePlayer("#jquery_jplayer_live",
  {
    //mp3: "http://77.68.106.224:8018/;stream/1"
    //mp3: "http://109.123.116.114:7066/;stream/1" /*radio zepce*/
    //mp3:"http://rs5.stream24.net:80/stream" /*radio Charivari Munich*/
   //mp3:jQuery("#jquery_jplayer_live").attr('streamurl')
  mp3: sjsitevars.sj_streamURL
  }, {
    supplied: "mp3",
    cssSelectorAncestor: "#cp_container_live",
    //swfPath: crc_siteVars.crc_siteurl+"/js/jPlayer.swf",// defined in function.php using wp function wp_localize_script to add php vars to javacript
    swfPath: "http://www.jplayer.org/2.1.0/js",
    wmode: "window"
    //size:{width: "20px", height: "20px"}
  });
document.close()
    });
}(jQuery));