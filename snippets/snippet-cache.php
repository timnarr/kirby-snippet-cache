<?php

$cache = $kirby->cache('timnarr.snippet-cache');
$defaultDuration = option('timnarr.snippet-cache.duration');
$snippetName = $snippet;

if (is_array($snippet)) {
	$snippetName = array_filter($snippet, function ($item) {
		return Snippet::file($item) !== null;
	});

	$snippetName = reset($snippetName);
}

// Set default values if not provided
$snippetVariables = $variables ?? [];
$duration = $duration ?? $defaultDuration;

// Create a unique cache hash
$pluginVersion = $kirby->plugin('timnarr/snippet-cache')->version();
$cacheHash = 'snippet-' . str_replace('/', '-', $snippetName) . '-' . hash('xxh3', serialize($snippetVariables) . $duration . $pluginVersion);
$cacheHash = strtolower($cacheHash);

// Retrieve data from cache or set it
$data = $cache->getOrSet($cacheHash, function () use ($snippetName, $snippetVariables) {
	return $data = snippet($snippetName, $snippetVariables, true);
}, $duration);

echo $data;
