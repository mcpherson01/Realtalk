1.4.10
- New plugin embed option that allows embedding from cookieless domain;
- New video post embed option for embedding from cookieless domain;
- Implemented new plugin filter "cbc_nocookie_embed" that can be used to force embed from cookieless domain.

1.4.9
- Solved a bug that was causing manual import to assign to the wrong or no category when selecting the category from the bottom of the page, beneath the videos list;
- Added views compatibility for theme Truemag.

1.4.8
- Added new option for latest videos widget that allows to enable/disable video auto play;
- Trim OAuth client ID and secret to avoid authentication errors.

1.4.7
- Solved single video import bug that was importing categories even if global option for importing categories was off;
- Solved single video import bug that was causing PHP error when importing categories;
- Plugin loads full JS script for embedding video when WordPress SCRIPT_DEBUG is on;
- Added filter "cbc_video_embed_filter_priority" that allows filtering of priority for the automatic embed made by the plugin. This is useful when using membership plugins that protect the content;
- Solved a bug that was preventing posts from being updated to pending review when check for post status was on.

1.4.6
- Solved a bug that stored video details in database as CBC_Video object instead of array;
- Modified class CBC_Ajax to use composition instead of inheritance;
- Introduced data cache class for video details retrieved from WP custom field.

1.4.4
- Added plugin options class for better options management;
- Improved speed by making additional changes to the plugin.

1.4.3
- Solved a page loading time on archive pages containing video posts that was caused in rare circumstances by requests made to YouTube API to refresh video information;
- Solved pagination issue under "My YouTube" plugin page;
- Implemented code timers that measure how long it takes for certain tasks to be accomplished by the plugin (to see reports you need the debugging plugin);

1.4.2
- Solved an automatic import bug that was causing the importer to stop when automatic import was set to import only newly added videos;
- Solved various filter/action plugin parameters that were returning an object instead of an array for the video details and this caused PHP errors to appear;
- Solved an automatic import error that appeared when using the date restriction functionality and was causing the importer to stop importing;
- Solved a bug that appeared when using the video schema;
- Implemented filter 'cbc_js_embed' that can be used to modify all embeds made by the plugin to place embed iframe directly into the post content instead of using plugin's JavaScript embedding.

1.4.1
- Solves PHP error "Fatal error: Can't use method return value in write context in" that is triggered if using a PHP version lower than 5.5. 

1.4.0
- Introduced function `cbc_get_class_instance()` that returns main class object reference (`CBC_YouTube_Videos`);
- Introduced new method of retrieving video details from post using method `CBC_YouTube_Videos->get_post_video_data( $post_id )` which returns an object of type CBC_Video;
- Introduced new class `CBC_Video` which handles all video details from a given post;
- Added etag field to automatic import post types;
- Added extra links to plugin entry in Plugins page (Settings, Documentation and First time installation);
- Added PHP version warning if PHP < 7.0;
- Solved a bug that wasn't resetting the countdown if current automatic import was deleted;
- Introduced new method `get_post_video_data($post)` in class `CBC_Video_Post_Type` that returns video details from post as `CBC_Video` object;
- Solved a PHP notice that was triggered when saving a video widget without setting the widget cache on;
- Added new function "cbc_video_embed_html()" that can be used in WP Loop to embed attached YouTube video, if available;
- Solved a bug that was causing automatic imports to not import newest videos from channels and user uploads if option to import only newly added videos was on. This bug is triggered by YouTube API which, for channels and user uploads, returns the results ordered by "relevance" instead of publishing date. This causes feeds to be returned ordered in a more or less random order which in turn prevents the plugin from determining which videos were imported lately;
- Added prioritization for automatic imports which allows to set an automatic import to run for up to 5 times consecutively before resuming the queue;
- Added several links to plugin entry in WP admin Plugins page; 
- Added welcome screen that is presented after plugin is activated;
- Added a friendly notice in plugin pages if server is running PHP version < 7;
- Added new filter 'cbc_video_post_embed_below_content' that allow control of video embed position right before displaying the video in video posts;
- Added new filter 'cbc_video_post_embed_options' that allows changing of all embed options right before displaying the video embed in video posts.

1.3.1
- Solved an error when checking automatic playlist when editing and the playlist ID field was left empty;
- Added friendly plugin review reminder;
- Solved a rare error that was disrupting shortcode setup modal window if third party plugin/theme used filter "pre_get_posts";
- Added REST API support;
- Added documentation links and extra information to plugin help page.

1.3
- Renamed plugin to YouTube Hub.
- Modified plugin widgets initialization to happen only once due to bug triggered by third party plugins that were implementing do_action('widgets_init') and were causing the initialization to happen more than once;
- Implemented optional plugin widgets caching for 5 minutes in transients to speed up widgets display;
- Solved a bug that was importing videos with closed comments and ping status under certain circumstances;
- Solved a bug that was issuing errors related to YouTube video comment count;
- Implemented filter "cbc_allow_auto_import" that can disable automatic imports from running. To disable automatic imports entirely and for good: add_filter( 'cbc_allow_auto_import', '__return_false' );
- Plugin uses YouTube OAuth instead of Server Key when both present (future plugin version won't use Server Keys anymore, for now OAuth is optional);
- Solved an OAuth bug that was asking to grant permission at a given time interval instead of refreshing access automatically;
- Added option to import YouTube video tags as post tags;
- Added taxonomy "video_tag" for plugin post type "video";
- Added a new, more flexible mechanism for making WP themes compatible with the plugin. More details can be found here: https://wpythub.com/documentation/tutorials/third-party-compatibility/
- Complete rewrite of automatic import process.

1.2.5
- Added automatic import debug messages that can be used to log every import made by the plugin;
- Created a debug plugin that will register all automatic imports into a log for later reference;
- Modified default volume value from 30 to 100.

1.2.4
- Solved a widget bug that was preventing the video thumbnails from being displayed;
- Solved a rare error that was issuing notices when likes/dislikes counts were missing;
- Solved a tabs back-end error on plugin Settings page;
- Updated back-end scripts to WP 4+ jQuery version.

1.2.3
- Plugin compatible with WordPress 4.3 (scheduled for release on August 18th, 2015);
- Added channel title to video details array;
- modified API query URL forming from using PHP http_build_query() to WP add_query_arg();
- Added NewsTube theme compatibility;
- added filter 'cbc_cpt_with_front' that can be used to modify "with_front" rewrite argument for custom post type 'video';
- added filter 'cbc_taxonomy_with_front' that can be used to modify "with_front" rewrite argument for custom post type taxonomy 'videos';
- Video embedding by plugin is done exclusively using YouTube Iframe API (no more Flash embedding).
- Partial rewrite of plugin upgrade class; now compatible with WP 4.4+ [29 Jan. 2016]

1.2.2
- Implemented 3 new actions on bulk imports (both manual and automatic) and thumbnails bulk import that allow removal of third party filters that make the import process take more time.
By using this, EWW Image optimizer is prevented from optimizing images when doing bulk imports since the process takes a lot of time.
- Solved an interface bug related to the Select All checkbox when doing manual bulk imports.
- Added video publish date on manual bulk import video list
- Implemented daily YouTube quota calculator
- New option to display used YouTube API quota units into the plugin pages
- New option and functionality to run automatic imports on page load instead of making a background request (useful on some installations where background requests are not allowed)
- Option to grant access to your YouTube accunt and instantly set up and import your playlists, channels or subscriptions
- Improved plugin Settings page links and redirects to automatically open desired tab set as hash on URL
- New admin menu plugin page that allows you to query your YouTube account and displays playlists and channels for the user authenticated by OAuth
- New option that allows to unpublish automatic import playlists if YouTube returns error when query is made to API

1.2
- Automatic import playlists import/export file for easy transition between installations
- Updated to use YouTube API 3
- New option in plugin Settings page to make regular checks for imported videos on YouTube to see if the video was removed of doesn't allow embedding
- Modified manual bulk import interface for better video import management
- More consistent, user friendly automatic import process
- Allow video imports from YouTube channels