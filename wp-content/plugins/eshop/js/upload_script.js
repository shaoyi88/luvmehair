
jQuery(document).ready(function() {
var imgid = 0;

jQuery('.upload_image_button').click(function() {
    var img_id = jQuery(this).attr("id");
    jQuery("#img_num").val(img_id);
    var d = dialog({
        id:"dialog",
        title: "插入图片",
        width:800,
        url: "media-upload.php?type=image&TB_iframe=true",
     });
    d.showModal();
});
 
window.send_to_editor = function(html) {
 imgurl = jQuery('img',html).attr('src');
   var img_num = jQuery("#img_num").val();
   jQuery('#eshop_'+img_num).val(imgurl);
   tb_remove();
   dialog({ id: 'dialog'}).close(); 
}
});
