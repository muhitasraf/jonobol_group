<?php

namespace App\Models;

class Permission extends Model {
     public $_table = 'permissions';
     //protected $primary = "id";
     protected $pdo;
     public function __construct()
     {
        parent::__construct();
        //$this->primary[$this->_table] = 'id';
        //$this->setPrimary($this->_table,'id');
     }

    public function hasRole($role) {
        return $this->table('roles')->where('slug',$role)->count();
    }

    public function hasPerm($permissions = []) {
        $user_role_id = session('role_id') ?? 0;
        $permissions = $this->table('permissions')->select('id')->where('name',$permissions)->fetchAll();
        if ($permissions) {
            foreach ($permissions as $key=>$row) {
                $permission_role = $this->table('permission_role')->where(['role_id'=>$user_role_id,'permission_id'=>$row->id])->count();
                if ($permission_role == 1)
                    return true;
            }
        }
        return false;
    }

    /*
    public static function hasRole($role) {
        return (new Permission())->table('roles')->where('slug',$role)->count();
    }

    public static function hasPerm($permission) {
        $user_role_id = session('role_id') ?? 0;
        $rs = (new Permission())->pdo->prepare("SELECT count(*) FROM permissions pm INNER JOIN permission_role pr ON
            pm.id=pr.permission_id WHERE pm.name=? AND pr.role_id=?");
        $rs->execute([$permission,$user_role_id]);
        return $rs->fetch()[0];
    }
     */
}
