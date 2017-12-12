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
(function (_, $) {
$.ceEvent('on', 'ce.ajaxdone', function (elms, scripts, params, response_data, response_text) {
try {
if (typeof response_data == "undefined" || response_data === null
|| typeof response_data.ab__sf_data == "undefined" || response_data.ab__sf_data === null
) {} else {
if (typeof response_data.ab__sf_data.tag_h1 == "undefined" || response_data.ab__sf_data.tag_h1 === null
) {} else {
$("h1[class*=mainbox-title] > span").text(response_data.ab__sf_data.tag_h1);
}
if (typeof response_data.ab__sf_data.page_title == "undefined" || response_data.ab__sf_data.page_title === null
) {} else {
document.title = response_data.ab__sf_data.page_title;
}
if (typeof response_data.ab__sf_data.description == "undefined" || response_data.ab__sf_data.description === null
) {} else {
var desc = $("div.ab__sf_cat_desc");
if (desc.length) {
desc.html(response_data.ab__sf_data.description);
ab__sf_hide_desc_init();
}
}
}
}
catch (e) {
console.log(e);
return false;
}
});
$.ceEvent('on', 'ce.commoninit', function(context) {
ab__sf_hide_desc_init();
});
function ab__sf_hide_desc_init (){
var desc = $('div.ab__sf_cat_desc');
if (desc.length && _.ab__sf.hide_description != 'disabled' && !$("div.ab__mcd_descs").length) {
desc.css({maxHeight:'none'});
_.ab__sf.full_height_description = desc.outerHeight(true) + 10;
if (parseInt(_.ab__sf.full_height_description) >= parseInt(_.ab__sf.hide_description)) {
ab__sf_hide_desc_remove();
desc.addClass('ab__sf_hide_description').css({maxHeight: parseInt(_.ab__sf.hide_description) + "px", overflow: "hidden",});
$("<div class='ab__sf_hide_description_more'>" + _.ab__sf.more + "</div>").insertAfter(desc);
}else{
ab__sf_hide_desc_remove();
}
}else{
ab__sf_hide_desc_remove();
}
}
function ab__sf_hide_desc_remove (){
var desc = $('div.ab__sf_cat_desc');
desc.removeClass('ab__sf_hide_description');
desc.removeClass('inverse');
var button = $('div.ab__sf_hide_description_more');
if (button.length){
button.remove();
}
}
$(document).on('click', 'div.ab__sf_hide_description_more:not(.inverse)', function() {
var button = $(this);
var desc = $('div.ab__sf_cat_desc');
desc.animate({maxHeight: _.ab__sf.full_height_description}, 800, function(){
button.addClass('inverse');
desc.addClass('inverse');
button.html(_.ab__sf.less);
});
});
$(document).on('click', 'div.ab__sf_hide_description_more.inverse', function() {
var button = $(this);
var desc = $('div.ab__sf_cat_desc');
desc.removeClass('inverse');
desc.animate({maxHeight: parseInt(_.ab__sf.hide_description) + "px"}, 800, function(){
button.removeClass('inverse');
button.html(_.ab__sf.more);
});
});
}(Tygh, Tygh.$));
