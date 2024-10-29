=== Auto SEO Links ===
Contributors: arvidschmeling, antonioleutsch
Donate link: 
Tags: seo, search engine optimization, suchmaschinenoptimierung
Requires PHP: 5.5
Requires at least: 4.6
Tested up to: 4.9.1
Stable tag: 1.0.2
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Filters WordPress content for keywords and replaces them with SEO links.

== Description ==

No inconvenient and manual link setting on every single page or post anymore. Auto SEO Links automates this process for you. Simply create your keywords in the administration area and determine their behaviour. Everything else will be handled by Auto SEO Links.


=== Replace your keywords with SEO links automatically ===

Auto SEO Links uses a filter system which applies itself to every post and page. The content will be checked for every keyword you have created in the administration area. Every match gets replaced with the corresponding SEO link. That way you don't need to manually set up your links for every single post or page anymore!


=== Individual configuration ===

You decide how your SEO links behave. With an easy-to-handle user interface you can immediatetly set up your configuration for every link while creating them:

* Define whether your SEO link is an internal link (with a target inside your own WordPress website) or an external link.
* If you choose the internal link target you'll get a drop-down list with all your published posts and pages. (even from custom post types as long as they're public).
* If you choose the external link target you can type any URL into a text-field.


=== Easily find and edit your SEO link entries, even in huge listings ===

While actively working on your link-building, your list of keywords and SEO links will grow pretty fast. With creating more and more SEO link entries, it can become difficult to find a specific one inside your list. Our integrated search will be helpful here. Type in your keyword, hit "Search" and you'll only see the entries that match your search term. If you're uncertain about the keyword, the integrated auto-complete-function will come in handy. It suggests matching keywords while you type in your search term.


=== The fruit of your labor at a glance ===

To provide an overview of how the keyword affects your link-building, we've added a column which calculates how often the keyword will be turned into an SEO link on your whole WordPress website. This way you can determine very easily on how many posts and pages your keyword is present.


=== SEO-friendly behaviour ===

Auto SEO Links aren't just a simple filter that crawls through posts and pages and replaces content in a mindless manner. To improve your search-engine ranking, Auto SEO Links follows some simple rules:

* No multiple replacements: Every keyword will be turned into an SEO link only once per post/page.
* No links to the current URL: In case an SEO link would lead to the same page you're currently located at, no link will be generated.


=== Options individualise the behaviour of your SEO links ===

Usually one wants to spread the SEO links as spacious as possible on their own website. There are some exceptions where SEO links might not be welcome, though. This could, for example, be the case concerning sub-pages with legal information (imprint, privacy policy etc.).

Taking this circumstance into consideration, we thought about a settings-page where you can set up this option - and some more:

* Choose from a list of all available posts and pages where Auto SEO Links shouldn't be applied.
* Set a limit of how many SEO links should be generated on every post/page.
* Set a limit of how many SEO links should be generated on every post/page which have the same internal target.
* We don't think this is likely to happen, but if you decide to not use Auto SEO Links anymore, you can choose whether you want to delete the corresponding plugin-data in your database as soon as the plugin gets deleted in the administration area (or when it gets deactivated in case it's a multisite network page).
  * Checkbox to purge SEO link entries with an internal target.
  * Checkbox to purge SEO link entries with an external target.
  * Checkbox to purge plugin settings.


== Installation ==

=== Installation in the WordPress administration area ===

* Navigate to "Plugins" > "Add New" in the WordPress administration area.
* Search for "Auto SEO Links".
* Install and activate the plugin.


=== Installation via FTP ===

* Download Auto SEO Links at [WordPress](https://wordpress.org/plugins/auto-seo-links/ "Auto SEO Links at WordPress").
* Unzip the archive.
* Upload the unzipped folder via FTP to wp-content/plugins/ .
* Auto SEO Links should now appear in the WordPress administration area under "Plugins" > "Installed Plugins" and just requires activation.


== Screenshots ==

1. SEO links management.
2. Settings-page for additional options.
3. The result.


== Frequently Asked Questions ==

= Do I have to pay for the plugin? =

No, Auto SEO Links is absolutely free.

= Does Auto SEO Links change the contents of my posts and pages? =

No, Auto SEO Link doesn't change content inside the database. The content gets filtered before rendering it on the frontend. Keyword matches will be replaced by SEO links and the modified content will be sent to the frontend, but these modifications won't be saved in the database.

= Will there be new features for Auto SEO Links? =

Definitely! We have some cool ideas for new features. Further version updates can be expected.
