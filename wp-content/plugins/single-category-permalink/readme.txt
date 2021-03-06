=== Single Category Permalink ===
Contributors: coffee2code
Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=6ARCFJ9TX3522
Tags: permalink, structure, link, category, coffee2code
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
Requires at least: 1.5
Tested up to: 4.1
Stable tag: 2.1.1

Reduce permalinks (category or post) that include entire hierarchy of categories to just having the lowest level category.


== Description ==

Reduce permalinks (category or post) that include entire hierarchy of categories to just having the lowest category in the hierarchy.

By default, WordPress replaces the %category% permalink tag in a custom permalink structure with the entire hierarchy of categories for the post's first matching category. For example, assuming your site has a hierarchical category structure like so:

`
Applications
  |_ Desktop
  |_ Web
    |_ WordPress
`

By default, if you have a permalink structure defined as `%category%/%year%/%monthnum%/%day%/%postname%`, your post titled "Best Plugins" assigned to the "WordPress" category would have a permalink of:

`http://www.example.com/applications/web/wordpress/2008/01/15/best-plugins`

If you activate the Single Category Permalink plugin, this would be the permalink generated for the post (and recognized by the blog):

`http://www.example.com/wordpress/2008/01/15/best-plugins`

In order for a category to be used as part of a post's permalink structure, %category% must be explicitly defined in the Settings -> Permalinks admin page as part of a custom structure, i.e. `/%category%/%postname%`.

For category links, `%category%` is implied to follow the value set as the "Category base" (or the default category base if none is specified). So if your category base is 'category', the above example would list posts in the 'WordPress' category on this category listing page:

`http://www.example.com/category/applications/web/wordpress/`

With this plugin activated, that link would become:

`http://www.example.com/category/wordpress/`

NOTE: The fully hierarchical category and post permalinks will continue to work. The plugin issues a 302 redirect to browsers and search engines pointing them to the shorter URL.

Links: [Plugin Homepage](http://coffee2code.com/wp-plugins/single-category-permalink/) | [Plugin Directory Page](https://wordpress.org/plugins/single-category-permalink/) | [Author Homepage](http://coffee2code.com)


== Installation ==

1. Unzip `single-category-permalink.zip` inside the `/wp-content/plugins/` directory for your site (or install via the built-in WordPress plugin installer)
1. Activate the plugin through the 'Plugins' admin menu in WordPress
1. Use `%category%` as a permalink tag in the `Settings` -> `Permalinks` admin options page when defining a custom permalink structure


== Frequently Asked Questions ==

= Will existing links to my site that used the full category hierarchy still work? =

Yes, WordPress will still serve the category listings and posts regardless of whether it is of the full category hierarchy format or just the single category format. But do note that WordPress doesn't perform any sort of redirects; it responds directly to the category/post URL requested.

= Could this give the appearance that I have duplicate content on my site if pages are accessible via the full category hierarchy permalink format and the single category permalink format? =

Whether this plugin is active or not, WordPress treats both types of category links the same. This plugin will however issue redirects for all of the non-canonical category and post permalink pages to point to the single category link version.

= What can this plugin do for me if I don't use `%category%` in my custom permalink structure? =

In addition to handling custom permalink structures (used to generate permalinks for posts) that contain `%category%`, the plugin also shortens category archive links. WordPress by default generates those links in a fully hierarchical fashion which this plugin will reduce to a single category. See the Description section for an example.

= Does this plugin include unit tests? =

Yes.


== Filters ==

The plugin exposes one filter for hooking. Typically, customizations utilizing this hook would be put into your active theme's functions.php file, or used by another plugin.

= c2c_single_category_redirect_status (filter) =

The 'c2c_single_category_redirect_status' hook allows you to specify an HTTP status code used for the redirect. By default this is 302.

Arguments:

* $status (integer) : The default HTTP status code

Example:

`
// Change single category redirect to 301
function scp_change_redirect_status( $code ) {
	return 301;
}
add_filter( 'c2c_single_category_redirect_status', 'scp_change_redirect_status' );
`


== Changelog ==

= 2.1.1 (2015-02-17) =
* Reformat plugin header
* Note compatibility through WP 4.1+
* Change documentation links to wp.org to be https
* Update copyright date (2015)
* Add plugin icon

= 2.1 (2014-01-24) =
* Add unit tests
* Minor documentation improvements
* Minor code reformatting (spacing, bracing)
* Note compatibility through WP 3.8+
* Update copyright date (2014)
* Change donate link
* Add banner

= 2.0.4 =
* Add check to prevent execution of code if file is directly accessed
* Note compatibility through WP 3.5+
* Update copyright date (2013)
* Minor code reformatting (spacing)

= 2.0.3 =
* Re-license as GPLv2 or later (from X11)
* Add 'License' and 'License URI' header tags to readme.txt and plugin file
* Remove ending PHP close tag
* Note compatibility through WP 3.4+

= 2.0.2 =
* Note compatibility through WP 3.3+
* Add link to plugin directory page to readme.txt
* Update copyright date (2012)

= 2.0.1 =
* Fix bug triggered when creating new post

= 2.0 =
* Fix compatibility bug relating to generation of category permalink
* Rename single_category_postlink() to c2c_single_category_postlink()
* Rename single_category_catlink() to c2c_single_category_catlink()
* Add c2c_single_category_redirect() to redirect hierarchical category links to the single category alternative
* Add filter 'c2c_single_category_redirect_status' to allow override of default redirect status code
* Wrap all functions in if (!function_exists()) check
* Remove docs from top of plugin file (all that and more are in readme.txt)
* Add plugin homepage and author links in description in readme.txt
* Note compatibility through WP3.2+
* Add PHPDoc documentation
* Expand documentation in readme.txt
* Minor tweaks to code formatting (spacing)
* Minor documentation reformatting in readme.txt
* Change description
* Add package info to top of plugin file
* Add Frequently Asked Questions, Filters, Changelog, and Upgrade Notice sections to readme.txt
* Update copyright date (2011)

= 1.0 =
* Initial release


== Upgrade Notice ==

= 2.1.1 =
Trivial update: noted compatibility through WP 4.1+; updated copyright date (2015); added plugin icon

= 2.1 =
Minor update: added unit tests; noted compatibility through WP 3.8+

= 2.0.4 =
Trivial update: noted compatibility through WP 3.5+

= 2.0.3 =
Trivial update: noted compatibility through WP 3.4+; explicitly stated license

= 2.0.2 =
Trivial update: noted compatibility through WP 3.3+

= 2.0.1 =
Bugfix release: fixed bug triggered when creating new post (especially recommended if using %category% in custom permalink structure)

= 2.0 =
Recommended update. No functional changes, but many changes to formatting and documentation; noted compatibility through WP 3.2.
