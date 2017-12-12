<?
function SLIM_A_LEFT_H1($PARAM) {
	$out = $_SESSION['engine']['langpack']['81'];
	return $out;
}

function SLIM_A_LEFT($PARAMS) {
	mysql_query("update `fe2_slim_groups` set `sort`=`id` where `sort`='0'");
	mysql_query("update `fe2_slim_items` set `sort`=`id` where `sort`='0'");
	unset($path);
	if ($PARAMS) {
		$PARAMS = explode("=", $PARAMS);
		if ($PARAMS[0] == "ei")//extended item
		{
			$e = explode(",", $PARAMS[1]);
			$P = $e[1];
			do {
				$path[$P] = "1";
				$P = mysql_get_param("fe2_slim_groups", "parent", "id", $P);
			} while($P!=0);

			$PARAMS[1] = mysql_get_param("fe2_slim_items", "parent", "id", $e[0]);
		} else if ($PARAMS[0] == "i") {
			$PARAMS[1] = mysql_get_param("fe2_slim_items", "parent", "id", $PARAMS[1]);
			$path[$PARAMS[1]] = "1";
		}
		do {
			$path[$PARAMS[1]] = "1";
			$PARAMS[1] = mysql_get_param("fe2_slim_groups", "parent", "id", $PARAMS[1]);
		} while($PARAMS[1]!=0);
	} else {
	}

	$out .= admin_build_slim_tree(0, 0, $path);
	return $out;
}

function SLIM_A_H1($PARAM) {
	$out = $_SESSION['engine']['langpack']['82'];
	return $out;
}

function admin_slim_tree_group($params) {
	print "update_by_id|slim_tree_group_" . $params[0] . "|" . base64_encode(admin_build_slim_tree($params[0], 0, "")) . ";";
	print "set_class_by_id|slim_tree_group_" . $params[0] . "|ins;";
}

function admin_build_slim_tree($parent, $level, $path) {
	$groups = mysql_query("select * from `fe2_slim_groups` where `parent`='" . $parent . "' order by `sort`");
	$out .= "<table class=\"admin_tree\">\n";
	while ($group = mysql_fetch_array($groups)) {
		switch($group['enabled']) {
			case 0 :
				$e = "<div id=\"switch_group_" . $group['id'] . "\"><p class=\"btn off\" onclick=\"admin_slim_group_switch_on('" . $group['id'] . "');\"></p></div>";
				break;
			case 1 :
				$e = "<div id=\"switch_group_" . $group['id'] . "\"><p class=\"btn on\"  onclick=\"admin_slim_group_switch_off('" . $group['id'] . "');\"></p></div>";
				break;
		}

		$us = mysql_query("select `id` from `fe2_slim_groups` where `parent`='" . $group['parent'] . "' and `sort`<'" . $group['sort'] . "' order by `sort` desc limit 1");
		if (mysql_num_rows($us)) {
			$u = mysql_fetch_array($us);
			$up = "<p onclick=\"admin_slim_group_swing('" . $group['id'] . "','" . $u['id'] . "')\" class=\"btn up\"></p>";
		} else
			$up = "";

		$ds = mysql_query("select `id` from `fe2_slim_groups` where `parent`='" . $group['parent'] . "' and `sort`>'" . $group['sort'] . "' order by `sort` limit 1");
		if (mysql_num_rows($ds)) {
			$d = mysql_fetch_array($ds);
			$down = "<p onclick=\"admin_slim_group_swing('" . $group['id'] . "','" . $d['id'] . "')\" class=\"btn down\"></p>";
		} else
			$down = "";

		$d = "<p class=\"btn del\" onclick=\"admin_slim_group_del('" . $group['id'] . "')\"></p>";
		$p = "";

		$n = short($group['name'], 250);
		/*
		 if(strlen($n)>35)
		 $pp="style=\"font-size: 10px;\"";
		 else
		 $pp="";
		 */
		global $TEMPLATE;

		if (isset($path[$group['id']]))
			$st = "style=\"background-position: 0px -41px;\"";
		else
			$st = "";

		$out .= "<tr class=\"gr\"><td><div class=\"sign\" " . $st . " id=\"slim_tree_sign_" . $group['id'] . "\" onclick=\"admin_slim_open_group('" . $group['id'] . "');\"></div><a class=\"gr\" " . $pp . " onclick=\"admin_slim_group_edit('" . $group['id'] . "','false');\"><b>" . $n . "</b></a></td><td class=\"c_id\">" . $group['id'] . "</td><td>" . $e . "</td><td>" . $up . "</td><td>" . $down . "</td><td>" . $d . "</td></tr>\n";

		if (isset($path[$group['id']])) {
			$out .= "<tr class=\"ins\"><td class=\"ins\" colspan=\"6\"><div class=\"ins\" style=\"display: block;\" id=\"slim_tree_group_" . $group['id'] . "\">\n";
			$out .= admin_build_slim_tree($group['id'], $level + 1, $path);
			$out .= "</div></td></tr>\n";
		} else {
			$out .= "<tr class=\"ins\"><td class=\"ins\" colspan=\"6\"><div class=\"loading\" style=\"display: none;\" id=\"slim_tree_group_" . $group['id'] . "\">\n";
			$out .= "  <p style=\"padding-top: 5px; padding-bottom: 10px;\">Загрузка...</p>\n";
			$out .= "</div></td></tr>\n";
		}
	}

	if ($parent) {
		$group = mysql_get_record("fe2_slim_groups", "id", $parent);
	} else {
		$group['name'] = $_SESSION['engine']['langpack']['83'];
		$group['id'] = 0;
	}
	$mi = mysql_get_param_ex("fe2_unit_vars", "value", "`unit`='slim' and `var`='many_items'", "");

	if (!$mi) {
		//=========================items============================
		$items = mysql_query("select * from `fe2_slim_items` where `parent`='" . $parent . "' order by `sort`");

		while ($item = mysql_fetch_array($items)) {
			$out .= "<tr class=\"it\">\n";
			switch($item['enabled']) {
				case 0 :
					$e = "<div id=\"switch_item_" . $item['id'] . "\"><p class=\"btn off\" onclick=\"admin_slim_item_switch_on('" . $item['id'] . "');\"></p></div>";
					break;
				case 1 :
					$e = "<div id=\"switch_item_" . $item['id'] . "\"><p class=\"btn on\"  onclick=\"admin_slim_item_switch_off('" . $item['id'] . "');\"></p></div>";
					break;
			}

			$us = mysql_query("select `id` from `fe2_slim_items` where `parent`='" . $item['parent'] . "' and `sort`<'" . $item['sort'] . "' order by `sort` desc limit 1");
			if (mysql_num_rows($us)) {
				$u = mysql_fetch_array($us);
				$up = "<p onclick=\"admin_slim_item_swing('" . $item['id'] . "','" . $u['id'] . "')\" class=\"btn up\"></p>";
			} else
				$up = "";

			$ds = mysql_query("select `id` from `fe2_slim_items` where `parent`='" . $item['parent'] . "' and `sort`>'" . $item['sort'] . "' order by `sort` limit 1");
			if (mysql_num_rows($ds)) {
				$d = mysql_fetch_array($ds);
				$down = "<p onclick=\"admin_slim_item_swing('" . $item['id'] . "','" . $d['id'] . "')\" class=\"btn down\"></p>";
			} else
				$down = "";

			$d = "<p class=\"btn del\" onclick=\"admin_slim_item_del('" . $item['id'] . "')\"></p>";
			$p = "";

			$n = short($item['name'], 250);

			/*
			 if(strlen($n)>15)
			 $pp="style=\"font-size: 10px;\"";
			 else
			 $pp="";
			 */

			$out .= "<td><a " . $pp . " onclick=\"admin_slim_item_edit('" . $item['id'] . "', 'false');\">" . $n . "</a></td><td class=\"c_id\">" . $item['id'] . "</td><td>" . $e . "</td><td>" . $up . "</td><td>" . $down . "</td><td>" . $d . "</td>\n";
			$out .= "</tr>\n";
		}
		//==============================add items===============================
		$items = mysql_query("select * from `fe2_slim_items` where concat(';',`parents`,';') like '%;" . $parent . ";%' order by `sort`");

		while ($item = mysql_fetch_array($items)) {
			$out .= "<tr class=\"it\">\n";
			switch($item['enabled']) {
				case 0 :
					$e = "<div>" . $_SESSION['engine']['langpack']['84'] . "</div>";
					break;
				case 1 :
					$e = "<div>" . $_SESSION['engine']['langpack']['85'] . "</div>";
					break;
			}

			$d = "<p class=\"btn del\" onclick=\"admin_slim_item_del_from_parents('" . $item['id'] . "')\"></p>";
			$p = "";

			$n = short($item['name'], 250);
			/*
			 if(strlen($n)>15)
			 $pp="style=\"font-size: 10px;\"";
			 else
			 $pp="";
			 */

			$out .= "<td><a " . $pp . " onclick=\"admin_slim_item_edit('" . $item['id'] . "', 'false');\">" . $n . "</a></td><td>" . $e . "</td><td>" . $up . "</td><td>" . $down . "</td><td>" . $d . "</td>\n";
			$out .= "</tr>\n";
		}
	} else {
		$its = mysql_query("select count(*) as `count` from `fe2_slim_items` where `parent`='" . $parent . "'");
		$its1 = mysql_query("select count(*) as `count` from `fe2_slim_items` where `parents` like '%;" . $parent . ";%'");
		$its = mysql_fetch_array($its);
		$its1 = mysql_fetch_array($its1);

		$out .= "<td><a href=\"#\" onclick=\"admin_slim_many_items(" . $parent . "); return false;\">" . $_SESSION['engine']['langpack']['86'] . ($its['count'] + $its1['count']) . "</a></td>";
	}
	$out .= "<tr class=\"tech\"><td colspan=\"5\"><p style=\"float: left;\" class=\"button b_add\" onclick=\"admin_slim_group_create_form('" . $group['id'] . "', '" . $group['name'] . "');\">" . $_SESSION['engine']['langpack']['87'] . "</p><p style=\"float: left;\" class=\"button b_add\" onclick=\"admin_slim_item_create_form('" . $group['id'] . "', '" . $group['name'] . "');\">" . $_SESSION['engine']['langpack']['88'] . "</p></tr></td>\n";

	$out .= "</table>\n";

	return $out;
}

function admin_slim_group_edit($params) {
	sync_entity("slim", "group", $params[0]);
	if (function_exists("a_userfuncs_slim_group_edit"))
		$out = a_userfuncs_slim_group_edit($params);
	if ($out)
		return $out;

	$groups = mysql_query("select * from `fe2_slim_groups` where `id`='" . $params[0] . "'");
	if (mysql_num_rows($groups)) {
		$group = mysql_fetch_array($groups);
		$out = "";
		$out .= "<h2>" . $_SESSION['engine']['langpack']['89'] . "</h2>\n";
		//=============head==================
		$out .= "<div id=\"slim_head\">\n";
		$out .= slim_group_head_view($group);
		$out .= "</div>\n";
		//=============head edit==================
		$out .= "<div id=\"slim_head_edit\" style=\"display: none;\">\n";
		$out .= "<table>\n";
		$out .= "  <tr><td>" . $_SESSION['engine']['langpack']['90'] . "</td><td><input id=\"hd_name\" name=\"name\" type=\"text\" value=\"" . $group['name'] . "\"></td></tr>\n";
		$out .= "  <tr><td>Название страницы</td><td><input id=\"hd_pagename\" name=\"pagename\" type=\"text\" value=\"" . $group['pagename'] . "\"></td></tr>\n";
		$out .= "  <tr><td>" . $_SESSION['engine']['langpack']['91'] . "</td><td><input id=\"hd_huu\" name=\"huu\" type=\"text\" value=\"" . $group['huu'] . "\"></td></tr>\n";
		if ($group['tech']) {
			$r0 = "";
			$r1 = "selected";
		} else {
			$r1 = "";
			$r0 = "selected";
		}

		$out .= "  <tr><td>" . $_SESSION['engine']['langpack']['92'] . "</td><td><select size=\"1\" id=\"hd_tech\"><option " . $r0 . " id=\"hdo_parent_0\" value=\"0\">" . $_SESSION['engine']['langpack']['93'] . "</option><option " . $r1 . " value=\"1\">" . $_SESSION['engine']['langpack']['94'] . "</option></select></td></tr>\n";
		$out .= "  <tr><td>" . $_SESSION['engine']['langpack']['95'] . "</td><td><input type=\"hidden\" id=\"hdo_parent\" value=\"" . $group['parent'] . "\"><select size=\"1\" id=\"hd_parent\"><option value=\"0\" id=\"hdo_parent_0\">" . $_SESSION['engine']['langpack']['96'] . "</option>" . slim_parent_selector() . "</select></td></tr>\n";
		$out .= "<tr class=\"tech\"><td><p class=\"button b_cancel\" style=\"float: left;\" onclick=\"document.getElementById('slim_head_edit').style.display='none';document.getElementById('slim_head_view').style.display='block';\">" . $_SESSION['engine']['langpack']['97'] . "</p></td><td><p class=\"button b_ok\" style=\"float: right;\" onclick=\"document.getElementById('hdo_parent').value=document.getElementById('hd_parent').value; admin_slim_group_head_update('" . $group['id'] . "');\">" . $_SESSION['engine']['langpack']['98'] . "</p></td></tr>\n";
		$out .= "</table>\n";
		$out .= "</div>\n";
		//=====================short==============================
		$out .= "<h2>" . $_SESSION['engine']['langpack']['108'] . "</h2>\n";
		$out .= "<div id=\"slim_group_short\">\n";
		$out .= slim_group_short_view($group);
		$out .= "</div>\n";

		$out .= "<div id=\"group_short_backup\" style=\"display: none;\"></div>";
		$out .= "<div id=\"short_edit_buttons\" style=\"display: none;\">";
		$out .= "  <p class=\"button b_edit\" onclick=\"admin_slim_group_short_update(" . $group['id'] . ");\">" . $_SESSION['engine']['langpack']['98'] . "</p>\n";
		$out .= "  <p class=\"button b_edit\" onclick=\"document.getElementById('slim_group_short_view').innerHTML=document.getElementById('group_short_backup').innerHTML; document.getElementById('short_edit_buttons').style.display='none'; document.getElementById('group_short_edit').style.display='inline-block';\">" . $_SESSION['engine']['langpack']['97'] . "</p>\n";
		$out .= "</div>";
		$out .= "<p class=\"button b_edit\" id=\"group_short_edit\" onclick=\"document.getElementById('group_short_backup').innerHTML=document.getElementById('slim_group_short_view').innerHTML; group_short_editor=createEditor('slim_group_short_view'); document.getElementById('short_edit_buttons').style.display='block'; this.style.display='none';\">" . $_SESSION['engine']['langpack']['278'] . "</p>\n";

		//$out.="<p class=\"button b_edit\" onclick=\"admin_slim_group_edit_short_form('".base64_encode($_SESSION['engine']['langpack']['109'].$group['name'])."','".$group['id']."');\">".$_SESSION['engine']['langpack']['101']."</p>\n";
		//=====================desc=============================
		$out .= "<h2>" . $_SESSION['engine']['langpack']['99'] . "</h2>\n";
		$out .= "<div id=\"slim_desc\">\n";
		$out .= slim_group_desc_view($group);
		$out .= "</div>\n";

		$out .= "<div id=\"group_desc_backup\" style=\"display: none;\"></div>";
		$out .= "<div id=\"desc_edit_buttons\" style=\"display: none;\">";
		$out .= "  <p class=\"button b_edit\" onclick=\"admin_slim_group_desc_update(" . $group['id'] . ");\">" . $_SESSION['engine']['langpack']['98'] . "</p>\n";
		$out .= "  <p class=\"button b_edit\" onclick=\"document.getElementById('slim_group_desc_view').innerHTML=document.getElementById('group_desc_backup').innerHTML; document.getElementById('desc_edit_buttons').style.display='none'; document.getElementById('group_desc_edit').style.display='inline-block';\">" . $_SESSION['engine']['langpack']['97'] . "</p>\n";
		$out .= "</div>";
		$out .= "<p class=\"button b_edit\" id=\"group_desc_edit\" onclick=\"document.getElementById('group_desc_backup').innerHTML=document.getElementById('slim_group_desc_view').innerHTML; group_desc_editor=createEditor('slim_group_desc_view'); document.getElementById('desc_edit_buttons').style.display='block'; this.style.display='none';\">" . $_SESSION['engine']['langpack']['278'] . "</p>\n";

		//    $out.="<p class=\"button b_edit\" onclick=\"admin_slim_group_desc_edit_form('".base64_encode($_SESSION['engine']['langpack']['100'].$group['name'])."','".$group['id']."');\">".$_SESSION['engine']['langpack']['101']."</p>\n";
		//=====================metadata view=====================
		$out .= "<h2>" . $_SESSION['engine']['langpack']['102'] . "</h2>\n";
		$out .= "<div id=\"slim_metas\">\n";
		$out .= "<div id=\"slim_metas_view\">\n";
		$out .= slim_group_meta_view($group);
		$out .= "</div>\n";
		//====================metadata edit========================
		$out .= "<div id=\"slim_metas_edit\" style=\"display: none;\"><table>\n";
		$out .= "<tr><td>Title</td><td><input name=\"title\" id=\"met_title\" type=\"text\" value=\"" . $group['title'] . "\"></td></tr>\n";
		$out .= "<tr><td>Description</td><td><input name=\"title\" id=\"met_description\" type=\"text\" value=\"" . $group['description'] . "\"></td></tr>\n";
		$out .= "<tr><td>Keywords</td><td><input name=\"title\" id=\"met_keywords\" type=\"text\" value=\"" . $group['keywords'] . "\"></td></tr>\n";
		$out .= "<tr class=\"tech\"><td><p class=\"button b_cancel\" style=\"float: left;\" onclick=\"document.getElementById('slim_group_metas_edit').style.display='none';document.getElementById('slim_metas_view').style.display='block';\">" . $_SESSION['engine']['langpack']['97'] . "</p></td><td><p class=\"button b_ok\" style=\"float: right;\" onclick=\"document.getElementById('slim_metas_edit').style.display='none';document.getElementById('slim_metas_view').style.display='block';admin_slim_group_meta_update('" . $group['id'] . "');\">" . $_SESSION['engine']['langpack']['98'] . "</p></td></tr>\n";
		$out .= "</table></div>\n";
		$out .= "</div>\n";

		$out .= admin_images("slim", "group", $group['id']);
		if (function_exists("admin_storage_files")) {
			$out .= admin_storage_files("slim", "group", $group['id']);
		}
		if (function_exists("admin_social_comments")) {
			$out .= admin_social_comments("slim", "group", $group['id']);
		}

		$out .= admin_add_values("slim", "group", $group['id']);

		if (function_exists("admin_comments")) {
			$out .= admin_comments("slim", "group", $group['id'], 1);
		}

		$parent = $group['parent'];
		while ($parent) {
			$i = mysql_get_record("fe2_slim_groups", "id", $parent);
			$b = "<li><a onclick=\"admin_slim_group_edit('" . $i['id'] . "');\">" . $i['name'] . "</a></li>" . $b;
			$parent = $i['parent'];
		}

		$breadcrumb = "<ul><li><a onclick=\"location.hash=''; document.getElementById('center').style.display='none'; document.getElementById('left').style.display='block'; document.getElementById('breadcrumb').innerHTML='<ul><li><a>Каталог</a></li></ul>'; $('html, body').animate({scrollTop: slim_base_scroll+'px'}, 'fast');\">Каталог</a></li>" . $b . "<li><a>" . $group['name'] . "</a></li></ul>";

		$o = "hide_by_id|left;show_by_id|center;update_by_id|breadcrumb|" . base64_encode($breadcrumb) . ";update_by_id|a_h1|" . base64_encode($_SESSION['engine']['langpack']['103'] . $group['name']) . ";update_by_id|a_slim_center|" . base64_encode($out) . ";function|a_image_init_drop('slim','group'," . $group['id'] . ");";
	} else {
		$o = "update_by_id|a_slim_center|" . base64_encode($_SESSION['engine']['langpack']['104'] . mysql_error()) . ";";
	}

	if ($params[1] == "true")
		$o .= "update_by_id|a_slim_left|" . base64_encode(slim_A_LEFT("g=" . $params[0])) . ";";
	return $o;
}

function build_parents_tree_slim($parent, $level, $parents) {
	$groups = mysql_query("select `id`, `name` from `fe2_slim_groups` where `parent`='" . $parent . "' order by `sort`");
	if (mysql_num_rows($groups)) {
		$out .= "<ul>\n";
		while ($group = mysql_fetch_array($groups)) {
			if (strpos(";" . $parents, ";" . $group['id'] . ";"))
				$c = "checked";
			else
				$c = "";

			$out .= "<li>" . $sp . "<input " . $c . " id=\"par_" . $group['id'] . "\" type=\"checkbox\" value=\"ON\"> " . $group['name'] . "</li>\n";
			$out .= build_parents_tree_slim($group['id'], $level + 1, $parents);
		}
		$out .= "</ul>\n";
	}
	return $out;
}

function admin_slim_item_edit($params) {
	sync_entity("slim", "item", $params[0]);
	if (function_exists("a_userfuncs_slim_item_edit"))
		$out = a_userfuncs_slim_item_edit($params);
	if ($out)
		return $out;

	if ($langs = unit_get_var_value("site", "site_languages")) {
		$langs = explode(";", $langs);
		foreach ($langs as $lang) {
			$lang = trim($lang);
			$lang_item[$lang] = mysql_get_record("fe2_" . $lang . "_slim_item", "id", $params[0]);
		}
	}

	$items = mysql_query("select * from `fe2_slim_items` where `id`='" . $params[0] . "'");
	if (mysql_num_rows($items)) {
		$item = mysql_fetch_array($items);
		$out = "";
		$out .= "<h2>" . $_SESSION['engine']['langpack']['89'] . "</h2>\n";
		//=============head==================
		$out .= "<div id=\"slim_head\">\n";
		$out .= slim_item_head_view($item);
		$out .= "</div>\n";
		//=============head edit==================
		$out .= "<div id=\"slim_head_edit\" style=\"display: none;\">\n";
		$out .= "<table>\n";
		$out .= "  <tr><td>" . $_SESSION['engine']['langpack']['90'] . "</td><td><input id=\"hd_name\" name=\"name\" type=\"text\" value=\"" . $item['name'] . "\"></td></tr>\n";
		$out .= "  <tr><td>Название страницы</td><td><input id=\"hd_pagename\" name=\"pagename\" type=\"text\" value=\"" . $item['pagename'] . "\"></td></tr>\n";
		if ($langs = unit_get_var_value("site", "site_languages")) {
			$langs = explode(";", $langs);
			foreach ($langs as $lang) {
				$lang = trim($lang);
				$out .= "  <tr><td>" . $_SESSION['engine']['langpack']['90'] . "[" . $lang . "]</td><td><input id=\"hd_name_" . $lang . "\" name=\"name_" . $lang . "\" type=\"text\" value=\"" . $lang_item[$lang]['name'] . "\">!</td></tr>\n";
			}
		}
		$out .= "  <tr><td>" . $_SESSION['engine']['langpack']['91'] . "</td><td><input id=\"hd_huu\" name=\"huu\" type=\"text\" value=\"" . $item['huu'] . "\"></td></tr>\n";
		$s = slim_parent_selector();

		$ps = explode(";", $item['parents']);
		foreach ($ps as $p) {
			if ($p)
				$s = str_replace("\"hdo_parent_" . $p . "\"", "\"hdo_parent_" . $p . "\" selected", $s);
		}

		$out .= "  <tr><td>" . $_SESSION['engine']['langpack']['95'] . "</td><td><p><input type=\"hidden\" id=\"hdo_parent\" value=\"" . $item['parent'] . "\"><select size=\"1\" id=\"hd_parent\"><option value=\"0\"  id=\"hdo_parent_0\">" . $_SESSION['engine']['langpack']['96'] . "</option>" . $s . "</select></p></td></tr>\n";
		$out .= "  <tr><td>" . $_SESSION['engine']['langpack']['364'] . "</td><td><input type=\"hidden\" id=\"hdo_parents\" value=\"" . $item['parents'] . "\" /><p><select size=\"1\" data-placelolder=\" \" multiple class=\"chosen-multiselect\" id=\"hd_parents\">" . $s . "</select></p></td></tr>\n";
		$out .= "<tr class=\"tech\"><td><p class=\"button b_cancel\" style=\"float: left;\" onclick=\"document.getElementById('slim_head_edit').style.display='none';document.getElementById('slim_head_view').style.display='block';\">" . $_SESSION['engine']['langpack']['97'] . "</p></td><td><p class=\"button b_ok\" style=\"float: right;\" onclick=\"document.getElementById('hdo_parent').value=document.getElementById('hd_parent').value; admin_slim_item_head_update('" . $item['id'] . "');\">" . $_SESSION['engine']['langpack']['98'] . "</p></td></tr>\n";
		$out .= "</table>\n";
		$out .= "</div>\n";
		//=============price==================
		if (function_exists("a_userfuncs_slim_price"))
			$e = 1;
		else
			$e = 0;

		if ($e) {
			$o .= a_userfuncs_slim_price($item);
			if (!$o)
				$e = 0;
		}

		if ($e)
			$out .= $o;
		else if (mysql_get_param_ex("fe2_unit_vars", "value", "`unit`='slim' and `var`='allow_price'", "")) {
			$out .= "<h2>" . $_SESSION['engine']['langpack']['106'] . "</h2>\n";
			$out .= "<div id=\"slim_price\">\n";
			$out .= slim_item_price_view($item);
			$out .= "</div>\n";
			//=============price edit==================
			$out .= "<div id=\"slim_price_edit\" style=\"display: none;\">\n";
			$out .= "<table>\n";
			$out .= "  <tr><td>" . $_SESSION['engine']['langpack']['106'] . "</td><td><input id=\"pr_price\" name=\"name\" type=\"text\" value=\"" . $item['price'] . "\"></td></tr>\n";
			$out .= "  <tr><td>" . $_SESSION['engine']['langpack']['107'] . "</td><td><input id=\"pr_stock\" name=\"name\" type=\"text\" value=\"" . $item['stock'] . "\"></td></tr>\n";
			$out .= "<tr class=\"tech\"><td><p class=\"button b_cancel\" style=\"float: left;\" onclick=\"document.getElementById('slim_head_edit').style.display='none';document.getElementById('slim_head_view').style.display='block';\">" . $_SESSION['engine']['langpack']['97'] . "</p></td><td><p class=\"button b_ok\" style=\"float: right;\" onclick=\"admin_slim_item_price_update('" . $item['id'] . "');\">" . $_SESSION['engine']['langpack']['98'] . "/p></td></tr>\n";
			$out .= "</table>\n";
			$out .= "</div>\n";
		}
		//=====================short==============================
		$out .= "<h2 class=\"short\">" . $_SESSION['engine']['langpack']['108'] . "</h2>\n";
		$out .= "<div id=\"slim_item_short\">\n";
		$out .= slim_item_short_view($item);
		$out .= "</div>\n";

		$out .= "<div id=\"item_short_backup\" style=\"display: none;\"></div>";
		$out .= "<div id=\"short_edit_buttons\" style=\"display: none;\">";
		$out .= "  <p class=\"button b_edit\" onclick=\"admin_slim_item_short_update(" . $item['id'] . ");\">" . $_SESSION['engine']['langpack']['98'] . "</p>\n";
		$out .= "  <p class=\"button b_edit\" onclick=\"document.getElementById('slim_item_short_view').innerHTML=document.getElementById('item_short_backup').innerHTML; document.getElementById('short_edit_buttons').style.display='none'; document.getElementById('item_short_edit').style.display='inline-block';\">" . $_SESSION['engine']['langpack']['97'] . "</p>\n";
		$out .= "</div>";
		$out .= "<p class=\"button b_edit\" id=\"item_short_edit\" onclick=\"document.getElementById('item_short_backup').innerHTML=document.getElementById('slim_item_short_view').innerHTML; item_short_editor=createEditor('slim_item_short_view'); document.getElementById('short_edit_buttons').style.display='block'; this.style.display='none';\">" . $_SESSION['engine']['langpack']['278'] . "</p>\n";

		//$out.="<p class=\"button b_edit\" onclick=\"admin_slim_item_edit_short_form('".base64_encode($_SESSION['engine']['langpack']['109'].$item['name'])."','".$item['id']."');\">".$_SESSION['engine']['langpack']['101']."</p>\n";
		//=====================desc=============================
		$out .= "<h2 class=\"desc\">" . $_SESSION['engine']['langpack']['99'] . "</h2>\n";
		$out .= "<div id=\"slim_desc\">\n";
		$out .= slim_item_desc_view($item);
		$out .= "</div>\n";

		$out .= "<div id=\"item_desc_backup\" style=\"display: none;\"></div>";
		$out .= "<div id=\"desc_edit_buttons\" style=\"display: none;\">";
		$out .= "  <p class=\"button b_edit\" onclick=\"admin_slim_item_desc_update(" . $item['id'] . ");\">" . $_SESSION['engine']['langpack']['98'] . "</p>\n";
		$out .= "  <p class=\"button b_edit\" onclick=\"document.getElementById('slim_item_desc_view').innerHTML=document.getElementById('item_desc_backup').innerHTML; document.getElementById('desc_edit_buttons').style.display='none'; document.getElementById('item_desc_edit').style.display='inline-block';\">" . $_SESSION['engine']['langpack']['97'] . "</p>\n";
		$out .= "</div>";
		$out .= "<p class=\"button b_edit\" id=\"item_desc_edit\" onclick=\"document.getElementById('item_desc_backup').innerHTML=document.getElementById('slim_item_desc_view').innerHTML; item_desc_editor=createEditor('slim_item_desc_view'); document.getElementById('desc_edit_buttons').style.display='block'; this.style.display='none';\">" . $_SESSION['engine']['langpack']['278'] . "</p>\n";

		/*$out.="<p class=\"button b_edit\" onclick=\"admin_slim_item_desc_edit_form('".base64_encode($_SESSION['engine']['langpack']['110'].$item['name'])."','".$item['id']."');\">".$_SESSION['engine']['langpack']['101']."</p>\n";*/
		//========================================================
		if (function_exists("a_userfuncs_slim_afterdesc"))
			$out .= a_userfuncs_slim_afterdesc($item);

		//=====================metadata view=====================
		$out .= "<h2>" . $_SESSION['engine']['langpack']['102'] . "</h2>\n";
		$out .= "<div id=\"slim_metas\">\n";
		$out .= "<div id=\"slim_metas_view\">\n";
		$out .= slim_item_meta_view($item);
		$out .= "</div>\n";
		//====================metadata edit========================
		$out .= "<div id=\"slim_metas_edit\" style=\"display: none;\"><table>\n";
		$out .= "<tr><td>Title</td><td><input name=\"title\" id=\"met_title\" type=\"text\" value=\"" . $item['title'] . "\"></td></tr>\n";
		$out .= "<tr><td>Description</td><td><input name=\"title\" id=\"met_description\" type=\"text\" value=\"" . $item['description'] . "\"></td></tr>\n";
		$out .= "<tr><td>Keywords</td><td><input name=\"title\" id=\"met_keywords\" type=\"text\" value=\"" . $item['keywords'] . "\"></td></tr>\n";
		$out .= "<tr class=\"tech\"><td><p class=\"button b_cancel\" style=\"float: left;\" onclick=\"document.getElementById('slim_metas_edit').style.display='none';document.getElementById('slim_metas_view').style.display='block';\">" . $_SESSION['engine']['langpack']['97'] . "</p></td><td><p class=\"button b_ok\" style=\"float: right;\" onclick=\"document.getElementById('slim_metas_edit').style.display='none';document.getElementById('slim_metas_view').style.display='block';admin_slim_item_meta_update('" . $item['id'] . "');\">" . $_SESSION['engine']['langpack']['98'] . "</p></td></tr>\n";
		$out .= "</table></div>\n";
		$out .= "</div>\n";

		if (function_exists("admin_images"))
			$out .= admin_images("slim", "item", $item['id']);
		if (function_exists("admin_storage_files"))
			$out .= admin_storage_files("slim", "item", $item['id']);

		$out .= admin_add_values("slim", "item", $item['id']);

		if (function_exists("admin_social_comments")) {
			$out .= admin_social_comments("slim", "item", $item['id']);
		}

		$parent = $item['parent'];
		while ($parent) {
			$i = mysql_get_record("fe2_slim_groups", "id", $parent);
			$b = "<li><a onclick=\"admin_slim_group_edit('" . $i['id'] . "');\">" . $i['name'] . "</a></li>" . $b;
			$parent = $i['parent'];
		}

		$breadcrumb = "<ul><li><a onclick=\"location.hash=''; document.getElementById('center').style.display='none';document.getElementById('left').style.display='block'; document.getElementById('breadcrumb').innerHTML='<ul><li><a>Каталог</a></li></ul>';  $('html, body').animate({scrollTop: slim_base_scroll+'px'}, 'fast');\">Каталог</a></li>" . $b . "<li><a>" . $item['name'] . "</a></li></ul>";

		$o = "hide_by_id|left;show_by_id|center;update_by_id|breadcrumb|" . base64_encode($breadcrumb) . ";update_by_id|a_h1|" . base64_encode($_SESSION['engine']['langpack']['111'] . $item['name']) . ";update_by_id|a_slim_center|" . base64_encode($out) . ";function|a_image_init_drop('slim','item'," . $item['id'] . ");";
	} else {
		$o = "update_by_id|a_slim_center|" . base64_encode($_SESSION['engine']['langpack']['104'] . mysql_error()) . ";";
	}

	if ($params[1])
		$o .= "update_by_id|a_slim_left|" . base64_encode(slim_A_LEFT("i=" . $params[0])) . ";";
	return $o;

}

function slim_parent_selector() {
	if (!file_exists($_SERVER['DOCUMENT_ROOT'] . "/cache/admin/slim_parenttree.cch")) {
		if (!file_exists($_SERVER['DOCUMENT_ROOT'] . "/cache/admin/")) {
			mkdir($_SERVER['DOCUMENT_ROOT'] . "/cache/admin/", 0777, true);
		}
		$fil = fopen($_SERVER['DOCUMENT_ROOT'] . "/cache/admin/slim_parenttree.cch", "w");
		fputs($fil, slim_parent_tree_build_item(0, $item['parent'], 0));
		fclose($fil);
	}
	return file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/cache/admin/slim_parenttree.cch");
}

function slim_group_head_view($group) {
	$out .= "<div id=\"slim_head_view\">\n";
	$out .= "<table>\n";
	$out .= "  <tr><td>" . $_SESSION['engine']['langpack']['90'] . "</td><td>" . $group['name'] . "</td></tr>\n";
	$out .= "  <tr><td>Название страницы</td><td>" . $group['pagename'] . "</td></tr>\n";
	$out .= "  <tr><td>" . $_SESSION['engine']['langpack']['91'] . "</td><td>" . $group['huu'] . "</td></tr>\n";
	if ($group['parent']) {
		$p = mysql_get_param("fe2_slim_groups", "name", "id", $group['parent']);
	} else {
		$p = $_SESSION['engine']['langpack']['96'];
	}

	if ($group['tech'])
		$t = $_SESSION['engine']['langpack']['94'];
	else
		$t = $_SESSION['engine']['langpack']['93'];
	$out .= "  <tr><td>" . $_SESSION['engine']['langpack']['92'] . "</td><td>" . $t . "</td></tr>\n";

	$out .= "  <tr><td>" . $_SESSION['engine']['langpack']['95'] . "</td><td>" . $p . "</td></tr>\n";

	$out .= "  <tr class=\"tech\"><td colspan=\"2\"><p class=\"button b_edit\" onclick=\"p=document.getElementById('hdo_parent').value; document.getElementById('hdo_parent_'+p).selected='true'; document.getElementById('slim_head_view').style.display='none';document.getElementById('slim_head_edit').style.display='block';\">" . $_SESSION['engine']['langpack']['101'] . "</p></td></tr>\n";
	$out .= "</table>\n";

	return $out;
}

function slim_item_price_view($item) {
	$out .= "<div id=\"slim_price_view\">\n";
	$out .= "<table>\n";
	$out .= "  <tr><td>" . $_SESSION['engine']['langpack']['106'] . "</td><td>" . $item['price'] . "</td></tr>\n";
	$out .= "  <tr class=\"price_stock\"><td>" . $_SESSION['engine']['langpack']['107'] . "</td><td>" . $item['stock'] . "</td></tr>\n";
	$out .= "  <tr class=\"tech\"><td colspan=\"2\"><p class=\"button b_edit\" onclick=\"document.getElementById('slim_price_view').style.display='none';document.getElementById('slim_price_edit').style.display='block';\">" . $_SESSION['engine']['langpack']['101'] . "</p></td></tr>\n";
	$out .= "</table>\n";

	return $out;
}

function slim_item_short_view($item) {
	$out = "<div id=\"slim_item_short_view\">";
	$out .= $item['short'];
	$out .= "</div>";
	return $out;
}

function slim_group_short_view($group) {
	$out = "<div id=\"slim_group_short_view\">";
	$out .= $group['short'];
	$out .= "</div>";
	return $out;
}

function slim_group_desc_view($group) {
	$out = "<div id=\"slim_group_desc_view\">";
	$out .= $group['desc'];
	$out .= "</div>";
	return $out;
}

function slim_group_meta_view($group) {
	$out .= "<table>\n";
	$out .= "<tr><td>Title</td><td>" . $group['title'] . "</td></tr>\n";
	$out .= "<tr><td>Description</td><td>" . $group['description'] . "</td></tr>\n";
	$out .= "<tr><td>Keywords</td><td>" . $group['keywords'] . "</td></tr>\n";
	$out .= "<tr class=\"tech\"><td colspan=\"2\"><p class=\"button b_edit\" onclick=\"document.getElementById('slim_metas_view').style.display='none';document.getElementById('slim_metas_edit').style.display='block';\">" . $_SESSION['engine']['langpack']['101'] . "</p></td></tr>\n";
	$out .= "</table>\n";
	return $out;
}

function slim_item_head_view($item) {
	$out .= "<div id=\"slim_head_view\">\n";
	$out .= "<table>\n";
	$out .= "  <tr><td>" . $_SESSION['engine']['langpack']['90'] . "</td><td colspan=\"2\">" . $item['name'] . "</td></tr>\n";
	if ($langs = unit_get_var_value("site", "site_languages")) {
		$langs = explode(";", $langs);
		foreach ($langs as $lang) {
			$lang = trim($lang);
			$out .= "  <tr><td>" . $_SESSION['engine']['langpack']['90'] . " [" . $lang . "]</td><td>" . mysql_get_param("fe2_" . $lang . "_slim_items", "name", "id", $item['id']) . "</td></tr>\n";
		}
	}

	$out .= "  <tr><td>Название страницы</td><td colspan=\"2\">" . $item['pagename'] . "</td></tr>\n";
	$out .= "  <tr><td>" . $_SESSION['engine']['langpack']['91'] . "</td><td colspan=\"2\">" . $item['huu'] . "</td></tr>\n";

	if ($parents = $item['parents']) {
		$parents = explode(";", trim($parents, ";"));
		$pp = "";
		$p1 = "";
		foreach ($parents as $parent) {
			if ($parent) {
				$pp .= $p1 . mysql_get_param("fe2_slim_groups", "name", "id", $parent);
				$p1 = "; ";
			}
		}
	}
	if ($item['parent']) {
		$p = mysql_get_param("fe2_slim_groups", "name", "id", $item['parent']);
	} else {
		$p = "Корневой";
	}

	$out .= "  <tr><td>" . $_SESSION['engine']['langpack']['95'] . "</td><td colspan=\"2\"><p><b>" . $p . "</b></p></td></tr>\n";
	$out .= "  <tr><td>" . $_SESSION['engine']['langpack']['364'] . "</td><td colspan=\"2\"><p>" . $pp . "</p></td></tr>\n";

	$out .= "  <tr class=\"tech\"><td colspan=\"2\"><p class=\"button b_edit\" onclick=\"p=document.getElementById('hdo_parent').value; document.getElementById('hdo_parent_'+p).selected='true'; document.getElementById('slim_head_view').style.display='none';document.getElementById('slim_head_edit').style.display='block'; chosen_update();\">" . $_SESSION['engine']['langpack']['101'] . "</p></td></tr>\n";
	$out .= "</table>\n";
	$out .= "</div>\n";

	return $out;
}

function slim_item_desc_view($item) {
	$out = "<div id=\"slim_item_desc_view\">";
	$out .= $item['desc'];
	$out .= "</div>";
	return $out;
}

function slim_item_meta_view($item) {
	$out .= "<table>\n";
	$out .= "<tr><td>Title</td><td>" . $item['title'] . "</td></tr>\n";
	$out .= "<tr><td>Description</td><td>" . $item['description'] . "</td></tr>\n";
	$out .= "<tr><td>Keywords</td><td>" . $item['keywords'] . "</td></tr>\n";
	$out .= "<tr class=\"tech\"><td colspan=\"2\"><p class=\"button b_edit\" onclick=\"document.getElementById('slim_metas_view').style.display='none';document.getElementById('slim_metas_edit').style.display='block';\">" . $_SESSION['engine']['langpack']['101'] . "</p></td></tr>\n";
	$out .= "</table>\n";
	return $out;
}

function slim_parent_tree_build_item($id, $parent, $level) {
	$slims = mysql_query("select `id`, `name` from `fe2_slim_groups` where `parent`='" . $id . "' order by `sort`");
	if (mysql_num_rows($slims)) {
		while ($slim = mysql_fetch_array($slims)) {
			/*
			 if(strpos(";;".$parent.";",";".$slim['id'].";"))
			 $s="selected";
			 else
			 $s="";
			 */
			$sp = "";
			for ($x = 0; $x <= $level; $x++)
				$sp .= "&nbsp;&nbsp;";
			$out .= "<option id=\"hdo_parent_" . $slim['id'] . "\" " . $s . " value=\"" . $slim['id'] . "\">" . $sp . $slim['name'] . "</option>";
			$out .= slim_parent_tree_build_item($slim['id'], $parent, $level + 1);
		}
	}
	return $out;
}

function slim_parent_tree_build_group($id, $parent, $current, $level) {
	$slims = mysql_query("select `id`, `name` from `fe2_slim_groups` where `parent`='" . $id . "' order by `sort` limit 10");
	if (mysql_num_rows($slims)) {
		while ($slim = mysql_fetch_array($slims)) {
			if ($slim['id'] != $current) {
				if ($slim['id'] == $parent)
					$s = "selected";
				else
					$s = "";

				$sp = "";
				for ($x = 0; $x <= $level; $x++)
					$sp .= "&nbsp;&nbsp;";
				$out .= "<option " . $s . " value=\"" . $slim['id'] . "\">" . $sp . $slim['name'] . "</option>";
				$out .= slim_parent_tree_build_group($slim['id'], $parent, $current, $level + 1);
			}
		}
	}
	return $out;
}

function admin_slim_group_create($params) {
	if ($params[0] == "")
		$params[0] = $params[1];
	$s['huu'] = translitIt($params[0]);
	$s['parent'] = $params[2];
	$path = admin_path_slim($s);

	if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/content/slim/" . $path))
		return "update_by_id|a_slim_left|" . base64_encode(slim_A_LEFT("g=" . $params[2])) . ";update_by_id|a_h1|" . base64_encode($_SESSION['engine']['langpack']['112']) . ";update_by_id|a_slim_center|" . base64_encode($_SESSION['engine']['langpack']['113'] . $path . $_SESSION['engine']['langpack']['114']) . ";update_url_hash|;";

	mkdir($_SERVER['DOCUMENT_ROOT'] . "/content/slim/" . $path, 0777, true);

	mysql_query("insert into `fe2_slim_groups` set `huu`='" . $s['huu'] . "', `name`='" . $params[1] . "', `parent`='" . $params[2] . "', `path`='" . $path . "'");
	mysql_query("update `fe2_slim_group` set `sort`=`id` where `sort`='0'");

	unlink($_SERVER['DOCUMENT_ROOT'] . "/cache/admin/slim_parenttree.cch");

	$slims = mysql_query("select * from `fe2_slim_groups` order by `id` desc limit 1");
	if (mysql_num_rows($slims)) {
		$slim = mysql_fetch_array($slims);
		$params[0] = $slim['id'];
		engine_event("slim", "group", "create", $slim['id']);
		sync_entity("slim", "group", $params[0]);
		return "update_by_id|a_slim_left|" . base64_encode(slim_A_LEFT("g=" . $params[2])) . ";update_by_id|a_h1|" . base64_encode($_SESSION['engine']['langpack']['115'] . $slim['name']) . ";" . admin_slim_group_edit($params) . ";update_url_hash|" . $slim['id'] . ";";
	} else {
		return "update_by_id|a_slim_left|" . base64_encode(slim_A_LEFT("g=" . $params[2])) . ";update_by_id|a_h1|" . base64_encode($_SESSION['engine']['langpack']['116']) . ";update_by_id|a_slim_center|" . base64_encode($_SESSION['engine']['langpack']['117']) . ";update_url_hash|;";
	}
}

function admin_slim_item_create($params) {
	if ($params[0] == "")
		$params[0] = $params[1];
	$s['huu'] = translitIt($params[0]);
	$s['parent'] = $params[2];
	$path = admin_path_slim($s);

	if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/content/slim/" . $path))
		return "update_by_id|a_slim_left|" . base64_encode(slim_A_LEFT("g=" . $params[2])) . ";update_by_id|a_h1|" . base64_encode($_SESSION['engine']['langpack']['112']) . ";update_by_id|a_slim_center|" . base64_encode($_SESSION['engine']['langpack']['118'] . $path . $_SESSION['engine']['langpack']['114']) . ";update_url_hash|;";

	mkdir($_SERVER['DOCUMENT_ROOT'] . "/content/slim/" . $path, 0777, true);

	mysql_query("insert into `fe2_slim_items` set `huu`='" . $s['huu'] . "', `name`='" . $params[1] . "', `parent`='" . $params[2] . "', `path`='" . $path . "'");
	$id = mysql_insert_id();
	mysql_query("update `fe2_slim_items` set `sort`=`id` where `sort`='0'");

	engine_event("slim", "item", "create", $id);
	sync_entity("slim", "item", $id);

	$params[0] = $id;
	return "update_by_id|a_slim_left|" . base64_encode(slim_A_LEFT("g=" . $params[2])) . ";update_by_id|a_h1|" . base64_encode($_SESSION['engine']['langpack']['115'] . $slim['name']) . ";" . admin_slim_item_edit($params) . ";update_url_hash|" . $slim['id'] . ";";
}

function admin_slim_group_del($params) {
	$p = mysql_get_param("fe2_slim_groups", "parent", "id", $params[0]);
	admin_slim_group_deltree($params[0]);
	return "update_by_id|a_slim_left|" . base64_encode(SLIM_A_LEFT("g=" . $p)) . ";update_by_id|a_h1|" . base64_encode($_SESSION['engine']['langpack']['121']) . ";update_by_id|a_slim_center|" . base64_encode($_SESSION['engine']['langpack']['122']) . ";update_url_hash|;";
}

function admin_slim_item_del($params) {
	$p = mysql_get_param("fe2_slim_groups", "parent", "id", $params[0]);
	$path = mysql_get_param("fe2_slim_items", "path", "id", $params[0]);
	mysql_query("delete from `fe2_slim_items` where `id`='" . $params[0] . "'");
	remove_dir($_SERVER['DOCUMENT_ROOT'] . "/content/slim/" . $path);
	return "update_by_id|a_slim_left|" . base64_encode(SLIM_A_LEFT("g=" . $p)) . ";update_by_id|a_h1|" . base64_encode($_SESSION['engine']['langpack']['121']) . ";update_by_id|a_slim_center|" . base64_encode($_SESSION['engine']['langpack']['122']) . ";update_url_hash|;";
}

function admin_slim_group_switch_on($params) {
	mysql_query("update `fe2_slim_groups` set `enabled`='1' where `id`='" . $params[0] . "'");
	sync_entity("slim", "group", $params[0]);
	return "update_by_id|switch_group_" . $params[0] . "|" . base64_encode("<p class=\"btn on\"  onclick=\"admin_slim_group_switch_off('" . $params[0] . "');\"></p>");
}

function admin_slim_group_switch_off($params) {
	mysql_query("update `fe2_slim_groups` set `enabled`='0' where `id`='" . $params[0] . "'");
	sync_entity("slim", "group", $params[0]);
	return "update_by_id|switch_group_" . $params[0] . "|" . base64_encode("<p class=\"btn off\"  onclick=\"admin_slim_group_switch_on('" . $params[0] . "');\"></p>");
}

function admin_slim_item_switch_on($params) {
	mysql_query("update `fe2_slim_items` set `enabled`='1' where `id`='" . $params[0] . "'");
	sync_entity("slim", "item", $params[0]);
	return "update_by_id|switch_item_" . $params[0] . "|" . base64_encode("<p class=\"btn on\"  onclick=\"admin_slim_item_switch_off('" . $params[0] . "');\"></p>");
}

function admin_slim_item_switch_off($params) {
	mysql_query("update `fe2_slim_items` set `enabled`='0' where `id`='" . $params[0] . "'");
	sync_entity("slim", "item", $params[0]);
	return "update_by_id|switch_item_" . $params[0] . "|" . base64_encode("<p class=\"btn off\"  onclick=\"admin_slim_item_switch_on('" . $params[0] . "');\"></p>");
}

function admin_slim_group_meta_update($params) {
	mysql_query("update `fe2_slim_groups` set `title`='" . $params[1] . "', `description`='" . $params[2] . "',`keywords`='" . $params[3] . "' where `id`='" . $params[0] . "'");
	$slims = mysql_query("select `title`, `description`, `keywords` from `fe2_slim_groups` where `id`='" . $params[0] . "'");
	$slim = mysql_fetch_array($slims);
	return "update_by_id|slim_metas_view|" . base64_encode(slim_group_meta_view($slim));
}

function admin_slim_item_meta_update($params) {
	mysql_query("update `fe2_slim_items` set `title`='" . $params[1] . "', `description`='" . $params[2] . "',`keywords`='" . $params[3] . "' where `id`='" . $params[0] . "'");

	$slims = mysql_query("select `title`, `description`, `keywords` from `fe2_slim_items` where `id`='" . $params[0] . "'");
	$slim = mysql_fetch_array($slims);
	return "update_by_id|slim_metas_view|" . base64_encode(slim_item_meta_view($slim));
}

function admin_slim_group_desc_update($params) {
	mysql_query("update `fe2_slim_groups` set `desc`='" . $params[1] . "' where `id`='" . $params[0] . "'");

	$slims = mysql_query("select `desc` from `fe2_slim_groups` where `id`='" . $params[0] . "'");
	$slim = mysql_fetch_array($slims);
	return "update_by_id|slim_desc|" . base64_encode(slim_group_desc_view($slim));
}

function admin_slim_item_desc_update($params) {
	mysql_query("update `fe2_slim_items` set `desc`='" . $params[1] . "' where `id`='" . $params[0] . "'");

	$slims = mysql_query("select `desc` from `fe2_slim_items` where `id`='" . $params[0] . "'");
	$slim = mysql_fetch_array($slims);
	return "update_by_id|slim_desc|" . base64_encode(slim_item_desc_view($slim));
}

function admin_slim_group_head_update($params) {
	$groups = mysql_query("select `name`, `huu`, `parent`, `path` from `fe2_slim_groups` where `id`='" . $params[0] . "'");
	$group = mysql_fetch_array($groups);

	if ($params[1] == "")
		$params[1] = $params[2];

	$s['huu'] = translitIt($params[1]);
	$s['parent'] = $params[3];
	$path = admin_path_slim($s);

	if ($group['path'] != $path) {
		if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/content/slim/" . $path))
			return "alert|" . $_SESSION['engine']['langpack']['123'] . ";update_by_id|slim_group_head_view|" . base64_encode(slim_group_head_view($static)) . ";" . "update_by_id|a_slim_left|" . base64_encode(slim_A_LEFT("g=" . $params[0]));

		if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/content/slim/" . $group['path']))
			rename($_SERVER['DOCUMENT_ROOT'] . "/content/slim/" . $group['path'], $_SERVER['DOCUMENT_ROOT'] . "/content/slim/" . $path);

		mysql_query("update `fe2_images` set `path`='slim/" . $path . "' where `unit`='slim' and `entity`='group' and `entid`='" . $params[0] . "'");
	}

	mysql_query("update `fe2_slim_groups` set `huu`='" . $s['huu'] . "', `name`='" . $params[2] . "', `pagename`='" . $params[5] . "', `parent`='" . $params[3] . "', `path`='" . $path . "', `tech`='" . $params[4] . "' where `id`='" . $params[0] . "'");
	sync_entity("slim", "group", $params[0]);

	admin_slim_update_path_for_children($params[0]);

	$slims = mysql_query("select `name`, `pagename`, `huu`, `parent`, `tech` from `fe2_slim_groups` where `id`='" . $params[0] . "'");
	$slim = mysql_fetch_array($slims);
	$out = "update_by_id|slim_head_view|" . base64_encode(slim_group_head_view($slim)) . ";";
	if ($group['name'] != $params[2] || $group['path'] != $path)
		$out .= "update_by_id|a_slim_left|" . base64_encode(slim_A_LEFT("g=" . $params[0])) . ";";
	return $out;
}

function admin_slim_item_head_update($params) {
	$items = mysql_query("select `name`, `huu`, `parent`, `path` from `fe2_slim_items` where `id`='" . $params[0] . "'");
	$item = mysql_fetch_array($items);

	if ($params[1] == "")
		$params[1] = $params[2];
	$s['huu'] = translitIt($params[1]);
	$s['parent'] = $params[3];
	$path = admin_path_slim($s);

	if ($item['path'] != $path) {
		if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/content/slim/" . $path))
			return "alert|" . $_SESSION['engine']['langpack']['124'] . ";update_by_id|slim_item_head_view|" . base64_encode(slim_item_head_view($static)) . ";" . "update_by_id|a_slim_left|" . base64_encode(slim_A_LEFT("i=" . $params[0]));

		if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/content/slim/" . $item['path']))
			rename($_SERVER['DOCUMENT_ROOT'] . "/content/slim/" . $item['path'], $_SERVER['DOCUMENT_ROOT'] . "/content/slim/" . $path);

		mysql_query("update `fe2_images` set `path`='slim/" . $path . "' where `unit`='slim' and `entity`='item' and `entid`='" . $params[0] . "'");
	}

	//  mysql_query("update `fe2_slim_items` set `huu`='".$s['huu']."', `name`='".$params[2]."', `pagename`='".$params[5]."', `parent`='".$params[3]."', `parents`='".$params[4]."', `path`='".$path."' where `id`='".$params[0]."'");
	mysql_query("update `fe2_slim_items` set `huu`='" . $s['huu'] . "', `name`='" . $params[2] . "', `parent`='" . $params[3] . "', `parents`='" . $params[4] . "', `path`='" . $path . "' where `id`='" . $params[0] . "'");
	sync_entity("slim", "item", $params[0]);

	//  $slims=mysql_query("select `id`, `name`, `pagename`, `huu`, `parent`, `parents` from `fe2_slim_items` where `id`='".$params[0]."'");
	$slims = mysql_query("select * from `fe2_slim_items` where `id`='" . $params[0] . "'");
	$slim = mysql_fetch_array($slims);

	$out = "update_by_id|slim_head_view|" . base64_encode(slim_item_head_view($slim)) . ";";
	if ($item['name'] != $params[2] || $item['path'] != $path)
		$out .= "update_by_id|a_slim_left|" . base64_encode(slim_A_LEFT("ei=" . $params[0] . "," . $item['parent'])) . ";";
	return $out;
}

function admin_slim_item_price_update($params) {
	mysql_query("update `fe2_slim_items` set `price`='" . $params[1] . "', `stock`='" . $params[2] . "' where `id`='" . $params[0] . "'");
	$item['price'] = $params[1];
	$item['stock'] = $params[2];
	sync_entity("slim", "item", $params[0]);
	return "update_by_id|slim_price_view|" . base64_encode(slim_item_price_view($item)) . ";";
}

function admin_slim_group_swing($params) {
	$s = mysql_query("select `sort`, `id`, `parent` from `fe2_slim_groups` where `id`='" . $params[0] . "' or `id`='" . $params[1] . "'");
	if (mysql_num_rows($s) == 2) {
		$s1 = mysql_fetch_array($s);
		$s2 = mysql_fetch_array($s);
		mysql_query("update `fe2_slim_groups` set `sort`='" . $s1['sort'] . "' where `id`='" . $s2['id'] . "'");
		mysql_query("update `fe2_slim_groups` set `sort`='" . $s2['sort'] . "' where `id`='" . $s1['id'] . "'");
		sync_entity("slim", "group", $s1['id']);
		sync_entity("slim", "group", $s2['id']);
	}

	return "update_by_id|a_slim_left|" . base64_encode(slim_A_LEFT("g=" . $s1['parent']));
}

function admin_slim_item_swing($params) {
	$s = mysql_query("select `sort`, `id` from `fe2_slim_items` where `id`='" . $params[0] . "' or `id`='" . $params[1] . "'");
	if (mysql_num_rows($s) == 2) {
		$s1 = mysql_fetch_array($s);
		$s2 = mysql_fetch_array($s);
		mysql_query("update `fe2_slim_items` set `sort`='" . $s1['sort'] . "' where `id`='" . $s2['id'] . "'");
		mysql_query("update `fe2_slim_items` set `sort`='" . $s2['sort'] . "' where `id`='" . $s1['id'] . "'");
		sync_entity("slim", "item", $s1['id']);
		sync_entity("slim", "item", $s2['id']);
	}

	return "update_by_id|a_slim_left|" . base64_encode(slim_A_LEFT("i=" . $params[0]));
}

function admin_path_slim($s) {
	$id = $s['id'];
	$p = $s['huu'];
	do {
		if ($s = mysql_get_record("fe2_slim_groups", "id", $s['parent']))
			$p = $s['huu'] . "/" . $p;
	} while($s['parent']!=0);
	return $p;
}

function admin_slim_update_path_for_children($gr) {
	$items = mysql_query("select * from `fe2_slim_items` where `parent`='" . $gr . "'");
	while ($item = mysql_fetch_array($items)) {
		$path = admin_path_slim($item);
		mysql_query("update `fe2_slim_items` set `path`='" . $path . "' where `id`='" . $item['id'] . "'");
		mysql_query("update `fe2_images` set `path`='slim/" . $path . "' where `unit`='slim' and `entity`='item' and `entid`='" . $item['id'] . "'");
		sync_entity("slim", "item", $item['id']);
	}
	$groups = mysql_query("select * from `fe2_slim_groups` where `parent`='" . $gr . "'");
	while ($group = mysql_fetch_array($groups)) {
		$path = admin_path_slim($group);
		mysql_query("update `fe2_slim_groups` set `path`='" . $path . "' where `id`='" . $group['id'] . "'");
		mysql_query("update `fe2_images` set `path`='slim/" . $path . "' where `unit`='slim' and `entity`='group' and `entid`='" . $group['id'] . "'");
		sync_entity("slim", "group", $group['id']);
		admin_slim_update_path_for_children($group['id']);
	}
}

function admin_slim_group_deltree($gr) {
	$path = mysql_get_param("fe2_slim_groups", "path", "id", $gr);
	mysql_query("delete from `fe2_slim_groups` where `id`='" . $gr . "'");
	mysql_query("delete from `fe2_images` where `unit`='slim' and `entity`='group' and `entid`='" . $gr . "'");
	remove_dir($_SERVER['DOCUMENT_ROOT'] . "/content/slim/" . $path);

	$items = mysql_query("select * from `fe2_slim_items` where `parent`='" . $gr . "'");
	while ($item = mysql_fetch_array($items)) {
		mysql_query("delete from `fe2_slim_items` where `id`='" . $item['id'] . "'");
		mysql_query("delete from `fe2_images` where `unit`='slim' and `entity`='item' and `entid`='" . $item['id'] . "'");
		remove_dir($_SERVER['DOCUMENT_ROOT'] . "/content/slim/" . $item['path']);
	}

	$groups = mysql_query("select * from `fe2_slim_groups` where `parent`='" . $gr . "'");
	while ($group = mysql_fetch_array($groups)) {
		admin_slim_group_deltree($group['id']);
	}
}

function admin_slim_item_short_update($params) {
	mysql_query("update `fe2_slim_items` set `short`='" . $params[1] . "' where `id`='" . $params[0] . "'");
	$slim_items = mysql_query("select `short` from `fe2_slim_items` where `id`='" . $params[0] . "'");
	$slim_item = mysql_fetch_array($slim_items);
	return "update_by_id|slim_item_short|" . base64_encode(slim_item_short_view($slim_item));
}

function admin_slim_group_short_update($params) {
	mysql_query("update `fe2_slim_groups` set `short`='" . $params[1] . "' where `id`='" . $params[0] . "'");
	$slim_groups = mysql_query("select `short` from `fe2_slim_groups` where `id`='" . $params[0] . "'");
	//  return "alert|".mysql_error().";";
	$slim_group = mysql_fetch_array($slim_groups);
	return "update_by_id|slim_group_short|" . base64_encode(slim_group_short_view($slim_group));
}

function admin_slim_many_items($params) {
	$parent = $params[0];
	$out = "<table>";
	//=========================items============================
	$items = mysql_query("select * from `fe2_slim_items` where `parent`='" . $parent . "' order by `sort`");

	while ($item = mysql_fetch_array($items)) {
		$out .= "<tr>\n";
		switch($item['enabled']) {
			case 0 :
				$e = "<div id=\"switch_item_" . $item['id'] . "\"><p class=\"btn off\" onclick=\"admin_slim_item_switch_on('" . $item['id'] . "');\"></p></div>";
				break;
			case 1 :
				$e = "<div id=\"switch_item_" . $item['id'] . "\"><p class=\"btn on\"  onclick=\"admin_slim_item_switch_off('" . $item['id'] . "');\"></p></div>";
				break;
		}

		/*
		 $us=mysql_query("select `id` from `fe2_slim_items` where `parent`='".$item['parent']."' and `sort`<'".$item['sort']."' order by `sort` desc limit 1");
		 if(mysql_num_rows($us))
		 {
		 $u=mysql_fetch_array($us);
		 $up="<p onclick=\"admin_slim_item_swing('".$item['id']."','".$u['id']."')\" class=\"btn up\"></p>";
		 }
		 else
		 $up="";

		 $ds=mysql_query("select `id` from `fe2_slim_items` where `parent`='".$item['parent']."' and `sort`>'".$item['sort']."' order by `sort` limit 1");
		 if(mysql_num_rows($ds))
		 {
		 $d=mysql_fetch_array($ds);
		 $down="<p onclick=\"admin_slim_item_swing('".$item['id']."','".$d['id']."')\" class=\"btn down\"></p>";
		 }
		 else
		 $down="";
		 */
		$d = "<p class=\"btn del\" onclick=\"admin_slim_item_del('" . $item['id'] . "')\"></p>";
		$p = "";

		$n = $item['name'];

		$out .= "<td><a " . $pp . " onclick=\"admin_slim_item_edit('" . $item['id'] . "', 'false');\">" . $n . "</a></td><td>" . $item['price'] . " руб.</td> <td>" . $e . "</td><td>" . $d . "</td>\n";
		$out .= "</tr>\n";
	}
	$out .= "</table>";

	return "update_by_id|a_h1|" . base64_encode($_SESSION['engine']['langpack']['125'] . $group['name']) . ";update_by_id|a_slim_center|" . base64_encode($out) . ";";

}

function admin_slim_item_name_update_lang($params) {
	mysql_query("update `fe2_" . $params[2] . "_slim_items` set `name`='" . $params[1] . "' where `id`='" . $params[0] . "'");
}
?>
