(function(){
var cab_URL = '<?= str_replace([
    'https',
    'http',
    ':',
], '', \Cake\Core\Configure::read('App.fullBaseUrl')) ?>';
var params = <?= empty(\Cake\Core\Configure::read('App.cpaParams')) ? '{clickid:""}' :
    json_encode(\Cake\Core\Configure::read('App.cpaParams')) ?>;
let query = window.location.search.substring(1);
if (query.length > 0) {
let parsed_qs = parseQueryString(query);
for (var paramName in params) {
if (params.hasOwnProperty(paramName)) {
params[paramName] = parsed_qs[paramName] || '';
}
}
setCookie('iz3_params', JSON.stringify(params), 1);
let stateCheck = setInterval(function(){
if (document.readyState === 'interactive' || document.readyState === 'complete') {
//clearInterval(stateCheck);
var elements = document.getElementsByTagName('a');
for (var i = 0; i < elements.length; i++) {
var href = elements[i].getAttribute("href");
try{
if (href.indexOf(cab_URL) !== -1 && href.indexOf('clickid') === -1) {
let params = getCookie('iz3_params') || '';
elements[i].href = elements[i].href + ((elements[i].href.indexOf('?') !== -1) ? '&' : '?') + 'clickid=' + encodeURIComponent(params);
}
}catch(e){}
}
}
}
, 500);
}
function parseQueryString(query) {
var vars = query.split("&");
var query_string = {};
for (var i = 0; i < vars.length; i++) {
var pair = vars[i].split("=");
var key = decodeURIComponent(pair[0]);
var value = decodeURIComponent(pair[1]);
if (typeof query_string[key] === "undefined") {
query_string[key] = decodeURIComponent(value);
} else if (typeof query_string[key] === "string") {
var arr = [query_string[key], decodeURIComponent(value)];
query_string[key] = arr;
} else {
query_string[key].push(decodeURIComponent(value));
}
}
return query_string;
}
function setCookie(name, value, days) {
var expires = "";
if (days) {
var date = new Date();
date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
expires = "; expires=" + date.toUTCString();
}
document.cookie = name + "=" + (value || "") + expires + "; path=/";
}
function getCookie(name) {
var nameEQ = name + "=";
var ca = document.cookie.split(';');
for (var i = 0; i < ca.length; i++) {
var c = ca[i];
while (c.charAt(0) == ' ')
c = c.substring(1, c.length);
if (c.indexOf(nameEQ) == 0)
return c.substring(nameEQ.length, c.length);
}
return null;
}
function eraseCookie(name) {
document.cookie = name + '=; Max-Age=-99999999;';
}
}
)();