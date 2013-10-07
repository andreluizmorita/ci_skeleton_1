<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| Pasta padrão asset_path
|--------------------------------------------------------------------------
|
| Define uma pasta padrão para arquivos como css, javascript, imagens que
| pode ser chamado usando o helper asset_url() 
|
*/

$config['asset_path'] = 'home_site/assets/';
	
	/*
	|----------------------------------------------------------------------
	| Pasta de Javascript, Stylesheet e image na pasta $config['asset_path']
	|----------------------------------------------------------------------
	*/
	$config['js_folder']     = 'js/';
	$config['css_folder']    = 'css/';
	$config['img_folder']    = 'images/';	
	$config['thumb_folder']  = $config['img_folder'].'/thumbs/';
    $config['qrcode_folder'] = 'qrcode/';
    $config['upload_folder'] = 'upload/';
	
/* End of file assets.php */
/* Location: ./application/config/assets.php */