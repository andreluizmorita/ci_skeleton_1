<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| Facebook helper Config
|--------------------------------------------------------------------------
|
*/

$config['facebook'] = array(
	// --- Common
	'app_id'		=> '',
	'font' 			=>'tahoma',				// lucida grande / tahoma / arial / segoe ui / trebuchet ms / verdana
	'color'			=>'light',  			// light / dark

	// --- Like
	'layout'		=> 'standard', 			// standard / button_count
	'show_faces'	=> 'false', 			// true / false
	'send' 			=> 'true',				// true / false
	'width_like'	=> '450',

	// --- Comments
	'url'			=> '',
	'width_comment' => '400', 
	'action'		=> 'like', 				// like / recommend
	'num_post'		=> '5',

	// --- Feeds
	'width_feeds'   => '300',
	'height_feeds'  => '300',
	'border'		=> '', 					// red / blue ... or #ccc #eee ... or null
	'recommend'		=> 'true',				// show recommend in feeds?    true / false
	'header_feeds'	=> 'true',				// true / false
	'linktarget'    => '_top',				// _top / _blank / _parent

	// --- Facepile
	'size'			=> 'small',				// small / large
	'rows_pile'		=> '1',

	// --- Box
	'face_page'		=> '', 
	'width_box'		=> '300',
	'face_box'		=> 'true',				// true / false
	'header_box'	=> 'true',				// true / false
	'stream_box'	=> 'false',				// true / false

	// --- Fan
	'id_fan'		=> '',
	'connections'	=> '15',
	'css_fan'		=> '' ,					// Link Custom css requer um id de API e um nome diferente de css para cada nova atualização
	'header_fan'	=> 'true',
	'width_fan'		=> '300',
	'height_fan'	=> '800',
	'face_fan'		=> 'true',
	'stream_fan'	=> 'true',

	// --- Login
	'face_login' 	=> 'true',				// true / false
	'width_login' 	=> '200',
	'rows_login'	=> '1'		
);

/* End of file facebook.php */
/* Location: ./application/config/facebook.php */