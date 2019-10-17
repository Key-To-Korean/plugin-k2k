![banner-1544x500](https://github.com/jekkilekki/plugin-k2k/blob/master/assets/banner-1544x500.png?raw=true)

# K2K

`Version 1.1.0`

- [Plugin Page](https://github.com/jekkilekki/plugin-k2k)
- [Author Page](https://aaron.kr/)

A complete Language Learning plugin that adds multiple new Custom Post Types, Taxonomies, and Page Templates for language learning blogs and sites.

## Description

Requires WordPress 3.5 and PHP 5.5 or later.

This plugin was built for my own Korean language learning site (keytokorean.com) to
enable me to better organize the grammar points I'm studying. It includes the following helper plugins:

1. CMB2 (Custom Metaboxes 2)
	- CMB2 Tabs
	- CMB2 Switch Button
	- CMB2 Attached Posts
	- [CMB2 Grid]
	- [CMB2 Field Slider]
2. JKL
	- [JKL Vocabulary](#jkl-vocabulary)
	- [JKL Grammar](#jkl-grammar)
	- [JKL Phrases](#jkl-phrases)
	- [JKL Writing](#jkl-writing)
	- [JKL Reading](#jkl-reading)

## JKL Plugins

### JKL Vocabulary

This plugin adds a Vocabulary Custom Post Type and the following taxonomies are associated with it:

- Levels
- Parts of Speech
- Topics
- Vocabulary Group

The Vocabulary CPT includes a custom meta box (CMB2) that includes the following fields:

CMB2 `k2k_vocab_meta_metabox`

Info Tab

| Name: Info Tab | ID: `tab_info` | Type: Tab |
| --- | --- | --- |
| Translation (EN) | `k2k_vocab_meta_subtitle` | Text |
| Level |`k2k_vocab_meta_level` | Taxonomy |
| Part of Speech | `k2k_vocab_meta_part_of_speech` | Taxonomy |
| Definitions [array] | `k2k_vocab_meta_definitions` | Text (repeatable) |
| Sentences [array] | `k2k_vocab_meta_sentences` | Group (repeatable) |
| - Original (KO) | `k2k_vocab_meta_sentences_1` | Text |
| - Translation (EN) | `k2k_vocab_meta_sentences_2` | Text |
| Vocab Group | `k2k_vocab_meta_vocab_group` | Taxonomy |

Related Tab

| Name: Related Tab | ID: `tab_related` | Type: Tab |
| --- | --- | --- |
| Topic | `k2k_vocab_meta_topic` | Taxonomy |
| Related Words | `k2k_vocab_meta_related_group` | Group |
| - Unlinked | `k2k_vocab_meta_related_unlinked` | Text |
| - Linked | `k2k_vocab_meta_related_linked` | Attached Posts |
| Synonyms | `k2k_vocab_meta_synonym_group` | Group |
| - Unlinked | `k2k_vocab_meta_synonyms_unlinked` | Text |
| - Linked | `k2k_vocab_meta_synonyms_linked` | Attached Posts |
| Antonyms | `k2k_vocab_meta_antonym_group` | Group |
| - Unlinked | `k2k_vocab_meta_antonyms_unlinked` | Text |
| - Linked | `k2k_vocab_meta_antonyms_linked` | Attached Posts |
| Hanja | `k2k_vocab_meta_hanja_group` | Group |
| - Unlinked | `k2k_vocab_meta_hanja_unlinked` | Text |
| - Linked | `k2k_vocab_meta_hanja_linked` | Attached Posts |

### JKL Grammar

This plugin adds a Grammar Custom Post Type and the following taxonomies are associated with it:

- Levels
- Parts of Speech
- Expressions
- Books
- Tenses
- Usage
- Phrase Type

The Grammar CPT includes a custom meta box (CMB2) that includes the following fields:

CMB2 `k2k_grammar_meta_metabox`

Info Tab

| Name: Info Tab | ID: `tab_info` | Type: Tab |
| --- | --- | --- |
| Translation (EN) | `k2k_grammar_meta_subtitle` | Text |
| Level | `k2k_grammar_meta_level` | Taxonomy |
| Detailed Explanation | `k2k_grammar_meta_wysiwyg` | Wysiwyg |
| Usage | `k2k_grammar_meta_usage` | Group |
| - Usage Type | `k2k_grammar_meta_usage_tax` | Taxonomy |
| - Must Use | `k2k_grammar_meta_usage_mu` | Text |
| - Prohibited | `k2k_grammar_meta_usage_no` | Text |
| Expression | `k2k_grammar_meta_expression` | Taxonomy |
| Book | `k2k_grammar_meta_book` | Taxonomy |

Conjugations Tab

| Name: Conjugations Tab | ID: `tab_conjugations` | Type: Tab |
| --- | --- | --- |
| Part of Speech | `k2k_grammar_meta_part_of_speech` | Taxonomy |
| Tenses | `k2k_grammar_meta_tenses` | Taxonomy |
| Adjective Conjugation | `k2k_grammar_meta_adjectives` | Group |
| - Past | `k2k_grammar_meta_adjective_past` | Text |
| - Present | `k2k_grammar_meta_adjective_present` | Text |
| - Future | `k2k_grammar_meta_adjective_future` | Text |
| - Supposition | `k2k_grammar_meta_adjective_supposition` | Text |
| Verb Conjugation | `k2k_grammar_meta_verbs` | Group |
| - Past | `k2k_grammar_meta_verb_past` | Text |
| - Present | `k2k_grammar_meta_verb_present` | Text |
| - Future | `k2k_grammar_meta_verb_future` | Text |
| - Supposition | `k2k_grammar_meta_verb_supposition` | Text |
| Noun Conjugation | `k2k_grammar_meta_nouns` | Group |
| - Past | `k2k_grammar_meta_noun_past` | Text |
| - Present | `k2k_grammar_meta_noun_present` | Text |
| - Future | `k2k_grammar_meta_noun_future` | Text |
| - Supposition | `k2k_grammar_meta_noun_supposition` | Text |

Sentences Tab

| Name: Sentences Tab | ID: `tab_sentences` | Type: Tab |
| --- | --- | --- |
| Past Tense Sentence | `k2k_grammar_meta_sentences_past` | Group (repeatable) |
| - Original (KO) | `k2k_grammar_meta_sentence_1` | Text |
| - Translation (EN) | `k2k_grammar_meta_sentence_2` | Text |
| Present Tense Sentence | `k2k_grammar_meta_sentences_present` | Group (repeatable) |
| - Original (KO) | `k2k_grammar_meta_sentence_1` | Text |
| - Translation (EN) | `k2k_grammar_meta_sentence_2` | Text |
| Future Tense Sentence | `k2k_grammar_meta_sentences_future` | Group (repeatable) |
| - Original (KO) | `k2k_grammar_meta_sentence_1` | Text |
| - Translation (EN) | `k2k_grammar_meta_sentence_2` | Text |

More Tab

| Name: More Tab | ID: `tab_more` | Type: Tab |
| --- | --- | --- |
| Practice Exercise | `k2k_grammar_meta_exercises` | Text (repeatable) |
| Related Grammar | `k2k_grammar_meta_related_grammar` | Group |
| - Needs Link | `k2k_grammar_meta_related_needs_link` | Checkbox |
| - Related Grammar Points | `k2k_grammar_meta_related_grammar_points` | Attached Posts |

### JKL Phrases

[Upcoming]

### JKL Writing

[Upcoming]

### JKL Reading

[Upcoming]

## Taxonomies

1. Level (Beginner, etc)
2. Book (Seoul University, Korean Grammar in Use, etc)
3. Part of Speech (Verb, Noun, etc)
4. Expression (frustation, excitement, etc)
5. Usage (formal, written, spoken, etc)
6. Tenses (past, present, future, supposition, etc)
7. Phrase Type (prepositive, interrogative, idiom, slang, etc)
8. Topics (Animals, Food, etc)
9. Vocab Group (Intermediate Day 1, etc)

**Tested with**

- [TwentySixteen Theme](https://wordpress.org/themes/twentysixteen/)
- [TwentySeventeen Theme](https://wordpress.org/themes/twentyseventeen/)

**Supported plugins**

- [WP Subtitle](https://wordpress.org/plugins/wp-subtitle/) - Changes metabox name from "Subtitle" to "Translation"

### Screenshots

1. Gutenberg editor screen

![screenshot-1](https://github.com/jekkilekki/plugin-k2k/blob/master/assets/screenshot-1.png?raw=true)

2. Classic editor screen

![screenshot-2](https://github.com/jekkilekki/plugin-k2k/blob/master/assets/screenshot-2.png?raw=true)

3. Archive Page

![screenshot-3](https://github.com/jekkilekki/plugin-k2k/blob/master/assets/screenshot-3.png?raw=true)

### Planned Upcoming Features

I'm looking into adding "subtitle" support that would let me put the Title in Korean and the subtitle in English. But we'll use this for a while and see how I'm actually putting it to use and what kinds of things I feel are still needed before laying out a roadmap for future development.

1. ReactJS Archive (index) page (filterable)
2. Gutenberg block for (something?) sentences, or usage, or notes, or something?

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
free to open a GitHub Issue on the [plugin repository](https://github.com/jekkilekki/plugin-k2k/issues)
to let me know the specific features or problems you're having.

### Contact Me

If you have questions about, problems with, or suggestions for improving this
plugin, please let me know at the [WordPress.org support forums](http://wordpress.org/support/plugin/k2k)

Want updates about my other WordPress plugins, themes, or tutorials? Follow me
[@jekkilekki](http://twitter.com/jekkilekki)

## License

K2K is free software; you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation; either version 2 of the License, or (at your option) any later version.

K2K is distributed in the hope that it will be useful, but WITHOUT ANY
WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A
PARTICULAR PURPOSE. See the GNU General Public License for more details.

You should have received a copy of the GNU General Public License along with this
program; if not, write to the Free Software Foundation, Inc., 51 Franklin St, Fifth
Floor, Boston, MA 02110-1301 USA

## Changelog

### 1.1.0 (Nov 28, 2018)

- Added custom single template
- Added custom archive template
- On archive template, added select dropdowns to view Grammar Posts contained in any taxonomy

### 1.0.0 (Nov 24, 2018)

- Initial release
