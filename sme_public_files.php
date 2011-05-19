<?php

/*

Plugin Name: SMEStorage Multi-Cloud File Download

Plugin URI: http://www.smestorage.com/

Description: The SMEStorage Multi-Cloud File Download plug-in enables you to share files for download. via a widget,  for over 10 cloud storage providers. These include Amazon S3, RackSpace Cloud Files, MobileMe, Box.net, Microsoft Live SkyDrive, Gmail, any POP3 or IMAP enabled email account, and any FTP server directory.

Author: SME Storage 

Author URI: http://www.smestorage.com/

Version: 1.0.3


*/

 

add_option('tag','');

add_option('order','');

add_option('no_of_files','');

add_option('users_names','');

add_option('file_or_time','');





$tag = $_POST['tag'];

$order = $_POST['order'];

$no_of_files = $_POST['no_of_files'];

$users_names = $_POST['users_names'];

$file_or_time = $_POST['file_or_time'];



if(strlen($tag)>0)

{

	update_option('tag',$tag);

	update_option('order',$order);

	update_option('no_of_files',$no_of_files);

	update_option('file_or_time',$file_or_time);	

}



if(strlen($users_names)>0)

{

	update_option('users_names',$users_names);

}





function sme_public_files()
{
	$tag = get_option('tag');
	$order = get_option('order');
	$no_of_files = get_option('no_of_files');
	$users_names = get_option('users_names');	

	 switch($order)
		{		
			case "last":
			$a = "selected";
			break;
			
			case "popular":
			$b = "selected";
			break;
		}

		$file_or_time = get_option('file_or_time');
		switch($file_or_time)
		{		
			case "only_file":
			$c = 'checked="checked"';
			break;

			case "file_with_time":
			$d = 'checked="checked"';
			break;

		}


		?>
		<h3>SMEStorage Public Files</h3>
		<p>This Plug-In displays files that you have set to be public on SMEStorage.com. SMEStorage.com is a multi-cloud access provider and supports over 10 storage clouds including Amazon S3, Box.net, RackSpace CloudFiles, MobileMe, and Microsoft Live SKyDrive.</p>
		<h4>Plugin Options</h4>
	<form name="form1" action="" method="post">
	<table width="692" border="1">
  <tr>
    <td width="343">Tag</td>
    <td width="333"><input type="text" value="<? echo $tag;?>" name="tag">&nbsp;(Use * To Show All Files)</td>
  </tr>
  <tr>
    <td>Order</td>
    <td>
		<select name="order">
		<option value="">--Select--</option>
		<option <? echo $a;$a="";?> value="last">Last</option>
		<option <? echo $b;$b="";?> value="popular">Popular</option>
		</select>
	</td>
  </tr>
  <tr>
    <td align="left">No of Files</td>
    <td align="left"><input type="text" value="<? if(strlen($no_of_files)>0){ echo $no_of_files;}else {?>20<? }?>" name="no_of_files"></td>
  </tr>
  <tr>
    <td align="left">Option For Displaying FileName or FileName With TimeStamp</td>
    <td align="left">&nbsp;<input type="radio" name="file_or_time" <? echo $c;?> value="only_file" />&nbsp;Filename&nbsp;<input type="radio" name="file_or_time" <? echo $d;?> value="file_with_time" />&nbsp;Filename With TimeStamp</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><input type="submit" value="Update" name="submit"></td>
  </tr>
</table>
</form>

<h4>SME Details</h4>
	<form name="form2"  action="" method="post">
	<table width="250" border="1">
  <tr>
    <td align="left">SME Username</td>
    <td align="right"><input type="text" name="users_names" value="<? echo $users_names;?>"></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><input type="submit" value="Update" name="submit"></td>
  </tr>
</table>	
	<?

}

function fetch_rss_feed($tag,$order,$no_of_files,$users_names)
{
	//$blogurl = "http://www.smetube.com/smestorage/rss/last/xxx/*/20";

	//$blogurl = "http://www.smetube.com/smestorage/rss/".$order."/".$users_names."/".$tag."/".$no_of_files;
	$blogurl = "http://smestorage.com/rss/".$order."/".$users_names."/".$tag."/".$no_of_files;


	$contents = getPageByUrl($blogurl);

	$contents = preg_replace('/<title>/',"******",$contents,2);

	//$contents = preg_replace('/<title>/',"******",$contents,1);

	//$contents = preg_replace('/<link>/',"******",$contents,1);		

	$contents = preg_replace('/<link>/',"******",$contents,2);	

	$contents = preg_replace('/<pubDate>/',"******",$contents,1);

	$total="";

	$file_or_time = get_option('file_or_time');

	while(stripos($contents,'<item>'))

	{	

		$item = stripos($contents,'<item>',0);	

		$p1 = stripos($contents,'<title>',$item);

		if($p1>0)

		{

			$p2 = stripos($contents,'</title>',$p1);		

			$title = substr($contents,$p1+7,$p2-$p1-7);

					$q1 = stripos($contents,'<link>',$item);

					if($q1>0)

					{

						$q2 = stripos($contents,'</link>',$q1);			

						$link = substr($contents,$q1+6,$q2-$q1-6);	

						//$total .= $link."<br>";

					}

					$r1 = stripos($contents,'<pubDate>',$item);

					if($r1>0)
					{
						$r2 = stripos($contents,'</pubDate>',$r1);			
						$pubdate = substr($contents,$r1+9,$r2-$r1-9);
						if($file_or_time=="file_with_time")
						{
							$total .= '<a href="'.$link.'" >'.$title.'</a>'."<br>".$pubdate."<br><br>";	
						}
						else
						{
							$pubdate = "";
							$total .= '<a href="'.$link.'" >'.$title.'</a>'."<br>".$pubdate."<br>";			
						}	

						//$total .= $pubdate."<br>";
					}			

			$contents = preg_replace('/<pubDate>/',"******",$contents,1);	
			$contents = preg_replace('/<title>/',"******",$contents,1);	
			$contents = preg_replace('/<link>/',"******",$contents,1);	
		}	
		$contents = preg_replace('<item>',"******",$contents,1);
	}

	return $total;
}

function getPageByUrl($url){
	if(ini_get("allow_url_fopen")){		# try use wrapper
		$contents = @file_get_contents($url);
		if(!empty($contents))	return $contents;
	}

	$ch=curl_init();									# try use cURL
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	if(strpos($url, "https://")!==false) curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	$contents = curl_exec($ch);
	$http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
	return $contents;
}

function sme_widget_files() {
	if ( !function_exists('register_sidebar_widget') )
		return;

	function sme_widget($args) 
	{
		extract($args);

		$options	= get_option('sme_widget');
		$title		= $options['title'];

		echo $before_widget . $before_title . $title . $after_title;
		$url_parts = parse_url(get_bloginfo('home'));				
		$tag = get_option('tag');
		$order = get_option('order');
		$no_of_files = get_option('no_of_files');
		$users_names = get_option('users_names');
		if(strlen($users_names)>0)
		{
			echo fetch_rss_feed($tag,$order,$no_of_files,$users_names);
		}

		echo $after_widget;
	}

	function control_option() 
	{
		$options = get_option('sme_widget');
		if ( !is_array($options) )
			$options = array('title'=>'SMEStorage');

		if ( $_POST['sme_submit'] ) {
			$options['title'] = strip_tags(stripslashes($_POST['wpaypal-title']));			
			update_option('sme_widget', $options);
		}

		$title		= htmlspecialchars($options['title'], ENT_QUOTES);

		echo '<p style="text-align:left;"><label for="wpaypal-title">Title: <input style="width: 100%;" id="wpaypal-title" name="wpaypal-title" type="text" value="'.$title.'" /></label></p>';

		echo '<input type="hidden" id="wpaypal-submit" name="sme_submit" value="1" />';
	}

	register_sidebar_widget('SMEStorage Files', 'sme_widget');
	register_widget_control('SMEStorage Files', 'control_option', 100, 100);
}

add_action('plugins_loaded', 'sme_widget_files');
add_action('admin_menu', 'sme_tube_public_files');

function sme_tube_public_files() 
{
	add_menu_page('', 'SMEStorage Public Files', 8, __FILE__, 'sme_public_files');
	add_submenu_page(__FILE__, 'SME Files', 'SME Files', 8, __FILE__, 'sme_public_files');
}

 ?>
