# Kirby Snippet Cache

This plugin provides caching functionality for Kirby CMS snippet output via a `snippet-cache` snippet.

It may be useful if you can't use Kirby's overall page cache, but have snippets that do extensive queries or loop and transform a lot of data.

## Installation

### Download

Download and copy this repository to `/site/plugins/kirby-snippet-cache`.

### Composer

```
composer require timnarr/kirby-snippet-cache
```

## Usage
```php
// Load the `header` snippet with default cache duration
<?php snippet('snippet-cache', ['snippet' => 'header']) ?>

// Load the `blog/author` snippet with default cache duration
<?php snippet('snippet-cache', ['snippet' => 'blog/author']) ?>

// Load the `blog/author` snippet with a custom cache duration
<?php snippet('snippet-cache', ['snippet' => 'blog/author', 'duration' => 30]) ?>

// Load the `blog/author` snippet and pass variables to the cached snippet
<?php snippet('snippet-cache', ['snippet' => 'blog/author', 'variables' => ['author' => $author]]) ?>
<?php snippet('snippet-cache', ['snippet' => 'blog/author', 'variables' => compact('author')]) ?>

// You can also use alternative/fallback snippets
<?php snippet('snippet-cache', ['snippet' => ['articles/' . $page->postType(), 'articles/default']]) ?>
```

## No usage with slots
⚠️ Unfortunately, passing slots to cached snippets is not supported and probably never will be.

Take a look at the following example of what a cached snippet with slots would look like. This would cache the snippet output, but also execute the slotted PHP each time, and if you are doing extensive tasks here (here using `sleep(4)` as an example), this would not provide any performance benefits.

```php
<?php snippet('snippet-cache', ['snippet' => 'mySnippet'], slots: true) ?>
	<h1>This is the default slot title</h1>
	<?php sleep(4) ?>
<?php endsnippet() ?>
```

### Clear cache

All caches are automatically cleared when an site (using the `page.update:after` hook) or page update (using the `site.update:after` hook) happens.

## Options

| Option          | Default | Description                                                                              |
| --------------- | ------- | ---------------------------------------------------------------------------------------- |
| `duration`      | `0`     | Default cache duration in minutes. Can be defined per snippet. `0` means infinite cache duration.                                                                   |

Set options in your `config.php` file:

```php
return [
	'cache' => [
		'timnarr.snippet-cache' => true,  // Enable snippet-cache...
		'pages' => [
			'active' => false // ... while deactivating page-cache
		]
	],
	'timnarr.snippet-cache' => [
		'duration' => 0 // in minutes
	],
];
```

## License

[MIT License](./LICENSE) Copyright © 2023 Tim Narr
