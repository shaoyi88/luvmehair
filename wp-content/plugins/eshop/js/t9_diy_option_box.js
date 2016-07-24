$(document).ready(function() {
    $("#add_diy_option_box").click(function(){
        var diy_option_num = $("#diy_option_num").val(); 
        var shipping = $("#shipping").val(); 
        var stock_control = $("#stock_control").val(); 
        var next_diy_option_num = parseInt(diy_option_num);
        var clearhtml='';
        var shippinghtml='';
        var stock_controlhtml='';
        var shippinghtml_th='';
        var shippinghtml='';
        var stockhtml_th='';
        var stockhtml='';
        if(next_diy_option_num%2==1){
            clearhtml='<dl class="clear"> </dl>';
        }
        if(shipping==1){
            shippinghtml_th='<th id="eshopweight">重量变化<span style="color: #ff0000;">*</span></th>';
            shippinghtml='<td headers="eshopweight eshopnumrow1"><input name="diy_option['+next_diy_option_num+'][option][0][weight]" value="0.00" type="text" size="6"></td>';
        }
        if(stock_control==1){
            stockhtml_th='<th id="eshopweight">库存变化<span style="color: #ff0000;">*</span></th>';
            stockhtml='<td headers="eshopstock eshopnumrow1"><input name="diy_option['+next_diy_option_num+'][option][0][stock]" value="0.00" type="text" size="6"></td>';
        }
		var html ='<div id="option_'+next_diy_option_num+'_box"><table width="100%"><tr><td><strong>参数名称：</strong></td><td><input type="text" name="diy_option[][name]" value="option_name_'+next_diy_option_num+'"/><select id="" name="diy_option['+next_diy_option_num+'][show_style]">					<option value="select">下拉框</option><option value="pic" selected>图文兼容</option><option value="checkbox">单选框</option></select></td><td width="8"><a class="close" href="javascript:void(0)"style="color:red"  onclick="remove_option_box('+next_diy_option_num+')">×</a></td></tr><tr><td><strong>参数项目：</strong></td><td></td><td></td></tr></table><table class="hidealllabels widefat eshoppopt" width="45%" id="option_'+next_diy_option_num+'_table"><thead><tr><th id="eshopoption">NO.</th><th id="eshopprice">选项<span style="color: #ff0000;">*</span></th><th id="eshopsaleprice">价格变化<span style="color: #ff0000;">*</span></th>'+shippinghtml_th+stockhtml_th+'<th id="eshopsaleprice">展示图片</th></tr></thead><input type="hidden" id="option_'+next_diy_option_num+'_num" name="'+next_diy_option_num+'_num" value="1"/><tbody><tr><td headers=" eshopnumrow1">1.</td><td headers="eshopoption eshopnumrow1"><input name="diy_option['+next_diy_option_num+'][option][0][title]" value="" type="text" size="6"></td><td headers="eshopprice eshopnumrow1"><input name="diy_option['+next_diy_option_num+'][option][0][price]" value="0.00" type="text" size="6"></td>'+shippinghtml+stockhtml+'<td headers="eshopprice eshopnumrow1" class="acf-image-uploader" data-preview_size="thumbnail" data-library="uploadedTo"><input class="acf-image-value" name="diy_option['+next_diy_option_num+'][option][0][img]" value="" type="text" size="40">	<input type="button" class="button add-image" value="添加图片"></td></tr></tbody></table><span class="add_option" onclick="add_option('+next_diy_option_num+')">+</span></div>';        
        $("#diy_option_num").val(parseInt(diy_option_num)+1);
		$("#diy_option_box").append(html+clearhtml);
	});
    $(".diy_option_selec").click(function(){
    });
    $(".diy_option_select").change(function(){
        var val = $(this).val(); 
        var box_id = $(this).attr("id");
        $("#"+box_id+"_"+val).find(':checkbox').attr('checked','');
        $("."+box_id+"_div").hide();
        $("#"+box_id+"_"+val).show();
    });
 });

function add_option(id){
    var option_ = 'option_'+id;
    var num = $("#"+option_+'_num').val();
    var next_num = parseInt(parseInt(num)+1);
    var shipping = $("#shipping").val(); 
    var stock_control = $("#stock_control").val(); 
    var shippinghtml='';
    var stock_controlhtml='';
    var clearhtml='';
    var shippinghtml='';
    var stockhtml='';
    if(shipping==1){
        shippinghtml='<td headers="eshopweight eshopnumrow1"><input name="diy_option['+id+'][option]['+num+'][weight]" value="0.00" type="text" size="6"></td>';
    }
    if(stock_control==1){
        stockhtml='<td headers="eshopstock eshopnumrow1"><input name="diy_option['+id+'][option]['+num+'][stock]" value="0.00" type="text" size="6"></td>';
    }

    var html ='<tr><td headers="eshopnumrow1">'+next_num+'.</td><td headers="eshopoption eshopnumrow1"><input name="diy_option['+id+'][option]['+num+'][title]" value="" type="text" size="6"></td><td headers="eshopprice eshopnumrow1"><input name="diy_option['+id+'][option]['+num+'][price]" value="0.00" type="text" size="6"></td>'+shippinghtml+stockhtml+'<td headers="eshopprice eshopnumrow1" class="acf-image-uploader" data-preview_size="thumbnail" data-library="uploadedTo"><input class="acf-image-value" name="diy_option['+id+'][option]['+num+'][img]" value="" type="text" size="40">	<input type="button" class="button add-image" value="添加图片"></td></tr>';        
    $("#"+option_+'_num').val(next_num);	
    $("#"+option_+'_table tbody').append(html);
};
function remove_option_box(id){
    $('#option_'+id+'_box').remove();
    var diy_option_num = $("#diy_option_num").val();
    $("#diy_option_num").val(parseInt(diy_option_num)-1);
}


function add_whs_box(){
     var num = $("#eshoppopt_price_num").val();
     var next_num = parseInt(parseInt(num)+1);
     var num = $("#eshoppopt_price_num").val(next_num);
    var html ='<tr id="tr_'+next_num+'"><td headers="eshopoption eshopnumrow1" colspan="2"> 购买数量区间 <input name="eshop_whs['+next_num+'][qty_start]" value="" type="text"size="6"> 到 <input name="eshop_whs['+next_num+'][qty_end]" value="" type="text"size="6"></td><td headers="eshopsaleprice eshopnumrow1"><input name="eshop_whs['+next_num+'][price]" value="" type="text"	size="15"> <p>价格变化（添加实例:加价5，填写“+5”，减价填写“-5”）</p></td><td headers="eshopweight eshopnumrow1"><a style="float:right;color:red" href="javascript:void(0)" onclick="remove_whs_box('+next_num+')">删除</a></td></tr>';        
    $("#eshoppopt_whs tbody").append(html);
};
function remove_whs_box(n){
   $("#tr_"+n).remove();
}

function add_rolesprcie_box(){
    var num = $("#eshoppopt_rolesprcie_num").val();
    var next_num = parseInt(parseInt(num)+1);
    var num = $("#eshoppopt_rolesprcie_num").val(next_num);
    var user_roles_select = $("#user_roles_html").html();
    user_roles_select = user_roles_select.replace(/str/g, 'eshop_groupprice['+next_num+']');
    var html ='<tr id="tr_'+next_num+'"><td headers="eshopoption eshopnumrow1" colspan="2">'+user_roles_select+'</td><td headers="eshopsaleprice eshopnumrow1"><input name="eshop_rolesprcie['+next_num+'][price]" value="" type="text"	size="15"> <p>价格变化（添加实例:加价5，填写“+5”，减价填写“-5”）</p></td><td headers="eshopweight eshopnumrow1"><a style="float:right;color:red" href="javascript:void(0)" onclick="remove_rolesprcie_box('+next_num+')">删除</a></td></tr>';        
    $("#eshoppopt_rolesprcie tbody").append(html);
};
function remove_rolesprcie_box(n){
   $("#tr_"+n).remove();
}

$('.option_img_upload').each(function (index) {
    $(this).click(	function(){		     
        wp.media.featuredImage.frame().open()
    })        
})





 