var sjPlayer=(function ($) {
jQuery(document).ready(function() {
 
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
 
jQuery(".cp-jplayer-live").each(function(){
   var jplayerID=jQuery(this).attr('id');
   var songPath=jQuery(this).attr('song');
   
  //get the extension 
  songExtension=getExtension(songPath);

    //extension function
   function getExtension(songPath) { 
    return songPath.split('.').pop().toLowerCase();
    }

    if(songExtension=='mp3'){
        new CirclePlayer("#"+jplayerID,
        {            
          mp3:songPath
        },
        {
          supplied: songExtension,
          cssSelectorAncestor: "#"+jplayerID+"-live",
          swfPath: sjsitevars.sj_pluginurl+"js/jPlayer.swf",
          wmode: "window",
          errorAlerts: false,
          warningAlerts: false
        });

    }else if(songExtension=='m4a'){
        new CirclePlayer("#"+jplayerID,
        {            
          m4a:songPath
        },
        {
          supplied: songExtension,
          cssSelectorAncestor: "#"+jplayerID+"-live",
          swfPath: sjsitevars.sj_pluginurl+"js/jPlayer.swf",
          wmode: "window",
          errorAlerts: false,
          warningAlerts: false
        });
      }else if(songExtension=='ogg' || songExtension=='oga'){
        new CirclePlayer("#"+jplayerID,
        {            
          oga:songPath
        },
        {
          supplied: "oga",
          cssSelectorAncestor: "#"+jplayerID+"-live",
          swfPath: sjsitevars.sj_pluginurl+"js/jPlayer.swf",
          wmode: "window",
          errorAlerts: false,
          warningAlerts: false
        });
      }else if(songExtension=='wav'){
        new CirclePlayer("#"+jplayerID,
        {            
          wav:songPath
        },
        {
          supplied: songExtension,
          cssSelectorAncestor: "#"+jplayerID+"-live",
          swfPath: sjsitevars.sj_pluginurl+"js/jPlayer.swf",
          wmode: "window",
          errorAlerts: false,
          warningAlerts: false
        });
      }else if(songExtension=='flv'){
        new CirclePlayer("#"+jplayerID,
        {            
          flv:songPath
        },
        {
          supplied: songExtension,
          cssSelectorAncestor: "#"+jplayerID+"-live",
          swfPath: sjsitevars.sj_pluginurl+"js/jPlayer.swf",
          wmode: "window",
          size: {width: "100px", height: "100px"},
          errorAlerts: false,
          warningAlerts: false
        });
      }else{
        new CirclePlayer("#"+jplayerID,
        {            
         mp3:songPath
        },
        {
          supplied: "mp3",
          cssSelectorAncestor: "#"+jplayerID+"-live",
          swfPath: sjsitevars.sj_pluginurl+"js/jPlayer.swf",
          wmode: "window",
          //volume: 0.1,
          errorAlerts: false,
          warningAlerts: false
        });
      }

    
  });/*each live sream class*/
 



});
}(jQuery));