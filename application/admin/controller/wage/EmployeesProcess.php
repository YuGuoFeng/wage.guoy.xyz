<?php

namespace app\admin\controller\wage;

use app\common\controller\Backend;
use think\exception\PDOException;
use think\exception\ValidateException;
use app\common\model\Process;
use app\common\model\MonthWage;
use Exception;
use Symfony\Component\VarExporter\Internal\Exporter;
use think\Db;
/**
 * 员工工序明细记录
 *
 * @icon fa fa-circle-o
 */
class EmployeesProcess extends Backend
{
    
    /**
     * EmployeesProcess模型对象
     * @var \app\common\model\EmployeesProcess
     */
    protected $model = null;

    public function _initialize()
    {
        parent::_initialize();
        $this->model = new \app\common\model\EmployeesProcess;

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
    
     public function years(){
         $data = [
             '2021' => '2021',
             '2022' => '2022',
             '2023' => '2023',
             '2024' => '2024',
         ];
         return $data;
     }

     public function month(){
        $data = [
            '1' => '1',
            '2' => '2',
            '3' => '3',
            '4' => '4',
            '5' => '5',
            '6' => '6',
            '7' => '7',
            '8' => '8',
            '9' => '9',
            '10' => '10',
            '11' => '11',
            '12' => '12',
        ];
        return $data;
    }

    /**
     * 查看
     */
    public function index()
    {
        //当前是否为关联查询
        $this->relationSearch = true;
        //设置过滤方法
        $this->request->filter(['strip_tags', 'trim']);
        if ($this->request->isAjax()) {
            //如果发送的来源是Selectpage，则转发到Selectpage
            if ($this->request->request('keyField')) {
                return $this->selectpage();
            }
            list($where, $sort, $order, $offset, $limit) = $this->buildparams();

            $list = $this->model
                    ->with(['employees','product','process'])
                    ->where($where)
                    ->order($sort, $order)
                    ->paginate($limit);

            foreach ($list as $row) {
                
                $row->getRelation('employees')->visible(['code_number','name']);
				$row->getRelation('product')->visible(['name']);
				$row->getRelation('process')->visible(['code_number','describe']);
            }

            $result = array("total" => $list->total(), "rows" => $list->items());

            return json($result);
        }
        return $this->view->fetch();
    }



    /**
     * 添加
     */
    public function add()
    {
        if ($this->request->isPost()) {
            $params = $this->request->post("row/a");
            if ($params) {
                $params = $this->preExcludeFields($params);

                if ($this->dataLimit && $this->dataLimitFieldAutoFill) {
                    $params[$this->dataLimitField] = $this->auth->id;
                }
                $result = false;
                Db::startTrans();
                try {
                    //是否采用模型验证
                    if ($this->modelValidate) {
                        $name = str_replace("\\model\\", "\\validate\\", get_class($this->model));
                        $validate = is_bool($this->modelValidate) ? ($this->modelSceneValidate ? $name . '.add' : $name) : $this->modelValidate;
                        $this->model->validateFailException(true)->validate($validate);
                    }

                    $info = $this->model->where('dates',$params['dates'])->find('id');
                    if(!empty($info['id'])){
                        throw new Exception("该员工".$params['dates']."号工资已经录入过了");
                    }
                    
                    $params['process_price'] = Process::where('id',$params['process_id'])->value('price');
                    $params['total_amount'] =  $params['process_price']*$params['process_num'];
                    $dates = explode('-',$params['dates']);
                    $params['years'] = $dates[0]??0;
                    $params['month'] = $dates[1]??0;
                    $params['day'] = $dates[2]??0;

                    // dump($params);exit();

                    $result = $this->model->allowField(true)->save($params);

                    if($result){
                        $result = (new MonthWage)->calculateWage($params['years'],$params['month'],$params['employees_id'] );
                    }

                    Db::commit();
                } catch (ValidateException $e) {
                    Db::rollback();
                    $this->error($e->getMessage());
                } catch (PDOException $e) {
                    Db::rollback();
                    $this->error($e->getMessage());
                } catch (Exception $e) {
                    Db::rollback();
                    $this->error($e->getMessage());
                }
                if ($result !== false) {
                    $this->success();
                } else {
                    $this->error(__('No rows were inserted'));
                }
            }
            $this->error(__('Parameter %s can not be empty', ''));
        }
        return $this->view->fetch();
    }

    /**
     * 编辑
     */
    public function edit($ids = null)
    {
        $row = $this->model->get($ids);
        if (!$row) {
            $this->error(__('No Results were found'));
        }
        $adminIds = $this->getDataLimitAdminIds();
        if (is_array($adminIds)) {
            if (!in_array($row[$this->dataLimitField], $adminIds)) {
                $this->error(__('You have no permission'));
            }
        }
        if ($this->request->isPost()) {
            $params = $this->request->post("row/a");
            if ($params) {
                $params = $this->preExcludeFields($params);
                $result = false;
                Db::startTrans();
                try {
                    //是否采用模型验证
                    if ($this->modelValidate) {
                        $name = str_replace("\\model\\", "\\validate\\", get_class($this->model));
                        $validate = is_bool($this->modelValidate) ? ($this->modelSceneValidate ? $name . '.edit' : $name) : $this->modelValidate;
                        $row->validateFailException(true)->validate($validate);
                    }


                    $params['process_price'] = Process::where('id',$params['process_id'])->value('price');
                    $params['total_amount'] =  $params['process_price']*$params['process_num'];
                    $dates = explode('-',$params['dates']);
                    $params['years'] = $dates[0]??0;
                    $params['month'] = $dates[1]??0;
                    $params['day'] = $dates[2]??0;

                    $result = $row->allowField(true)->save($params);

                    if($result){
                        $result = (new MonthWage)->calculateWage($params['years'],$params['month'],$params['employees_id'] );
                    }

                    Db::commit();
                } catch (ValidateException $e) {
                    Db::rollback();
                    $this->error($e->getMessage());
                } catch (PDOException $e) {
                    Db::rollback();
                    $this->error($e->getMessage());
                } catch (Exception $e) {
                    Db::rollback();
                    $this->error($e->getMessage());
                }
                if ($result !== false) {
                    $this->success();
                } else {
                    $this->error(__('No rows were updated'));
                }
            }
            $this->error(__('Parameter %s can not be empty', ''));
        }
        $this->view->assign("row", $row);
        return $this->view->fetch();
    }


    /**
     * 删除
     */
    public function del($ids = "")
    {
        if (!$this->request->isPost()) {
            $this->error(__("Invalid parameters"));
        }
        $ids = $ids ? $ids : $this->request->post("ids");
        if ($ids) {
            $pk = $this->model->getPk();
            $adminIds = $this->getDataLimitAdminIds();
            if (is_array($adminIds)) {
                $this->model->where($this->dataLimitField, 'in', $adminIds);
            }
            $list = $this->model->where($pk, 'in', $ids)->select();
            $info = $this->model->where('id',$ids)->find();
            $count = 0;
            Db::startTrans();
            try {
                foreach ($list as $k => $v) {
                    $count += $v->delete();
                }

                if($count){
                   
                    $result = (new MonthWage)->calculateWage($info['years'],$info['month'],$info['employees_id'] );
                    if(!$result){
                        $count = 0;
                    }
                }

                Db::commit();
            } catch (PDOException $e) {
                Db::rollback();
                $this->error($e->getMessage());
            } catch (Exception $e) {
                Db::rollback();
                $this->error($e->getMessage());
            }
            if ($count) {
                $this->success();
            } else {
                $this->error(__('No rows were deleted'));
            }
        }
        $this->error(__('Parameter %s can not be empty', 'ids'));
    }

}
