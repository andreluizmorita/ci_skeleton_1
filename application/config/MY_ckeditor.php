<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| CKEditor Folder
|--------------------------------------------------------------------------
*/
$config['ckeditor_path']  = 'assets/ckeditor/';

/*
|--------------------------------------------------------------------------
| CKEditor Toolbar Set Default
|--------------------------------------------------------------------------
*/

$config['ckeditor_toolbar_01']	= array(
	//array('Source', '-','Save','NewPage','DocProps','Preview','Print' ),
    array('Save'),
    array('NumberedList','BulletedList'),
    array( 'Link','Unlink', 'Anchor','Table' ),
	array('Cut','Copy','Paste','PasteText','PasteFromWord','-','Undo','Redo'),
	//array('Image','Flash','Table','HorizontalRule','Smiley','SpecialChar','PageBreak','Iframe', 'Link', 'Unlink', 'Anchor'),
	//array('Find','Replace','-','SelectAll','-','SpellChecker', 'Scayt'),
	array('TextColor','BGColor','Maximize'),			
	//array('NumberedList','BulletedList','-','Outdent','Indent','-','Blockquote','CreateDiv','-','JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock','-','BidiLtr','BidiRtl'),
	array('Bold','Italic','Underline','Strike','Subscript','Superscript','-','RemoveFormat'),
	//array('Styles','Format','Font','FontSize','Maximize', 'ShowBlocks','-','About')
);

/*
|--------------------------------------------------------------------------
| MODELO PARA TOOLBARS
|--------------------------------------------------------------------------
*/
$config['ckeditor_toolbar_02'] = array(
	array(),
	array()
);

/*
|--------------------------------------------------------------------------
| CKFinger Folder
|--------------------------------------------------------------------------
*/
$config['ckfinger_path'] = '../../../assets/ckfinder/';

/* ------------------------------------------------------------------------
 * Option Ckeditor toolbars
 * ------------------------------------------------------------------------

	config.toolbar_Full =
	[
		{ name: 'document', items : [ 'Source','-','Save','NewPage','DocProps','Preview','Print','-','Templates' ] },
		{ name: 'clipboard', items : [ 'Cut','Copy','Paste','PasteText','PasteFromWord','-','Undo','Redo' ] },
		{ name: 'editing', items : [ 'Find','Replace','-','SelectAll','-','SpellChecker', 'Scayt' ] },
		{ name: 'forms', items : [ 'Form', 'Checkbox', 'Radio', 'TextField', 'Textarea', 'Select', 'Button', 'ImageButton','HiddenField' ] },
		'/',
		{ name: 'basicstyles', items : [ 'Bold','Italic','Underline','Strike','Subscript','Superscript','-','RemoveFormat' ] },
		{ name: 'paragraph', items : [ 'NumberedList','BulletedList','-','Outdent','Indent','-','Blockquote','CreateDiv','-','JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock','-','BidiLtr','BidiRtl' ] },
		{ name: 'links', items : [ 'Link','Unlink','Anchor' ] },
		{ name: 'insert', items : [ 'Image','Flash','Table','HorizontalRule','Smiley','SpecialChar','PageBreak','Iframe' ] },
		'/',
		{ name: 'styles', items : [ 'Styles','Format','Font','FontSize' ] },
		{ name: 'colors', items : [ 'TextColor','BGColor' ] },
		{ name: 'tools', items : [ 'Maximize', 'ShowBlocks','-','About' ] }
	];

*/

/* End of file ckeditor.php */
/* Location: ./application/config/ckeditor.php */