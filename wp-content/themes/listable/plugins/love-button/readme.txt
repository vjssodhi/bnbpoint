=== Love Button ===
Contributors: 
Donate link: http://love.delucks.comTags: social media, share button, social network, deLucks, twitter, facefook, stumbleupon, linkedin, google+, googleplus, flattr, xing, pinterest, statistics, shortcode, print, favorite, buffer, mailRequires at least: 2.5Tested up to: 3.5.1Stable tag: 2.0.4License: GPLv2 or laterLicense URI: http://www.gnu.org/licenses/gpl-2.0.html
The Love Button is the only Social Sharing Plugin, which combines the data privacy of a 2-click social sharing buttons with individual settings and anonymous, viral statistics. 
== Description ==

**Social Sharing FOR EVERYONE:**

* Data privacy specialists love the Love Button, because user data will only be transferd to social networks after double opt-in and only anonymous data will be stored internally.
* Copyright specialists love the Love Button, because images, for which they don’t have the right for using in social media, can be excluded from social sharing.
* Marketers love the Love Button, because they can analyse their contents “virality” and display the new and most loved articles in a frontend widget.
* Designers love the Love Button, because they can choose between different styles and settings or select an own button for social sharing.

**Supported social networks/ functions are:** 

* Facebook
* Twitter
* Google+
* LinkedIn
* Xing
* Pinterest
* StumbleUpon
* Buffer
* Flattr
* Tumblr
* VKontakte
* Print
* E-Mail
* Browser favorites

**Functions:**
* The Love Button supports all important social networks like Facebook, Twitter, Google or Pinterest. It can also print, mail or favourite your contents.
* Choose between different styles or select an own image as a love button. Adapt the button to your needs and insert it wherever you want in your website.
* Give your website visitors recommendations for the most recommended articles from a specific time space. Leverage click-through-rates, and social booksmarks so.
* Learn, which contents are recommended most in a specific network and improve your social media marketing out of that.
== Installation ==
1. Backup your custom css file `/wp-content/plugins/love-button/fe/style_custom.css`
2. Upload folder `love-button` to the `/wp-content/plugins/` directory3. Activate the plugin through the 'Plugins' menu in WordPress4. Go to 'Settings > Love Button' and set up the plugin5. Set the placement option to 'Pages/Posts/Blog views' or to 'only shortcode' and place `<?php echo do_shortcode('[love-button]');?>` in your templates
== Screenshots ==
1. Frontend layout2. New and Loved widget in administrator
== Changelog ==

= 2.0.4 =
* Adding the love-button as menu item is now possible
* New option to add a css-class to the verb-element
* Fixed css for cross browsers
* Fixed several bugs

= 2.0.3 =
* IMPORTANT - BEFORE UPDATING: copy your custom style (/love-button/fe/style_custom.css) to your template directory an rename it to love-button-style_custom.css to keep your customized style
* File /love-button/fe/style_custom.css renamed to love-button-style_custom.css
* Fixed several bugs
* Changed php short_open_tag to echos in config.php

= 2.0.1 =
* compatibility fix for versions 3.5.0 or less
* ajax caching is now disabled for using the love button with cached sites

= 2.0.0  =
* New network: VKontakte (vk.com)
* New network: Tumblr
* New translation: German
* New Widget: Dashboard widget for visual love overview of the last 7 days (activation vis dashboars > options)
* Facebook: ability to fade in an overlay with a like-box after sharing a page
* Twitter: ability to fade in an overlay with a follow-box after sharing a page
* Google+: ability to fade in an overlay with a follow-box after sharing a page
* Pinterest: Fallback to post/page title if no image title is set via media manager
* Pinterest: Duplicate check
* Pinterest: Minimum image width/height option added
* New option to set a minimum width/height for auto generated og:image tags
* New option to display/hide the data privacy button
* New option to display the data privacy text by default
* New option (heartless) to display the network buttons directly without a trigger button *premium version
* New option to change the verb wich is displayed on trigger button
* New option to remove backgrounds and borders from button elements *premium version
* Fixed position option added
* Dark theme completed
* Network buttons are now smaller on deactivated "show counters" option
* Added a limit option for statistic output
* Added a button to reset counter database
* Backend template fix
* Chrome columns-count bugfix
= 1.1.3  =
* CSS fix in frontend
= 1.1.2 =
* New option to display the data privacy text by default
* New option to change the verb wich is displayed on trigger button
= 1.1.1 =
* Fixed option for twitter username
= 1.1.0 =
* Added option for twitter username
* Removed Love Button entry from main menu (go to settings > love button)
* Blog url will be removed on like-url, multidomain is now supported on activated url sharing option
* CSS fix
= 1.0.9 =
* Set OpenGraph image dimensions to minimum 150x150px
* New Network: Flattr
* CSS Bugfix
* Added procedure to add settings to networks
= 1.0.8 =
* Added the ability to auto proceed OpenGraph image tags
* Images can be marked up as unshareable to social networks by using the new toolbar button
* Bugfixes
= 1.0.7 =
* Added a widget feature for suggest articles
= 1.0.6 =
* Added print function on shortcode
= 1.0.5 =
* Closing the Button is now possible without a second count.
* Button Styles are more override protected now
* Shortcode issue fixed
* Database ID count Issue fixed
* Pinterest Posting optimized
= 1.0.4 =
* Fixed a bug to load jQuery
= 1.0.3 =
* Added an option to hide branding
= 1.0.1 =
* Clean up