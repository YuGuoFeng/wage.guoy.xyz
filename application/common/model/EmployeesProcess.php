<?php

namespace app\common\model;

use think\Model;
use traits\model\SoftDelete;

class EmployeesProcess extends Model
{

    use SoftDelete;

    

    // 表名
    protected $name = 'employees_process';
    
    // 自动写入时间戳字段
    protected $autoWriteTimestamp = 'int';

    // 定义时间戳字段名
    protected $createTime = 'createtime';
    protected $updateTime = 'updatetime';
    protected $deleteTime = 'deletetime';

    // 追加属性
    protected $append = [

    ];
    

    

    // 查询用户月几件的总工资
    public function employeesProcessWage($employees_id,$years,$month){
       
        return $this->where(['employees_id'=>$employees_id,'years'=>$years,'month'=>$month])->sum('total_amount');
    }   




    public function employees()
    {
        return $this->belongsTo('Employees', 'employees_id', 'id', [], 'LEFT')->setEagerlyType(0);
    }


    public function product()
    {
        return $this->belongsTo('Product', 'product_id', 'id', [], 'LEFT')->setEagerlyType(0);
    }


    public function process()
    {
        return $this->belongsTo('Process', 'process_id', 'id', [], 'LEFT')->setEagerlyType(0);
    }
}
