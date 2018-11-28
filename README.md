![banner-1544x500](https://github.com/jekkilekki/plugin-jkl-grammar/blob/master/assets/banner-1544x500.png?raw=true)

# JKL Grammar

`Version 1.1.0`

* [Plugin Page](https://github.com/jekkilekki/plugin-jkl-grammar)
* [Author Page](https://aaron.kr/)

A simple plugin that adds a "Grammar" Custom Post Type to better organize grammar points for language learning blogs and sites.

## Description

Requires WordPress 3.5 and PHP 5.5 or later.

This plugin was built for my own Korean language learning site (keytokorean.com) to
enable me to better organize the grammar points I'm studying. It includes the following taxonomies:

1. Level (Beginner, etc)
2. Book (Seoul University, Korean Grammar in Use, etc)
3. Part of Speech (Verb, Noun, etc)
4. Expression (frustation, excitement, etc)
5. Usage (formal, written, spoken, etc)

__Tested with__

* [TwentySixteen Theme](https://wordpress.org/themes/twentysixteen/) 
* [TwentySeventeen Theme](https://wordpress.org/themes/twentyseventeen/)

__Supported plugins__

* [WP Subtitle](https://wordpress.org/plugins/wp-subtitle/) - Changes metabox name from "Subtitle" to "Translation"

### Screenshots

1. Gutenberg editor screen

![screenshot-1](https://github.com/jekkilekki/plugin-jkl-grammar/blob/master/assets/screenshot-1.png?raw=true)

2. Classic editor screen

![screenshot-2](https://github.com/jekkilekki/plugin-jkl-grammar/blob/master/assets/screenshot-2.png?raw=true)

3. Archive Page

![screenshot-3](https://github.com/jekkilekki/plugin-jkl-grammar/blob/master/assets/screenshot-3.png?raw=true)

### Planned Upcoming Features 

I'm looking into adding "subtitle" support that would let me put the Title in Korean and the subtitle in English. But we'll use this for a while and see how I'm actually putting it to use and what kinds of things I feel are still needed before laying out a roadmap for future development.

1. ReactJS Archive (index) page (filterable)
2. Gutenberg block for (something?) sentences, or usage, or notes, or something?

### Translations

* English (EN) - default
* Korean (KO) - upcoming

If you want to help translate the plugin into your language, please have a look 
at the `.pot` file which contains all definitions and may be used with a [gettext] 
editor.

If you have created your own language pack, or have an update of an existing one, 
you can send your [gettext .po or .mo file] to me so that I can bundle it in the
plugin.

### FAQs

#### Tips

As a general rule, it is always best to keep your WordPress installation and all 
Themes and Plugins fully updated in order to avoid problems with this or any other 
Themees or Plugins. I regularly update my site and test my Plugins and Themes with
the latest version of WordPress.

#### When I select something from the dropdown menus on the archive page, I get a 404 error.

Please navigate to your WordPress Dashboard, go to `Settings -> Permalinks` and click the "Save"
button. You just need to "flush" the permalink rewrite rules in this way.

#### Can you ADD / REMOVE / CHANGE features of the plugin?

Sure, I'm always open to suggestions. Let me know what you're looking for. Feel
free to open a GitHub Issue on the [plugin repository](https://github.com/jekkilekki/plugin-jkl-grammar/issues)
to let me know the specific features or problems you're having.

### Contact Me 

If you have questions about, problems with, or suggestions for improving this 
plugin, please let me know at the [WordPress.org support forums](http://wordpress.org/support/plugin/jkl-grammar)

Want updates about my other WordPress plugins, themes, or tutorials? Follow me 
[@jekkilekki](http://twitter.com/jekkilekki)

## License

JKL Grammar is free software; you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation; either version 2 of the License, or (at your option) any later version.

JKL Grammar is distributed in the hope that it will be useful, but WITHOUT ANY 
WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A 
PARTICULAR PURPOSE. See the GNU General Public License for more details.

You should have received a copy of the GNU General Public License along with this 
program; if not, write to the Free Software Foundation, Inc., 51 Franklin St, Fifth 
Floor, Boston, MA 02110-1301 USA

## Changelog

### 1.1.0 (Nov 28, 2018)
* Added custom single template
* Added custom archive template
* On archive template, added select dropdowns to view Grammar Posts contained in any taxonomy

### 1.0.0 (Nov 24, 2018)
* Initial release
