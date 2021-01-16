![banner-1544x500](https://github.com/jekkilekki/plugin-jkl-grammar/blob/master/assets/banner-1544x500.png?raw=true)

# JKL Grammar

`Version 1.2.0`

- [Full Plugin Page](https://github.com/jekkilekki/plugin-k2k)
- [Original Plugin Page](https://github.com/jekkilekki/plugin-jkl-grammar)
- [Author Page](https://aaron.kr/)

A simple plugin that adds a "Grammar" Custom Post Type to better organize grammar points for language learning blogs and sites.

## Description

Requires WordPress 3.5 and PHP 5.5 or later.

This plugin was built for my own Korean language learning site (keytokorean.com) to
enable me to better organize the grammar points I'm studying. It includes the following taxonomies:

1. Level (Beginner, etc)
2. Book (Seoul University, Korean Grammar in Use, etc)
3. Part of Speech (Verb, Noun, etc)
4. Tenses (Past, Present, Future, etc)
5. Expression (frustation, excitement, etc)
6. Usage (formal, written, spoken, etc)

**Developed for**

- [Gaya Theme](https://wordpress.org/themes/twentysixteen/) on [KeyToKorean.com](https://keytokorean.com)

**Depends on**

- [CMB2](https://cmb2.io/) - Custom Meta Boxes 2 (and various add-ons) are used to build the Post Type Meta Boxes that gather data for each Grammar Point. See the [K2K plugin Readme](https://github.com/jekkilekki/plugin-k2k/blob/master/README.md) for more info.

## CMB2 `k2k_grammar_meta_metabox`

The Grammar CPT includes a custom meta box (CMB2) that includes the following fields:

**Info Tab**

| Name: Info Tab       | ID: `tab_info`                | Type: Tab                           |
| -------------------- | ----------------------------- | ----------------------------------- |
| Translation (EN)     | `k2k_grammar_meta_subtitle`   | Text                                |
| Level                | `k2k_grammar_meta_level`      | Taxonomy (`k2k-grammar-level`)      |
| Detailed Explanation | `k2k_grammar_meta_wysiwyg`    | Wysiwyg                             |
| Usage                | `k2k_grammar_meta_usage`      | Group                               |
| - Usage Type         | `k2k_grammar_meta_usage_tax`  | Taxonomy (`k2k-grammar-usage`)      |
| - Must Use           | `k2k_grammar_meta_usage_mu`   | Text                                |
| - Prohibited         | `k2k_grammar_meta_usage_no`   | Text                                |
| Expression           | `k2k_grammar_meta_expression` | Taxonomy (`k2k-grammar-expression`) |
| Book                 | `k2k_grammar_meta_book`       | Taxonomy (`k2k-grammar-book`)       |

**Conjugations Tab**

| Name: Conjugations Tab | ID: `tab_conjugations`                   | Type: Tab                               |
| ---------------------- | ---------------------------------------- | --------------------------------------- |
| Part of Speech         | `k2k_grammar_meta_part_of_speech`        | Taxonomy (`k2k-grammar-part-of-speech`) |
| Tenses                 | `k2k_grammar_meta_tenses`                | Taxonomy (`k2k-grammar-tenses`)         |
| Adjective Conjugation  | `k2k_grammar_meta_adjectives`            | Group                                   |
| - Past                 | `k2k_grammar_meta_adjective_past`        | Text                                    |
| - Present              | `k2k_grammar_meta_adjective_present`     | Text                                    |
| - Future               | `k2k_grammar_meta_adjective_future`      | Text                                    |
| - Supposition          | `k2k_grammar_meta_adjective_supposition` | Text                                    |
| Verb Conjugation       | `k2k_grammar_meta_verbs`                 | Group                                   |
| - Past                 | `k2k_grammar_meta_verb_past`             | Text                                    |
| - Present              | `k2k_grammar_meta_verb_present`          | Text                                    |
| - Future               | `k2k_grammar_meta_verb_future`           | Text                                    |
| - Supposition          | `k2k_grammar_meta_verb_supposition`      | Text                                    |
| Noun Conjugation       | `k2k_grammar_meta_nouns`                 | Group                                   |
| - Past                 | `k2k_grammar_meta_noun_past`             | Text                                    |
| - Present              | `k2k_grammar_meta_noun_present`          | Text                                    |
| - Future               | `k2k_grammar_meta_noun_future`           | Text                                    |
| - Supposition          | `k2k_grammar_meta_noun_supposition`      | Text                                    |

**Sentences Tab**

| Name: Sentences Tab    | ID: `tab_sentences`                  | Type: Tab          |
| ---------------------- | ------------------------------------ | ------------------ |
| Past Tense Sentence    | `k2k_grammar_meta_sentences_past`    | Group (repeatable) |
| - Original (KO)        | `k2k_grammar_meta_sentence_1`        | Text               |
| - Translation (EN)     | `k2k_grammar_meta_sentence_2`        | Text               |
| Present Tense Sentence | `k2k_grammar_meta_sentences_present` | Group (repeatable) |
| - Original (KO)        | `k2k_grammar_meta_sentence_1`        | Text               |
| - Translation (EN)     | `k2k_grammar_meta_sentence_2`        | Text               |
| Future Tense Sentence  | `k2k_grammar_meta_sentences_future`  | Group (repeatable) |
| - Original (KO)        | `k2k_grammar_meta_sentence_1`        | Text               |
| - Translation (EN)     | `k2k_grammar_meta_sentence_2`        | Text               |

**More Tab**

| Name: More Tab           | ID: `tab_more`                            | Type: Tab         |
| ------------------------ | ----------------------------------------- | ----------------- |
| Practice Exercise        | `k2k_grammar_meta_exercises`              | Text (repeatable) |
| Related Grammar          | `k2k_grammar_meta_related_grammar`        | Group             |
| - Needs Link             | `k2k_grammar_meta_related_needs_link`     | Checkbox          |
| - Related Grammar Points | `k2k_grammar_meta_related_grammar_points` | Attached Posts    |

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

JKL Grammar is free software; you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation; either version 2 of the License, or (at your option) any later version.

JKL Grammar is distributed in the hope that it will be useful, but WITHOUT ANY
WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A
PARTICULAR PURPOSE. See the GNU General Public License for more details.

You should have received a copy of the GNU General Public License along with this
program; if not, write to the Free Software Foundation, Inc., 51 Franklin St, Fifth
Floor, Boston, MA 02110-1301 USA

## Changelog

### 1.2.0 (Jan 16, 2021)

- Added Tenses taxonomy
- Added [CMB2](https://cmb2.io/) (managed by the [K2K plugin](https://github.com/jekkilekki/plugin-k2k/))
- Updated README

### 1.1.0 (Nov 28, 2018)

- Added custom single template
- Added custom archive template
- On archive template, added select dropdowns to view Grammar Posts contained in any taxonomy

### 1.0.0 (Nov 24, 2018)

- Initial release
