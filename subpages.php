<?php
/*
Plugin Name: SubPages
Plugin URI: http://amplifiedprojects.com/projects/subpages-wordpress-widget/
Description: A plugin to display the current page's subpages. Nothing is displayed if there are no subpages
Version: 1.0
Author: Amanda Chappell
Author URI: http://amplifiedprojects.com
*/

/*  Copyright 2009  Amanda Chappell  (email : amanda@amplifiedprojects.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/



function widget_SubPages($args) 
{
	extract($args);

	$options = get_option("widget_subpages");

	echo $before_widget;
	
	global $wp_query;
	$thePostID = $wp_query->post->ID;
	 $children = wp_list_pages('echo=0&title_li=&child_of='.$thePostID);
	if($children){
	echo $before_title;
	echo $options['title'];
	echo $after_title;
?>
<ul>
<?php
	
	$output = wp_list_pages ('echo=0&child_of=' . $thePostID . '&title_li=');
  	echo $output;
?>
</ul><?php
	}
	
	
	?>
<?php
	echo $after_widget;
}

function subPages_control(){
	$options = get_option("widget_subpages");

	if(!is_array($options)){
		$options = array('title' => 'SubPages');
	}
	if($_POST['subpages-Submit']){
		$options['title'] = htmlspecialchars($_POST['subpages-WidgetTitle']);
		update_option("widget_subpages",$options);
	}

	echo '<p>
			<label for="subpages-WidgetTitle">Widget Title: </label>
			<input type="text" id="ravelryPB-WidgetTitle" name="subpages-WidgetTitle" value="';
	echo $options['title'];
	echo '" />
			<input type="hidden" id="subpages-Submit" name="subpages-Submit" value="1" />
		</p>';
}


function subPages_init()
{
  	register_sidebar_widget(__('SubPages Display'), 'widget_SubPages');
	register_widget_control('SubPages Display','subpages_control');
}

add_action("plugins_loaded", "subPages_init");

?>