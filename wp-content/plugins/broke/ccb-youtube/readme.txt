Installation
-------------------------

The only archive needed to be uploaded in WordPress using WordPress's Upload option is ccb-youtube.zip. It contains the files needed for installation.

After plugin installation
--------------------------

A new menu is created in your WordPress administration called Videos. 
Visit Settings page under Videos and set up your preferences for importing videos and default player aspect.

Please note that player aspect options can be overriden from Video editing. Also note that embeded playlists will have most of the player options you enter in your Videos->Settings page ( except size and volume ).


How to import videos
-------------------------

There are 3 ways of importing videos into your WordPress blog using this plugin:

1. Individual videos

	By clicking Add new under Videos menu you can create a single new video. Just input the video ID you can find when opening any video in YouTube and the the plugin will load its decription and title automatically so you can edit them.

2. Manual bulk-import videos

	Bulk import can import videos from YouTube playlists, user playlists or search queries. Please note that YouTube feeds are cached, freshly uploaded videos will take a while before YouTube makes them available in feed queries.

	Also, before doing any bulk imports visit Settings page under Videos menu to set up your importing preferences. They will allow you to only import some details if needed and also to import (or not) the video categories from YouTube.

3. Automatic bulk-import

	Same as manual bulk import only that will import a given number of videos every given period of time. Imports can be made from user or YouTube playlists and can be imported as custom posts or as specially formatted posts compabitle with WordPress themes DeTube and Avada. 


Themes compatibility
------------------------

The plugin is compatible with several WordPress themes by default. When the plugin detects a compatible theme, when doing individual imports, manual bulk imports or automatic imports, a new checkbox will be displayed asking if you want to import as theme post. After checking it, the plugin will create posts that are compatible with your theme.

Plugins compatibility
------------------------

The plugin is compatible by default with Yoast Video SEO. Other plugins can be made compatible by using the actions/filters implemented into the plugin.