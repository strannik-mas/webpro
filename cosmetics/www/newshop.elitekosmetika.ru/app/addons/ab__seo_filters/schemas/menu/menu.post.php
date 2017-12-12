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
if (!defined('BOOTSTRAP')) {die('Access denied');}
use Tygh\Registry;
$schema['central']['ab__addons']['items']['ab__seo_filters'] = array(
'attrs' => array('class'=>'is-addon'),
'href' => 'ab__sf_rules.manage',
'position' => 2,
'subitems' => array(
'ab__sf.rules' => array(
'attrs' => array(
'class'=>'is-addon'
),
'href' => 'ab__sf_rules.manage',
'position' => 10
),
'ab__sf.names' => array(
'attrs' => array(
'class'=>'is-addon'
),
'href' => 'ab__sf_names.manage',
'position' => 20
),
'ab__sf.patterns' => array(
'attrs' => array(
'class'=>'is-addon'
),
'href' => 'ab__sf_patterns.manage',
'position' => 25
),
'ab__sf.sitemap' => array(
'attrs' => array(
'class'=>'is-addon'
),
'href' => 'ab__sf_sitemap.manage',
'position' => 30
),
'ab__sf.export' => array(
'attrs' => array(
'class'=>'is-addon'
),
'href' => 'exim.export?section=ab__seo_filters',
'position' => 40
),
'ab__sf.import' => array(
'attrs' => array(
'class'=>'is-addon'
),
'href' => 'exim.import?section=ab__seo_filters',
'position' => 50
),
'ab__sf.help' => array(
'attrs' => array(
'class'=>'is-addon'
),
'href' => 'ab__sf.help',
'position' => 60
),
),
);
if (fn_allowed_for('MULTIVENDOR') && !Registry::get('runtime.company_id') || fn_allowed_for('ULTIMATE')) {
$schema['top']['administration']['items']['export_data']['subitems']['ab__seo_filters'] = array(
'href' => 'exim.export?section=ab__seo_filters',
'position' => 1
);
$schema['top']['administration']['items']['import_data']['subitems']['ab__seo_filters'] = array(
'href' => 'exim.import?section=ab__seo_filters',
'position' => 1
);
}
return $schema;
