<?php
namespace app\admin\controller;

use cmf\controller\AdminBaseController;
use app\admin\model\OrderModel;
use think\Db;

/**
 * themes/admin_simpleboot3/admin\order\index.html
 *
 * @author luandly
 *         增加一项 订单模块
 */
class OrderController extends AdminBaseController
{

    public function _initialize()
    {}

    public function index()
    {
        // echo '<pre>', ROOT_PATH, '</pre>';
        // // 引入实体类
        // $orderModel = new OrderModel();
        // // 数据查询
        // $orders = Db::name('order')->order("id asc")->select();
        // $orders = Db::name('order')->order("id asc")->select();
        $orders = Db::name('order')->order("id asc")->paginate(10);
        // $orderModel1 = OrderModel::get(1);
        // echo '<pre>', $orderModel, '</pre>';
        // echo '<pre>', $orders, '</pre>';
        // echo '<pre>', $orderModel1['paymentType'], '</pre>';
        // $routeModel->getRoutes(true);
        $page = $orders->render();
        // 把查询的数据 放到对应的前端中去
        $this->assign("orders", $orders);
        $this->assign("page", $page);
        return $this->fetch();
    }

    /**
     * 订单模块控制器增加编辑功能
     *
     * @return unknown
     */
    public function edit()
    {
        $id = $this->request->param("id", 0, 'intval');
        $order = Db::name('order')->where([
            'id' => $id
        ])->find();
        $this->assign($order);
        // print_r($order);
        // dump($order);
        // $this->assign("order", $order);
        // echo '<pre>helloe'.print_r($cart_wrapper, TRUE).'</pre>'; value="{$user_email}"
        // echo '<pre>hello--', ROOT_PATH, '--2world</pre>';
        // echo '<pre>hello--', $id, '--2world</pre>';
        // echo '<pre>hello--', $order['verifyName'], '--world</pre>';
        return $this->fetch();
    }
    
    /**
     * 修改保存 
     */
    public function editPost()
    {
        $data       = $this->request->param();
        $orderModel = new OrderModel();       
        $orderModel->allowField(true)->isUpdate(true)->save($data);        
        $this->success("保存成功！");
    }

    /**
     * 添加一项
     *
     * @return unknown
     */
    public function add()
    {
        return $this->fetch();
    }

    /**
     * 添加 保存数据
     *
     * @return unknown
     */
    public function addPost()
    {
        $data = $this->request->param();
        $orderModel = new OrderModel();
        $paymentTypeInfo =$_POST['paymentTypeInfo'];
        $verifyName =$_POST['verifyName'];
        DB::name("order")->insert([
            "paymentTypeInfo" => $paymentTypeInfo,
            "verifyName" => $verifyName
        ]);
        //$orderModel->allowField(true)->save($data);
        // $this->success("添加成功！", url("Route/index", ['id' => $orderModel->id]));
        $this->success("添加成功！", url("order/index"));
    }
    
    /**
     * 删除
     */
    public function delete()
    {
        $id = $this->request->param('id', 0, 'intval');
        if ($id == 1) {
            $this->error("这是第一条数据！请手下留情");
        }
        if (Db::name('order')->delete($id) !== false) {
            $this->success("删除成功！".$id);
        } else {
            $this->error("删除失败！".$id);
        }
    }
}