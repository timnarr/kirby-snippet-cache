<?php

use Kirby\Cms\App;

$kirby = App::instance();
$cache = $kirby->cache('timnarr.snippet-cache');

Kirby::plugin('timnarr/snippet-cache', [
	'options' => [
		'cache' => true,
		'duration' => 0
	],
	'snippets' => [
		'snippet-cache' => __DIR__ . '/snippets/snippet-cache.php'
	],
	'hooks' => [
		'page.update:after' => function () use ($cache) {
			return $cache->flush();
		},
		'site.update:after' => function () use ($cache) {
			return $cache->flush();
		}
	]
]);
