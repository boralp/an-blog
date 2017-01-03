require __DIR__.'/parsedown.inc';
$conf = json_decode(file_get_contents(__DIR__.'/_config.json'), true);
$temp = str_replace(["\t", "\n", "\r"], '', file_get_contents(__DIR__.'/assets/'.$conf['temp'].'.htm'));
$link = trim(strtr('http' . ($_SERVER['HTTPS'] ?? '' === 'on' ? 's' : '') . '://' . $_SERVER['SERVER_NAME'] . (!in_array($_SERVER['SERVER_PORT'], ['80', '443']) ? ':' . $_SERVER['SERVER_PORT'] : '') . $_SERVER['REQUEST_URI'], [$conf['base'] => '', '/' => '-']), '-');
$link = ($link === '' ? $conf['index'] : $link);
$page = __DIR__.'/items/'.$link.'.md';
if (!file_exists($page)) {
    header('HTTP/1.0 404 Not Found');
    $page = __DIR__.'/items/'.$conf['404'].'.md';
}
$title = str_replace('#', '', fgets(fopen($page, 'r'))) . ' - ';
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
    foreach (array_reverse(glob(__DIR__.'/items/20*.md', GLOB_BRACE)) as $file) {
        $page .= strtr(file_get_contents(__DIR__.'/assets/_article.htm'), [
            '{article_title}' => str_replace('#', '', fgets(fopen($file, 'r'))),
            '{article_path}' => str_replace([__DIR__.'/items/', '.md'], '', $file),
            '{article_date}' => date('F j, Y', strtotime(mb_substr(str_replace([__DIR__.'/items/', '.md'], '', $file), 0, 10))),
        ]);
    }
}
$temp = strtr($temp, [
    '{base}' => $conf['base'],
    '{body}' => $page,
    '{title}' => ($link !== $conf['index'] ? $title : '') . $conf['title'],
    '{page_title}' => $conf['title'],
    '{description}' => $conf['description'],
    '{year}' => date('Y'),
    '{generated}' => round(microtime(true) - $_SERVER['REQUEST_TIME_FLOAT'], 4),
]);
echo str_replace(["\t", "\n", "\r"], '', $temp);
