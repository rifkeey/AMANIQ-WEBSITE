<?php
/*
 * Produces public_html/assets/css/site.min.css from site.css.
 * Production serves the minified file automatically when it exists
 * (see stylesheet() in amaniq/src/helpers.php). Run after editing site.css:
 *
 *   php tools/build-assets.php
 *
 * The site's JavaScript is small and served as written.
 */
$dir = dirname(__DIR__) . '/public_html/assets/css';
$css = file_get_contents($dir . '/site.css');

$css = preg_replace('~/\*.*?\*/~s', '', $css);          // comments
$css = preg_replace('/\s+/', ' ', $css);                // collapse whitespace
$css = preg_replace('/\s*([{};,>~])\s*/', '$1', $css);  // space around punctuation (not "+", which calc() needs)
$css = preg_replace('/:\s+/', ':', $css);
$css = str_replace(';}', '}', $css);

file_put_contents($dir . '/site.min.css', trim($css) . "\n");
printf("site.css %s KB → site.min.css %s KB\n", round(filesize($dir . '/site.css') / 1024, 1), round(filesize($dir . '/site.min.css') / 1024, 1));
