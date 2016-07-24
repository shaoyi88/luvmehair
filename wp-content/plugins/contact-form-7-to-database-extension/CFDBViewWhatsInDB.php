<?php
require_once('CF7DBPlugin.php');
require_once('CFDBView.php');
require_once('ExportToHtmlTable.php');

class CFDBViewWhatsInDB extends CFDBView {

    function display(&$plugin) {
        if ($plugin == null) {
            $plugin = new CF7DBPlugin;
        }
        $canEdit = $plugin->canUserDoRoleOption('CanChangeSubmitData');
        $this->pageHeader($plugin);

        global $wpdb;
        $tableName = $plugin->getSubmitsTableName();
        $useDataTables = $plugin->getOption('UseDataTablesJS', 'true') == 'true';
        $tableHtmlId = 'cf2dbtable';

        // Identify which forms have data in the database
        $formsList = $plugin->getForms();
        if (count($formsList) == 0) {
            _e('<br />暂无询盘数据，客户询盘数据会直接发送到您的邮箱, 这里会对数据进行保存, 方便查询！', 'contact-form-7-to-database-extension');
            return;
        }
        $page = 1;
        if (isset($_REQUEST['dbpage'])) {
            $page = $_REQUEST['dbpage'];
        }
        else if (isset($_GET['dbpage'])) {
            $page = $_GET['dbpage'];
        }
        $currSelection = null;
        if (isset($_REQUEST['form_name'])) {
            $currSelection = $_REQUEST['form_name'];
        }
        else if (isset($_GET['form_name'])) {
            $currSelection = $_GET['form_name'];
        }
        // If there is only one form in the DB, select that by default
        if (!$currSelection && count($formsList) == 1) {
            $currSelection = $formsList[0];
            // Bug fix: Need to set this so the Editor plugin can reference it
            $_REQUEST['form_name'] = $formsList[0];
        }
        if ($currSelection) {
            // Check for delete operation
            if (isset($_POST['delete']) && $canEdit) {
                if (isset($_POST['submit_time'])) {
                    $submitTime = $_POST['submit_time'];
                    $wpdb->query(
                        $wpdb->prepare(
                            "delete from `$tableName` where `form_name` = '%s' and `submit_time` = %F",
                            $currSelection, $submitTime));
                }
                else  if (isset($_POST['all'])) {
                    $wpdb->query(
                        $wpdb->prepare(
                            "delete from `$tableName` where `form_name` = '%s'", $currSelection));
                }
                else {
                    foreach ($_POST as $name => $value) { // checkboxes
                        if ($value == 'row') {
                            // Dots and spaces in variable names are converted to underscores. For example <input name="a.b" /> becomes $_REQUEST["a_b"].
                            // http://www.php.net/manual/en/language.variables.external.php
                            // We are expecting a time value like '1300728460.6626' but will instead get '1300728460_6626'
                            // so we need to put the '.' back in before going to the DB.
                            $name = str_replace('_', '.', $name);
                            $wpdb->query(
                                $wpdb->prepare(
                                    "delete from `$tableName` where `form_name` = '%s' and `submit_time` = %F",
                                    $currSelection, $name));
							
                        }
                    }
                }
            }
            else if (isset($_POST['delete_wpcf7']) && $canEdit) {
                $plugin->delete_wpcf7_fields($currSelection);
                $plugin->add_wpcf7_noSaveFields();
            }
        }
        // Form selection drop-down list
        $pluginDirUrl = $plugin->getPluginDirUrl();

        ?>
		<html>
<head>
<meta charset="utf-8">
<title>后台</title>
<link href="../wp-content/plugins/contact-form-7-to-database-extension/admin-public.css" rel="stylesheet">
</head>

<body>

<div class="main-wrap">

<!-- 顶部 -->
<div class="inquiry-tbar">
   <div class="tbar-in"> 
   <div style="float:right;padding:3px 0 0 0;">			                <?php if ($currSelection && $canEdit) { ?>
                <form action="" method="post">
                    <input name="form_name" type="hidden" value="<?php echo $currSelection ?>"/>
                    <input name="all" type="hidden" value="y"/>
                    <input name="delete" type="submit"
                           value="<?php _e('清除所有询盘信息', 'contact-form-7-to-database-extension'); ?>"
                           onclick="return confirm('确定要清除所有询盘信息吗？是所有询盘信息！')"/>
                </form>
                <?php } ?></div>
      <div class="fr">
 <?php if ($currSelection) { ?>
                <script type="text/javascript" language="Javascript">
                    function changeDbPage(page) {
                        var newdiv = document.createElement('div');
                        newdiv.innerHTML = "<input id='dbpage' name='dbpage' type='hidden' value='" + page + "'>";
                        var dispForm = document.forms['displayform'];
                        dispForm.appendChild(newdiv);
                        dispForm.submit();
                    }
                    function getSearchFieldValue() {
                        var searchVal = '';
                        if (typeof jQuery == 'function') {
                            try {
                                searchVal = jQuery('#<?php echo $tableHtmlId;?>_filter input').val();
                            }
                            catch (e) {
                            }
                        }
                        return searchVal;
                    }
                    function exportData(encSelect) {
                        var enc = encSelect.options[encSelect.selectedIndex].value;
                        if (enc == 'GSS') {
                            if (typeof jQuery == 'function') {
                                try {
                                    jQuery("#GoogleCredentialsDialog").dialog({ autoOpen: false, title: '<?php _e("Google Login for Upload", 'contact-form-7-to-database-extension')?>' });
                                    jQuery("#GoogleCredentialsDialog").dialog('open');
                                    jQuery("#guser").focus();
                                }
                                catch (e) {
                                    alert('Error: ' + e.message);
                                }
                            }
                            else {
                                alert("<?php _e('Cannot perform operation because jQuery is not loaded in this page', 'contact-form-7-to-database-extension')?>");
                            }
                        }
                        else {
                            var url = '<?php echo admin_url('admin-ajax.php') ?>?action=cfdb-export&form=<?php echo urlencode($currSelection) ?>&enc=' + enc;
                            var searchVal = getSearchFieldValue();
                            if (searchVal != null && searchVal != "") {
                                url += '&search=' + encodeURIComponent(searchVal);
                            }
                            location.href = url;
                        }
                    }
                    function uploadGoogleSS() {
                        var key = '3fde789a';
                        var guser = printHex(des(key, jQuery('#guser').attr('value'), 1));
                        var gpwd = printHex(des(key, jQuery('#gpwd').attr('value'), 1));
                        jQuery("#GoogleCredentialsDialog").dialog('close');
                        var form = document.createElement("form");
                        form.setAttribute("method", 'POST');
                        var url = '<?php echo $pluginDirUrl ?>export.php?form=<?php echo urlencode($currSelection) ?>&enc=GSS';
                        var searchVal = getSearchFieldValue();
                        if (searchVal != null && searchVal != "") {
                            url += '&search=' + encodeURI(searchVal);
                        }
                        form.setAttribute("action", url);
                        var params = {guser: encodeURI(guser), gpwd: encodeURI(gpwd)};
                        for (var pkey in params) {
                            var hiddenField = document.createElement("input");
                            hiddenField.setAttribute("type", "hidden");
                            hiddenField.setAttribute("name", pkey);
                            hiddenField.setAttribute("value", params[pkey]);
                            form.appendChild(hiddenField);
                        }
                        document.body.appendChild(form);
                        form.submit();
                    }
                </script>
                <form name="exportcsv" action="">
                    <input type="hidden" name="unbuffered" value="true"/>
                    <select size="1" name="enc">
                        <option id="IQY" value="IQY">
                            <?php _e('Excel Internet Query', 'contact-form-7-to-database-extension'); ?>
                        </option>
                        <option id="CSVUTF8BOM" value="CSVUTF8BOM">
                            <?php _e('Excel CSV (UTF8-BOM)', 'contact-form-7-to-database-extension'); ?>
                        </option>
                        <option id="TSVUTF16LEBOM" value="TSVUTF16LEBOM">
                            <?php _e('Excel TSV (UTF16LE-BOM)', 'contact-form-7-to-database-extension'); ?>
                        </option>
                        <option id="CSVUTF8" value="CSVUTF8">
                            <?php _e('Plain CSV (UTF-8)', 'contact-form-7-to-database-extension'); ?>
                        </option>
                        <option id="CSVSJIS" value="CSVSJIS">
                            <?php _e('Excel CSV for Japanese (Shift-JIS)', 'contact-form-7-to-database-extension'); ?>
                        </option>
                        <option id="GSS" value="GSS">
                            <?php _e('Google Spreadsheet', 'contact-form-7-to-database-extension'); ?>
                        </option>
                        <option id="GLD" value="GLD">
                            <?php _e('Google Spreadsheet Live Data', 'contact-form-7-to-database-extension'); ?>
                        </option>
                        <option id="HTML" value="HTML">
                            <?php _e('HTML', 'contact-form-7-to-database-extension'); ?>
                        </option>
                        <option id="JSON" value="JSON">
                            <?php _e('JSON', 'contact-form-7-to-database-extension'); ?>
                        </option>
                    </select>
                    <input name="exportButton" type="button"
                           value="<?php _e('导出所有询盘信息', 'contact-form-7-to-database-extension'); ?>"
                           onclick="exportData(this.form.elements['enc'])"/>
                   
                </form>
                <?php } ?>
	
      </div>
      <ul class="inquiry-tabs">
	  

                        <?php foreach ($formsList as $formName) {
                            $selected = ($formName == $currSelection) ? "selected" : "";
                        ?>
						         <li><a href="admin.php?page=CF7DBPluginSubmissions&form_name=<?php echo $formName ?>">询盘表单: <?php echo $formName ?></a></li>
                        <?php } ?>
      </ul>      
   </div>
   <div style="float:right;padding:3px 0 0 0;">客户询盘会同时发送到您设置的企业邮箱，请注意查看！</div>
</div>


        <?php
            if ($currSelection && $canEdit && $useDataTables) {
        ?>
        
        <?php
            }
        ?>



    <?php
            if ($currSelection) {
            // Show table of form data
            if ($useDataTables) {
                $i18nUrl = $plugin->getDataTableTranslationUrl();

                // Work out the datatable menu for number or rows shown
                $maxVisible = $plugin->getOption('MaxVisibleRows', -1);
                if (!is_numeric($maxVisible)) {
                    $maxVisible = -1;
                }
                $menuJS = $this->createDatatableLengthMenuJavascriptString($maxVisible);
                ?>
            <script type="text/javascript" language="Javascript">
                var oTable;
                jQuery(document).ready(function() {
                    oTable = jQuery('#<?php echo $tableHtmlId ?>').dataTable({ <?php // "sDom": 'Rlfrtip', // ColReorder ?>
                        "bJQueryUI": true,
                        "aaSorting": [],
                        "bScrollCollapse": true,
                        "sScrollX":"100%",
                        "iDisplayLength": <?php echo $maxVisible ?>,
                        "aLengthMenu": <?php echo $menuJS ?>
                        <?php
                        if ($i18nUrl) {
                            echo ", \"oLanguage\": { \"sUrl\":  \"$i18nUrl\" }";
                        }
                        if ($canEdit) {
                            do_action_ref_array('cfdb_edit_fnDrawCallbackJSON', array($tableHtmlId));
                        }

                        ?>
                    });
                    jQuery('th[id="delete_th"]').unbind('click'); <?php // Don't sort delete column ?>
                });

            </script>
            <?php

            }
            if ($canEdit) {
                ?>
        <form action="" method="post">
            <input name="form_name" type="hidden" value="<?php echo $currSelection ?>"/>
                <input name="delete" type="hidden" value="rows"/>
                <?php

            }
            ?>
            <?php
                $exporter = new ExportToHtmlTable();
            $dbRowCount = $exporter->getDBRowCount($currSelection);
            $maxRows = $plugin->getOption('MaxRows', '100');
            $startRow = $this->paginationDiv($plugin, $dbRowCount, $maxRows, $page);
            ?>
            <div <?php if (!$useDataTables) echo 'style="overflow:auto; max-height:500px; max-width:500px; min-width:75px"' ?>>
            <?php
                // Pick up any options that the user enters in the URL.
                // This will include extraneous "form_name" and "page" GET params which are in the URL
                // for this admin page
                $options = array_merge($_POST, $_GET);
                $options['canDelete'] = $canEdit;
                if ($maxRows) {
                    $options['limit'] = ($startRow - 1) . ',' . ($maxRows);
                }
                if ($useDataTables) {
                    $options['id'] = $tableHtmlId;
                    $options['class'] = '';
                    $options['style'] = "#$tableHtmlId td > div { max-height: 100px;  min-width:75px; overflow: auto; font-size: small; }"; // don't let cells get too tall
                }
                $exporter->export($currSelection, $options);
                ?>
            </div>
            <?php if ($canEdit) {
                ?>
            </form>
        <?php

            }
        }
        ?>
   
    <?php
           if ($currSelection && 'true' == $plugin->getOption('ShowQuery')) {
            ?>
        <div id="query" style="margin: 20px; border: dotted #d3d3d3 1pt;">
            <strong><?php _e('Query:', 'contact-form-7-to-database-extension') ?></strong><br/>
            <pre><?php echo $exporter->getPivotQuery($currSelection); ?></pre>
        </div>
        <?php

        }
        if ($currSelection) {
            ?>
        <div id="GoogleCredentialsDialog" style="display:none; background-color:#EEEEEE;">
            <table>
                <tbody>
                <tr>
                    <td><label for="guser">User</label></td>
                    <td><input id="guser" type="text" size="25" value="@gmail.com"/></td>
                </tr>
                <tr>
                    <td><label for="gpwd">Password</label></td>
                    <td><input id="gpwd" type="password" size="25" value=""/></td>
                </tr>
                <tr>
                    <td></td>
                    <td>
                        <input type="button" value="<?php _e('Cancel', 'contact-form-7-to-database-extension') ?>"
                               onclick="jQuery('#GoogleCredentialsDialog').dialog('close');"/>
                        <input type="button" value="<?php _e('Upload', 'contact-form-7-to-database-extension') ?>"
                               onclick="uploadGoogleSS()"/>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
        <script type="text/javascript" language="Javascript">
            var addColumnLabelText = '<?php _e('Add Column', 'contact-form-7-to-database-extension'); ?>';
            var deleteColumnLabelText = '<?php _e('Delete Column', 'contact-form-7-to-database-extension'); ?>';
        </script>
        <?php
            do_action_ref_array('cfdb_edit_setup', array($plugin));
        }
    }

    /**
     * @param  $plugin CF7DBPlugin
     * @param  $totalRows integer
     * @param  $rowsPerPage integer
     * @param  $page integer
     * @return integer $startRow
     */
    protected function paginationDiv($plugin, $totalRows, $rowsPerPage, $page) {

        $nextLabel = __('next »', 'contact-form-7-to-database-extension');
        $prevLabel = __('« prev', 'contact-form-7-to-database-extension');

        echo '<link rel="stylesheet" href="';
        echo $plugin->getPluginFileUrl();
        echo '/css/paginate.css';
        echo '" type="text/css"/>';
        //        echo '<style type="text/css">';
        //        include('css/paginate.css');
        //        echo '</style>';


        if (!$page || $page < 1) $page = 1; //default to 1.
        $startRow = $rowsPerPage * ($page - 1) + 1;


        $endRow = min($startRow + $rowsPerPage - 1, $totalRows);
        echo '';
        printf(__('', 'contact-form-7-to-database-extension'),
               $startRow, $endRow, $totalRows);
        echo '';
        echo '<div class="cfdb_paginate">';

        $numPages = ($rowsPerPage > 0) ? ceil($totalRows / $rowsPerPage) : 1;
        $adjacents = 3;

        /* Setup page vars for display. */
        $prev = $page - 1; //previous page is page - 1
        $next = $page + 1; //next page is page + 1
        $lastpage = $numPages;
        $lpm1 = $lastpage - 1; //last page minus 1

        /*
            Now we apply our rules and draw the pagination object.
            We're actually saving the code to a variable in case we want to draw it more than once.
        */
        if ($lastpage > 1) {
            echo  "<div class=\"pagination\">";
            //previous button
            if ($page > 1)
                echo  $this->paginateLink($prev, $prevLabel);
            else
                echo  "<span class=\"disabled\">$prevLabel</span>";

            if ($lastpage < 7 + ($adjacents * 2)) //not enough pages to bother breaking it up
            {
                for ($counter = 1; $counter <= $lastpage; $counter++)
                {
                    if ($counter == $page)
                        echo  "<span class=\"current\">$counter</span>";
                    else
                        echo  $this->paginateLink($counter, $counter);
                }
            }
            elseif ($lastpage > 5 + ($adjacents * 2)) //enough pages to hide some
            {
                //close to beginning; only hide later pages
                if ($page < 1 + ($adjacents * 2)) {
                    for ($counter = 1; $counter < 4 + ($adjacents * 2); $counter++)
                    {
                        if ($counter == $page)
                            echo  "<span class=\"current\">$counter</span>";
                        else
                            echo  $this->paginateLink($counter, $counter);
                    }
                    echo  '...';
                    echo  $this->paginateLink($lpm1, $lpm1);
                    echo  $this->paginateLink($lastpage, $lastpage);
                }
                    //in middle; hide some front and some back
                elseif ($lastpage - ($adjacents * 2) > $page && $page > ($adjacents * 2))
                {
                    echo  $this->paginateLink(1, 1);
                    echo  $this->paginateLink(2, 2);
                    echo  '...';
                    for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++)
                    {
                        if ($counter == $page)
                            echo  "<span class=\"current\">$counter</span>";
                        else
                            echo  $this->paginateLink($counter, $counter);
                    }
                    echo  '...';
                    echo  $this->paginateLink($lpm1, $lpm1);
                    echo  $this->paginateLink($lastpage, $lastpage);
                }
                    //close to end; only hide early pages
                else
                {
                    echo  $this->paginateLink(1, 1);
                    echo  $this->paginateLink(2, 2);
                    echo  '...';
                    for ($counter = $lastpage - (2 + ($adjacents * 2)); $counter <= $lastpage; $counter++)
                    {
                        if ($counter == $page)
                            echo  "<span class=\"current\">$counter</span>";
                        else
                            echo  $this->paginateLink($counter, $counter);
                    }
                }
            }

            //next button
            if ($page < $counter - 1)
                echo  $this->paginateLink($next, $nextLabel);
            else
                echo  "<span class=\"disabled\">$nextLabel</span>";
            echo  "</div>\n";
        }

        echo '</div>';
        return $startRow;
    }

    protected function paginateLink($page, $label) {
        return "<a href=\"#\" onclick=\"changeDbPage('$page');\">$label</a>";
    }

    /**
     * Create aLengthMenu javascript string for databatable
     * @param $maxVisible
     * @return string
     */
    protected function createDatatableLengthMenuJavascriptString($maxVisible) {
        $numRowsMenu = array();
        $found = $maxVisible == -1;
        foreach (array(10, 25, 50, 100) as $entry) {
            if ($found) {
                $numRowsMenu[] = $entry;
            } else {
                if ($maxVisible == $entry) {
                    $found = true;
                } else if ($maxVisible < $entry) {
                    $numRowsMenu[] = $maxVisible;
                    $found = true;
                }
                $numRowsMenu[] = $entry;
            }
        }
        if (!$found) {
            $numRowsMenu[] = $maxVisible;
        }
        $numRowsMenu[] = -1;

        $menuJS1 = '[[';
        $menuJS2 = ', [';
        foreach ($numRowsMenu as $val) {
            $menuJS1 .= $val . ',';
            if ($val == -1) {
                $val = '"' . __('All', 'contact-form-7-to-database-extension') . '"';
            }
            $menuJS2 .= $val . ',';
        }
        $menuJS1 = substr($menuJS1, 0, -1) . ']';
        $menuJS2 = substr($menuJS2, 0, -1) . ']]';
        return $menuJS1 . $menuJS2;
    }

}
