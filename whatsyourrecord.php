<?php
/*
Plugin Name: WhatsYourRecord
Plugin URI: http://www.whatsyourrecord.com/tools
Description: Displays the latest Records from WhatsYourRecord.com
Author: Juergen Koller
Version: 1.0
Author URI: http://www.kollermedia.com
*/

/***********************    YOUR OPTIONS    *****************************/
$option['title'] ="Latest Records"; // Title on the Top of the box
$option['showcount'] = 4; // How many entries do you want to show? maximum is 15
$option['image'] ="1"; // Display an image?
$option['image_pos'] ="right"; // Image Position - left or right
$option['image_size'] ="35"; // Size of the image in px
$option['username'] = "yourusername"; // Enter your username (important for displaying a personal feed)
$option['credit'] = 'yes'; // Do you want to show a credit link (small link that shows to the whatsyourrecord website)
$option['feedurl'] = "1"; /* Choose a feed you want to display

1 = latest records 					(language english)
2 = latest individual records		(language english)
3 = latest group records 			(language english)
4 = latest records from a user		(language english)
*/

/***********************    TEMPLATE TAGS    *****************************
%%image%% = image of the record user
%%title%% = name of the record
%%username%% = username from the person who has done this record
%%userprofileurl%% = the url of the users profile
%%userrecordurl%% = the url of the users record page
%%result%% = record result
%%date_added%% = the date the record was added
%%record_date%% = the date the record attempt was done
%%place%% = the place of the record
%%rating%% = the current rating of the record
%%best_result%% = the best result for this record so far
%%record_type%% = the type of the record - individual record or group record
%%url%% = the url of the record detailpage
*/

/***********************   EDIT YOUR TEMPLATE   *****************************/
$option['template'] ="
%%image%%
<strong><a href=%%url%% target='_blank'>%%title%%</a></strong><br />
<strong>by</strong> <a href =%%userprofileurl%%>%%username%%</a><br />
<strong>Result:</strong> %%result%% <br />
<strong>Best Result so far:</strong> %%best_result%% <br />
";




/***********************   NO NEED TO EDIT BELOW  *****************************/
function WhatsYourRecordOutput() 
{
global $option;


switch ($option['feedurl']) 
{
case 1:
$option['recordfeed'] = "http://www.whatsyourrecord.com/rss/latest_records_en.xml";
break;

case 2:
$option['recordfeed'] = "http://www.whatsyourrecord.com/rss/latest_individual_records_en.xml";
break;

case 3:
$option['recordfeed'] = "http://www.whatsyourrecord.com/rss/latest_group_records_en.xml";
break;

case 4:
$option['recordfeed'] = "http://www.whatsyourrecord.com/rss/user/".$option['username']."/latest_records_en.xml";
break;
}

/*  The file function is used to get the content of rss feed url in to an array of string, which in turn is converted to single string using the implode function and the rss xml content is stored in a variable */
$xml = implode ('', file($option['recordfeed']));

// Create a DOM object for the rss xml document using the function domxml_open_mem.
$dom = domxml_open_mem($xml);

// Fetch the root element note of the xml document using document_element function
$root = $dom->document_element();

/* Fetch the content of xml tags and store the values in array variables. */
$title = $root->get_elements_by_tagname("title");
$record_username = $root->get_elements_by_tagname("record_username");
$record_value = $root->get_elements_by_tagname("record_value");
$record_date_added = $root->get_elements_by_tagname("record_date_added");
$record_date = $root->get_elements_by_tagname("record_date");
$record_place = $root->get_elements_by_tagname("record_place");
$record_rating = $root->get_elements_by_tagname("record_rating");
$record_value_best = $root->get_elements_by_tagname("record_value_best");
$record_type = $root->get_elements_by_tagname("record_type");
$link = $root->get_elements_by_tagname("link");

// Fetch each values from the array variables and display

if ($option['showcount'] >15) {$option['showcount'] = 15+1;} else {$option['showcount'] = $option['showcount']+1;}


for($i=0;$i<=$option['showcount'];$i++)
{ if ($i >1 ){
echo "<div class='whatsyourrecord' style='margin:5px 0px;'>";
if ($option['image_pos'] =="left") {
$output = str_replace("%%image%%", "<img src='http://www.whatsyourrecord.com/images/userimages/".$record_username[$i-2]->get_content()."/".$record_username[$i-2]->get_content()."90.jpg' width='".$option['image_size']."' style='float:left; margin-right:5px; ' />", $option['template']);
}
else {
$output = str_replace("%%image%%", "<img src='http://www.whatsyourrecord.com/images/userimages/".$record_username[$i-2]->get_content()."/".$record_username[$i-2]->get_content()."90.jpg' width='".$option['image_size']."' style='float:right; margin-left:5px; ' />", $option['template']);
}

$output = str_replace("%%title%%", $title[$i]->get_content(), $output);
$output = str_replace("%%username%%", $record_username[$i-2]->get_content(), $output);
$output = str_replace("%%result%%", $record_value[$i-2]->get_content(), $output);
$output = str_replace("%%date_added%%", $record_date_added[$i-2]->get_content(), $output);
$output = str_replace("%%record_date%%", $record_date[$i-2]->get_content(), $output);
$output = str_replace("%%place%%", $record_place[$i-2]->get_content(), $output);
$output = str_replace("%%rating%%", $record_rating[$i-2]->get_content(), $output);
$output = str_replace("%%best_result%%", $record_value_best[$i-2]->get_content(), $output);
$output = str_replace("%%record_type%%", $record_type[$i-2]->get_content(), $output);
$output = str_replace("%%url%%", $link[$i]->get_content(), $output);
$output = str_replace("%%userrecordurl%%", "http://www.whatsyourrecord.com/records/".$record_username[$i-2]->get_content()."", $output);
$output = str_replace("%%userprofileurl%%", "http://www.whatsyourrecord.com/profile/".$record_username[$i-2]->get_content()."", $output);
echo $output;
echo "</div>";
	}
}
if ($option['credit']=="yes") {echo "<small>Widget by <a href=\"http://www.whatsyourrecord.com\" title=\"visit WhatsYourRecord.com\" target=\"_blank\">WhatsYourRecord.com</a></small>";}

}



function WhatsYourRecord() {
global $option;

	if (function_exists('widget_WhatsYourRecord_checkoptions')) {
		$options = widget_WhatsYourRecord_checkoptions();
		$option = array_merge($option,$options);
	}
WhatsYourRecordOutput();
}



function WhatsYourRecord_init()
{
if ( !function_exists('register_sidebar_widget') )	return;

	global $options;

	function widget_WhatsYourRecord($args) {
	global $option ;
	extract($args);
	$options = get_option('widget_WhatsYourRecord');
	$title = $options['title'];
	echo $before_widget . $before_title . $title . $after_title;
	WhatsYourRecord();
	echo $after_widget;
	}

	function widget_WhatsYourRecord_checkoptions() {
		global $option;
		$oldoptions = $options = get_option('widget_WhatsYourRecord');
		if (!$options['title']) $options['title'] = $option['title'];
		if (!$options['username']) $options['username'] = $option['username'];
		if (!$options['showcount']) $options['showcount'] = $option['showcount'];
		if (!$options['image_size']) $options['image_size'] = $option['image_size'];
		if (!$options['feedurl']) $options['feedurl'] = $option['feedurl'];
		if (!$options['feedurl']) $options['feedurl'] = $option['image_pos'];
		if (!$options['template']) $options['template'] = $option['template'];
		if (!$options['credit']) $options['credit'] = $option['credit'];
		
		if ($oldoptions != $options) update_option('widget_WhatsYourRecord', $options);
		
		return $options;
	}

	function widget_WhatsYourRecord_control() {
		global $option;
		// Get our options and see if we're handling a form submission.

		if ($_POST['youfave-submit'] ) {
			$options['title'] = $_POST['form-title'];
			$options['username'] = $_POST['form-username'];
			$options['showcount'] = $_POST['form-showcount'];
			$options['image_size'] = $_POST['form-image_size'];
			$options['feedurl'] = $_POST['form-feed'];
			$options['image_pos'] = $_POST['form-image_pos'];
			$options['credit'] = $_POST['form-credit'];
			$options['template'] = $_POST['form-template'];
			update_option('widget_WhatsYourRecord', $options);
		}

		$options = widget_WhatsYourRecord_checkoptions();

		// A few formatting
		$title = htmlspecialchars($options['title'], ENT_QUOTES);
		$username = htmlspecialchars($options['username'], ENT_QUOTES);
		$count = htmlspecialchars($options['showcount'], ENT_QUOTES);
		$image_size = htmlspecialchars($options['image_size'], ENT_QUOTES);
		$feedurl = htmlspecialchars($options['feedurl'], ENT_QUOTES);
		$image_pos = htmlspecialchars($options['image_pos'], ENT_QUOTES);
		if ($feedurl =='1') {$one = 'selected'; $two = ''; $three = ''; $four = '';} 
		else if ($feedurl =='2') {$one = ''; $two = 'selected'; $three = ''; $four = '';}
		else if ($feedurl =='3') {$one = ''; $two = ''; $three = 'selected'; $four = '';}
		else if ($feedurl =='4') {$one = ''; $two = ''; $three = ''; $four = 'selected';}
		
		$image_pos = htmlspecialchars($options['image_pos'], ENT_QUOTES);
		if ($image_pos =='right') {$image_posright = 'selected'; $image_posleft = '';} else {$image_posleft = 'selected'; $image_posright = '';}
		$credit = htmlspecialchars($options['credit'], ENT_QUOTES);
		if ($credit =='yes') {$credityes = 'selected'; $creditno = '';} else {$creditno = 'selected'; $credityes = '';}
		$template = stripslashes(htmlspecialchars($options['template'], ENT_NOQUOTES));
		
		// Widget Form Style
		echo '<style>
		#whatsyourrecord label, #whatsyourrecord p{text-align:left; margin:0.1em}
		#whatsyourrecord input{width:190px;}
		#whatsyourrecord textarea {width:380px; height:90px;font-size:80%;}
		#whatsyourrecord hr {clear:both;display:block;visibility:hidden;height:1em;}
		#whatsyourrecord h3 {clear:both;margin-bottom:0.1em;}
		#whatsyourrecorddisplay span {cursor:help;}</style>';
		
		
		// Widget Form Structure
	echo '	<div id="whatsyourrecord">
			<h3>Settings</h3>
			<div style="float:left;width:190px;">
			<p><label for="form-title"><strong>Title:</strong><br/><input id="form-title" name="form-title" type="text" value="'.$title.'" /></label></p>
	<p><label for="form-showcount"><strong>Number of Records:</strong><br/><input id="form-showcount" name="form-showcount" type="text" value="'.$count.'" /></label></p>';
	echo '</div><div style="float:right;width:220px;">';
	echo '	<p>
			<label for="form-username"><strong>WhatsYourRecord Username:</strong><br/>
			<input id="form-username" name="form-username" type="text" value="'.$username.'" /></label>
			</p>
			
			<p>
			<label for="form-image_size"><strong>Image Size:</strong><br/>
			<input id="form-image_size" name="form-image_size" type="text" value="'.$image_size.'" /></label>
			</p>';
		echo '</div><hr/>';
		
		echo '<p><label for="form-feed"><strong>What records do you want to show?</strong><br/><select id="form-feed" name="form-feed">
		<option value="1" '.$one.'>All Latest Records (english)</option>
		<option value="2" '.$three.'>Latest Single Records (english)</option>
		<option value="3" '.$five.'>Latest Group Records (english)</option>
		<option value="4" '.$seven.'>My Latest Records (english)</option>
		</select></label></p>';
		echo '<p><label for="form-image_pos"><strong>Image Position:</strong><br />
 			<select id="form-image_pos" name="form-image_pos">
			<option value="right" '.$image_posright.'>right</option>
			<option value="left" '.$image_posleft.'>left</option>
			</select>
			</label></p>';
 
		echo '<p><label for="form-credit"><strong>Show small credit link to WhatsYourRecord?</strong><br />
 <select id="form-credit" name="form-credit"><option value="yes" '.$credityes.'>Yes</option><option value="no" '.$creditno.'>No thanks</option></select></label></p>';
		echo '<div id="whatsyourrecorddisplay">';
		echo '<h3>Display Template</h3>';
		echo '<p><label for="form-template"></label>
<textarea id="form-template" name="form-template" rows="4" cols="60">'.$template.'</textarea><br /><small><strong>Tags you can use:</strong>
		<span title="image of the record user">%%image%%</span> &#8212;
		<span title="name of the record">%%title%%</span> &#8212;
		<span title="username from the person who has done this record">%%username%%</span> &#8212;
		<span title="the url of the users profile">%%userprofileurl%%</span> &#8212;
		<span title="the url of the users record page">%%userrecordurl%%</span> &#8212;
		<span title="record result">%%result%%</span>	 &#8212;	
		<span title="the date the record was added">%%date_added%%</span>		 &#8212;		
		<span title="the date the record attempt was done">%%record_date%%</span>	 &#8212;
		<span title="the place of the record">%%place%%</span>	 &#8212;
		<span title="the current rating of the record">%%rating%%</span> &#8212;
		<span title="the best result for this record so far">%%best_result%%</span> &#8212;
		<span title="the type of the record - individual record or group record">%%record_type%%</span> &#8212;
		<span title="the url of the record detailpage">%%url%%</span>
		</small></p>';
		echo '<input type="hidden" id="youfave-submit" name="youfave-submit" value="1" />';
		echo '</div>';
		echo '</div>';
		echo '</div>';
	}



  register_sidebar_widget(__('WhatsYourRecord'), 'widget_WhatsYourRecord');
  // Register the widget control form
  register_widget_control('WhatsYourRecord', 'widget_WhatsYourRecord_control', 430, 480);     
}
add_action("plugins_loaded", "WhatsYourRecord_init");
?>