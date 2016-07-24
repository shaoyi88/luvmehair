<?php
function eshop_boing($pee, $short = 'no', $postid = '', $isshortcode = 'n') {
	global $wpdb, $post, $eshopchk, $eshopoptions;
	if ($postid == '') $postid = $post -> ID;
	$stkav = get_post_meta($postid, '_eshop_stock', true);
	$eshop_product = maybe_unserialize(get_post_meta($postid, '_eshop_product', true));
	$saleclass = '';
	if (isset($eshop_product['sale']) && $eshop_product['sale'] == 'yes') {
		$saleclass = ' sale';
	} 
	$stocktable = $wpdb -> prefix . "eshop_stock";
	$uniq = rand();

	if (post_password_required()) {
		return $pee;
	} 
	// if the search page we don't want the form!
	// was (!strpos($pee, '[eshop_addtocart'))
	if ($short != 'yes' && (strpos($pee, '[eshop_details') === false) && ((is_single() || is_page())) && isset($eshopoptions['details']['display']) && 'yes' == $eshopoptions['details']['display']) {
		$details = '';
		if (isset($eshop_product['products'])) {
			if ($eshopoptions['details']['show'] != '')
				$details .= " show='" . esc_attr($eshopoptions['details']['show']) . "'";
			if ($eshopoptions['details']['class'] != '')
				$details .= " class='" . esc_attr($eshopoptions['details']['class']) . "'";
			if ($eshopoptions['details']['hide'] != '')
				$details .= " options_hide='" . esc_attr($eshopoptions['details']['hide']) . "'";
			if (isset($eshopoptions['details']['tax']) && $eshopoptions['details']['tax'] != '')
				$details .= " etax_page='" . esc_attr($eshopoptions['details']['tax']) . "'";
			if ($isshortcode == 'n')
				$pee .= do_shortcode('[eshop_details' . $details . ']');
		} 
	} 

	if ((strpos($pee, '[eshop_addtocart') === false) && ((is_single() || is_page()) || 'yes' == $eshopoptions['show_forms'])) {
		// need to precheck stock
		if ($postid != '') {
			if (isset($eshopoptions['stock_control']) && 'yes' == $eshopoptions['stock_control']) {
				$anystk = false;
				$stkq = $wpdb -> get_results("SELECT option_id, available from $stocktable where post_id=$postid");
				foreach($stkq as $thisstk) {
					$stkarr[$thisstk -> option_id] = $thisstk -> available;
				} 
				$opt = $eshopoptions['options_num'];
				for($i = 1;$i <= $opt;$i++) {
					$currst = 0;
					if (isset($stkarr[$i]) && $stkarr[$i] > 0) $currst = $stkarr[$i];
					if ($currst > 0) {
						$anystk = true;
						$i = $opt;
					} 
				} 
				if ($anystk == false) {
					$stkav = '0';
					delete_post_meta($postid, '_eshop_stock');
				} 
			} 
		} 
		$replace = '';
		$stkav = apply_filters('eshop_show_addtocart', $stkav, $postid, $post);
		if ($stkav == '1') {
			$currsymbol = $eshopoptions['currency_symbol'];
			if (isset($eshopoptions['cart_text']) && $eshopoptions['cart_text'] != '' && $short == 'no') {
				if ($eshopoptions['cart_text_where'] == '1')
					$replace .= '<p class="eshop-cart-text-above">' . stripslashes($eshopoptions['cart_text']) . '</p>';
			} 
			$replace .= '<form action="' . get_permalink($eshopoptions['cart']) . '" method="post" class="eshop addtocart' . $saleclass . '" id="eshopprod' . $postid . $uniq . '" name="myform">
			';
			$theid = sanitize_file_name($eshop_product['sku']); 
			// option sets
			// diy_option
			$eshop_diy_option = maybe_unserialize(get_post_meta($post -> ID, '_eshop_diy_option', true));

			foreach($eshop_diy_option as $val) {
				if ($val['show_style'] == 'select') {
					if ($val["name"] != '') {
						$replace .= '<div class="form-item" id="form_item_' . $val["name"] . '_all" data-style="'.$val['show_style'].'">
						   <dl>
							  <dt>' . $val["name"] . ':</dt>
							  <dd>';
							  $k = 0; 
							  
							  
							  

							  
							  
							  
								  $replace .='<div class="select-box change-item 1">
										<select name="diy_option[' . $val['name'] . ']" ' . $data_img . ' class="select-size select-with-custom price-change select-require">';
										$replace .='<option value="' . $v['title'] . '@' . $v['price'] . '@' . $v['weight']. '@' . $v['img'] . '">
												--- Please Select ---
											</option>';
										foreach($val['option'] as $v) {
											
											                                if ($v['price'] != '0')
									$addprice = sprintf(__(' + %1$s%2$s', 'eshop'), $currsymbol, number_format_i18n($v['price'], __('2', 'eshop')));
								else
									$addprice = '';
											
											
											if((intval($eshop_product['products'][1]['stkqty'])+intval($v['stock']))>0){
												 $replace .='<option value="' . $v['title'] . '@' . $v['price'] . '@' . $v['weight']. '@' . $v['img'] . '">' . $v['title'] . ' '. $addprice. '</option>';
											}
											
										}	 								 
										$replace .='</select>
									</div>
									<div class="form-error-msg">
										--- Please Select ---
									</div>
							  </dd>
						   </dl>             
						   </div>';

						if ($relate_arr[$val["name"]]) {
							foreach($relate_arr[$val["name"]] as $relate_key => $relate_val) {
								$replace .= '<div class="form-item" id="form_item_' . $relate_name . '_' . $relate_key . '"><dl>
						  <dt>' . $val["name"] . "-" . $relate_key . '-' . $relate_name . ':</dt>
						  <dd>
							 <ul class="size-list check-require tags-for-color 1">';

								foreach($relate_val[$relate_name] as $relate_v) {
									$relate_img = $relate_v_arr = array();
									$relate_v_arr = explode('@', $relate_v);
									if ($relate_v_arr[3] != '') {
										$size = 'full';
										$relate_img = wp_get_attachment_image_src($relate_v_arr[3],$size);
									} 
									$relate_data_img = '';
									if ($relate_img[0] != '')
										$relate_data_img = 'data-img="' . $relate_img[0] . '"';

									$relate_data_big = '';
									if ($relate_img[0] != '')
										$relate_data_big = 'data-big="' . $relate_img[0] . '"';

									$data_name = '';
									if ($img[0] != '')
										$data_name = 'data-name="' . $relate_v_arr[0] . ' ' . $addprice . '"';

									if ($relate_v_arr[1] != '0')
										$addprice = sprintf(__(' + %1$s%2$s', 'eshop'), $currsymbol, number_format_i18n($relate_v_arr[1], __('2', 'eshop')));
									else
										$addprice = '';
									$replace .= '
								<li> <input class="price-change" type="radio"  value="' . $relate_v . '" id="a' . $relate_key . '" name="diy_option[' . $relate_name . ']" ' . $data_img . '>
								   <label for="a' . $relate_v . '"><span class="size-value" ' . $relate_data_big . ' ' . $relate_data_name . '>' . $relate_v_arr[0] . '</span><b class="ico-tick"></b></label> 
								</li>';
								} 
								$replace .= '</ul>
							 <div class="form-error-msg"> --- Please Select --- </div>
						  </dd>
					   </dl> </div>';
							} 
						} 
					}
				} elseif ($val['show_style'] == 'checkbox') {
					if ($val["name"] != '') {
						$replace .= '<div class="form-item" id="form_item_' . $val["name"] . '_all" data-style="'.$val['show_style'].'">
               <dl>
                  <dt>' . $val["name"] . ':</dt>
                  <dd>
                     <ul class="check-require tags-for-color 2">';
						$k = 0;

						foreach($val['option'] as $v) {
							if ($v['relate_yes']) {
								$relate_name = $v['relate']['name'];
								$relate_arr[$val["name"]][$v["title"]][$relate_name] = $v['relate']['val'];
							} 
							if ($v['img'] != '') {
								$img = wp_get_attachment_image_src($v['img']);
							} 
							if ($v['title'] != ''&&(intval($eshop_product['products'][1]['stkqty'])+intval($v['stock']))>0) {
								if ($k == 0) {
									$checked = "checked";
								} else {
									$checked = "";
								} 
								$data_img = '';
								if ($img[0] != '')
									$data_img = 'data-img="' . $img[0] . '"';

								$data_big = '';
								if ($img[0] != '')
									$data_big = 'data-big="' . $img[0] . '"';
								
								if ($v['price'] != '0')
									$addprice = sprintf(__(' + %1$s%2$s', 'eshop'), $currsymbol, number_format_i18n($v['price'], __('2', 'eshop')));
								else
									$addprice = '';
								
								$data_name = '';
								if ($img[0] != '')
									$data_name = 'data-name="' . $v['title'] . ' ' . $addprice . '"';



								$replace .= '
					    <li> 
                           <input class="price-change" type="radio"  value="' . $v['title'] . '@' . $v['price'] . '@' . $v['weight']. '@' . $v['img'] . '" id="a' . $v['title'] . '@' . $v['price'] . '@' . $v['weight']. '@' . $v['img'] . '" name="diy_option[' . $val['name'] . ']" ' . $data_img . '>
                           <label for="a' . $v['title'] . '@' . $v['price'] . '@' . $v['weight']. '@' . $v['img'] . '"><span class="size-value" ' . $data_big . ' ' . $data_name . '>' . $v['title'] . ' ' . $addprice . '</span><b class="ico-tick"></b></label> 
                        </li>';
								$k++;
							} 
						} 
						$replace .= '</ul>
                     <div class="form-error-msg"> --- Please Select --- </div>
                  </dd>
               </dl>             
               </div>';

						if ($relate_arr[$val["name"]]) {
							foreach($relate_arr[$val["name"]] as $relate_key => $relate_val) {
								$replace .= '<div class="form-item" id="form_item_' . $relate_name . '_' . $relate_key . '"><dl>
						  <dt>' . $val["name"] . "-" . $relate_key . '-' . $relate_name . ':</dt>
						  <dd>
							 <ul class="size-list check-require tags-for-color 6">';
								foreach($relate_val[$relate_name] as $relate_v) {
									$relate_img = $relate_v_arr = array();
									$relate_v_arr = explode('@', $relate_v);
									if ($relate_v_arr[3] != '') {
										$relate_img = wp_get_attachment_image_src($relate_v_arr[3]);
									} 
									$relate_data_img = '';
									if ($relate_img[0] != '')
										$relate_data_img = 'data-img="' . $relate_img[0] . '"';

									$relate_data_big = '';
									if ($relate_img[0] != '')
										$relate_data_big = 'data-big="' . $relate_img[0] . '"';

								if ($relate_v_arr[1] != '0')
										$addprice = sprintf(__(' + %1$s%2$s', 'eshop'), $currsymbol, number_format_i18n($relate_v_arr[1], __('2', 'eshop')));
									else
										$addprice = '';
									
									$data_name = '';
									if ($img[0] != '')
										$data_name = 'data-name="' . $relate_v_arr[0] . ' ' . $addprice . '"';

	
									$replace .= '
								<li> <input class="price-change" type="radio"  value="' . $relate_v . '" id="a' . $relate_key . '" name="diy_option[' . $relate_name . ']" ' . $data_img . '>
								   <label for="a' . $relate_v . '"><span class="size-value" ' . $relate_data_big . ' ' . $relate_data_name . '>' . $relate_v_arr[0] . '</span><b class="ico-tick"></b></label> 
								</li>';
								} 

								$replace .= '</ul>
							 <div class="form-error-msg"> --- Please Select --- </div>
						  </dd>
					   </dl> </div>';
							} 
						} 
					} 
				} else {
					if ($val["name"] != '') {
						$replace .= '<div class="form-item" id="form_item_' . $val["name"] . '_all" data-style="'.$val['show_style'].'">
               <dl>
                  <dt>' . $val["name"] . ':</dt>
                  <dd>
                     <ul class="size-list check-require tags-for-color 5">';
						$k = 0;

						foreach($val['option'] as $v) {
							$img= array();
							if ($v['relate_yes']) {
								$relate_name = $v['relate']['name'];
								$relate_arr[$val["name"]][$v["title"]][$relate_name] = $v['relate']['val'];
								$relate=$relate_name;
							}else{
								$relate_name ='';
								$relate_arr = array();
								$relate="";
							} 
							if ($v['img'] != '') {
								$size = 'full';
								$img = wp_get_attachment_image_src($v['img'],$size);
							} 
							if ($v['title'] != ''&&(intval($eshop_product['products'][1]['stkqty'])+intval($v['stock']))>0) {
								if ($k == 0) {
									$checked = "checked";
								} else {
									$checked = "";
								} 
								$data_img = '';
								if ($img[0] != '')
									$data_img = 'data-img="' . $img[0] . '"';

								$data_big = '';
								if ($img[0] != '')
									$data_big = 'data-big="' . $img[0] . '"';

                                if ($v['price'] != '0')
									$addprice = sprintf(__(' + %1$s%2$s', 'eshop'), $currsymbol, number_format_i18n($v['price'], __('2', 'eshop')));
								else
									$addprice = '';
								
								$data_name = '';
								
								if ($img[0] != '')
									$data_name = 'data-name="' . $v['title'] . ' ' . $addprice . '"';



								$replace .= '
					    <li data-cat="'.$val["name"].'" data-relate="'.$relate.'" data-val="'.$v['title'].'"> 
                           <input class="price-change" type="radio"  value="' . $v['title'] . '@' . $v['price'] . '@' . $v['weight']. '@' . $v['img'] . '" id="a' . $v['title'] . '@' . $v['price'] . '@' . $v['weight'] . '@' . $v['img'] . '" name="diy_option[' . $val['name'] . ']" ' . $data_img . '>
                           <label for="a' . $v['title'] . '@' . $v['price'] . '@' . $v['weight'] . '@' . $v['img'] . '"><span class="size-value" ' . $data_big . ' ' . $data_name . '>' . $v['title'] . '</span><b class="ico-tick"></b></label> 
                        </li>';
								$k++;
							} 
						} 
						$replace .= '</ul>
                     <div class="form-error-msg"> --- Please Select --- </div>
                  </dd>
               </dl>             
               </div>';
                            $replace .='<script type="text/javascript">';		
                            $replace .='relate_json["'.$val["name"].'"]= '.json_encode($relate_arr[$val["name"]]).';';				 
                            $replace .='</script>';
					} 
				} 
			} 
			
			// end diy_option
			// js_价格叠加
			$replace .= '
<script>
var sys_item={
	"sys_attrprice":{
	"0":{"price":"0","mktprice":"0"},';

			foreach($eshop_diy_option as $val) {
				$k = 0;
				foreach($val['option'] as $v) {
					if ($v['price'] != '') {
						if ($k == 0) {
							$checked = "checked";
						} else {
							$checked = "";
						} 
						$replace .= '"' . $v['title'] . '@' . $v['price'] . '@' . $v['weight'] . '@' . $v['img'] . '":{"price":"' . $v['price'] . '","mktprice":"' . $v['price'] . '"},';
						$k++;
					} 
				} 
			} 
			// end js_价格叠加
			$optsets = $eshop_product['optset'];
			$optsetsecho = $mainoptsecho = '';
			if (is_array($optsets)) {
				$opttable = $wpdb -> prefix . 'eshop_option_sets';
				$optnametable = $wpdb -> prefix . 'eshop_option_names';
				$optarray = array();
				foreach($optsets as $foo => $opset) {
					$qb[] = "(n.optid=$opset && n.optid=s.optid)";
				} 
				$qbs = implode("OR", $qb);
				$optionsetord = apply_filters('eshop_option_set_ordering', 'ORDER BY type, id ASC');
				$myrowres = $wpdb -> get_results("select n.optid,n.name as name, n.type, s.name as label, s.price, s.id, s.img from $opttable as s, 
					$optnametable as n where $qbs $optionsetord");
				$x = 0;
				foreach($myrowres as $myrow) {
					$optarray[$myrow -> optid]['name'] = $myrow -> name;
					$optarray[$myrow -> optid]['optid'] = $myrow -> optid;
					$optarray[$myrow -> optid]['type'] = $myrow -> type;
					$optarray[$myrow -> optid]['item'][$x]['id'] = $myrow -> id;
					$optarray[$myrow -> optid]['item'][$x]['label'] = $myrow -> label;
					$optarray[$myrow -> optid]['item'][$x]['price'] = $myrow -> price;
					$optarray[$myrow -> optid]['item'][$x]['img'] = $myrow -> img;
					$x++;
				} 

				$enumb = 0;
				if (is_array($optarray)) {
					$ox = 0;
					foreach($optarray as $optsets) {
						foreach($optsets['item'] as $opsets) {
							$ox++;
							if ($opsets['price'] != '0.00')
								$addprice = sprintf(__(' + %1$s%2$s', 'eshop'), $currsymbol, number_format_i18n($opsets['price'], __('2', 'eshop')));
							else
								$addprice = '';
							$optsetsecho .= '"' . $opsets['id'] . '":{"price":"' . $opsets['price'] . '","mktprice":"' . $opsets['price'] . '"},';
							$enumb++;
						} 
					} 

					$optsetsecho .= '}};
</script>';

					foreach($optarray as $optsets) {
						switch ($optsets['type']) {
							case '1':// select
								$optsetsecho .= "\n" . '
			<div class="form-item">
               <dl>
                  <dt>' . stripslashes(esc_attr($optsets['name'])) . ': </dt>
                  <dd>
                     <div class="select-box change-item 4">
                        <select id="optset' . $enumb . '" name="optset[' . $enumb . '][id]" class="select-size select-with-custom price-change select-require">
                           <option value="0">--- Please Select ---</option>
						   ' . "\n";
								foreach($optsets['item'] as $opsets) {
									if ($opsets['price'] != '0.00')
										$addprice = sprintf(__(' + %1$s%2$s', 'eshop'), $currsymbol, number_format_i18n($opsets['price'], __('2', 'eshop')));

									else
										$addprice = '';

									$optsetsecho .= '<option value="' . $opsets['id'] . '">' . stripslashes(esc_attr($opsets['label'])) . $addprice . '</option>' . "\n";
								} 
								$optsetsecho .= '</select>
                     </div>
                     <div class="form-error-msg"> --- Please Select --- </div>
                  </dd>
               </dl>
               </div>';

								break;
							case '0':// checkbox
								$optsetsecho .= "\n" . '
				<div class="form-item"><dl><dt>' . stripslashes(esc_attr($optsets['name'])) . ': </dt>
				<dd>
                  <div class="choose-color">
                  <ul class="color-list check-require">
				  ' . "\n";
								$ox = 0;
								foreach($optsets['item'] as $opsets) {
									$ox++;
									if ($opsets['price'] != '0.00')
										$addprice = sprintf(__(' + %1$s%2$s', 'eshop'), $currsymbol, number_format_i18n($opsets['price'], __('2', 'eshop')));
									else
										$addprice = '';
									$optsetsecho .= '<li><input type="radio"  value="' . $opsets['id'] . '" id="exopt' . $optsets['optid'] . $enumb . 'i' . $ox . $uniq . '" name="optset[' . $optsets['optid'] . '][id]" class="price-change" /><label for="exopt' . $optsets['optid'] . $enumb . 'i' . $ox . $uniq . '"><span class="color-small-img"><img disabled="" data-big="' . $opsets['img'] . '" data-name="' . stripslashes(esc_attr($opsets['label'])) . $addprice . '" src="' . $opsets['img'] . '"></span><b class="ico-tick"></b></label></li>

									' . "\n";
									$enumb++;
								} 
								$optsetsecho .= "</ul>
                  <div class='form-error-msg'> --- Please Select --- </div>
                  </div>                     
                  </dd>
               </dl>
               </div>";

								break;

							case '2':// text
								foreach($optsets['item'] as $opsets) {
									if ($opsets['price'] != '0.00')
										$addprice = sprintf(__(' + %1$s%2$s', 'eshop'), $currsymbol, number_format_i18n($opsets['price'], __('2', 'eshop')));
									else
										$addprice = '';
									$optsetsecho .= "\n" . '               <div class="form-item">
               <dl>
                  <dt>' . stripslashes(esc_attr($opsets['label'])) . ' : </dt>
                  <dd>' . "\n";
									$optsetsecho .= '<input class="form-input ipt-require" type="text" id="optset' . $enumb . '" name="optset[' . $enumb . '][text]" value="" /> ' . $addprice . '' . "\n";
									$optsetsecho .= '<input type="hidden" name="optset[' . $enumb . '][id]" value="' . $opsets['id'] . '" />' . "\n";
									$optsetsecho .= '<input type="hidden" name="optset[' . $enumb . '][type]" value="' . $optsets['type'] . '" />' . "\n";
								} 
								$optsetsecho .= '
                  </dd>
               </dl>
               </div>';

								break;
							case '3':// textarea
								foreach($optsets['item'] as $opsets) {
									if ($opsets['price'] != '0.00')
										$addprice = sprintf(__(' + %1$s%2$s', 'eshop'), $currsymbol, number_format_i18n($opsets['price'], __('2', 'eshop')));
									else
										$addprice = '';

									$optsetsecho .= "\n" . '<div class="form-item">
               <dl>
                  <dt>' . stripslashes(esc_attr($opsets['label'])) . ': </dt>' . $addprice . '</span></label>' . "\n";
									$optsetsecho .= '<dd><textarea class="text-area" id="exopt' . $optsets['optid'] . $enumb . $uniq . '" name="optset[' . $enumb . '][text]" rows="4" cols="40"></textarea></dd>' . "\n";
									$optsetsecho .= '<input type="hidden" name="optset[' . $enumb . '][id]" value="' . $opsets['id'] . '" />' . "\n";
									$optsetsecho .= '<input type="hidden" name="optset[' . $enumb . '][type]" value="' . $optsets['type'] . '" />' . "\n";
								} 
								$optsetsecho .= "</dl></div>\n";

								break;
						} 
						$enumb++;
					} 
				} 
			} else $replace .= '}};
</script>';
			if ($eshopoptions['options_num'] > 1 && !empty($eshop_product['products']['2']['option']) && !empty($eshop_product['products']['2']['price'])) {
				if (isset($eshop_product['cart_radio']) && $eshop_product['cart_radio'] == '1') {
					$opt = $eshopoptions['options_num'];
					$uniq = apply_filters('eshop_uniq', $uniq);
					$mainoptsecho .= "\n<ul class=\"eshopradio\">\n";
					for($i = 1;$i <= $opt;$i++) {
						$option = $eshop_product['products'][$i]['option'];
						$price = $eshop_product['products'][$i]['price'];

						if (isset($eshopoptions['sale_prices']) && $eshopoptions['sale_prices'] == 1 && isset($eshopoptions['sale']) && 'yes' == $eshopoptions['sale'] &&
								isset($eshop_product['products'][$i]['saleprice']) && $eshop_product['products'][$i]['saleprice'] != '' && isset($eshop_product['sale']) && $eshop_product['sale'] == 'yes') {
							$price = $eshop_product['products'][$i]['saleprice'];
						} 

						if ($i == '1') $esel = ' checked="checked"';
						else $esel = '';
						$currst = 1;
						if (isset($eshopoptions['stock_control']) && 'yes' == $eshopoptions['stock_control']) {
							if (isset($stkarr[$i]) && $stkarr[$i] > 0) $currst = $stkarr[$i];
							else $currst = 0;
						} 
						if ($option != '' && $currst > 0) {
							if ($price != '0.00')
								$mainoptsecho .= '<li><input type="radio" value="' . $i . '" id="eshopopt' . $theid . '_' . $i . $uniq . '" name="option"' . $esel . ' /><label for="eshopopt' . $theid . '_' . $i . $uniq . '">' . sprintf(__('%1$s @ %2$s%3$s', 'eshop'), stripslashes(esc_attr($option)), $currsymbol, number_format_i18n($price, __('2', 'eshop'))) . "</label>\n</li>";
							else
								$mainoptsecho .= '<li><input type="radio" value="' . $i . '" id="eshopopt' . $theid . '_' . $i . $uniq . '" name="option" /><label for="eshopopt' . $theid . '_' . $i . $uniq . '">' . stripslashes(esc_attr($option)) . '</label>' . "\n</li>";
						} 
					} 
					$mainoptsecho .= "</ul>\n"; 
					// combine 2 into 1 then extract
					$filterarray[0] = $mainoptsecho;
					$filterarray[1] = $eshop_product;
					$filterarray = apply_filters('eshop_after_radio', $filterarray);
					$mainoptsecho = $filterarray[0];
				} else {
					$opt = $eshopoptions['options_num'];
					$mainoptsecho .= "\n" . '<label for="eopt' . $theid . $uniq . '">Please Select: </label><select id="eopt' . $theid . $uniq . '" name="option"><option value="0">-- Please Select --</option>';
					for($i = 1;$i <= $opt;$i++) {
						if (isset($eshop_product['products'][$i])) {
							$option = $eshop_product['products'][$i]['option'];
							$price = $eshop_product['products'][$i]['price'];
							if (isset($eshopoptions['sale_prices']) && $eshopoptions['sale_prices'] == 1 && isset($eshopoptions['sale']) && 'yes' == $eshopoptions['sale'] && isset($eshop_product['products'][$i]['saleprice']) && $eshop_product['products'][$i]['saleprice'] != '' && isset($eshop_product['sale']) && $eshop_product['sale'] == 'yes') {
								$price = $eshop_product['products'][$i]['saleprice'];
							} 
							$currst = 1;
							if (isset($eshopoptions['stock_control']) && 'yes' == $eshopoptions['stock_control']) {
								if (isset($stkarr[$i]) && $stkarr[$i] > 0) $currst = $stkarr[$i];
								else $currst = 0;
							} 
							if ($option != '' && $currst > 0) {
								if ($price != '0.00')
									$mainoptsecho .= '<option value="' . $i . '">' . sprintf(__('%1$s - %2$s%3$s', 'eshop'), stripslashes(esc_attr($option)), $currsymbol, number_format_i18n($price, __('2', 'eshop'))) . '</option>' . "\n";
								else
									$mainoptsecho .= '<option value="' . $i . '">' . stripslashes(esc_attr($option)) . '</option>' . "\n";
							} 
						} 
					} 
					$mainoptsecho .= '</select>';
				} 
			} else {
				$option = $eshop_product['products']['1']['option'];
				$price = $eshop_product['products']['1']['price'];
				if (isset($eshopoptions['sale_prices']) && $eshopoptions['sale_prices'] == '1' && isset($eshopoptions['sale']) && 'yes' == $eshopoptions['sale'] && isset($eshop_product['products']['1']['saleprice']) && $eshop_product['products']['1']['saleprice'] != '' && isset($eshop_product['sale']) && $eshop_product['sale'] == 'yes') {
					$price = $eshop_product['products']['1']['saleprice'];
				} 
				$currst = 1;
				if (isset($eshopoptions['stock_control']) && 'yes' == $eshopoptions['stock_control']) {
					if (isset($stkarr[1]) && $stkarr[1] > 0) $currst = $stkarr[1];
				} 

				$mainoptsecho .= '<input type="hidden" name="option" value="1" />';
				if ($currst > 0) {
					if ($price != '0.00') {
						$mainoptsecho .= '
						<ul class="product-buy">
						';
					} else {
						$mainoptsecho .= '
						';
					} 
				} 
			} 
			/**
			 * default is set to true to show options sets followed by manin options
			 * change to false to show main option followed by option sets
			 */
			$eshopoptionsorder = apply_filters('eshop_options_order', true);
			if ($eshopoptionsorder)
				$replace .= $optsetsecho . $mainoptsecho;
			else
				$replace .= $mainoptsecho . $optsetsecho;
			$addqty = 1;
			if (isset($eshopoptions['min_qty']) && $eshopoptions['min_qty'] != '')
				$addqty = $eshopoptions['min_qty'];

			if ($short == 'yes') {
				$replace .= '<input type="hidden" name="qty" value="' . $addqty . '" />';
			} else {
				$replace .= '
				
				<label for="qty' . $theid . $uniq . '" class="qty">' . __('<li class="quantity"><div class="choose-qty"><label>Qty :</label>', 'eshop') . '</label>
				<span class="btn-minus"></span>
<input class="ipt-qty" type="text" value="' . $addqty . '" id="qty' . $theid . $uniq . '" maxlength="3" size="3" name="qty" /><span class="btn-plus"></span></div>';
			} 
			$replace .= '
			<input type="hidden" name="pclas" value="' . $eshop_product['shiprate'] . '" />
			<input type="hidden" name="pname" value="' . stripslashes(esc_attr($eshop_product['description'])) . '" />
			<input type="hidden" name="pid" value="' . $eshop_product['sku'] . '" />
			<input type="hidden" name="purl" value="' . get_permalink($postid) . '" />
			<input type="hidden" name="postid" value="' . $postid . '" />
			<input type="hidden" name="eshopnon" value="set" />';

			$replace .= wp_nonce_field('eshop_add_product_cart', '_wpnonce' . $uniq, true, false);
			if ($eshopoptions['addtocart_image'] == 'img') {
				$eshopfiles = eshop_files_directory();
				$imgloc = apply_filters('eshop_theme_addtocartimg', $eshopfiles['1'] . 'addtocart.png');
				$replace .= '<input class="buttonimg eshopbutton" src="' . $imgloc . '" value="' . __('Add to Cart', 'eshop') . '" title="' . __('Add selected item to your shopping basket', 'eshop') . '" type="image" />';
			} else {				if(isset($eshop_product['amazon_link']) && $eshop_product['amazon_link']){					$replace .= '<a href="'.$eshop_product['amazon_link'].'" target="_blank" style="float: right;background: #fab23a;padding: 0 10px;vertical-align: top;margin: -10px 10px;line-height: 40px;height: 40px;color: #FFF;font-size: 15px;">BUY AT AMAZON US</a>';				}				$replace .= '<input class="btn-add-cart add-to-cart" value="' . __('ADD TO CART', 'eshop') . '" title="' . __('Add selected item to your shopping basket', 'eshop') . '" type="submit" /><div class="wishlist_show"></div></li></ul>';
			} 
			$replace .= '<div class="eshopajax"></div>
			</form>';
			if (isset($eshopoptions['cart_text']) && $eshopoptions['cart_text'] != '' && $short == 'no') {
				if ($eshopoptions['cart_text_where'] == '2')
					$replace .= '<p class="eshop-cart-text-below">' . stripslashes($eshopoptions['cart_text']) . '</p>';
			} 
			$pee = $pee . $replace;
		} elseif (isset($currst) && $currst <= 0 && is_array($eshop_product)) {
			$replace = '<p class="eshopnostock"><span>' . $eshopoptions['cart_nostock'] . '</span></p>';
			$pee = $pee . $replace;
		} 
		return $pee;
	} else {
		return $pee;
	} 
} 

function eshop_boing_combination_product($pee, $short = 'no', $postid = '', $isshortcode = 'n') {
	global $wpdb, $post, $eshopchk, $eshopoptions;
	if ($postid == '') $postid = $post -> ID;
	$stkav = get_post_meta($postid, '_eshop_stock', true);
	$eshop_product = maybe_unserialize(get_post_meta($postid, '_eshop_product', true));
	$saleclass = '';
	if (isset($eshop_product['sale']) && $eshop_product['sale'] == 'yes') {
		$saleclass = ' sale';
	} 
	$stocktable = $wpdb -> prefix . "eshop_stock";
	$uniq = rand();

	if (post_password_required()) {
		return $pee;
	} 
	// if the search page we don't want the form!
	// was (!strpos($pee, '[eshop_addtocart'))
	if ($short != 'yes' && (strpos($pee, '[eshop_details') === false) && ((is_single() || is_page())) && isset($eshopoptions['details']['display']) && 'yes' == $eshopoptions['details']['display']) {
		$details = '';
		if (isset($eshop_product['products'])) {
			if ($eshopoptions['details']['show'] != '')
				$details .= " show='" . esc_attr($eshopoptions['details']['show']) . "'";
			if ($eshopoptions['details']['class'] != '')
				$details .= " class='" . esc_attr($eshopoptions['details']['class']) . "'";
			if ($eshopoptions['details']['hide'] != '')
				$details .= " options_hide='" . esc_attr($eshopoptions['details']['hide']) . "'";
			if (isset($eshopoptions['details']['tax']) && $eshopoptions['details']['tax'] != '')
				$details .= " etax_page='" . esc_attr($eshopoptions['details']['tax']) . "'";
			if ($isshortcode == 'n')
				$pee .= do_shortcode('[eshop_details' . $details . ']');
		} 
	} 

	if ((strpos($pee, '[eshop_addtocart') === false) && ((is_single() || is_page()) || 'yes' == $eshopoptions['show_forms'])) {
		// need to precheck stock
		if ($postid != '') {
			if (isset($eshopoptions['stock_control']) && 'yes' == $eshopoptions['stock_control']) {
				$anystk = false;
				$stkq = $wpdb -> get_results("SELECT option_id, available from $stocktable where post_id=$postid");
				foreach($stkq as $thisstk) {
					$stkarr[$thisstk -> option_id] = $thisstk -> available;
				} 
				$opt = $eshopoptions['options_num'];
				for($i = 1;$i <= $opt;$i++) {
					$currst = 0;
					if (isset($stkarr[$i]) && $stkarr[$i] > 0) $currst = $stkarr[$i];
					if ($currst > 0) {
						$anystk = true;
						$i = $opt;
					} 
				} 
				if ($anystk == false) {
					$stkav = '0';
					delete_post_meta($postid, '_eshop_stock');
				} 
			} 
		} 
		$replace = '';
		$stkav = apply_filters('eshop_show_addtocart', $stkav, $postid, $post);
		if ($stkav == '1') {
			$currsymbol = $eshopoptions['currency_symbol'];
			if (isset($eshopoptions['cart_text']) && $eshopoptions['cart_text'] != '' && $short == 'no') {
				if ($eshopoptions['cart_text_where'] == '1')
					$replace .= '<p class="eshop-cart-text-above">' . stripslashes($eshopoptions['cart_text']) . '</p>';
			} 
			$replace .= '<form action="' . get_permalink($eshopoptions['cart']) . '" method="post" class="eshop addtocart' . $saleclass . '" id="eshopprod' . $postid . '_post" name="myform" target="_hiddenframe' . $postid . '">
			';
			$theid = sanitize_file_name($eshop_product['sku']); 
			// option sets
			// diy_option
			$eshop_diy_option = maybe_unserialize(get_post_meta($post -> ID, '_eshop_diy_option', true));

			foreach($eshop_diy_option as $val) {
				if ($val['show_style'] == 'select') {
					if ($val["name"] != '') {
						$replace .= '<div class="form-item" id="form_item_' . $val["name"] . '_all" data-style="'.$val['show_style'].'">
						   <dl>
							  <dt>' . $val["name"] . ':</dt>
							  <dd>';
							  $k = 0; 
								  $replace .='<div class="select-box change-item 3">
										<select name="diy_option[' . $val['name'] . ']" ' . $data_img . ' class="select-size select-with-custom price-change select-require">';
										$replace .='<option value="' . $v['title'] . '@' . $v['price'] . '@' . $v['weight']. '@' . $v['img'] . '">
												--- Please Select ---
											</option>';
										foreach($val['option'] as $v) {
											$replace .='<option value="' . $v['title'] . '@' . $v['price'] . '@' . $v['weight']. '@' . $v['img'] . '">' . $v['title'] . '</option>';
										}	 								 
										$replace .='</select>
									</div>
									<div class="form-error-msg">
										--- Please Select ---
									</div>
							  </dd>
						   </dl>             
						   </div>';

						if ($relate_arr[$val["name"]]) {
							foreach($relate_arr[$val["name"]] as $relate_key => $relate_val) {
								$replace .= '<div class="form-item" id="form_item_' . $relate_name . '_' . $relate_key . '"><dl>
						  <dt>' . $val["name"] . "-" . $relate_key . '-' . $relate_name . ':</dt>
						  <dd>
							 <ul class="size-list check-require tags-for-color 4">';

								foreach($relate_val[$relate_name] as $relate_v) {
									$relate_img = $relate_v_arr = array();
									$relate_v_arr = explode('@', $relate_v);
									if ($relate_v_arr[3] != '') {
										$size = 'full';
										$relate_img = wp_get_attachment_image_src($relate_v_arr[3],$size);
									} 
									$relate_data_img = '';
									if ($relate_img[0] != '')
										$relate_data_img = 'data-img="' . $relate_img[0] . '"';

									$relate_data_big = '';
									if ($relate_img[0] != '')
										$relate_data_big = 'data-big="' . $relate_img[0] . '"';

									$data_name = '';
									if ($img[0] != '')
										$data_name = 'data-name="' . $relate_v_arr[0] . ' ' . $addprice . '"';

									if ($relate_v_arr[1] != '0')
										$addprice = sprintf(__(' + %1$s%2$s', 'eshop'), $currsymbol, number_format_i18n($relate_v_arr[1], __('2', 'eshop')));
									else
										$addprice = '';
									$replace .= '
								<li> <input class="price-change" type="radio"  value="' . $relate_v . '" id="a' . $relate_key . '" name="diy_option[' . $relate_name . ']" ' . $data_img . '>
								   <label for="a' . $relate_v . '"><span class="size-value" ' . $relate_data_big . ' ' . $relate_data_name . '>' . $relate_v_arr[0] . '</span><b class="ico-tick"></b></label> 
								</li>';
								} 
								$replace .= '</ul>
							 <div class="form-error-msg"> --- Please Select --- </div>
						  </dd>
					   </dl> </div>';
							} 
						} 
					}
				} elseif ($val['show_style'] == 'checkbox') {
					if ($val["name"] != '') {
						$replace .= '<div class="form-item" id="form_item_' . $val["name"] . '_all" data-style="'.$val['show_style'].'">
               <dl>
                  <dt>' . $val["name"] . ':</dt>
                  <dd>
                     <ul class="check-require tags-for-color 1">';
						$k = 0;

						foreach($val['option'] as $v) {
							if ($v['relate_yes']) {
								$relate_name = $v['relate']['name'];
								$relate_arr[$val["name"]][$v["title"]][$relate_name] = $v['relate']['val'];
							} 
							if ($v['img'] != '') {
								$img = wp_get_attachment_image_src($v['img']);
							} 
							if ($v['title'] != '') {
								if ($k == 0) {
									$checked = "checked";
								} else {
									$checked = "";
								} 
								$data_img = '';
								if ($img[0] != '')
									$data_img = 'data-img="' . $img[0] . '"';

								$data_big = '';
								if ($img[0] != '')
									$data_big = 'data-big="' . $img[0] . '"';

							    if ($v['price'] != '0')
									$addprice = sprintf(__(' + %1$s%2$s', 'eshop'), $currsymbol, number_format_i18n($v['price'], __('2', 'eshop')));
								else
									$addprice = '';
								
								
								$data_name = '';
								if ($img[0] != '')
									$data_name = 'data-name="' . $v['title'] . ' ' . $addprice . '"';



								$replace .= '
					    <li> 
                           <input class="price-change" type="radio"  value="' . $v['title'] . '@' . $v['price'] . '@' . $v['weight']. '@' . $v['img'] . '" id="a' . $v['title'] . '@' . $v['price'] . '@' . $v['weight'] . '" name="diy_option[' . $val['name'] . ']" ' . $data_img . '>
                           <label for="a' . $v['title'] . '@' . $v['price'] . '@' . $v['weight']. '@' . $v['img'] . '"><span class="size-value" ' . $data_big . ' ' . $data_name . '>' . $v['title'] . ' ' . $addprice . ' </span><b class="ico-tick"></b></label> 
                        </li>';
								$k++;
							} 
						} 
						$replace .= '</ul>
                     <div class="form-error-msg"> --- Please Select --- </div>
                  </dd>
               </dl>             
               </div>';

						if ($relate_arr[$val["name"]]) {
							foreach($relate_arr[$val["name"]] as $relate_key => $relate_val) {
								$replace .= '<div class="form-item" id="form_item_' . $relate_name . '_' . $relate_key . '"><dl>
						  <dt>' . $val["name"] . "-" . $relate_key . '-' . $relate_name . ':</dt>
						  <dd>
							 <ul class="size-list check-require tags-for-color 3">';
								foreach($relate_val[$relate_name] as $relate_v) {
									$relate_img = $relate_v_arr = array();
									$relate_v_arr = explode('@', $relate_v);
									if ($relate_v_arr[3] != '') {
										$relate_img = wp_get_attachment_image_src($relate_v_arr[3]);
									} 
									$relate_data_img = '';
									if ($relate_img[0] != '')
										$relate_data_img = 'data-img="' . $relate_img[0] . '"';

									$relate_data_big = '';
									if ($relate_img[0] != '')
										$relate_data_big = 'data-big="' . $relate_img[0] . '"';

									$data_name = '';
									if ($img[0] != '')
										$data_name = 'data-name="' . $relate_v_arr[0] . ' ' . $addprice . '"';

									if ($relate_v_arr[1] != '0')
										$addprice = sprintf(__(' + %1$s%2$s', 'eshop'), $currsymbol, number_format_i18n($relate_v_arr[1], __('2', 'eshop')));
									else
										$addprice = '';
									$replace .= '
								<li> <input class="price-change" type="radio"  value="' . $relate_v . '" id="a' . $relate_key . '" name="diy_option[' . $relate_name . ']" ' . $data_img . '>
								   <label for="a' . $relate_v . '"><span class="size-value" ' . $relate_data_big . ' ' . $relate_data_name . '>' . $relate_v_arr[0] . '</span><b class="ico-tick"></b></label> 
								</li>';
								} 

								$replace .= '</ul>
							 <div class="form-error-msg"> --- Please Select --- </div>
						  </dd>
					   </dl> </div>';
							} 
						} 
					} 
				} else {
					if ($val["name"] != '') {
						$replace .= '<div class="form-item" id="form_item_' . $val["name"] . '_all" data-style="'.$val['show_style'].'">
               <dl>
                  <dt>' . $val["name"] . ':</dt>
                  <dd>
                     <ul class="size-list check-require tags-for-color 2">';
						$k = 0;

						foreach($val['option'] as $v) {
							$img= array();
							if ($v['relate_yes']) {
								$relate_name = $v['relate']['name'];
								$relate_arr[$val["name"]][$v["title"]][$relate_name] = $v['relate']['val'];
								$relate=$relate_name;
							}else{
								$relate_name ='';
								$relate_arr = array();
								$relate="";
							} 
							if ($v['img'] != '') {
								$size = 'full';
								$img = wp_get_attachment_image_src($v['img'],$size);
							} 
							if ($v['title'] != '') {
								if ($k == 0) {
									$checked = "checked";
								} else {
									$checked = "";
								} 
								$data_img = '';
								if ($img[0] != '')
									$data_img = 'data-img="' . $img[0] . '"';

								$data_big = '';
								if ($img[0] != '')
									$data_big = 'data-big="' . $img[0] . '"';

								$data_name = '';
								if ($img[0] != '')
									$data_name = 'data-name="' . $v['title'] . ' ' . $addprice . '"';

								if ($v['price'] != '0')
									$addprice = sprintf(__(' + %1$s%2$s', 'eshop'), $currsymbol, number_format_i18n($v['price'], __('2', 'eshop')));
								else
									$addprice = '';

								$replace .= '
					    <li data-cat="'.$val["name"].'" data-relate="'.$relate.'" data-val="'.$v['title'].'"> 
                           <input class="price-change" type="radio"  value="' . $v['title'] . '@' . $v['price'] . '@' . $v['weight']. '@' . $v['img'] . '" id="a' . $v['title'] . '@' . $v['price'] . '@' . $v['weight'] . '@' . $v['img'] . '" name="diy_option[' . $val['name'] . ']" ' . $data_img . '>
                           <label for="a' . $v['title'] . '@' . $v['price'] . '@' . $v['weight'] . '@' . $v['img'] . '"><span class="size-value" ' . $data_big . ' ' . $data_name . '>' . $v['title'] . '</span><b class="ico-tick"></b></label> 
                        </li>';
								$k++;
							} 
						} 
						$replace .= '</ul>
                     <div class="form-error-msg"> --- Please Select --- </div>
                  </dd>
               </dl>             
               </div>';
                            $replace .='<script type="text/javascript">';		
                            $replace .='relate_json["'.$val["name"].'"]= '.json_encode($relate_arr[$val["name"]]).';';				 
                            $replace .='</script>';
					} 
				} 
			} 
			
			// end diy_option
			// js_价格叠加
			$replace .= '
<script>
var sys_item={
	"sys_attrprice":{
	"0":{"price":"0","mktprice":"0"},';

			foreach($eshop_diy_option as $val) {
				$k = 0;
				foreach($val['option'] as $v) {
					if ($v['price'] != '') {
						if ($k == 0) {
							$checked = "checked";
						} else {
							$checked = "";
						} 
						$replace .= '"' . $v['title'] . '@' . $v['price'] . '@' . $v['weight'] . '@' . $v['img'] . '":{"price":"' . $v['price'] . '","mktprice":"' . $v['price'] . '"},';
						$k++;
					} 
				} 
			} 
			// end js_价格叠加
			$optsets = $eshop_product['optset'];
			$optsetsecho = $mainoptsecho = '';
			if (is_array($optsets)) {
				$opttable = $wpdb -> prefix . 'eshop_option_sets';
				$optnametable = $wpdb -> prefix . 'eshop_option_names';
				$optarray = array();
				foreach($optsets as $foo => $opset) {
					$qb[] = "(n.optid=$opset && n.optid=s.optid)";
				} 
				$qbs = implode("OR", $qb);
				$optionsetord = apply_filters('eshop_option_set_ordering', 'ORDER BY type, id ASC');
				$myrowres = $wpdb -> get_results("select n.optid,n.name as name, n.type, s.name as label, s.price, s.id, s.img from $opttable as s, 
					$optnametable as n where $qbs $optionsetord");
				$x = 0;
				foreach($myrowres as $myrow) {
					$optarray[$myrow -> optid]['name'] = $myrow -> name;
					$optarray[$myrow -> optid]['optid'] = $myrow -> optid;
					$optarray[$myrow -> optid]['type'] = $myrow -> type;
					$optarray[$myrow -> optid]['item'][$x]['id'] = $myrow -> id;
					$optarray[$myrow -> optid]['item'][$x]['label'] = $myrow -> label;
					$optarray[$myrow -> optid]['item'][$x]['price'] = $myrow -> price;
					$optarray[$myrow -> optid]['item'][$x]['img'] = $myrow -> img;
					$x++;
				} 

				$enumb = 0;
				if (is_array($optarray)) {
					$ox = 0;
					foreach($optarray as $optsets) {
						foreach($optsets['item'] as $opsets) {
							$ox++;
							if ($opsets['price'] != '0.00')
								$addprice = sprintf(__(' + %1$s%2$s', 'eshop'), $currsymbol, number_format_i18n($opsets['price'], __('2', 'eshop')));
							else
								$addprice = '';
							$optsetsecho .= '"' . $opsets['id'] . '":{"price":"' . $opsets['price'] . '","mktprice":"' . $opsets['price'] . '"},';
							$enumb++;
						} 
					} 

					$optsetsecho .= '}};
</script>';

					foreach($optarray as $optsets) {
						switch ($optsets['type']) {
							case '1':// select
								$optsetsecho .= "\n" . '
			<div class="form-item">
               <dl>
                  <dt>' . stripslashes(esc_attr($optsets['name'])) . ': </dt>
                  <dd>
                     <div class="select-box change-item 2">
                        <select id="optset' . $enumb . '" name="optset[' . $enumb . '][id]" class="select-size select-with-custom price-change select-require">
                           <option value="0">--- Please Select ---</option>
						   ' . "\n";
								foreach($optsets['item'] as $opsets) {
									if ($opsets['price'] != '0.00')
										$addprice = sprintf(__(' + %1$s%2$s', 'eshop'), $currsymbol, number_format_i18n($opsets['price'], __('2', 'eshop')));

									else
										$addprice = '';

									$optsetsecho .= '<option value="' . $opsets['id'] . '">' . stripslashes(esc_attr($opsets['label'])) . $addprice . '</option>' . "\n";
								} 
								$optsetsecho .= '</select>
                     </div>
                     <div class="form-error-msg"> --- Please Select --- </div>
                  </dd>
               </dl>
               </div>';

								break;
							case '0':// checkbox
								$optsetsecho .= "\n" . '
				<div class="form-item"><dl><dt>' . stripslashes(esc_attr($optsets['name'])) . ': </dt>
				<dd>
                  <div class="choose-color">
                  <ul class="color-list check-require">
				  ' . "\n";
								$ox = 0;
								foreach($optsets['item'] as $opsets) {
									$ox++;
									if ($opsets['price'] != '0.00')
										$addprice = sprintf(__(' + %1$s%2$s', 'eshop'), $currsymbol, number_format_i18n($opsets['price'], __('2', 'eshop')));
									else
										$addprice = '';
									$optsetsecho .= '<li><input type="radio"  value="' . $opsets['id'] . '" id="exopt' . $optsets['optid'] . $enumb . 'i' . $ox . $uniq . '" name="optset[' . $optsets['optid'] . '][id]" class="price-change" /><label for="exopt' . $optsets['optid'] . $enumb . 'i' . $ox . $uniq . '"><span class="color-small-img"><img disabled="" data-big="' . $opsets['img'] . '" data-name="' . stripslashes(esc_attr($opsets['label'])) . $addprice . '" src="' . $opsets['img'] . '"></span><b class="ico-tick"></b></label></li>

									' . "\n";
									$enumb++;
								} 
								$optsetsecho .= "</ul>
                  <div class='form-error-msg'> --- Please Select --- </div>
                  </div>                     
                  </dd>
               </dl>
               </div>";

								break;

							case '2':// text
								foreach($optsets['item'] as $opsets) {
									if ($opsets['price'] != '0.00')
										$addprice = sprintf(__(' + %1$s%2$s', 'eshop'), $currsymbol, number_format_i18n($opsets['price'], __('2', 'eshop')));
									else
										$addprice = '';
									$optsetsecho .= "\n" . '               <div class="form-item">
               <dl>
                  <dt>' . stripslashes(esc_attr($opsets['label'])) . ' : </dt>
                  <dd>' . "\n";
									$optsetsecho .= '<input class="form-input ipt-require" type="text" id="optset' . $enumb . '" name="optset[' . $enumb . '][text]" value="" /> ' . $addprice . '' . "\n";
									$optsetsecho .= '<input type="hidden" name="optset[' . $enumb . '][id]" value="' . $opsets['id'] . '" />' . "\n";
									$optsetsecho .= '<input type="hidden" name="optset[' . $enumb . '][type]" value="' . $optsets['type'] . '" />' . "\n";
								} 
								$optsetsecho .= '
                  </dd>
               </dl>
               </div>';

								break;
							case '3':// textarea
								foreach($optsets['item'] as $opsets) {
									if ($opsets['price'] != '0.00')
										$addprice = sprintf(__(' + %1$s%2$s', 'eshop'), $currsymbol, number_format_i18n($opsets['price'], __('2', 'eshop')));
									else
										$addprice = '';

									$optsetsecho .= "\n" . '<div class="form-item">
               <dl>
                  <dt>' . stripslashes(esc_attr($opsets['label'])) . ': </dt>' . $addprice . '</span></label>' . "\n";
									$optsetsecho .= '<dd><textarea class="text-area" id="exopt' . $optsets['optid'] . $enumb . $uniq . '" name="optset[' . $enumb . '][text]" rows="4" cols="40"></textarea></dd>' . "\n";
									$optsetsecho .= '<input type="hidden" name="optset[' . $enumb . '][id]" value="' . $opsets['id'] . '" />' . "\n";
									$optsetsecho .= '<input type="hidden" name="optset[' . $enumb . '][type]" value="' . $optsets['type'] . '" />' . "\n";
								} 
								$optsetsecho .= "</dl></div>\n";

								break;
						} 
						$enumb++;
					} 
				} 
			} else $replace .= '}};
</script>';
			if ($eshopoptions['options_num'] > 1 && !empty($eshop_product['products']['2']['option']) && !empty($eshop_product['products']['2']['price'])) {
				if (isset($eshop_product['cart_radio']) && $eshop_product['cart_radio'] == '1') {
					$opt = $eshopoptions['options_num'];
					$uniq = apply_filters('eshop_uniq', $uniq);
					$mainoptsecho .= "\n<ul class=\"eshopradio\">\n";
					for($i = 1;$i <= $opt;$i++) {
						$option = $eshop_product['products'][$i]['option'];
						$price = $eshop_product['products'][$i]['price'];

						if (isset($eshopoptions['sale_prices']) && $eshopoptions['sale_prices'] == 1 && isset($eshopoptions['sale']) && 'yes' == $eshopoptions['sale'] &&
								isset($eshop_product['products'][$i]['saleprice']) && $eshop_product['products'][$i]['saleprice'] != '' && isset($eshop_product['sale']) && $eshop_product['sale'] == 'yes') {
							$price = $eshop_product['products'][$i]['saleprice'];
						} 

						if ($i == '1') $esel = ' checked="checked"';
						else $esel = '';
						$currst = 1;
						if (isset($eshopoptions['stock_control']) && 'yes' == $eshopoptions['stock_control']) {
							if (isset($stkarr[$i]) && $stkarr[$i] > 0) $currst = $stkarr[$i];
							else $currst = 0;
						} 
						if ($option != '' && $currst > 0) {
							if ($price != '0.00')
								$mainoptsecho .= '<li><input type="radio" value="' . $i . '" id="eshopopt' . $theid . '_' . $i . $uniq . '" name="option"' . $esel . ' /><label for="eshopopt' . $theid . '_' . $i . $uniq . '">' . sprintf(__('%1$s @ %2$s%3$s', 'eshop'), stripslashes(esc_attr($option)), $currsymbol, number_format_i18n($price, __('2', 'eshop'))) . "</label>\n</li>";
							else
								$mainoptsecho .= '<li><input type="radio" value="' . $i . '" id="eshopopt' . $theid . '_' . $i . $uniq . '" name="option" /><label for="eshopopt' . $theid . '_' . $i . $uniq . '">' . stripslashes(esc_attr($option)) . '</label>' . "\n</li>";
						} 
					} 
					$mainoptsecho .= "</ul>\n"; 
					// combine 2 into 1 then extract
					$filterarray[0] = $mainoptsecho;
					$filterarray[1] = $eshop_product;
					$filterarray = apply_filters('eshop_after_radio', $filterarray);
					$mainoptsecho = $filterarray[0];
				} else {
					$opt = $eshopoptions['options_num'];
					$mainoptsecho .= "\n" . '<label for="eopt' . $theid . $uniq . '">Please Select: </label><select id="eopt' . $theid . $uniq . '" name="option"><option value="0">-- Please Select --</option>';
					for($i = 1;$i <= $opt;$i++) {
						if (isset($eshop_product['products'][$i])) {
							$option = $eshop_product['products'][$i]['option'];
							$price = $eshop_product['products'][$i]['price'];
							if (isset($eshopoptions['sale_prices']) && $eshopoptions['sale_prices'] == 1 && isset($eshopoptions['sale']) && 'yes' == $eshopoptions['sale'] && isset($eshop_product['products'][$i]['saleprice']) && $eshop_product['products'][$i]['saleprice'] != '' && isset($eshop_product['sale']) && $eshop_product['sale'] == 'yes') {
								$price = $eshop_product['products'][$i]['saleprice'];
							} 
							$currst = 1;
							if (isset($eshopoptions['stock_control']) && 'yes' == $eshopoptions['stock_control']) {
								if (isset($stkarr[$i]) && $stkarr[$i] > 0) $currst = $stkarr[$i];
								else $currst = 0;
							} 
							if ($option != '' && $currst > 0) {
								if ($price != '0.00')
									$mainoptsecho .= '<option value="' . $i . '">' . sprintf(__('%1$s - %2$s%3$s', 'eshop'), stripslashes(esc_attr($option)), $currsymbol, number_format_i18n($price, __('2', 'eshop'))) . '</option>' . "\n";
								else
									$mainoptsecho .= '<option value="' . $i . '">' . stripslashes(esc_attr($option)) . '</option>' . "\n";
							} 
						} 
					} 
					$mainoptsecho .= '</select>';
				} 
			} else {
				$option = $eshop_product['products']['1']['option'];
				$price = $eshop_product['products']['1']['price'];
				if (isset($eshopoptions['sale_prices']) && $eshopoptions['sale_prices'] == '1' && isset($eshopoptions['sale']) && 'yes' == $eshopoptions['sale'] && isset($eshop_product['products']['1']['saleprice']) && $eshop_product['products']['1']['saleprice'] != '' && isset($eshop_product['sale']) && $eshop_product['sale'] == 'yes') {
					$price = $eshop_product['products']['1']['saleprice'];
				} 
				$currst = 1;
				if (isset($eshopoptions['stock_control']) && 'yes' == $eshopoptions['stock_control']) {
					if (isset($stkarr[1]) && $stkarr[1] > 0) $currst = $stkarr[1];
				} 

				$mainoptsecho .= '<input type="hidden" name="option" value="1" />';
				if ($currst > 0) {
					if ($price != '0.00') {
						$mainoptsecho .= '
						<ul class="product-buy">
						';
					} else {
						$mainoptsecho .= '
						';
					} 
				} 
			} 
			/**
			 * default is set to true to show options sets followed by manin options
			 * change to false to show main option followed by option sets
			 */
			$eshopoptionsorder = apply_filters('eshop_options_order', true);
			if ($eshopoptionsorder)
				$replace .= $optsetsecho . $mainoptsecho;
			else
				$replace .= $mainoptsecho . $optsetsecho;
			$addqty = 1;
			if (isset($eshopoptions['min_qty']) && $eshopoptions['min_qty'] != '')
				$addqty = $eshopoptions['min_qty'];

			if ($short == 'yes') {
				$replace .= '<input type="hidden" name="qty" value="' . $addqty . '" />';
			} else {
				$replace .= '
				
				<label for="qty' . $theid . $uniq . '" class="qty">' . __('<li class="quantity"><div class="choose-qty"><label>Qty :</label>', 'eshop') . '</label>
				<span class="btn-minus"></span><input class="ipt-qty" type="text" value="' . $addqty . '" id="qty' . $theid . $uniq . '" maxlength="3" size="3" name="qty" /><span class="btn-plus"></span></div>';
			} 
			$replace .= '	<input type="hidden" name="pclas" value="' . $eshop_product['shiprate'] . '" />
			<input type="hidden" name="pname" value="' . stripslashes(esc_attr($eshop_product['description'])) . '" />
			<input type="hidden" name="pid" value="' . $eshop_product['sku'] . '" />
			<input type="hidden" name="purl" value="' . get_permalink($postid) . '" />
			<input type="hidden" name="postid" value="' . $postid . '" />
			<input type="hidden" name="eshopnon" value="set" />';

			$replace .= wp_nonce_field('eshop_add_product_cart', '_wpnonce' . $uniq, true, false);
			if ($eshopoptions['addtocart_image'] == 'img') {
				$eshopfiles = eshop_files_directory();
				$imgloc = apply_filters('eshop_theme_addtocartimg', $eshopfiles['1'] . 'addtocart.png');
				$replace .= '<input class="buttonimg eshopbutton" src="' . $imgloc . '" value="' . __('Add to Cart', 'eshop') . '" title="' . __('Add selected item to your shopping basket', 'eshop') . '" type="image" />';
			} else {				if(isset($eshop_product['amazon_link']) && $eshop_product['amazon_link']){					$replace .= '<a href="'.$eshop_product['amazon_link'].'" target="_blank" style="float: right;background: #fab23a;padding: 0 10px;vertical-align: top;margin: -10px 10px;line-height: 40px;height: 40px;color: #FFF;font-size: 15px;">BUY AT AMAZON US</a>';				}				$replace .= '<input class="btn-add-cart add-to-cart" value="' . __('ADD TO CART', 'eshop') . '" title="' . __('Add selected item to your shopping basket', 'eshop') . '" type="submit" /><div class="wishlist_show"></div></li></ul>';
			} 
			$replace .= '<div class="eshopajax"></div>
			</form>';
			if (isset($eshopoptions['cart_text']) && $eshopoptions['cart_text'] != '' && $short == 'no') {
				if ($eshopoptions['cart_text_where'] == '2')
					$replace .= '<p class="eshop-cart-text-below">' . stripslashes($eshopoptions['cart_text']) . '</p>';
			} 
			$pee = $pee . $replace;
		} elseif (isset($currst) && $currst <= 0 && is_array($eshop_product)) {
			$replace = '<p class="eshopnostock"><span>' . $eshopoptions['cart_nostock'] . '</span></p>';
			$pee = $pee . $replace;
		} 
		return $pee;
	} else {
		return $pee;
	} 
} 

?>