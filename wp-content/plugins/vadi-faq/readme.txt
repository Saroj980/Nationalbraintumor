=== Free Responsive Accordian FAQ and Question Answer ===
Contributors: waheed146
Author URI: https://www.facebook.com/waheed146
Donate link: a_r_waheed@yahoo.com
Tags: faq shortcodes,  wordpress,  wp-faq, FAQ,  frequently asked questions,  question answer plugin, faq,  wordpress faq accordion,  wp-faq with QA,  faq list accordion,  question answer with accordion,  faqs,  jquery accordion,  wordpress question answer accordion,   faq with accordion,  questions answer,  WordPress Plugin,  FAQS,  faq plugin,  faq list,  accordion custom post type, Vadi Faq
Requires at least: 3.0.1
Tested up to: 3.4
Stable tag: 4.3
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html


A simplest and easiest way to add responsive accordion FAQ and question answer to your faq page or post with shortcode

== Description ==
Almost all the websites have FAQ page. Responsive Accordion FAQ and Question Answer plugin allow you to easily display FAQs to your website. 



place the following shortcode to any page to display Faqs
<code>[vadi_faq]</code> 

Faqs can be categorised by the following shorcodes
<code>[vadi_faq category="1"] 1 is category id</code>

Faqs can be orderd by post date or by faq order custom number
<code>order by post date[vadi_faq orderby="date"]</code>
<code>order by faq order custom number[vadi_faq orderby="order"]</code>

Faqs shortcode with all parameters
<code>[vadi_faq limit="3" category="1" orderby="order" order="ASC" transition_speed="300" transition_type="ease" morethenoneopen="false" design="1" font_color="#000" border_color="#d9d9d9" background_color="#f4f4f4" active_bg_color="#fff" active_title_color="#000" icon_color="black" icon_position="right" icon_type="updown"  qa="yes" q_font_color="#fff"]</code>

= Shortcode parameters are =
limit: limit="3" limitize the faq items by default all item will be displays

category: category="category id" FAQs can be categories by category id 

morethenoneopen: morethenoneopen="true" if true all the faqs can be open while if false then only one faq at a time will open on click

transition_speed: transition_speed="300" transition speed when user click to open FAQ item by default 300 

transition_type: transition_type="eases" A string indicating which easing function to use for the transition. ease(this is default)linear, ease-in, ease-out, ease-in-out.

design: FAQ plugin included with 8 color scheme you can select see in shortcode page.  

<strong>FAQ plugin can be customize design wiht the following parameter</strong><br>

font_color: font_color="#000" you can change text color by using hexa color

border_color: border_color="#d9d9d9" faqs border color can be change by using hexa color

background_color: background_color="#f4f4f4"  faqs background color can be change by using hexa color

active_bg_color: active_bg_color="#fff"  open faqs color can be change with hexa color 

active_title_color active_title_color="#000" opened faqs title text color can be changed


<strong>FAQ Plugin included icons</strong><br>
icon_color: icon_color="black"  icon color can be select by white and black color

icon_position: icon_position="right" icon position can be select left or right

icon_type: icon_type="updown" icon type can be select by updown and plus  




== Installation ==

1. Extract the files and Upload to the `/wp-content/plugins` directory, or install the plugin through the WordPress plugins screen directly.
2. Activate the plugin through the 'Plugins' screen in WordPress
3. vadi faq menu created in side menu where you can create and manage faqs.
4. Place shortcode <code>[vadi_faq]</code> in a post or page to display faqs.


== Frequently Asked Questions ==
Please ask question if you have


== Screenshots ==

1. FAQ list, in quick screen faq order can be change
2. Add new FAQ or Edit Faq also able to change FAQ order
3. FAQ category shorcode for category available
4. Place shortcode to a page or post
5. Display FAQ at front page


== Changelog ==


= 1.0.0 =
Initial release