=== PopCash.Net Code Integration Tool ===
Contributors: (popcashnet)
Tags: popcash.net, code, integrator, integration, popunder, script, snippet, tool
Requires at least: 3.0.1
Tested up to: 5.3
Stable tag: trunk/1.1.1
License: GPLv2
License URI: http://www.gnu.org/licenses/gpl-2.0.html

This plugin is designed to help the integration of the publisher code from PopCash.Net

== Description ==

The plugin offers Wordpress publishers the possibility to integrate the PopCash.Net pop-under code by two methods: either through inserting User ID (UID) and Website ID (WID) or through copying and pasting the code obtained through your PopCash.Net user panel. More than this, the plugin also offers users the option to temporarily disable the code integration without having to uninstall or deactivate the plugin

### Bug Reports ###
* Ricardo Sanchez ([report here](https://packetstormsecurity.com/files/144583/WordPress-PopCash.Net-Publisher-Code-Integration-1.0-Cross-Site-Scripting.html)). Thank you!

== Installation ==

This section describes how to install the plugin and get it working.

1. Upload the plugin files to the `/wp-content/plugins/popcash-net` directory, or install the plugin through the WordPress plugins screen directly.
2. Activate the plugin through the 'Plugins' screen in WordPress
3. Use the PopCash.Net screen to configure the plugin
3.1. Plugin Configuration
3.1.1. On the Individual IDs page, insert the User ID and Website ID that you have obtained from your PopCash.Net User Dashboard
3.1.2. On the Code integration page, copy and paste the code that you can get from your PopCash.Net User Dashboard

== Changelog ==

= 1.1 =
* Fix cross site scripting vulnerability described [here](https://packetstormsecurity.com/files/144583/WordPress-PopCash.Net-Publisher-Code-Integration-1.0-Cross-Site-Scripting.html). Thanks to Ricardo Sanchez
= 1.1.1 =
* Fixing bugs when switching tabs


== Upgrade Notice ==

= 1.1 =
Includes fix for cross site scripting vulnerability described [here](https://packetstormsecurity.com/files/144583/WordPress-PopCash.Net-Publisher-Code-Integration-1.0-Cross-Site-Scripting.html). Thanks to Ricardo Sanchez