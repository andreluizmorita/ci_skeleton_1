<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * CSVReader
 *
 * @package		CodeIgniter
 * @author		Andr� Luiz Morita - andreluizmorita@gmail.com
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
 * @author		Andr� Luiz Morita - andreluizmorita@gmail.com
 * @link		https://github.com/andreluizmorita/ci_csvreader.git
 */
class CSVReader
{
    public function __construct()
	{
        log_message('debug', "Csvreader Class Initialized");
	} 
    
    /**
	 * O m�todo generate abre o arquivo reconhece os delimitadores e quebras de linhas
     * e retorna um array com os dados organizados conforma a estrutura do csv.
     * 
     * @param string $filePath local onde est� o arquivo csv para leitura.
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
                $line = str_replace('&ordm;', '�', $line);
                $line = str_replace('&ardm;', '�', $line);
                
                /*
                 * Corrige acentua��o
                 */
                $line = str_replace(array('&aacute;'), '�', $line);
                $line = str_replace('&Atilde;', '�', $line);
                $line = str_replace('&atilde;', '�', $line);
                $line = str_replace('&Aacute;', '�', $line);
                $line = str_replace('&Aacute;', '�', $line);
                $line = str_replace('&acirc;', '�', $line);
                $line = str_replace('&Acirc;', '�', $line);
                $line = str_replace(array('&eacute;','é'), '�', $line);
                $line = str_replace('&eacute;', '�', $line);
                $line = str_replace('&Eacute;', '�', $line);
                $line = str_replace('&iacute;', '�', $line);
                $line = str_replace('&Iacute;', '�', $line);
                $line = str_replace('&oacute;', '�', $line);
                $line = str_replace('&Oacute;', '�', $line);
                $line = str_replace('&uacute;', '�', $line);
                $line = str_replace('&Uacute;', '�', $line);
                $line = str_replace('&atilde;', '�', $line);
                $line = str_replace('&Atilde;', '�', $line);
                $line = str_replace('&otilde;', '�', $line);
                $line = str_replace('&Otilde;', '�', $line);
                $line = str_replace('&Ccedil;', '�', $line);
                $line = str_replace('&ccedil;', '�', $line);
                
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
