<?php

namespace app\admin\controller\employees;

use app\common\controller\Backend;

/**
 * 员工列管理
 *
 * @icon fa fa-circle-o
 */
class Employees extends Backend
{
    
    /**
     * Employees模型对象
     * @var \app\common\model\Employees
     */
    protected $model = null;

    public function _initialize()
    {
        parent::_initialize();
        $this->model = new \app\common\model\Employees;
        $this->view->assign("stateList", $this->model->getStateList());
    }

    public function userList(){
        return $this->model->where('state',1)->where('deletetime',null)->column('id,name');
    }

    public function import()
    {
        parent::import();
    }

    /**
     * 默认生成的控制器所继承的父类中有index/add/edit/del/multi五个基础方法、destroy/restore/recyclebin三个回收站方法
     * 因此在当前控制器中可不用编写增删改查的代码,除非需要自己控制这部分逻辑
     * 需要将application/admin/library/traits/Backend.php中对应的方法复制到当前控制器,然后进行修改
     */
    

}
