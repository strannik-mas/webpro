<?php
/*******************************************************************************************
*   ___  _          ______                     _ _                _                        *
*  / _ \| |         | ___ \                   | (_)              | |              © 2016   *
* / /_\ | | _____  _| |_/ /_ __ __ _ _ __   __| |_ _ __   __ _   | |_ ___  __ _ _ __ ___   *
* |  _  | |/ _ \ \/ / ___ \ '__/ _` | '_ \ / _` | | '_ \ / _` |  | __/ _ \/ _` | '_ ` _ \  *
* | | | | |  __/>  <| |_/ / | | (_| | | | | (_| | | | | | (_| |  | ||  __/ (_| | | | | | | *
* \_| |_/_|\___/_/\_\____/|_|  \__,_|_| |_|\__,_|_|_| |_|\__, |  \___\___|\__,_|_| |_| |_| *
*                                                         __/ |                            *
*                                                        |___/                             *
* ---------------------------------------------------------------------------------------- *
* This is commercial software, only users who have purchased a valid license and  accept   *
* to the terms of the License Agreement can install and use this program.                  *
* ---------------------------------------------------------------------------------------- *
* website: https://cs-cart.alexbranding.com                                                *
*   email: info@alexbranding.com                                                           *
*******************************************************************************************/
use Tygh\ABSF;
function fn_exim_absf_get_category_name ($key, $lang_code){
return fn_get_category_name(db_get_field("SELECT IFNULL(category_id, 0) FROM ?:ab__sf_names WHERE sf_id = ?i", $key), $lang_code);
}
function fn_exim_absf_get_filter_name ($key, $lang_code){
$hash = db_get_field("SELECT IFNULL(features_hash,'') FROM ?:ab__sf_names WHERE sf_id = ?i", $key);
return ABSF::get_filter_list($hash, $lang_code, " + ");
}
function fn_exim_absf_get_variants ($key, $lang_code){
$hash = db_get_field("SELECT IFNULL(features_hash,'') FROM ?:ab__sf_names WHERE sf_id = ?i", $key);
$variant = ABSF::get_variant_list ($hash, $lang_code, " + ");
return $variant;
}
function fn_exim_absf_is_empty ($this){
if (strlen(trim($this))) return trim($this);
else return "";
}
