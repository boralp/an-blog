<?php

require __DIR__.'/parsedown.inc';
$conf = json_decode(file_get_contents(__DIR__.'/_config.json'), true);
$temp = file_get_contents(__DIR__.'/assets/'.$conf['temp'].'.htm');
$temp = str_replace(["\t", "\n", "\r"], '', $temp);
$link = str_replace('/', '-', trim($_SERVER['REQUEST_URI'], '/'));
$link = ($link === '' ? $conf['index'] : $link);
$page = __DIR__.'/items/'.$link.'.md';
if (!file_exists($page)) {
    header('HTTP/1.0 404 Not Found');
    $page = __DIR__.'/items/'.$conf['404'].'.md';
}
$page = Parsedown::instance()->text(file_get_contents($page));
foreach ($conf['menu'] as $menuw => $menus) {
    if (preg_match('/{#'.$menuw.'_menu}(.*?){\/#'.$menuw.'_menu}/', $temp, $menu)) {
        foreach ($menus as $m) {
            $menu[-1]['list'][] = strtr($menu[1], [
                '{'.$menuw.'_link}' => $m,
                '{'.$menuw.'_title}' => $m,
            ]);
        }
        $temp = str_replace($menu[0], implode('', $menu[-1]['list']), $temp);
    }
}
if ($link === $conf['index']) {
    foreach (glob(__DIR__.'/items/20*.md', GLOB_BRACE) as $file) {
        $page .= strtr(file_get_contents(__DIR__.'/assets/_article.htm'), [
            '{article_title}' => str_replace('#', '', fgets(fopen($file, 'r'))),
            '{article_path}' => str_replace([__DIR__.'/items/', '.md'], '', $file),
            '{article_date}' => date('F j, Y', strtotime(mb_substr(str_replace([__DIR__.'/items/', '.md'], '', $file), 0, 10))),
        ]);
    }
}
$temp = strtr($temp, [
    '{body}' => $page,
    '{title}' => $conf['title'],
    '{description}' => $conf['description'],
    '{year}' => date('Y'),
	'{generated}' => round(microtime(true) - $_SERVER['REQUEST_TIME_FLOAT'], 4),
]);
echo str_replace(["\t", "\n", "\r"], '', $temp);