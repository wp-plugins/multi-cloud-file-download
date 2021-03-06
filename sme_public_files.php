<?php
/*
Plugin Name: StorageMadeEasy Multi-Cloud File Download
Plugin URI: http://www.storagemadeeasy.com/
Description: The StorageMadeEasy Multi-Cloud File Download plug-in enables you to share files for download, via a widget, for over 30 cloud storage providers. These include Amazon S3, RackSpace Cloud Files, Box.net, Microsoft Live SkyDrive, Gmail, any POP3 or IMAP enabled email account, and any FTP server directory.
Author: Storage Made Easy
Author URI: http://www.storagemadeeasy.com/
Version: 1.1.1
*/

add_option('tag','');
add_option('order','');
add_option('no_of_files','');
add_option('SME_server_url','');
add_option('users_names','');
add_option('file_or_time','');
add_option('file_extension','');

$tag = '';
$order = '';
$no_of_files = '';
$users_names = '';
$SME_server_url='';
$file_or_time = '';
$file_extension = '';

if(!empty($_POST['tag'])) $tag=$_POST['tag'];
if(!empty($_POST['order'])) $order = $_POST['order'];
if(!empty($_POST['no_of_files']) && is_numeric($_POST['no_of_files'])) $no_of_files = $_POST['no_of_files'];
if(!empty($_POST['users_names'])) $users_names = $_POST['users_names'];
if(!empty($_POST['SME_server_url'])) $SME_server_url = $_POST['SME_server_url'];
if(!empty($_POST['file_or_time'])) $file_or_time = $_POST['file_or_time'];
if(!empty($_POST['file_extension'])) $file_extension = $_POST['file_extension'];

if(strlen($tag)>0){
	update_option('tag',$tag);
	update_option('order',$order);
	update_option('no_of_files',$no_of_files);
	update_option('file_or_time',$file_or_time);
	update_option('file_extension',$file_extension);
}

if(strlen($users_names)>0){
	update_option('users_names',$users_names);
}

if(strlen($SME_server_url)>0){
	update_option('SME_server_url',$SME_server_url);
}

function sme_public_files(){
	$tag = get_option('tag');
	$order = get_option('order');
	$no_of_files = get_option('no_of_files');
	$users_names = get_option('users_names');	
	$SME_server_url = get_option('SME_server_url');	
	$a=$b=$c=$d='';
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

		$file_extension = get_option('file_extension');
		switch($file_extension)
		{		
			case "file_with_extension":
			$e = 'checked="checked"';
			break;

			case "file_without_extension":
			$f = 'checked="checked"';
			break;

		}

		?>
		<h3>StorageMadeEasy Public Files</h3>
		<p>This Plug-In displays files that you have set to be public on StorageMadeEasy.com. StorageMadeEasy.com is a multi-cloud access provider and supports over 30 storage clouds including DropBox, Microsoft Live SkyDrive, Amazon S3, Box.com, RackSpace CloudFiles, FTP and WebDAV.</p>
<?php
if(!ini_get("allow_url_fopen") && function_exists('curl_init')){
?>
<div style="padding-top:10px; color:#880000; font-size:14px">
Warning!<br>
CURL and option allow_url_fopen is disabled. So, plugin can not send requests to SME API. It is need to enable cURL or option allow_url_fopen in the file php.ini
</div>
<?php
}

?>
		<h4>Plugin Options</h4>
	<form name="form1" action="" method="post">
	<table width="692" border="1">
  <tr>
    <td width="343">Tag</td>
    <td width="333"><input type="text" value="<?php echo $tag;?>" name="tag">&nbsp;(Use * To Show All Files)</td>
  </tr>
  <tr>
    <td>Order</td>
    <td>
		<select name="order">
		<option value="">--Select--</option>
		<option <?php echo $a;$a="";?> value="last">Last</option>
		<option <?php echo $b;$b="";?> value="popular">Popular</option>
		</select>
	</td>
  </tr>
  <tr>
    <td align="left">Number of Files</td>
    <td align="left"><input type="text" value="<?php if(strlen($no_of_files)>0){ echo $no_of_files;}else {?>20<?php }?>" name="no_of_files"></td>
  </tr>
  <tr>
    <td align="left">Option For Displaying FileName or FileName With TimeStamp</td>
    <td align="left">&nbsp;<input type="radio" name="file_or_time" <?php echo $c;?> value="only_file" />&nbsp;Filename&nbsp;<input type="radio" name="file_or_time" <?php echo $d;?> value="file_with_time" />&nbsp;Filename With TimeStamp</td>
  </tr>
  <tr>
    <td align="left">Option For Displaying extension in FileName</td>
    <td align="left">&nbsp;<input type="radio" name="file_extension" <?php echo $e;?> value="file_with_extension" />&nbsp;Filename With Extension&nbsp;<input type="radio" name="file_extension" <?php echo $f;?> value="file_without_extension" />&nbsp;Filename Without Extension</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><input type="submit" value="Update" name="submit"></td>
  </tr>
</table>
</form>

<script>
function updateServer(){
	if(document.getElementById("SME_server_url2").value=='') return ;
	document.getElementById("SME_server_url").value=document.getElementById("SME_server_url2").value;
}
</script>
<h4>SME Details</h4>
	<form name="form2"  action="" method="post">
	<table width="450" border="1">
  <tr>
    <td align="left" width="200">SME Server</td>
    <td align="right">
       
      <table border="0" cellpadding="0" cellspacing="0" style="margin-top:2px; margin-bottom:2px;">
         <tr>
            <td><input type="text" id="SME_server_url" name="SME_server_url" value="<?php echo $SME_server_url; ?>" style="width:259px; height:22px; margin-right:0px; padding-right:0px"></td>
            
            <td class="dvSelect" style="margin:0px; padding:0px; background-image:url(<?php echo plugins_url('multi-cloud-file-download/selectButton.png', dirname(__FILE__)); ?>); background-repeat:no-repeat; overflow: hidden;">
               <select size="1" id="SME_server_url2" style="width:18px; margin-left:0px; padding-left:0px; height:22px; opacity:0.0;" onchange="updateServer();">
                  <option value=""> </option>
                  <option value="storagemadeeasy.com">storagemadeeasy.com</option>
                  <option value="eu.storagemadeeasy.com">eu.storagemadeeasy.com</option>
               </select>
            </td>
         </tr>
      </table>

    </td>
  </tr>
  <tr>
    <td align="left">SME Username</td>
    <td align="right"><input type="text" name="users_names" value="<?php echo $users_names;?>" style="width:100%;"></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><input type="submit" value="Update" name="submit"></td>
  </tr>
</table>	
	<?php

}

function fetch_rss_feed($tag,$order,$no_of_files,$users_names)
{
	if(empty($order)) $order='last';
	$url = get_option('SME_server_url');
	if(empty($url)) $url='storagemadeeasy.com';

	$proto='http://';
	$blogurl='';
	if(preg_match("/^http([s]{0,1})\:\/\/(.+?)(\/{0,1})$/i", $url, $m)){
		if($m[1]=='s') $proto='https://';
		$blogurl=$proto.$m[2];
	}else{
		$blogurl=$proto.$url;
	}

	if(!isset($tag) || $tag=='') $tag='*';
	if($tag!='*') $tag=urlencode($tag);
	$blogurl .= "/rss/".$order."/".urlencode($users_names)."/".$tag."/".$no_of_files;

	$contents = getPageByUrl($blogurl);
	$contents = preg_replace('/<title>/',"******",$contents,2);
	//$contents = preg_replace('/<title>/',"******",$contents,1);
	//$contents = preg_replace('/<link>/',"******",$contents,1);
	$contents = preg_replace('/<link>/',"******",$contents,2);
	$contents = preg_replace('/<pubDate>/',"******",$contents,1);
	$total="";
	$file_or_time = get_option('file_or_time');
	$file_extension = get_option('file_extension');
	
	while(stripos($contents,'<item>'))
	{
		$item = stripos($contents,'<item>',0);
		$p1 = stripos($contents,'<title>',$item);
		if($p1>0)
		{
			$p2 = stripos($contents,'</title>',$p1);
			$title = substr($contents,$p1+7,$p2-$p1-7);

			if($file_extension=="file_without_extension"){
				$p0 = strrpos($title, '.');		// remove extension
				if($p0>0){
					$title = substr($title, 0, $p0);
				}
			}

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

	if(function_exists('curl_init')){
		$ch=curl_init();									# try use cURL
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_MAXREDIRS, 3);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
		if(strpos($url, "https://")!==false) curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		$contents = curl_exec($ch);
		$http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
	}
	return $contents;
}

function sme_widget_files(){
	if(!function_exists('register_sidebar_widget') && !function_exists('wp_register_sidebar_widget'))
		return;

	function sme_widget($args){
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

	function control_option(){
		$options = get_option('sme_widget');
		if(!is_array($options))
			$options = array('title'=>'Storage Made Easy');

		if ( $_POST['sme_submit'] ) {
			$options['title'] = strip_tags(stripslashes($_POST['wpaypal-title']));			
			update_option('sme_widget', $options);
		}

		$title		= htmlspecialchars($options['title'], ENT_QUOTES);

		echo '<p style="text-align:left;"><label for="wpaypal-title">Title: <input style="width: 100%;" id="wpaypal-title" name="wpaypal-title" type="text" value="'.$title.'" /></label></p>';

		echo '<input type="hidden" id="wpaypal-submit" name="sme_submit" value="1" />';
	}

	if(function_exists('wp_register_sidebar_widget')){
		wp_register_sidebar_widget('sme_public_files_w1', 'StorageMadeEasy Files', 'sme_widget', array('description' => __('The StorageMadeEasy Multi-Cloud File Download plug-in enables you to share files for download. via a widget,  for over 10 cloud storage providers. These include Amazon S3, RackSpace Cloud Files, Box.net, Microsoft Live SkyDrive, Gmail, any POP3 or IMAP enabled email account, and any FTP server directory.')));
		wp_register_widget_control('sme_public_files_w1', 'StorageMadeEasy Files', 'control_option');
	}elseif(function_exists('register_sidebar_widget')){
		register_sidebar_widget('StorageMadeEasy Files', 'sme_widget');
		register_widget_control('StorageMadeEasy Files', 'control_option', 100, 100);
	}
}

add_action('plugins_loaded', 'sme_widget_files');
add_action('admin_menu', 'sme_tube_public_files');

function sme_tube_public_files(){
	add_menu_page('', 'SME Public Files', 8, __FILE__, 'sme_public_files');
	add_submenu_page(__FILE__, 'SME Files', 'SME Files', 8, __FILE__, 'sme_public_files');
}

?>