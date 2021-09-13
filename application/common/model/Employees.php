<?php

namespace app\common\model;

use think\Model;
use traits\model\SoftDelete;

class Employees extends Model
{

    use SoftDelete;

    

    // 表名
    protected $name = 'employees';
    
    // 自动写入时间戳字段
    protected $autoWriteTimestamp = 'int';

    // 定义时间戳字段名
    protected $createTime = 'createtime';
    protected $updateTime = 'updatetime';
    protected $deleteTime = 'deletetime';

    // 追加属性
    protected $append = [
        'induction_time_text',
        'state_text'
    ];
    

    
    public function getStateList()
    {
        return ['0' => __('State 0'), '1' => __('State 1')];
    }

    public function getGenderList()
    {
        return ['0' => __('Gender 0'), '1' => __('Gender 1')];
    }

    public function whereField($id,$field='id'){
        return $this->where('id',$id)->value($field);
    }


    public function getInductionTimeTextAttr($value, $data)
    {
        $value = $value ? $value : (isset($data['induction_time']) ? $data['induction_time'] : '');
        return is_numeric($value) ? date("Y-m-d H:i:s", $value) : $value;
    }


    public function getStateTextAttr($value, $data)
    {
        $value = $value ? $value : (isset($data['state']) ? $data['state'] : '');
        $list = $this->getStateList();
        return isset($list[$value]) ? $list[$value] : '';
    }

    protected function setInductionTimeAttr($value)
    {
        return $value === '' ? null : ($value && !is_numeric($value) ? strtotime($value) : $value);
    }


}
