=== WhatsYourRecord Widget ===
Contributors: WhatsYourRecord
Tags: widget, record, rss
Requires at least: 2.0
Tested up to: 2.5
Stable tag: trunk

Plugin with Widget Support for displaying the latest Records of WhatsYourRecord.com

== Description ==

With this WordPress Plugin you can display the latest Single Records, the latest Group Records or the latest Records from a User of [WhatsYourRecord.com](http://www.whatsyourrecord.com/ "WhatsYourRecord - compete with the world"). This Plugin is with Widget Support but can also be used without widgets.

== Installation ==

**Installation for Widget Support:**

1. Put the whatsyourrecord-widget directory (with the file in it) in your wp-content/plugins
2. Go to your Wordpress Plugin Page and activate the Plugin
3. Go to the Wordpress Design/Widgets Page and add the WhatsYourRecord Widget to your Sidebar. Click on the "edit"  to change the Settings (don't forget to click the Save Changes Button).


**Installation without Widgets:**

1. Put the whatsyourrecord-widget directory (with the file in it) in your wp-content/plugins
2. Go to your Wordpress Plugin Page and activate the Plugin
3. Set the different Settings in the whatsyourrecord.php File
4. Add <?php WhatsYourRecordOutput();?> in your Sidebar.php file or somewhere else where you want to display the records.


**Template Tags you can use in your Widget Settings to display datas:**

* %%image%% = image of the record user
* %%title%% = name of the record
* %%username%% = username from the person who has done this record
* %%userprofileurl%% = the url of the users profile
* %%userrecordurl%% = the url of the users record page
* %%result%% = record result
* %%date_added%% = the date the record was added
* %%record_date%% = the date the record attempt was done
* %%place%% = the place of the record
* %%rating%% = the current rating of the record
* %%best_result%% = the best result for this record so far
* %%record_type%% = the type of the record - single record or group record

== Screenshots ==

1. Admin Widget Settings
2. Frontend Sidebar Example of the Latest Records