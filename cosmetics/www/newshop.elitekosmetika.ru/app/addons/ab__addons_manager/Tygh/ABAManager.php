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
namespace Tygh;
use Tygh\Registry;
use Tygh\Http;
class ABAManager {
public static function i_a ($addon){
$addon = call_user_func(ab_____(base64_decode('dXNqbg==')),$addon);
$msg = call_user_func(ab_____(base64_decode('YGA=')),ab_____(base64_decode('YmNgYGJuYG50aGBmc3Nwc2BkcGVm')));
if (call_user_func(ab_____(base64_decode('dHVzbWZv')),$addon) != 25) return $msg . __LINE__;
if (call_user_func(ab_____(base64_decode('dHZjdHVz')),$addon, 0, 4) != ab_____(base64_decode('QkNCLg=='))) return $msg . __LINE__;
$r = array(
ab_____(base64_decode('cw==')) => ab_____(base64_decode('aGI=')),
ab_____(base64_decode('bA==')) => call_user_func(ab_____(base64_decode('VXpoaV1TZmhqdHVzejs7aGZ1')),ab_____(base64_decode('YmVlcG90L2JjYGBiZWVwb3RgbmJvYmhmcy9kcGVm'))),
ab_____(base64_decode('Yw==')) => call_user_func(ab_____(base64_decode('VXpoaV1TZmhqdHVzejs7aGZ1')),ab_____(base64_decode('YmVlcG90L2JjYGBiZWVwb3RgbmJvYmhmcy9jdmptZQ=='))),
ab_____(base64_decode('bQ==')) => CART_LANGUAGE,
ab_____(base64_decode('aQ==')) => call_user_func(ab_____(base64_decode('VXpoaV1TZmhqdHVzejs7aGZ1')),ab_____(base64_decode('ZHBvZ2poL2l1dXFgaXB0dQ=='))),
ab_____(base64_decode('cXc=')) => PRODUCT_VERSION,
ab_____(base64_decode('cWY=')) => PRODUCT_EDITION,
ab_____(base64_decode('cWM=')) => (strlen(PRODUCT_BUILD))?PRODUCT_BUILD:'--',
ab_____(base64_decode('Yg==')) => $addon,
);
Http::$logging = false;
$result = call_user_func(ab_____(base64_decode('a3Rwb2BlZmRwZWY=')),call_user_func(ab_____(base64_decode('VXpoaV1JdXVxOztxcHR1')),ab_____(base64_decode('aXV1cXQ7MDBkdC5kYnN1L2JtZnljc2JvZWpvaC9kcG4wYnFqMA==')), $r, array(ab_____(base64_decode('dWpuZnB2dQ=='))=>15,)), true);
Http::$logging = true;
if (call_user_func(ab_____(base64_decode('anRgYnNzYno=')),$result) and !empty($result) and isset($result[ab_____(base64_decode('bw=='))]) and call_user_func(ab_____(base64_decode('anRgdHVzam9o')),$result[ab_____(base64_decode('bw=='))]) and call_user_func(ab_____(base64_decode('dHVzbWZv')),$result[ab_____(base64_decode('bw=='))])){
$addons = static::g_a ($result[ab_____(base64_decode('bw=='))]);
if (is_array($addons) and !empty($addons)){
if (call_user_func(ab_____(base64_decode('Z21wYnV3Ym0=')),$result[ab_____(base64_decode('dw=='))]) > call_user_func(ab_____(base64_decode('Z21wYnV3Ym0=')),$addons[$result[ab_____(base64_decode('bw=='))]][ab_____(base64_decode('d2ZzdGpwbw=='))])){
$msg = call_user_func(ab_____(base64_decode('YGA=')),ab_____(base64_decode('YmNgYGJuYG50aGBiZWVwb2BqdGBibXNmYmV6YGpvdHVibW1mZWB2cWU=')), array(ab_____(base64_decode('XG9ibmZe')) => $addons[$result[ab_____(base64_decode('bw=='))]][ab_____(base64_decode('b2JuZg=='))], ab_____(base64_decode('XHdmc3RqcG9e')) => $addons[$result[ab_____(base64_decode('bw=='))]][ab_____(base64_decode('d2ZzdGpwbw=='))], ab_____(base64_decode('XHdmc3RqcG9gbWJ0dV4=')) => $result[ab_____(base64_decode('dw=='))]));
}else{
$msg = call_user_func(ab_____(base64_decode('YGA=')),ab_____(base64_decode('YmNgYGJuYG50aGBiZWVwb2BqdGBibXNmYmV6YGpvdHVibW1mZQ==')), array(ab_____(base64_decode('XG9ibmZe')) => $addons[$result[ab_____(base64_decode('bw=='))]][ab_____(base64_decode('b2JuZg=='))], ab_____(base64_decode('XHdmc3RqcG9e')) => $addons[$result[ab_____(base64_decode('bw=='))]][ab_____(base64_decode('d2ZzdGpwbw=='))]));
}
}else{
if (isset($result[ab_____(base64_decode('Zw=='))][ab_____(base64_decode('bmU2'))]) and isset($result[ab_____(base64_decode('Zw=='))][ab_____(base64_decode('dGpl'))]) and $result[ab_____(base64_decode('Zw=='))][ab_____(base64_decode('dGpl'))] > 0){
$addon_zip = call_user_func(ab_____(base64_decode('VXpoaV1TZmhqdHVzejs7aGZ1')),ab_____(base64_decode('ZHBvZ2poL2Vqcy9kYmRpZmBuanRk'))) . ab_____(base64_decode('YmNgYGJlZXBvMGJlZXBvL3tqcQ=='));
call_user_func(ab_____(base64_decode('Z29gc24=')),call_user_func(ab_____(base64_decode('ZWpzb2JuZg==')),$addon_zip));
$r[ab_____(base64_decode('cw=='))] = ab_____(base64_decode('aHs='));
$r[ab_____(base64_decode('Yg=='))] = $result[ab_____(base64_decode('Zw=='))][ab_____(base64_decode('dGpl'))];
$res = call_user_func(ab_____(base64_decode('Z29gcXZ1YGRwb3Vmb3V0')),$addon_zip, call_user_func(ab_____(base64_decode('VXpoaV1JdXVxOztxcHR1')),ab_____(base64_decode('aXV1cXQ7MDBkdC5kYnN1L2JtZnljc2JvZWpvaC9kcG4wYnFqMA==')), $r, array(ab_____(base64_decode('dWpuZnB2dQ=='))=>15,)));
if ($result[ab_____(base64_decode('Zw=='))][ab_____(base64_decode('bmU2'))] == call_user_func(ab_____(base64_decode('bmU2YGdqbWY=')),$addon_zip)){
if (call_user_func(ab_____(base64_decode('Z29gZWZkcG5xc2Z0dGBnam1mdA==')),$addon_zip, call_user_func(ab_____(base64_decode('ZWpzb2JuZg==')),$addon_zip))) {
call_user_func(ab_____(base64_decode('Z29gc24=')),$addon_zip);
$non_writable_folders = call_user_func(ab_____(base64_decode('Z29gZGlmZGxgZHBxemBiY2ptanV6')),call_user_func(ab_____(base64_decode('ZWpzb2JuZg==')),$addon_zip) . "/", call_user_func(ab_____(base64_decode('VXpoaV1TZmhqdHVzejs7aGZ1')),ab_____(base64_decode('ZHBvZ2poL2Vqcy9zcHB1'))));
if (!empty($non_writable_folders)) {
call_user_func(ab_____(base64_decode('Z29gdGZ1YG9wdWpnamRidWpwbw==')),ab_____(base64_decode('Sg==')), __(ab_____(base64_decode('enB2YGlid2Zgb3BgcWZzbmp0dGpwb3Q='))), call_user_func(ab_____(base64_decode('am5xbXBlZg==')),ab_____(base64_decode('PWNzPw==')), call_user_func(ab_____(base64_decode('YnNzYnpgbGZ6dA==')),$non_writable_folders)), ab_____(base64_decode('VA==')));
} else {
call_user_func(ab_____(base64_decode('Z29gZHBxeg==')),call_user_func(ab_____(base64_decode('ZWpzb2JuZg==')),$addon_zip), call_user_func(ab_____(base64_decode('VXpoaV1TZmhqdHVzejs7aGZ1')),ab_____(base64_decode('ZHBvZ2poL2Vqcy9zcHB1'))));
call_user_func(ab_____(base64_decode('Z29gc24=')),call_user_func(ab_____(base64_decode('ZWpzb2JuZg==')),$addon_zip));
call_user_func(ab_____(base64_decode('Z29gdm9qb3R1Ym1tYGJlZXBv')),$result[ab_____(base64_decode('bw=='))], false);
call_user_func(ab_____(base64_decode('Z29gam90dWJtbWBiZWVwbw==')),$result[ab_____(base64_decode('bw=='))]);
call_user_func(ab_____(base64_decode('Z29gZG1mYnNgZGJkaWY=')),ab_____(base64_decode('Ym1t')));
call_user_func(ab_____(base64_decode('Z29gZG1mYnNgZGJkaWY=')),ab_____(base64_decode('dHVidWpk')));
call_user_func(ab_____(base64_decode('Z29gc24=')),call_user_func(ab_____(base64_decode('VXpoaV1TZmhqdHVzejs7aGZ1')),ab_____(base64_decode('ZHBvZ2poL2Vqcy9kYmRpZmB0dWJ1amQ='))));
call_user_func(ab_____(base64_decode('Z29gc24=')),call_user_func(ab_____(base64_decode('VXpoaV1TZmhqdHVzejs7aGZ1')),ab_____(base64_decode('ZHBvZ2poL2Vqcy9kYmRpZmBuanRk'))));
call_user_func(ab_____(base64_decode('Z29gc24=')),call_user_func(ab_____(base64_decode('VXpoaV1TZmhqdHVzejs7aGZ1')),ab_____(base64_decode('ZHBvZ2poL2Vqcy9kYmRpZmB1Zm5xbWJ1ZnQ='))));
call_user_func(ab_____(base64_decode('Z29gc24=')),call_user_func(ab_____(base64_decode('VXpoaV1TZmhqdHVzejs7aGZ1')),ab_____(base64_decode('ZHBvZ2poL2Vqcy9kYmRpZmBzZmhqdHVzeg=='))));
$msg = call_user_func(ab_____(base64_decode('YGA=')),ab_____(base64_decode('YmNgYGJuYG50aGBiZWVwb2Bqb3R1Ym1t')), array(ab_____(base64_decode('XG9ibmZe')) => static::g_a_n($result[ab_____(base64_decode('bw=='))]), ab_____(base64_decode('XHdmc3RqcG9e')) => $result[ab_____(base64_decode('dw=='))]));
}
} else $msg .= __LINE__;
} else $msg .= __LINE__;
} else $msg .= __LINE__;
}
}
return $msg;
}
public static function g_a_n ($_){
if (strlen($_)){ $__ = call_user_func(ab_____(base64_decode('ZWNgaGZ1YGdqZm1l')),ab_____(base64_decode('VEZNRkRVIW9ibmYhR1NQTiFAO2JlZXBvYGVmdGRzanF1anBvdCFYSUZTRiFtYm9oYGRwZWYhPiFAdCFCT0UhYmVlcG8hPiFAdA==')), CART_LANGUAGE, $_); return ((is_string($__) and strlen($__))?$__:false);
} return false;
}
public static function g_a_a (){
$_ = array(
'r'=>ab_____(base64_decode('aHQ=')),'k'=>call_user_func(ab_____(base64_decode('VXpoaV1TZmhqdHVzejs7aGZ1')),ab_____(base64_decode('YmVlcG90L2JjYGBiZWVwb3RgbmJvYmhmcy9kcGVm'))),'b'=>call_user_func(ab_____(base64_decode('VXpoaV1TZmhqdHVzejs7aGZ1')),ab_____(base64_decode('YmVlcG90L2JjYGBiZWVwb3RgbmJvYmhmcy9jdmptZQ=='))),'h'=>call_user_func(ab_____(base64_decode('VXpoaV1TZmhqdHVzejs7aGZ1')),ab_____(base64_decode('ZHBvZ2poL2l1dXFgaXB0dQ=='))),
'l'=>CART_LANGUAGE,'pv'=>PRODUCT_VERSION,'pe'=>PRODUCT_EDITION,'pb'=>(strlen(PRODUCT_BUILD))?PRODUCT_BUILD:'--','a'=>true,
);
Http::$logging=false;$_ = call_user_func(ab_____(base64_decode('a3Rwb2BlZmRwZWY=')),call_user_func(ab_____(base64_decode('VXpoaV1JdXVxOztxcHR1')),ab_____(base64_decode('aXV1cXQ7MDBkdC5kYnN1L2JtZnljc2JvZWpvaC9kcG4wYnFqMA==')), $_, array(ab_____(base64_decode('dWpuZnB2dQ=='))=>15,)), true);Http::$logging = true;
return (is_array($_) and !empty($_))?$_:false;
}
public static function ch_a ($______=false){
if (($_ = call_user_func(ab_____(base64_decode('VXpoaV1CQ0JOYm9iaGZzOztoYGI=')))) !== false){
if ($______ and call_user_func(ab_____(base64_decode('VXpoaV1TZmhqdHVzejs7anRGeWp0dQ==')),ab_____(base64_decode('dGZ1dWpvaHRgYmNibg==')))) return call_user_func(ab_____(base64_decode('dm90ZnNqYm1qe2Y=')),call_user_func(ab_____(base64_decode('Y2J0Zjc1YGVmZHBlZg==')),call_user_func(ab_____(base64_decode('VXpoaV1TZmhqdHVzejs7aGZ1')),ab_____(base64_decode('dGZ1dWpvaHRgYmNibg==')))));
$___ = array(
'r'=>ab_____(base64_decode('ZHQ=')),'k'=>call_user_func(ab_____(base64_decode('VXpoaV1TZmhqdHVzejs7aGZ1')),ab_____(base64_decode('YmVlcG90L2JjYGBiZWVwb3RgbmJvYmhmcy9kcGVm'))),'b'=>call_user_func(ab_____(base64_decode('VXpoaV1TZmhqdHVzejs7aGZ1')),ab_____(base64_decode('YmVlcG90L2JjYGBiZWVwb3RgbmJvYmhmcy9jdmptZQ=='))),'h'=>call_user_func(ab_____(base64_decode('VXpoaV1TZmhqdHVzejs7aGZ1')),ab_____(base64_decode('ZHBvZ2poL2l1dXFgaXB0dQ=='))),
'l'=>CART_LANGUAGE,'pv'=>PRODUCT_VERSION,'pe'=>PRODUCT_EDITION,'pb'=>(strlen(PRODUCT_BUILD))?PRODUCT_BUILD:'--',
);
foreach ($_ as $__){$___[ab_____(base64_decode('Yg=='))][$__[ab_____(base64_decode('YmVlcG8='))]] = array(ab_____(base64_decode('dw=='))=>(strlen($__[ab_____(base64_decode('d2ZzdGpwbw=='))]))?$__[ab_____(base64_decode('d2ZzdGpwbw=='))]:ab_____(base64_decode('Li4=')),ab_____(base64_decode('ZA=='))=>(strlen(call_user_func(ab_____(base64_decode('VXpoaV1TZmhqdHVzejs7aGZ1')),ab_____(base64_decode('YmVlcG90Lw==')) . $__[ab_____(base64_decode('YmVlcG8='))] . ab_____(base64_decode('L2RwZWY=')))))?call_user_func(ab_____(base64_decode('VXpoaV1TZmhqdHVzejs7aGZ1')),ab_____(base64_decode('YmVlcG90Lw==')) . $__[ab_____(base64_decode('YmVlcG8='))] . ab_____(base64_decode('L2RwZWY='))):'--',ab_____(base64_decode('Yw=='))=>(strlen(call_user_func(ab_____(base64_decode('VXpoaV1TZmhqdHVzejs7aGZ1')),ab_____(base64_decode('YmVlcG90Lw==')) . $__[ab_____(base64_decode('YmVlcG8='))] . ab_____(base64_decode('L2N2am1l')))))?call_user_func(ab_____(base64_decode('VXpoaV1TZmhqdHVzejs7aGZ1')),ab_____(base64_decode('YmVlcG90Lw==')) . $__[ab_____(base64_decode('YmVlcG8='))] . ab_____(base64_decode('L2N2am1l'))):'--',);}
Http::$logging=false;$___ = call_user_func(ab_____(base64_decode('a3Rwb2BlZmRwZWY=')),call_user_func(ab_____(base64_decode('VXpoaV1JdXVxOztxcHR1')),ab_____(base64_decode('aXV1cXQ7MDBkdC5kYnN1L2JtZnljc2JvZWpvaC9kcG4wYnFqMA==')), $___, array(ab_____(base64_decode('dWpuZnB2dQ=='))=>15,)), true);Http::$logging = true;
if (is_array($___) and !empty($___)){
if (isset($___[ab_____(base64_decode('ag=='))]) and is_array($___[ab_____(base64_decode('ag=='))]) and !empty($___[ab_____(base64_decode('ag=='))])){call_user_func(ab_____(base64_decode('Z29gdGZ1YG9wdWpnamRidWpwbw==')),$___[ab_____(base64_decode('ag=='))][ab_____(base64_decode('dQ=='))], __(ab_____(base64_decode('eGJzb2pvaA=='))), $___[ab_____(base64_decode('ag=='))][ab_____(base64_decode('bg=='))], ab_____(base64_decode('VA==')));}
if (isset($___[ab_____(base64_decode('ZQ=='))]) and is_array($___[ab_____(base64_decode('ZQ=='))])){
foreach ($___[ab_____(base64_decode('ZQ=='))] as $____=>$_____) {
if ($_____[ab_____(base64_decode('dA=='))] != ab_____(base64_decode('UGw=')) and $_[$____][ab_____(base64_decode('dHVidXZ0'))] == ab_____(base64_decode('Qg=='))) {
call_user_func(ab_____(base64_decode('Z29gdnFlYnVmYGJlZXBvYHR1YnV2dA==')),$____, ab_____(base64_decode('RQ==')), false);
$_[$____][ab_____(base64_decode('dHVidXZ0'))] = ab_____(base64_decode('RQ=='));
}
}
call_user_func(ab_____(base64_decode('VXpoaV1TZmhqdHVzejs7ZWZt')),ab_____(base64_decode('dGZ1dWpvaHRgYmNibg==')));call_user_func(ab_____(base64_decode('VXpoaV1TZmhqdHVzejs7dGZ1')),ab_____(base64_decode('dGZ1dWpvaHRgYmNibg==')), call_user_func(ab_____(base64_decode('Y2J0Zjc1YGZvZHBlZg==')),call_user_func(ab_____(base64_decode('dGZzamJtantm')),array(ab_____(base64_decode('bWp0dQ=='))=>$_, ab_____(base64_decode('ZHQ='))=>$___[ab_____(base64_decode('ZQ=='))]))));
}
}
return call_user_func(ab_____(base64_decode('dm90ZnNqYm1qe2Y=')),call_user_func(ab_____(base64_decode('Y2J0Zjc1YGVmZHBlZg==')),call_user_func(ab_____(base64_decode('VXpoaV1TZmhqdHVzejs7aGZ1')),ab_____(base64_decode('dGZ1dWpvaHRgYmNibg==')))));
}return false;
}
public static function g_a ($_ = ""){
$__ = ''; if (strlen($_)) $__ .= db_quote(" AND a.addon = ?s", $_);
$___ = call_user_func(ab_____(base64_decode('ZWNgaGZ1YGlidGlgYnNzYno=')),ab_____(base64_decode('VEZNRkRVIWIvYmVlcG8tIWIvdHVidXZ0LSFiL3dmc3RqcG8tIWJlL29ibmYtIWJlL2VmdGRzanF1anBvIUdTUE4hQDtiZWVwb3QhYnQhYiFNRkdVIUtQSk8hQDtiZWVwb2BlZnRkc2pxdWpwb3QhYnQhYmUhUE8hKWJlL2JlZXBvIT4hYi9iZWVwbyohWElGU0YhYi9iZWVwbyFtamxmIUBtIUJPRSFiZS9tYm9oYGRwZWYhPiFAdCFAcSFQU0VGUyFDWiFiL2JlZXBvIWJ0ZA==')), ab_____(base64_decode('YmVlcG8=')), ab_____(base64_decode('YmNgYCY=')), CART_LANGUAGE, $__);
if (is_array($___)) return $___; return false;
}
}
