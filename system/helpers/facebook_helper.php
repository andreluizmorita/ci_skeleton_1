<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if( !function_exists('config_facebook') )
{
	function config_facebook()
	{
		$CI =& get_instance();
		$pre = $CI->config->item('subclass_prefix');
		
		$CI->load->config( $pre . 'facebook');
		
		return $CI->config->item('facebook');
	}
}


if( !function_exists('facebook') )
{
	function facebook($id = NULL )
	{
		if(is_null($id))
		{
			$option = config_facebook();
			$id = $option['app_id'];
		}		
		
		$script_id = 
			'<div id="fb-root"></div>
		 		<script>(function(d, s, id) {
			 		var js, fjs = d.getElementsByTagName(s)[0];
			  		if (d.getElementById(id)) {return;}
			  			js = d.createElement(s); js.id = id;
				  		js.src = "//connect.facebook.net/pt_BR/all.js#xfbml=1&appId='.$id.'";
			  			fjs.parentNode.insertBefore(js, fjs);
					}(document, "script", "facebook-jssdk"));
		   	 	</script>';
		
		return $script_id;
	}

}

if(!function_exists('facebook_like') )
{
	function facebook_like( $url = NULL, $option = NULL)
	{
		if($option == null)
			$option = config_facebook();

		if($url == null):
			$option = config_facebook();
			$url = $option['url'];
		endif;
		
	   	//checking layout
/* 		if($option['layout']=='standard'){
			if($option['show_faces']=='true')
	       		$height='80';
	     	else
	       		$height='35';
	     	
	   	}else if($option['layout']=='box_count'){
	     	$height='65';
	   	}else if($option['layout']=='button_count'){
	     	$height='21';
	   	}else{
	     	$option['layout']='standard';
	     	$height='35';
	   	} */
	   	
	   	$like = facebook($option['app_id']).
	   		    '<fb:like href="'.$url.'" layout="'.$option['layout'].'" action="'.$option['action'].'" send="'.$option['send'].'" width="'.$option['width_like'].'" show_faces="'.$option['show_faces'].'" font="'.$option['font'].'" colorscheme="'.$option['color'].'"></fb:like>';
	   
	   	return $like;
	}
}

if(!function_exists('facebook_comment'))
{
	function facebook_comment($option = null)
	{	
		if($option == null)
			$option = config_facebook();
		
		$comment = facebook($option['app_id']).
			       '<fb:comments href="'.$option['url'].'" num_posts="'.$option['num_post'].'" width="'.$option['width_comment'].'" colorscheme="'.$option['color'].'"></fb:comments>';
		
		return $comment;
	}
}

if(!function_exists('facebook_send'))
{
	function facebook_send( $url = NULL, $option = NULL)
	{
		if($option == null)
			$option = config_facebook();
		
		if($url == null):
			$option = config_facebook();
			$url = $option['url'];
		endif;
		
		$send = facebook($option['app_id']).
				'<fb:send href="'.$url.'" colorscheme="'.$option['color'].'"  font="'.$option['font'].' " ></fb:send>';
		
		return $send;
	}
}


if(!function_exists('facebook_feeds'))
{
	function facebook_feeds($option = null)
	{
		if($option == null)
			$option = config_facebook();
		
		$feeds = facebook($option['app_id']).
				 '<fb:activity site="'.$option['url'].'" width="'.$option['width_feeds'].'" height="'.$option['height_feeds'].'" header="'.$option['header_feeds'].'" border_color="'.$option['border'].'" font="'.$option['font'].'" recommendations="'.$option['recommend'].'"></fb:activity>';
		
		return $feeds;
	}	
	
}

if(!function_exists('facebook_facepile'))
{
	function facebook_facepile($option = null)
	{
		if($option == null)
			$option = config_facebook();
		
		$facepile = facebook($option['app_id']).
					'<fb:facepile href="'.$option['url'].'" size="'.$option['size'].'" width="'.$option['width'].'" max_rows="'.$option['rows_pile'].'" colorscheme="'.$option['color'].'"></fb:facepile>';
		
		return $facepile;
	}
}
if(!function_exists('facebook_box'))
{
	function facebook_box($option = null)
	{
		if($option == null)
			$option = config_facebook();
		
		$face_box = facebook($option['app_id']).
					'<fb:like-box href="'.$option['face_page'].'" width="'.$option['width_box'].'" show_faces="'.$option['face_box'].'" stream="'.$option['stream_box'].'" header="'.$option['header_box'].'"  colorscheme="'.$option['color'].'"></fb:like-box>';
		
		return $face_box;
	}
}
if(!function_exists('facebook_login'))
{
	function facebook_login($option = null)
	{
		if($option == null)
			$option = config_facebook();
		
		$login = facebook($option['app_id']).
				 '<fb:login-button show-faces="'.$option['face_login'].'" width="'.$option['width_login'].'" max-rows="'.$option['rows_login'].'"></fb:login-button>';
		
		return $login;
	}
}

if(!function_exists('facebook_fanpage'))
{
	function facebook_fanpage($option = null)
	{
		if($option == null)
			$option = config_facebook();
		
		$fan = facebook($option['app_id']).
				'<fb:fan profile_id="'.$option['id_fan'].'" width="'.$option['width_fan'].'" height="'.$option['height_fan'].'" show_faces="'.$option['face_fan'].'" stream="'.$option['stream_fan'].'" header="'.$option['header_fan'].'" css="'.$option['css_fan'].'" connections="'.$option['connections'].'"></fb:fan>';
		
		return $fan;
	}
}

?>