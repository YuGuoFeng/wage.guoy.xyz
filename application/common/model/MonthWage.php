<?php

namespace app\common\model;

use think\Model;
use traits\model\SoftDelete;

class MonthWage extends Model
{

    use SoftDelete;

    

    // 表名
    protected $name = 'employees_month_wage';
    
    // 自动写入时间戳字段
    protected $autoWriteTimestamp = 'int';

    // 定义时间戳字段名
    protected $createTime = 'createtime';
    protected $updateTime = 'updatetime';
    protected $deleteTime = 'deletetime';

    // 追加属性
    protected $append = [

    ];
    

    







    public function employees()
    {
        return $this->belongsTo('Employees', 'employees_id', 'id', [], 'LEFT')->setEagerlyType(0);
    }
}
