<?php

namespace App\Traits;


use App\Models\Model;

trait SettingsMasterTrait
{
    public function generateList($param = null, $value = null) {
        $this->model = new Model();
        $data_object = $this->model->table("settings_master")->select('id','name')->where($param, $value);
        $list = ['-- Select --'];
        foreach ($data_object as $item) {
            $list[$item->id] = $item->name;
        }
        return $list;
    }
}
