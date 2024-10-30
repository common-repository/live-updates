=== LiveUpdates ===
Contributors: fov
Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=10766432
Tags: live, ajax, text, widget
Requires at least: 2.5
Tested up to: 2.9
Stable tag: 1.0.1

Live Updating text widget.

== Description ==

Creates a section in the sidebar which displays a live message which can be updated from the admin area.
http://fov.cc/wordpress-plugins/live-updates/

== Installation ==

###Updgrading From A Previous Version###

To upgrade from a previous version of this plugin, delete the entire folder and files from the previous version of the plugin and then follow the installation instructions below.

###Installing The Plugin###

Extract all files from the ZIP file, making sure to keep the file structure intact, and then upload it to `/wp-content/plugins/`.

This should result in the following file structure:

`- wp-content
    - plugins
        - live-updates
            | readme.txt
            | liveupdates.php
            | jquery.js
            | updater.js
            | messages.php`
          
Edit the $config_loc at the top of messages.php.

Then just visit your admin area, activate the plugin and put your new widget anywhere you wish.
You can add a title to go above your updates in the widget config section.

To update your text visit the live updates page under the 'Posts' heading.


== Frequently Asked Questions ==

= I love your plugin! Can I donate to you? =

Sure! Donations keep me interested and help me to update my work.
https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=10766432


== ChangeLog ==

**Version 1.0.1**

* Gets round WP hosting the plugin making the folder live-updates instead of liveupdates.

**Version 1.0.0**

* Initial release.