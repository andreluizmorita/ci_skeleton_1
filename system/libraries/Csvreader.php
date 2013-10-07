<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * CSVReader
 *
 * @package		CodeIgniter
 * @author		André Luiz Morita - andreluizmorita@gmail.com
 * @license		open source
 * @link		https://github.com/andreluizmorita/ci_csvreader.git
 * @since		Version 1.0
 * @filesource
 */


/**
 * CSV Reader
 *
 * @package		CodeIgniter
 * @subpackage	Libraries
 * @category	CSV Reader
 * @author		André Luiz Morita - andreluizmorita@gmail.com
 * @link		https://github.com/andreluizmorita/ci_csvreader.git
 */
class CSVReader
{
    public function __construct()
	{
        log_message('debug', "Csvreader Class Initialized");
	} 
    
    /**
	 * O método generate abre o arquivo reconhece os delimitadores e quebras de linhas
     * e retorna um array com os dados organizados conforma a estrutura do csv.
     * 
     * @param string $filePath local onde está o arquivo csv para leitura.
     */
    public function generate($filePath, $delimiter_set = NULL)
    {
        $handle = @fopen($filePath, "r");
        
        if ($handle) 
        {
            $line=fgets($handle, 4096);
            fclose($handle); 
            
            /*
             * Ajusta quebras de linhas para csv gerados no Mac ou Window e reconhece
             * qual o separador foi usado para gerar esse csv
             */
            if(is_null($delimiter_set))
            {
                if (count(explode(',', $line))>1) $delimiter = ',';
            
                if (count(explode(';', $line))>1) $delimiter = ';';
            }
            else
            {
                $delimiter = $delimiter_set;
            }
            
            if (count(explode("\r", $line))>1) $break_line = "\r";

            if (count(explode("\n", $line))>1) $break_line = "\n";

            if (count(explode("\r\n", $line))>1) $break_line = "\r\n";
                       
            $lines = file($filePath);
            
            $content = '';
            
            foreach( $lines as $line_num => $line ) 
            {
                $line = htmlentities($line);
                
                /*
                 * 
                 */
                $line = str_replace('&ordm;', '°', $line);
                $line = str_replace('&ardm;', 'ª', $line);
                
                /*
                 * Corrige acentuação
                 */
                $line = str_replace(array('&aacute;'), 'á', $line);
                $line = str_replace('&Atilde;', 'Â', $line);
                $line = str_replace('&atilde;', 'ã', $line);
                $line = str_replace('&Aacute;', 'Á', $line);
                $line = str_replace('&Aacute;', 'Á', $line);
                $line = str_replace('&acirc;', 'â', $line);
                $line = str_replace('&Acirc;', 'Â', $line);
                $line = str_replace(array('&eacute;','Ã©'), 'é', $line);
                $line = str_replace('&eacute;', 'é', $line);
                $line = str_replace('&Eacute;', 'É', $line);
                $line = str_replace('&iacute;', 'í', $line);
                $line = str_replace('&Iacute;', 'Í', $line);
                $line = str_replace('&oacute;', 'ó', $line);
                $line = str_replace('&Oacute;', 'Ó', $line);
                $line = str_replace('&uacute;', 'ú', $line);
                $line = str_replace('&Uacute;', 'Ú', $line);
                $line = str_replace('&atilde;', 'ã', $line);
                $line = str_replace('&Atilde;', 'Ã', $line);
                $line = str_replace('&otilde;', 'õ', $line);
                $line = str_replace('&Otilde;', 'Õ', $line);
                $line = str_replace('&Ccedil;', 'Ç', $line);
                $line = str_replace('&ccedil;', 'ç', $line);
                
                if( $line != '' )
                { 
                    $elements = explode($delimiter, $line);

                    if( !is_array($content) ) 
                    { 
                        $elements = str_replace("\r\n", '', $elements);
                        $elements = str_replace("\n", '', $elements);
                        $elements = str_replace("\r", '', $elements);
                        
                        $this->fields = $elements;
                        $content = array();
                    } 
                    else 
                    {
                        $item = array();

                        foreach( $this->fields as $id => $field ) 
                        {
                            if( isset($elements[$id]) ) 
                            {
                                $item[$field] = $elements[$id];
                            }
                        }
                        $content[] = $item;
                    }
                }
            }
            return $content;
        } 
    }
}
