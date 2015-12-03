<!DOCTYPE html>
<html lang="en">
<head>
<title><?php echo $sitename, (trim($page->data->title) ? " - " . $page->data->title : ""); ?></title>
<meta charset="utf-8">
<meta name="viewport" content="initial-scale=1, minimum-scale=1, maximum-scale=1">
<meta http-equiv="x-ua-compatible" content="ie=edge">
<link rel="stylesheet" type="text/css" href="/assets/css/web.css">
<base href="<?php echo htmlspecialchars($root, ENT_QUOTES, "UTF-8"); ?>">
</head>
<body>
<header>
<h1><a href="."><?php $sitename; ?><small><?php echo $sitespot; ?></small></a></h1>
<nav>
