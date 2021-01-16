![banner-1544x500](https://github.com/jekkilekki/plugin-jkl-grammar/blob/master/assets/banner-1544x500.png?raw=true)

# JKL Phrases

`Version 1.2.0`

- [Plugin Page](https://github.com/jekkilekki/plugin-k2k)
- [Author Page](https://aaron.kr/)

A simple plugin that adds a "Phrases" Custom Post Type to better organize various phrases (idioms, dialect, etc) for language learning blogs and sites.

## Description

Requires WordPress 3.5 and PHP 5.5 or later.

This plugin was built for my own Korean language learning site (keytokorean.com) to
enable me to better organize the vocabulary words I'm studying. It includes the following taxonomies:

1. Phrase Type (Idiom, Proverb, etc)
2. Phrase Topic (money, food, etc)
3. Keywords

**Developed for**

- [Gaya Theme](https://wordpress.org/themes/twentysixteen/) on [KeyToKorean.com](https://keytokorean.com)

**Depends on**

- [CMB2](https://cmb2.io/) - Custom Meta Boxes 2 (and various add-ons) are used to build the Post Type Meta Boxes that gather data for each Vocabulary Word. See the [K2K plugin Readme](https://github.com/jekkilekki/plugin-k2k/blob/master/README.md) for more info.

## CMB2 `k2k_phrase_meta_metabox`

| Name:                    | ID:                           | Type:                            |
| ------------------------ | ----------------------------- | -------------------------------- |
| Literal Translation (EN) | `k2k_phrase_meta_translation` | Text                             |
| Meaning                  | `k2k_phrase_meta_meaning`     | Text                             |
| Related Hanja            | `k2k_phrase_meta_hanja`       | Text                             |
| Topic                    | `k2k_phrase_meta_topic`       | Taxonomy (`k2k-phrase-topic`)    |
| Detailed Explanation     | `k2k_phrase_meta_wysiwyg`     | WYSIWYG                          |
| Phrase Type              | `k2k_phrase_meta_type`        | Taxonomy (`k2k-phrase-type`)     |
| Keywords                 | `k2k_phrase_meta_keywords`    | Taxonomy (`k2k-phrase-keywords`) |

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
[plugin repository](https://github.com/jekkilekki/plugin-k2k/issues)
to let me know the specific features or problems you're having.

### Contact Me

If you have questions about, problems with, or suggestions for improving this
plugin, please let me know by opening a GitHub Issue on the
[plugin repository](https://github.com/jekkilekki/plugin-k2k/issues)

Want updates about my other WordPress plugins, themes, or tutorials? Follow me
[@jekkilekki](http://twitter.com/jekkilekki)

## License

JKL Phrases is free software; you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation; either version 2 of the License, or (at your option) any later version.

JKL Phrases is distributed in the hope that it will be useful, but WITHOUT ANY
WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A
PARTICULAR PURPOSE. See the GNU General Public License for more details.

You should have received a copy of the GNU General Public License along with this
program; if not, write to the Free Software Foundation, Inc., 51 Franklin St, Fifth
Floor, Boston, MA 02110-1301 USA

## Changelog

### 1.2.0 (Jan 16, 2021)

- Added [CMB2](https://cmb2.io/) (managed by the [K2K plugin](https://github.com/jekkilekki/plugin-k2k/))
- Added Phrases Custom Post Type and related taxonomies
- Updated README

### 1.1.0 (Nov 28, 2018)

- Work on updated (full) version (K2K)

### 1.0.0 (Nov 24, 2018)

- Initial release (JKL-Grammar)
