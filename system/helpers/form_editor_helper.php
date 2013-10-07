<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

if ( !function_exists('form_fckeditor'))
{

	function form_ckeditor($data = '', $value = '', $extra = '')
	{
	    $CI =& get_instance();
	
	    $fckeditor_basepath = $CI->config->item('ckeditor_basepath');
	    
	    require_once( $_SERVER["DOCUMENT_ROOT"] . $fckeditor_basepath. 'ckeditor.php' );
	    
	    $instanceName = ( is_array($data) && isset($data['name'])  ) ? $data['name'] : $data;
	    $fckeditor = new CKeditor($instanceName);
	    
	    
	    
	    
	        $fckeditor->Value = html_entity_decode($value);
	        $fckeditor->BasePath = $fckeditor_basepath;
	        if( $fckeditor_toolbarset = $CI->config->item('ckeditor_toolbarset_default'))
	                $fckeditor->ToolbarSet = $fckeditor_toolbarset;
	        
	        if( is_array($data) )
	        {
	            if( isset($data['value']) )
	                $fckeditor->Value = html_entity_decode($data['value']);
	            if( isset($data['basepath']) )
	                $fckeditor->BasePath = $data['basepath'];
	            if( isset($data['toolbarset']) )
	                $fckeditor->ToolbarSet = $data['toolbarset'];
	            if( isset($data['width']) )
	                $fckeditor->Width = $data['width'];
	            if( isset($data['height']) )
	                $fckeditor->Height = $data['height'];
	        }        
	        
	        return $fckeditor->CreateHtml();
	    
	}
}


/* End of file form_editor.php */
/* Location: ./system/helpers/form_editor.php */