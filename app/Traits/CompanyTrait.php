<?php

namespace App\Traits;


use App\Models\Model;

trait CompanyTrait
{
    public function company_info() {
        $this->model = new Model();
        return $this->model->table('company')->where('id',1)->fetch();
    }

}
