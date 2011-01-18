=== Plugin Name ===
Contributors: leewillis77
Donate link: http://www.leewillis.co.uk/wordpress-plugins/?utm_source=wordpress&utm_medium=www&utm_campaign=ajax-campaign-monitor-forms
Tags: campaign monitor, email, subscribers, mailing list 
Requires at least: 3.0
Tested up to: 3.1
Stable tag: 0.5
License: GPLv3

== Description ==

A WordPress plugin that adds Ajax powered forms to allow site visitors to sign up to your Campaign Monitor powered email lists. 

== Installation ==

1. Upload the plugin to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress

Adding a form to your sidebars
* Add the widgets to your sidebar from Appearance > Widgets
* Add your account API key and list API key to the widget
* Save

Adding a form to a post or page
* Edit the post/page
* Click the "Campaign Monitor" button ![Screenshot of button](http://s.wordpress.org/extend/plugins/ajax-campaign-monitor-forms/screenshot-5.png?r=333233)
* Enter your account API Key and list API key
* Save

== Frequently Asked Questions ==

= Where do I find my Campaign Monitor API keys? =
Campaign Monitor have an excellent guide here:
http://www.campaignmonitor.com/api/getting-started/

= Is there a shortcode, so I can insert the form into posts or pages? =
Yes, but it's beta - please let me know if it works for you! Just click the CampaignMonitor button in the post/page editor

= What if users don't have Javascript enabled? =
The widget falls back to a standard web page request, but will still keep users on your site, unlike the normal CampaignMonitor forms.

== Screenshots ==

1. Configuration
2. Sign-up form
3. Ajax submission
4. Feedback
5. Inserting a shortcode
6. Choosing a shortcode / creating a new shortcode

== Changelog ==
 
= 0.5 =
Small bugfixes, and allow user to pick from list of existing shortcodes

= 0.4 = 
Add button to the editor to allow shortcode to be inserted into posts (Beta - please let me know if this works for you!)

= 0.3 = 
Fix compatability with some themes

= 0.2 = 
Commit missing files & remove dev branch stuff 

= 0.1 =
First release
