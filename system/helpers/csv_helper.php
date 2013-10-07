<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

// ------------------------------------------------------------------------

/**
 * CSV Helpers
 * Inspiration from PHP Cookbook by David Sklar and Adam Trachtenberg
 * 
 * @author		JÃ©rÃ´me Jaglale
 * @link		http://maestric.com/en/doc/php/codeigniter_csv
 */

// ------------------------------------------------------------------------

/**
 * Array to CSV
 *
 * download == "" -> return CSV string
 * download == "toto.csv" -> download file toto.csv
 */
if ( ! function_exists('array_to_csv'))
{
	function array_to_csv($array_or_object, $download = "")
	{
        if ($download != "")
		{	
			header('Content-Type: application/csv');
			header('Content-Disposition: attachement; filename="' . $download . '"');
		}
        
        ob_start();
		$f = fopen('php://output', 'w') or show_error("Can't open php://output");
		$n = 0;	
        
        if(is_object($array_or_object))
        {
            
        }
        elseif(is_array($array_or_object))
        {
            foreach ($array_or_object as $line)
            {
                $n++;
                if ( ! fputcsv($f, $line,";"))
                {
                    show_error("Can't write line $n: $line");
                }
            }
        }
		
		fclose($f) or show_error("Can't close php://output");
		$str = ob_get_contents();
		ob_end_clean();

		if ($download == "")
		{
			return $str;	
		}
		else
		{	
			echo $str;
		}		
	}
}

// ------------------------------------------------------------------------

/**
 * Query to CSV
 *
 * download == "" -> return CSV string
 * download == "toto.csv" -> download file toto.csv
 */
if ( ! function_exists('query_to_csv'))
{
	function query_to_csv($query, $headers = TRUE, $download = "")
	{
		if ( ! is_object($query) OR ! method_exists($query, 'list_fields'))
		{
			show_error('Não foi possível gerar o CSV!!!.');
		}
		
		$array = array();
		
		if ($headers)
		{
			$line = array();
			foreach ($query->list_fields() as $name)
			{
				$line[] = $name;
			}
			$array[] = $line;
		}
		
		foreach ($query->result_array() as $row)
		{
			$line = array();
			foreach ($row as $item)
			{
				$line[] = $item;
			}
			$array[] = $line;
		}

		echo array_to_csv($array, $download);
	}
}

/* End of file csv_helper.php */
/* Location: ./system/helpers/csv_helper.php */