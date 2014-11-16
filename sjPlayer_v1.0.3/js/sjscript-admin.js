var sjPlayer_admin=(function ($) {
jQuery(document).ready(function($) {

  /*color picker*/

//take id from clicked field and append colorpicker to that field
$(".sjplayer-colorpicker").live('click',function(){

  var sj_color_id=$(this).attr('id');
  

  $("#"+sj_color_id).ColorPicker({
  
  color: '#0000ff',
  onShow: function (colpkr) {
    $(colpkr).fadeIn(500);
    return false;
  },
  onHide: function (colpkr) {
    $(colpkr).fadeOut(500);
    return false;
  },
  onChange: function (hsb, hex, rgb) {
      /*change background color of preview color div*/
      $("#"+sj_color_id).next('.sj_player_color_box').css('backgroundColor', '#' + hex);
       //add color value to field
       $("#"+sj_color_id).val("#"+hex);//rgb;
      } 
    });

})/*color picker*/



/*widget song upload*/
 var sj_current_field_id;
var sj_current_upload_desc;

//create default sent to editor variable
var sj_orig_send_to_editor = window.send_to_editor;

jQuery('.sj_upload_audio_source').live('click',function() {

      sj_current_field_id=jQuery(this).attr('id');
      sj_current_upload_desc=jQuery(this).attr('value');
      //alert(sj_current_upload_desc);
        
       tb_show(sj_current_upload_desc, 'media-upload.php?referer=js_plugin_options_ID&type=audio&TB_iframe=true&post_id=0', false);
   

  window.send_to_editor = function(html) {

        //extract values from html
        var sj_audio_url = jQuery(html).attr('href');
        var sj_audio_desc = jQuery(html).attr('alt');
        var sj_audio_title = jQuery(html).text();       

        //fill in input fields
        jQuery("#"+sj_current_field_id+'_url').val(sj_audio_url);

        //populate audio title
        var sj_title_field=sj_current_field_id.replace('-url','-audio_title')
        jQuery("#"+sj_title_field).val(sj_audio_title);

        //populate audio description
        var sj_desc_field=sj_current_field_id.replace('-url','-audio_description')
        jQuery("#"+sj_desc_field).val(sj_audio_desc);

        //restore original send to editor
        window.send_to_editor = sj_orig_send_to_editor;
        
        tb_remove(); 
         
       }
         return false;
    });
 // }//if is use custom uploader

 
  });
}(jQuery));