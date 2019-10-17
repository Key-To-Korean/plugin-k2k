=== K2K ===
Contributors:           jekkilekki
Plugin Name:            K2K
Plugin URI:             https://github.com/jekkilekki/plugin-k2k
Author:                 Aaron Snowberger
Author URI:             https://www.aaron.kr/
Donate link:            https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=567MWDR76KHLU
Tags:                   custom post types, custom taxonomies, page templates, cmb2
Requires at least:      3.5
Tested up to:           5.0
Stable tag:             1.1.0
Version:                1.1.0
License:                GPLv2 or later
License URI:            http://www.gnu.org/licenses/gpl-2.0.html

A simple plugin that adds a "Grammar" Custom Post Type to better organize grammar points 
for language learning blogs and sites.

== Description ==

Requires WordPress 3.5 and PHP 5.5 or later.

This plugin was built for my own Korean language learning site (keytokorean.com) to
enable me to better organize the grammar points I'm studying. It includes the following
taxonomies:

1. Level (Beginner, etc)
2. Book (Seoul University, Korean Grammar in Use, etc)
3. Part of Speech (Verb, Noun, etc)
4. Expression (frustation, excitement, etc)
5. Usage (formal, written, spoken, etc)

= Tested With =

* TwentySixteen Theme
* TwentySeventeen Theme 

= Supported Plugins = 

* WP Subtitle - changes metabox title from "Subtitle" to "Translation"

= Planned Upcoming Features = 

I'm looking into adding "subtitle" support that would let me put the Title in Korean 
and the subtitle in English. But we'll use this for a while and see how I'm actually 
putting it to use and what kinds of things I feel are still needed before laying out 
a roadmap for future development.

= Translations = 

* English (EN) - default
* Korean (KO) - upcoming

If you want to help translate the plugin into your language, please have a look 
at the `.pot` file which contains all definitions and may be used with a [gettext] 
editor.

If you have created your own language pack, or have an update of an existing one, 
you can send your [gettext .po or .mo file] to me so that I can bundle it in the
plugin.

= Contact Me = 

If you have questions about, problems with, or suggestions for improving this 
plugin, please let me know at the [GitHub repository](https://github.com/jekkilekki/k2k/issues)

Want updates about my other WordPress plugins, themes, or tutorials? Follow me 
[@jekkilekki](http://twitter.com/jekkilekki)

== Installation ==

= Automatic installation =
1. Log into your WordPress admin
2. Go to `Plugins -> Add New`
3. Search for `K2K`
4. Click `Install Now`
5. Activate the Plugin

= Manual installation =
1. Download the Plugin
2. Extract the contents of the .ZIP file
3. Upload the contents of the `k2k` directory to your `/wp-content/plugins` 
folder of your WordPress installation
4. Activate the Plugin from the `Plugins` page

= Documentation = 
Full documentation of the Plugin and its uses can (currently) be found at its 
[GitHub page](https://github.com/jekkilekki/plugin-k2k) 

== Frequently Asked Questions ==

= Tips =
As a general rule, it is always best to keep your WordPress installation and all 
Themes and Plugins fully updated in order to avoid problems with this or any other 
Themees or Plugins. I regularly update my site and test my Plugins and Themes with
the latest version of WordPress.

= When I select something from the dropdown menus on the archive page, I get a 404 error. =
Please navigate to your WordPress Dashboard, go to `Settings -> Permalinks` and click the "Save"
button. You just need to "flush" the permalink rewrite rules in this way.

= Can you ADD / REMOVE / CHANGE features of the plugin? =
Sure, I'm always open to suggestions. Let me know what you're looking for. Feel
free to open a GitHub Issue on the [plugin repository](https://github.com/jekkilekki/plugin-k2k/issues)
to let me know the specific features or problems you're having.

== Screenshots ==

1. Gutenberg editor screen
2. Classic editor screen
3. Archive Page

== Other Notes ==

= Support = 
[Click here to visit the Issues for this plugin](https://github.com/jekkilekki/k2k/issues)

= Acknowledgements = 

= License = 
K2K is free software; you can redistribute it and/or modify it under the terms 
of the GNU General Public License as published by the Free Software Foundation; either 
version 2 of the License, or (at your option) any later version.

K2K is distributed in the hope that it will be useful, but WITHOUT ANY 
WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A 
PARTICULAR PURPOSE. See the GNU General Public License for more details.

You should have received a copy of the GNU General Public License along with this 
program; if not, write to the Free Software Foundation, Inc., 51 Franklin St, Fifth 
Floor, Boston, MA 02110-1301 USA

== Changelog ==

= 1.1.0 (Nov 28, 2018) =
* Added custom single template
* Added custom archive template
* On archive template, added select dropdowns to view Grammar Posts contained in any taxonomy

= 1.0.0 (Nov 24, 2018) =
* Initial release