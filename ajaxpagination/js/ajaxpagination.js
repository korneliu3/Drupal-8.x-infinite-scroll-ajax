 
jQuery(document).ready(function() {  
jQuery('#gridgallery_cat').justifiedGallery();
   var win = jQuery(window);
    
   // Each time the user scrolls
   
   win.scroll(function() {
       
           // End of the document reached?
           if (jQuery(document).height() - win.height() == win.scrollTop()) {
               var me = jQuery(this);
                 

                if ( me.data('requestRunning') ) {
                    return false;
                }
                me.data('requestRunning', true);
                   var idload =jQuery('.last_id').attr("title");
                     if( idload==='9999999'){
                          return false;
                     }
                     
                    jQuery('#loading').show();
                   jQuery.ajax({
                           url: "/ajaxcall/" + idload,
                           dataType: 'json',
                           success: function(html) {
                            jQuery('#gridgallery_cat .post_list:last').after(html["content"]);
                            jQuery('.last_id').attr("title", html["id"]);
                            jQuery('#loading').hide();
                            
                           },
                            complete: function() {
                                me.data('requestRunning', false);
                                jQuery('#gridgallery_cat').justifiedGallery('norewind');
                            }
                   });
                   
                     
           }
         });
       });
       
 