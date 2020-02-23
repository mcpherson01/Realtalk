=== WP Speed of Light Addon ===
Contributors: JoomUnited
Tags: cache, caching, performance, speed test, performance test, wp-cache, cdn, combine, compress, speed plugin, database cache, deflate, webpagetest, gzip, http compression, js cache, minify, optimize, optimizer, page cache, performance, speed, expire headers, mobile cache
Requires at least: 4.5
Tested up to: 5.0.3
Stable tag: 2.4.0
Requires PHP: 5.3
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

WP Speed of Light Addon is a WordPress speedup plugin and load time testing. Cache, Gzip, minify, group, Lazy Loading, CDN

== Description ==

== Changelog ==

= 2.4.0 =
 * Add : Rewrite code from “Simple Cache” and “Autoptimize”
 * Add :  After a cache cleanup, auto-reload the page
 * Add : Cleanup cache on Gutenberg save content
 * Fix : Remove direct CURL calls (security fix)
 * Fix : Admin responsive configuration & Speed optimization

= 2.3.0 =
 * Add : New UX for Speed Otimization and Speed Testing
 * Add : Possibility to search in plugin menus and settings
 * Add : New plugin installer with quick configuration
 * Add : Environment checker on install (PHP Version, PHP Extensions, Apache Modules)
 * Add : System Check menu to notify of server configuration problems after install
 * Add : Server testing before plugin activation to avoid all fatal errors

= 2.2.0 =
 * Add : Import/Export plugin configuration
 * Add : Exclude URLs from the lazy loading

= 2.1.1 =
 * Add : Enhance code readability and performance with phpcs

= 2.1.0 =
 * Add : Implement image Lazy Loading
 * Add : Implement option to disable WordPress Emoji
 * Add : Implement option to disable WordPress Gravatar
 * Add : Exclude inline JS scripts from minification
 * Add : Possibility to defer script loading in page footer

= 2.0.2 =
 * Fix : Check addon to exclude file from minification

= 2.0.1 =
 * Fix : Using PHPCS to make standard definitions
 * Fix : Change preloading activation method

= 2.0.0 =
 * Add : Database automatic optimization: duplicate post, comment, user, term meta
 * Add : Database automatic optimization: run database tables optimization
 * Add : Flush CDN cache from MaxCDN, KeyCDN and CloudFlare, automatic or manual method
 * Add : Flush cache from Siteground plugin and Varnish, automatic or manual method
 * Add : Change install message to a WP option, and display only once

= 1.0.0 =
 * Add : Disable cache per user role
 * Add : Disable cache per URL using rules like www.domain.com/blog*
 * Add : Automatic database cleanup by interval
 * Add : Preload the cache per URL
 * Add : DNS Prefetching (define custom domains)
 * Add : Option to exclude custom JS/CSS/FONT files from group
 * Add : Add the option to group fonts and Google fonts in optimization
 * Add : Initial release of WP Speed of Light Addon


