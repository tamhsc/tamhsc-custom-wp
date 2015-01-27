=== TAMHSC Customization ===
Contributors: jeremytarpley
Requires at least: 4.0
Tested up to: 4.1
Stable tag: trunk
License: GNU General Public License v2
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Basic customization for wordpress, TAMHSC branded login, disable password reset, etc.

== Description ==
=== Basic security related changes ===

* Remove login screen error messages
* Disable the theme / plugin editor in the wordpress admin
* Remove the wordpress version number from the
* Disable password resets, pingbacks, xmlrpc, rsd links

=== Interface changes specific to TAMHSC ===

* Removes post formats, meta boxes for custom fields, comments and sharing
* Add TAMU logo to the admin header and favicon
* Hide menu items like tools, links and jetpack for non-admins
* Hide most default dashboard widgets including incoming links, wordpress news, welcome panel and such
* Add a custom login message and logo to login page
* Hide update notifications for non-admins
* Allow editors to see \'Appearance\' menu and access \'Widgets\' and \'Menus\' sub-menus but removes ability to see updates, change theme and customize menu
* Disable auto linking of images in editor
* Prevent Wordpress WP-KSES and TinyMCE from stripping out tags we want to use for embedding items such as Youtube videos and web forms.

== Installation ==
Since this plugin is just a few tweaks we make on TAMHSC websites, it will live in Github instead of Wordpress.org\'s plugin repository.  To install, download the latest zip or clone in your plugins folder.

Automatic updating from Github requires the GitHub Updater plugin available at [codepress/github-plugin-updater]: https://codepress/github-plugin-updater



== Changelog ==
# 1.4.5

* Added plugin description, installation info and other metadata
* Tested and verified that updating from Github works even if the plugin folder wasn\'t cloned from Git

# 1.4.4

* Testing github updating

# 1.4.3

* Added ability to allow object, embed, script tags in wordpress

# 1.4.2

* added $args[\'timeout\'] = 600; to class-github-updater.php - found this here: https://github.com/afragen/github-updater/issues/81

# 1.4.0

* Trying to figure out how to get this to update from GitHub!
