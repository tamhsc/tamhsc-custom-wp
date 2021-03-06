=== TAMHSC Customization ===

Contributors: jeremytarpley
Requires at least: 4.0
Tested up to: 4.3.1
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

https://github.com/tamhsc/tamhsc-custom-wp/archive/master.zip
or
`git clone https://github.com/tamhsc/tamhsc-custom-wp`

Automatic updating from Github requires the GitHub Updater plugin available at [codepress/github-plugin-updater]: https://codepress/github-plugin-updater
The automatic updates work based on git tag.  The GitHub Updater compares the version of the currently installed plugin with the latest tag in the Git repository.



== Changelog ==
# 1.4.8

* Totally disabled xml-rpc. Its a constant vector for attack and other than some Jetpack functionallity, I don't know of any tools we are using that rely on it.
* Made logo a little smaller and a few cosmetic fixes on login page

# 1.4.7

* Updated to allow embedding Kaltura videos.  Editor no longer strips html tags and attributes from Kaltura embed code.

# 1.4.6

* Fixed items that broke after refactoring the code

# 1.4.5

* Added plugin description, installation info and other metadata
* Tested and verified that updating from Github works even if the plugin folder wasn\'t cloned from Git
* Added default index.php and uninstall script from [Tom McFarlin\'s Wordpress plugin boilerplate]: https://github.com/tommcfarlin/WordPress-Plugin-Boilerplate
* Broke code out into separate files and made other changes to better follow Wordpress coding conventions

# 1.4.4

* Testing github updating

# 1.4.3

* Added ability to allow object, embed, script tags in wordpress

# 1.4.2

* added $args[\'timeout\'] = 600; to class-github-updater.php - found this here: https://github.com/afragen/github-updater/issues/81

# 1.4.0

* Trying to figure out how to get this to update from GitHub!
