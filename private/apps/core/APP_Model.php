<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

 
class APP_Model extends MY_Model
{
    protected $_db;

    protected $eliminate_field  = array();
    
    protected $cols            = array();
    protected $arrDecimalCols  = array();
    protected $arrDateCols     = array();
    protected $arrIntCols      = array();

    protected $compareCols1  = '';
    protected $compareCols2  = 'users_id';

    protected $soft_delete_key = 'is_deleted';

    public $before_create   = array( 'added_time' );
    public $before_update   = array( 'updated_time' );
    public $before_delete   = array( 'deleted_time' );

    protected $_where_params = FALSE;

    public $_selected_col = array();

    protected $dt_grouped   = NULL;

    /**
     * Initialise the controller, tie into the CodeIgniter superobject
     * and try to autoload the models and helpers
     */
    public function __construct()
    {
        $this->_set_database();

        parent::__construct();
    }

    protected function added_time($data)
    {
        $users_id    = $this->session->userdata('users_id');
        
        if($users_id && !empty($users_id) && !is_null($users_id)) $data['_created_by'] = $users_id;
        $data['_created_at'] = time();
        return $data;
    }

    protected function updated_time($data)
    {
        $users_id    = $this->session->userdata('users_id');
        if($users_id && !empty($users_id) && !is_null($users_id)) $data['_updated_by'] = $users_id;
        $data['_updated_at'] = time();

        if(isset($data['status']))
        {
            if($data['status'] == 10)
            {
                $data['is_deleted'] = 1;
            }
            else
            {
                $data['is_deleted'] = 0;
            }
        }
        return $data;
    }

    protected function deleted_time($data)
    {
        if($this->soft_delete == TRUE)
        {
            $users_id    = $this->session->userdata('users_id');
            
            if($users_id && !empty($users_id) && !is_null($users_id)) $data['_updated_by'] = $users_id;
            $data['status'] = 10;
            $data['_updated_at'] = time();
        }
        return $data;
    }

    protected function _filter_data($data)
    {
        $filtered_data = array();
        $columns = $this->_database->list_fields($this->_table);

        if (is_array($data))
        {
            foreach ($columns as $column)
            {
                if (array_key_exists($column, $data))
                    $filtered_data[$column] = $data[$column];
            }
        }

        return $filtered_data;
    }

    protected function filter_selected_field()
    {
        $this->_database->select($this->eliminate_field());
    }

    protected function eliminate_field($cols=array())
    {
        $filtered_data = (((is_array($cols) && (count($cols)) >= 1) || !empty($cols)) ? $cols : $this->eliminate_select);
        $columns = $this->_database->list_fields($this->_table);
        $field  = '';

        if(!is_array($filtered_data))
        {
            $filtered_data  = explode(',', $filtered_data);
        }

        foreach ($columns as $column)
        {
            if (!in_array($column, $filtered_data))
                $field  .= $column.',';
        }
        return rtrim($field, ',');
    }

    private function _set_database()
    {
        //we'll read the config file later
        if ($this->_db == null )
        {
            $this->db = $this->load->database('default', TRUE);
        }    
        else
        {
            $this->db = $this->load->database($this->_db, TRUE);
        }
    }

    public function datatables_customize_all()
    {

    }

    public function datatables_customize_filtered()
    {

    }

    public function datatables_filter($keyword,$columns)
    {
        if($keyword)
        {
            $this->_database->group_start();
            foreach ($columns as $idxCol => $column)
            {
                if($column['searchable'] == "true")
                {
                    $this->_database->or_like($column['data'],$keyword);
                }
            }
            $this->_database->group_end();
        }

        if(isset($columns))
        {
            foreach ($columns as $idxCol => $column)
            {
                if(!empty($column['search']['value']) && !is_null($column['search']['value']) && $column['search']['value'] <> "" && strlen($column['search']['value']) > 0)
                {
                    $this->_database->group_start();
                    $this->_database->where($this->table().'.'.$column['data'],$column['search']['value']);
                    $this->_database->group_end();
                }
            }
        }

        if($this->dt_grouped <> NULL)
        {
            $this->_database->group_by($this->dt_grouped);
        }
    }

    public function datatables_filter_limited($keyword,$columns)
    {
        $this->datatables_filter($keyword,$columns);
    }

    public function datatables_order($columns,$orders)
    {
        if($orders)
        {
            foreach ($orders as $idxOrd => $order)
            {
                if($columns[$order['column']]['orderable'] == "true")
                {
                    $this->_database->order_by($columns[$order['column']]['data'], $order['dir']);
                }
            }
        }
    }

    public function datatables_populated($get_filtered_data)
    {
        if($get_filtered_data && count($get_filtered_data) > 0)
        {
            foreach ($get_filtered_data as $idxRow => $row)
            {
                $return[$idxRow]                    = $row;
                $return[$idxRow]->DT_RowId          = 'row_'.$row->{$this->primary_key};
                $return[$idxRow]->DT_RowData        = new stdClass();
                $return[$idxRow]->DT_RowData->pkey  = $row->{$this->primary_key};
            }
            return $return;
        }
        return array();
    }

    public function datatables($condition=NULL)
    {
        $columns        = $this->input->get_post('columns');
        $keyword        = $this->input->get_post('search')['value'];
        $offset         = $this->input->get_post('start');
        $limit          = $this->input->get_post('length');
        $orders         = $this->input->get_post('order');
        $ordersTotal    = count($orders);
        $searchCount    = 0;
        $return['draw'] = $this->input->get_post('draw');

        $this->datatables_customize_filtered();        
        $this->datatables_filter($keyword,$columns);
        $this->datatables_order($columns,$orders);
        $this->_database->limit($limit, $offset);
        $get_filtered_data  = (($condition == NULL) ? $this->get_all() : $this->get_many_by($condition));
        $return['sql1'] = $this->db->last_query();

        $this->datatables_customize_all();        
        $this->datatables_filter($keyword,$columns);
        $return['recordsFiltered']  = count(($condition == NULL) ? $this->get_all() : $this->get_many_by($condition));
        $return['sql2'] = $this->db->last_query();

        $this->datatables_customize_all();        
        $return['recordsTotal'] = count(($condition == NULL) ? $this->get_all() : $this->get_many_by($condition));
        $return['sql3'] = $this->db->last_query();

        $return['data'] = $this->datatables_populated($get_filtered_data);
        return $return;
    }

    /**
     * Fetch a single record based on an arbitrary WHERE call. Can be
     * any valid value to $this->_database->where().
     */
    public function get_by()
    {
        $where = func_get_args();

        if ($this->soft_delete && $this->_temporary_with_deleted !== 1)
        {
            $this->_database->where($this->_table.'.'.$this->soft_delete_key, $this->_temporary_only_deleted);
        }

        $this->_set_where($where);

        $this->trigger('before_get');

        $row = $this->_database->get($this->_table)
                        ->{$this->_return_type()}();
        $this->_temporary_return_type = $this->return_type;

        $row = $this->trigger('after_get', $row);

        $this->_with = array();
        return $row;
    }

    /**
     * Fetch all the records in the table. Can be used as a generic call
     * to $this->_database->get() with scoped methods.
     */
    public function get_all()
    {
        $this->trigger('before_get');

        if ($this->soft_delete && $this->_temporary_with_deleted !== 1)
        {
            $this->_database->where($this->_table.'.'.$this->soft_delete_key, $this->_temporary_only_deleted);
        }

        $result = $this->_database->get($this->_table)
                           ->{$this->_return_type(1)}();
        $this->_temporary_return_type = $this->return_type;

        foreach ($result as $key => &$row)
        {
            $row = $this->trigger('after_get', $row, ($key == count($result) - 1));
        }

        $this->_with = array();
        return $result;
    }

    /**
     * Delete a row from the database table by an arbitrary WHERE clause
     */
    /*public function delete_by()
    {
        $where = func_get_args();

        $where = $this->trigger('before_delete', $where);

        $this->_set_where($where);


        if ($this->soft_delete)
        {
            $result = $this->_database->update($this->_table, array( $this->_table.'.'.$this->soft_delete_key => 1 ));
        }
        else
        {
            $result = $this->_database->delete($this->_table);
        }

        $this->trigger('after_delete', $result);

        return $result;
    }*/

    /**
     * Delete many rows from the database table by multiple primary values
     */
    /*public function delete_many($primary_values)
    {
        $primary_values = $this->trigger('before_delete', $primary_values);

        $this->_database->where_in($this->primary_key, $primary_values);

        if ($this->soft_delete)
        {
            $result = $this->_database->update($this->_table, array( $this->_table.'.'.$this->soft_delete_key => 1 ));
        }
        else
        {
            $result = $this->_database->delete($this->_table);
        }

        $this->trigger('after_delete', $result);

        return $result;
    }*/

    /**
     * Delete a row from the table by the primary value
     */
    /*public function delete($id)
    {
        $this->trigger('before_delete', $id);

        $this->_database->where($this->primary_key, $id);

        if ($this->soft_delete)
        {
            $data[$this->soft_delete_key]   = 1;
            $result = $this->_database->update($this->_table, array( $this->_table.'.'.$this->soft_delete_key => 1 ));
        }
        else
        {
            $result = $this->_database->delete($this->_table);
        }

        $this->trigger('after_delete', $result);

        return $result;
    }*/

    /**
     * Set WHERE parameters, cleverly
     */
    protected function _set_where($params)
    {//echo "<pre>";print_r($params);echo "</pre>";//exit;
        if (count($params) == 1 && is_array($params[0]))
        {
            foreach ($params[0] as $field => $filter)
            {
                if (is_array($filter))
                {
                    $this->_database->where_in($this->_table.'.'.$field, $filter);
                }
                else
                {
                    if (is_int($field))
                    {
                        $this->_database->where($filter);
                    }
                    else
                    {
                        $this->_database->where($this->_table.'.'.$field, $filter);
                    }
                }
            }
        } 
        else if (count($params) == 1)
        {
            $this->_database->where($params[0]);
        }
        else if(count($params) == 2)
        {
            if (is_array($params[1]))
            {
                $this->_database->where_in($params[0], $params[1]);    
            }
            else
            {
                $this->_database->where($params[0], $params[1]);
            }
        }
        else if(count($params) == 3)
        {
            $this->_database->where($params[0], $params[1], $params[2]);
        }
        else
        {
            if (isset($params[1]) && is_array($params[1]))
            {
                $this->_database->where_in($params[0], $params[1]);    
            }
            else
            {
                $this->_database->where($params[0], $params[1]);
            }
        }
    }

    /**
     * Retrieve and generate a form_dropdown friendly array
     */
    function dropdown()
    {
        $args = func_get_args();

        if(count($args) == 2)
        {
            list($key, $value) = $args;
        }
        else
        {
            $key = $this->primary_key;
            $value = $args[0];
        }

        $this->trigger('before_dropdown', array( $key, $value ));

        if ($this->soft_delete && $this->_temporary_with_deleted !== 1)
        {
            $this->_database->where($this->_table.'.'.$this->soft_delete_key, 0);
        }

        $result = $this->_database->select(array($key, $value))
                           ->get($this->_table)
                           ->result();

        $options = array();

        foreach ($result as $row)
        {
            $options[$row->{$key}] = $row->{$value};
        }

        $options = $this->trigger('after_dropdown', $options);

        return $options;
    }

    /**
     * Fetch a count of rows based on an arbitrary WHERE call.
     */
    public function count_by()
    {
        if ($this->soft_delete && $this->_temporary_with_deleted !== 1)
        {
            $this->_database->where($this->_table.'.'.$this->soft_delete_key, $this->_temporary_only_deleted);
        }

        $where = func_get_args();
        $this->_set_where($where);

        return $this->_database->count_all_results($this->_table);
    }

    /**
     * Fetch a total count of rows, disregarding any previous conditions
     */
    public function count_all()
    {
        if ($this->soft_delete && $this->_temporary_with_deleted !== 1)
        {
            $this->_database->where($this->_table.'.'.$this->soft_delete_key, $this->_temporary_only_deleted);
        }

        return $this->_database->count_all($this->_table);
    }

    public function get_field_table()
    {
        return $this->_database->list_fields($this->_table);
    }
} 