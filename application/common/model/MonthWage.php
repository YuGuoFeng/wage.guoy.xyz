<?php

namespace app\common\model;

use think\Model;
use traits\model\SoftDelete;
use app\common\model\EmployeesProcess;
use app\common\model\Employees;
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
    

    
    // 计算月工资
    public function calculateWage($years,$month,$employees_id){
        $$month = (int)$month;
        //查询员工记件的总工资
        $employees_process_wage = (new EmployeesProcess)->employeesProcessWage($employees_id,$years,$month);
       
        $row = $this->where(['employees_id'=>$employees_id,'years'=>$years,'month'=>$month])->find();
       
        if($row){
            $other = 0;
            if(!empty($row['json'])){
                $json = json_decode($row['json'],true);
                foreach($json as $v){
                    $other += (float)$v;
                }
                
            }
            //合计金额
            $total_amount = (float)$row['employees_basis_wage'] + (float)$employees_process_wage + $other+(float)$row['hous_fill']+(float)$row['rice_fill']-(float)$row['five_insurance'];;
            $row->employees_process_wage = $employees_process_wage;
            $row->total_amount = $total_amount;
            $res = $row->save();

        }else{
            $user = (new Employees)->where('id',$employees_id)->find();
            //查询用户的基础工资
            $employees_basis_wage = $user['wage'];//(new Employees)->whereField($employees_id,'wage');
            $wage_base = $user['wage_base'];
            $five_ratio = config('site.five_insurance');

            //扣除五险金额
            $five_insurance = (1-$five_ratio/100)*$wage_base;

            //合计金额
            $total_amount = (float)$employees_basis_wage + (float)$employees_process_wage - (float)$five_insurance;

            $data = $this;
            $data->employees_id = $employees_id;
            $data->employees_process_wage = $employees_process_wage;
            $data->employees_basis_wage = $employees_basis_wage;
            $data->total_amount = $total_amount;
            $data->wage_base = $wage_base;
            $data->five_ratio = $five_ratio;
            $data->five_insurance = $five_insurance;
            $data->years = $years;
            $data->month = $month;
            $res = $data->save();

        }

        return $res;
    }





    public function employees()
    {
        return $this->belongsTo('Employees', 'employees_id', 'id', [], 'LEFT')->setEagerlyType(0);
    }
}
