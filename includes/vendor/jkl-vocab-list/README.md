![banner-1544x500](https://github.com/Key-To-Korean/plugin-jkl-grammar/blob/main/assets/banner-1544x500.png?raw=true)

# JKL Vocab List

`Version 1.3.0`

- [Plugin Page](https://github.com/Key-To-Korean/plugin-k2k)
- [Author Page](https://aaron.kr/)

A simple plugin that adds a "Vocab Lists" Custom Post Type to better organize vocabulary lists for language learning blogs and sites.

## Description

Requires WordPress 3.5 and PHP 5.5 or later.

This plugin was built for my own Korean language learning site (keytokorean.com) to
enable me to better organize the vocabulary words I'm studying. It includes the following taxonomies:

1. Level (Beginner, etc)
2. Book (Vocab, grammar, or other books)

**Developed for**

- [Gaya Theme](https://github.com/Key-To-Korean/theme-gaya/) on [KeyToKorean.com](https://keytokorean.com)

**Depends on**

- [CMB2](https://cmb2.io/) - Custom Meta Boxes 2 (and various add-ons) are used to build the Post Type Meta Boxes that gather data for each Vocab List. See the [K2K plugin Readme](https://github.com/Key-To-Korean/plugin-k2k/blob/main/README.md) for more info.

## CMB2 `k2k_vocab_list_meta_metabox`

**Info Tab**

| Name: Info Tab   | ID: `tab_info`                 | Type: Tab                         |
| ---------------- | ------------------------------ | --------------------------------- |
| Translation (EN) | `k2k_vocab_list_meta_subtitle` | Text                              |
| File             | `k2k_vocab_list_meta_file`     | File Upload or URL (PDFs only)    |
| WYSIWYG          | `k2k_vocab_list_meta_wysiwyg`  | WYSIWYG                           |
| Level            | `k2k_vocab_list_meta_level`    | Taxonomy (`k2k-vocab-list-level`) |
| Book             | `k2k_vocab_list_meta_book`     | Taxonomy (`k2k-vocab-list-book`)  |

**Related Tab**

| Name: Related Tab | ID: `tab_related`                      | Type: Tab                    |
| ----------------- | -------------------------------------- | ---------------------------- |
| Related Lists     | `k2k_vocab_list_meta_related_group`    | Group                        |
| - Unlinked        | `k2k_vocab_list_meta_related_unlinked` | Text                         |
| - Linked          | `k2k_vocab_list_meta_related_linked`   | Attached Posts               |

### Screenshots

(Coming soon)

### Planned Upcoming Features

1. ReactJS Archive (index) page (filterable)

### Translations

- English (EN) - default
- Korean (KO) - upcoming

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
free to open a GitHub Issue on the
[plugin repository](https://github.com/Key-To-Korean/plugin-k2k/issues)
to let me know the specific features or problems you're having.

### Contact Me

If you have questions about, problems with, or suggestions for improving this
plugin, please let me know by opening a GitHub Issue on the
[plugin repository](https://github.com/Key-To-Korean/plugin-k2k/issues)

Want updates about my other WordPress plugins, themes, or tutorials? Follow me
[@aaron.kr](https://aaron.kr)

## License

JKL Vocab List is free software; you can redistribute it and/or modify it under the 
terms of the GNU General Public License as published by the Free Software Foundation; 
either version 2 of the License, or (at your option) any later version.

JKL Vocab List is distributed in the hope that it will be useful, but WITHOUT ANY
WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A
PARTICULAR PURPOSE. See the GNU General Public License for more details.

You should have received a copy of the GNU General Public License along with this
program; if not, write to the Free Software Foundation, Inc., 51 Franklin St, Fifth
Floor, Boston, MA 02110-1301 USA

## Changelog

### 2.0.0 (May 1, 2023)

- Added JKL Vocab List Custom Post Type 

### 1.2.0 (Jan 16, 2021)

- Added [CMB2](https://cmb2.io/) (managed by the [K2K plugin](https://github.com/jekkilekki/plugin-k2k/))
- Reorganized plugin structure to use individual (separate) taxonomies for Level, etc, rather than shared taxonomies
- Updated README

### 1.1.0 (Nov 28, 2018)

- Added custom single template
- Added custom archive template
- On archive template, added select dropdowns to view Grammar Posts contained in any taxonomy

### 1.0.0 (Nov 24, 2018)

- Initial release
