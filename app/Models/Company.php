<?php

namespace App\Models;

class Company extends Model {
    public $_table = 'company';
    public function __construct()
    {
        parent::__construct();
    }

    public function getData($id = null)
    {
        $rs = $this->table($this->_table);
        if (!empty($id)) {
            $rs = $rs->where('id',$id);
        }else{
            if(session('role_id')==1){
                $rs = $this->table($this->_table);
            }else{
                $rs = $rs->where('is_active','1');
            }
        }
        return $rs; //->fetchAll();
    }

    public function insertData($inputs)
    {
        return $this->table($this->_table)->insert($inputs,'prepared');
    }

    public function destroy(?int $id)
    {
        return $this->table($this->_table,$id)->delete();
    }

    public function updateData(array $data, $id)
    {
        $rs = $this->table($this->_table)->where('id',$id);
        return $rs->update($data);
    }
}