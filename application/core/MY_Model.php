<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * CodeIgniter MY_Model
 *
 * An open source application development framework for PHP 5.1.6 or newer
 * 
 * @author		André Luiz Morita - São Paulo, Brasil - andreluizmorita@gmail.com - @andreluizmorita
 * @since		Version 1.0
 * @license		GPL2 
 * 
 */

class MY_Model extends CI_Model
{
    /* --- Pertence a --- */
	protected $belongs_to = array();
    
    /*
     * Modelo para uso
        protected $belongs_to = array(
            array(<table_name_join>,<table_name_join_pk>,<table_foreign_key>)
        );
     * 
     */
    
	/* --- Possui um --- */
	protected $has_one = array();
	/* --- Possui muitos --- */
	protected $has_many = array();
	/* --- Possui e pertence a muitos --- */
	protected $has_and_belongs_to_many = array();	
    /* --- Nome da tabela de manipulação do modelo --- */
	public $table;
	/* --- Array para salvar ou atualizar dados de uma tabela --- */
    protected $data_save;
    
    /* --- Objeto com métodos do active record do Codeigniter --- */
    public $db;
    
    /* --- Inabilita os Joins --- */
    public $joins = TRUE;
    
    /* --- Habilita adição do nome da tabela como alias --- */
    protected $table_alias = array();
    
	public function __construct()
	{
		parent::__construct();
        
		log_message('debug', "MY_ORM_Model Class Initialized");
        
		$this->table = strtolower( str_replace(array('_model','model'),'',get_class($this)));
        
        $this->table_alias = array('active'=>TRUE,'delimiter'=>'_');
        
        $this->db = $this->load->database( ENVIRONMENT  . '_sistemaetapa', TRUE);
	}  
    
    public function table_alias($delimiter = '_', $active = TRUE)
    {
        $this->table_alias = array(
            'active'    => $active,
            'delimiter' => $delimiter
        );
    }
    
    private function belongs_to()
    {        
        if(count($this->belongs_to)>0)
        {
            if($this->table_alias['active'] == TRUE)
            {
                $fields = $this->db->field_data($this->table);
	
                foreach ($fields as $field)
                {
                    $this->db->select($this->table . '.' . $field->name . ' AS ' . $this->table . $this->table_alias['delimiter'] . $field->name, FALSE);
                }
            }
            
            foreach($this->belongs_to as $table_join)
            {
                if(is_array($table_join))
                {
                    $fields = $this->db->field_data($table_join[0]);
	
                    foreach ($fields as $field)
                    {
                        $this->db->select($table_join[0] . '.' . $field->name . ' AS ' . $table_join[0] . $this->table_alias['delimiter'] . $field->name, FALSE);
                    }
                    
                    $this->db->join($table_join[0],$table_join[0] . '.' .$table_join[1] . ' = ' . $this->table . '.' . $table_join[2]);
                }      
            }
        }   
    }
    
    public function __call($name, $where)
    {
        if(!is_array($where[0]))
        {
            $fields = $this->db->field_data($this->table);
	
			foreach ($fields as $field)
            {
				if($field->primary_key==1)
                {
					$this->db->where($field->name, $where[0]);
                    $primary_key = TRUE;
                }
            }
            
            if(!$primary_key)
            {
                $this->db->where('id', $where[0]);
            }
        }
        else
        {
            $this->db->where($where[0]);
        }
        
        $query = $this->db->get($this->table);
        
        if($query->num_rows()>0)
        {
            $result = $query->result();
            return $result[0]->$name;
        }
        else 
            return FALSE;
    }
    
    public function __set($name, $value)
    {
        $this->data_save[$name] = $value;
    }
    
    public function clear()
    {
        unset($this->data_save);
        
        $this->data_save = array();
    }
    
    public function database($name_connection)
	{
		$this->db = $this->load->database( ENVIRONMENT . '_' . $name_connection, TRUE);
	}
	
	public function save($id = NULL, $data = NULL)
	{   
        if(is_array($data) && count($this->data_save)>0)
        {
            $save_data = array_merge($data,$this->data_save);
        }
        elseif(is_array($data) && count($this->data_save) == 0)
        {
            $save_data = $data;
        }
        elseif(count($this->data_save) > 0)
        {
            $save_data = $this->data_save;
        }
        
        $this->db->set((array) $save_data);
        
        if($id == NULL)
        {
            $this->db->insert($this->table, (array) $this->data_save);
            
            return $this->db->affected_rows();
        }
        elseif(count($save_data)>0 && $id != NULL)
        {
            if(is_array($id))
            {
                foreach ($id as $key => $value) 
                {
                    $this->db->where($key, $value);
                }
            }
            else 
            {
                $fields = $this->db->field_data($this->table);
	
                foreach ($fields as $field)
                {
                    if($field->primary_key==1)
                    {
                        $this->db->where($field->name, $id);
                        $primary_key = TRUE;
                    }
                }

                if(!$primary_key)
                {
                    $this->db->where('id', $id);
                } 
            }
            
            
            $this->db->update($this->table);
            
            return $this->db->affected_rows();
        }
        
        $this->clear();
	}
	
    
	public function find($where = NULL, $options = array())
	{
        if($this->joins)
            $this->belongs_to();
        
		if( is_numeric($where) )
		{
			$fields = $this->db->field_data($this->table);
	
			foreach ($fields as $field)
				if($field->primary_key==1)
					$this->db->where($field->name, $where);
	
		}
		elseif( is_array($where) && count($where)>0 )
			$this->db->where($where);
		
		if(isset($options['limit']) && isset($options['offset']))
			$this->db->limit($options['limit'], $options['offset']);
		elseif(isset($options['limit']))
            if(isset($options['page']))
                $this->db->limit($options['limit'],$options['page']);
            else
                $this->db->limit($options['limit'],0);

		if(isset($options['order_by']))
            $this->db->order_by($options['order_by']);            
            
        $query = $this->db->get($this->table);
        $rows = $query->result();
        
        //echo '<pre>';
        //echo $this->db->last_query();
        //echo '</pre>';
		if(isset($options['return']) && $options['return'] == 'array'):
            
            if($query->num_rows()>0)
                return $query->result_array();
            else
                return FALSE;
			
        elseif(isset($options['return']) && $options['return'] == 'this'):
            
            if($query->num_rows()>0)
                return $rows[0];
            else
                return FALSE;
            
        elseif(isset($options['return']) && $options['return'] == 'count'):
            
            return $this->db->count_all_results($this->table);
        
        elseif(isset($options['return']) && $options['return'] == 'first'):
            
            if($query->num_rows()>0)
                return $rows[0];
            else
                return FALSE;
        
        elseif(isset($options['return']) && $options['return'] == 'last'):
            
            return $rows[count($rows)-1];
        
        else:
			return $rows;
        endif;
	}	
    
    public function find_this($where = NULL, $options = array())
    {
       return $this->find($where, array_merge($options, array('return'=>'this'))); 
    }
    
    public function find_all($options = array(),$tablename = "")
    {
        $tablename = $this->table;
        
        if(isset($options['limit']) && isset($options['offset']))
			$this->db->limit($options['limit'], $options['offset']);
		elseif(isset($options['limit']))
			$this->db->limit($options['limit'],0);
        
        $query = $this->db->get($tablename);
        return $query->result();
    }
    
	public function find_count($where = NULL, $options = array())
	{
        return $this->find($where, array_merge($options, array('return'=>'count'))); 
	}
    
	# --- CRUD TABLE DATA GATEWAY
	public function insert($data)
	{
		$this->db->insert($this->table,$data);
	
		return $this->db->affected_rows();
	}
    
    public function create()
    {
        $this->db->insert($this->table,$data);
	
		return $this->db->affected_rows();
    }
    
	public function update($where, $data = NULL)
	{
        $fields = $this->db->field_data($this->table);
        
        if(!is_array($where))
        {
            $fields = $this->db->field_data($this->table);
	
			foreach ($fields as $field)
            {
				if($field->primary_key==1)
                {
					$this->db->where($field->name, $where);
                    $primary_key = TRUE;
                }
            }
            
            if(!$primary_key)
                $this->db->where('id', $where);
        }
        else
        {
            $this->db->where($where);
        }
        
        if($data == NULL && count($this->data_save)>0)
            $this->db->set((array) $this->data_save);        
        else
            $this->db->set($data);
        
        $this->db->update($this->table);
                
		return $this->db->affected_rows();
	}
	
	public function delete($where)
	{
        $fields = $this->db->field_data($this->table);
        
        if(!is_array($where))
        {
            $fields = $this->db->field_data($this->table);
	
			foreach ($fields as $field)
            {
				if($field->primary_key==1)
                {
					$this->db->where($field->name, $where);
                    $primary_key = TRUE;
                }
            }
            
            if(!$primary_key)
                $this->db->where('id', $where);
        }
        else
        {
            $this->db->where($where);
        }
        
		$this->db->delete($this->table);
	
		return $this->db->affected_rows();
	}
	
	public function all($options = array())
	{
        if(!isset($options['limit']))
            $options['limit'] = 30;
        if(!isset($options['page']))
            $options['page'] = 0;
        
        $this->db->limit($options['limit'],$options['page']);
        
        return $this->find(NULL, $options); 
	}
    
    public function where($where_1, $where_2 = NULL)
    {
        if(is_array($where_1))
        {
            return $this->find($where_1);
        }
        elseif(is_null($where_2))
        {
            return $this->find($where_1);
        }
        else
        {
            return $this->find(array($where_1=>$where_2));
        }
    }
    
    public function pagination($where = NULL, $page = 0, $limit = 30 )
	{        
        return $this->find($where, array_merge($options = array(),array('limit'=>$limit,'page'=>$page)));
	}
	
	public function exists($where = array())
	{
        if(count($where)>0)
        {
            $this->db->where($where);
            $query = $this->db->get($this->table);

            if($query->num_rows()>0)
                return TRUE;
            else
                return FALSE;
        }
        else 
        {
            return FALSE;    
        }
	}
    
    public function check($where = array())
    {
        return $this->exists($where);
    }
	
	public function first($where = NULL, $options = array())
	{
		return $this->find($where, array_merge($options,array('return'=>'first'))); 
	}
	
	public function last($where = NULL, $options = array())
	{
		return $this->find($where, array_merge($options,array('return'=>'last'))); 
	}
	
	public function count_all()
	{
        return $this->db->count_all_results($this->table);
	}

	
	/**
	 * Define os dados obrigatórios no vetor que é passado para cada um dos modelos
	 *
	 * @param array $required			|required
	 * @param array $data 				|required
	 * @result bool
	 *
	 */
	protected function _required($required , $data)
	{
		foreach($required as $field)
			if(!isset($data[$field]) || $data[$field] == '')
			{
				log_message('Error','  Severity: Warning  --> O campo requirido no model nao foi encontrado no array');
				return true;
			}
					
		return false;	
	}
	
	/**
	 * @description Define um valor padrão para campos obrigatórios
	 *
	 * @param array $defaults			|required
	 * @param array $options			|required
	 * @result bool
	 *
	 */
	protected function _default($defaults,$options)
	{
		return array_merge($defaults,$options);
	}
    
    public function generate_log()
    {
        
    }
}
