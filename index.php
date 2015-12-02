<?php
require __DIR__ . "/parsedown.inc";
$pd = new Parsedown() or die('pd');
$sitename = "Bora Alp Arat";
$sitespot = "PHP static blog engine under 50 lines";
$blogname = "Blog";
function load($file) {
	return json_decode(file_get_contents($file), false);
}
$root = substr($_SERVER["PHP_SELF"], 0, -strlen(basename($_SERVER["PHP_SELF"])));
$link = basename(parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH));
((parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH) === $root) ? $link = "" : "");
$type =  strpos($_SERVER["REQUEST_URI"], "post/") ? "post" : "page";
$pages = glob(__DIR__ . "/items/*" . $link . ".{json}", GLOB_BRACE);
$link = ($pages ? $pages[0] : "./items/error-404.txt");
$page = load($link);
echo "<!DOCTYPE html><html lang=\"en\"><head><title>", $sitename, (trim($page->data->title) ? " - " . $page->data->title : ""), "</title><meta charset=\"utf-8\"><meta name=\"viewport\" content=\"initial-scale=1, minimum-scale=1, maximum-scale=1\"><meta http-equiv=\"x-ua-compatible\" content=\"ie=edge\"><link rel=\"stylesheet\" type=\"text/css\" href=\"/assets/css/web.css\"><base href=\"", htmlspecialchars($root, ENT_QUOTES, "UTF-8"), "\"></head><body><header><h1><a href=\".\">", $sitename, "<small>", $sitespot, "</small></a></h1><nav>";
foreach($pages as $menu) {
	$menu_item = load($menu);
	if ($menu_item->data->menu) {
		echo "<a href=\"", ($menu_item->data->url ? $menu_item->data->url : pathinfo($menu)['filename']), "\">", $menu_item->data->title, "</a>";
	}
}
echo "</nav></header><main>";
if ($type === "post") {
	echo "<article><h2>", $page->data->title, "</h2><h3>", $page->data->spot, "</h3>", ($page->data->cover ? "<p><img src=\"" . $page->data->cover . "\" alt=\"" . $page->data->title . "\"></p>" : ""), $pd->setBreaksEnabled(true)->text($page->data->body), "</article>";
}
else if ($type === "page") {
	echo "<article><h2>", $page->data->title, "</h2><h3>", $page->data->spot, "</h3>", ($page->data->cover ? "<p><img src=\"" . $page->data->cover . "\" alt=\"" . $page->data->title . "\"></p>" : ""), $pd->setBreaksEnabled(true)->text($page->data->body), "</article>";
}
if ($page->data->title === $blogname) {
	foreach($pages as $post) {
		$post_item = load($post);
		if ($post_item->data->post) {
		  echo "<article><h2><a href=\"./post/", ($post_item->data->url ? $post_item->data->url : pathinfo($post)['filename']), "\">", $post_item->data->title, "</a></h2><h3>", $post_item->data->spot, "</h3>", ($page->data->cover ? "<p><img src=\"" . $page->data->cover . "\" alt=\"" . $post_item->data->title . "\"></p>" : ""), "</article>";
		}
	}
}
echo "</main><footer><p>", $sitename, " &copy; ", date("Y"), " | Powered by <a href=\"https://github.com/boralp/divless\" target=\"_blank\">{divless}</a>.</p></footer></body></html>";
?>
