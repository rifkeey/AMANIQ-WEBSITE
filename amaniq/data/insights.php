<?php
/*
 * Insights and announcements. Empty until real articles are published —
 * the Insights page shows a "coming soon" state and stays out of search results.
 *
 * To publish an article, add an entry keyed by its URL slug:
 *
 *   'securing-small-business-email' => [
 *       'slug' => 'securing-small-business-email',
 *       'title' => 'Securing email for small businesses',
 *       'summary' => 'One or two sentences used on the listing and as the meta description.',
 *       'category' => 'Cybersecurity',          // Cybersecurity, Consulting, Training, Announcements
 *       'date' => '2026-11-03',                  // publication date, YYYY-MM-DD
 *       'author' => 'mohammed-ibrahim',          // a slug from team.php
 *       'body' => [                              // paragraphs; use ['h2', 'Heading'] for sub-headings
 *           'First paragraph…',
 *           ['h2', 'A sub-heading'],
 *           'Next paragraph…',
 *       ],
 *   ],
 *
 * Never publish placeholder or invented articles.
 */
return [];
