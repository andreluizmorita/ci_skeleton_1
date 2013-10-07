<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * CodeIgniter
 *
 * An open source application development framework for PHP 5.1.6 or newer
 *
 * @package		CodeIgniter
 * @author		ExpressionEngine Dev Team
 * @copyright	Copyright (c) 2008 - 2011, EllisLab, Inc.
 * @license		http://codeigniter.com/user_guide/license.html
 * @link		http://codeigniter.com
 * @since		Version 1.0
 * @filesource
 */

// ------------------------------------------------------------------------

/**
 * CodeIgniter Path Helpers
 *
 * @package		CodeIgniter
 * @subpackage	Helpers
 * @category	Helpers
 * @author		ExpressionEngine Dev Team
 * @link		http://codeigniter.com/user_guide/helpers/xml_helper.html
 */

// ------------------------------------------------------------------------

/**
 * Set Realpath
 *
 * @access	public
 * @param	string
 * @param	bool	checks to see if the path exists
 * @return	string
 */
if ( ! function_exists('set_realpath'))
{
	function set_realpath($path, $check_existance = FALSE)
	{
		// Security check to make sure the path is NOT a URL.  No remote file inclusion!
		if (preg_match("#^(http:\/\/|https:\/\/|www\.|ftp|[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3})#i", $path))
		{
			show_error('The path you submitted must be a local server path, not a URL');
		}

		// Resolve the path
		if (function_exists('realpath') AND @realpath($path) !== FALSE)
		{
			$path = realpath($path).'/';
		}

		// Add a trailing slash
		$path = preg_replace("#([^/])/*$#", "\\1/", $path);

		// Make sure the path exists
		if ($check_existance == TRUE)
		{
			if ( ! is_dir($path))
			{
				show_error('Not a valid path: '.$path);
			}
		}

		return $path;
	}
}

##################################################
##		ATEN��O PARA ATUALIZAR O FRAMEWORK		##
##################################################

// application/helpers/path_helper.php
if ( ! function_exists('asset_url') )
{
	function asset_url( $path = null)
	{
		// the helper function doesn't have access to $this, so we need to get a reference to the
		// CodeIgniter instance.  We'll store that reference as $CI and use it instead of $this
		$CI =& get_instance();

		if( is_null($path) )
		// return the asset_url
		return base_url() . $CI->config->item('asset_path');
		else
		return base_url() . $CI->config->item('asset_path') . $path;
	}
}

/* End of file path_helper.php */
/* Location: ./system/helpers/path_helper.php */