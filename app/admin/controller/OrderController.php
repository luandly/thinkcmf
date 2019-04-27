<?php
namespace app\admin\controller;

use cmf\controller\AdminBaseController;
use app\admin\model\OrderModel;
use think\Db;

/**
 * themes/admin_simpleboot3/admin\order\index.html
 * @author luandly
 * 增加一项 订单模块
 */
class OrderController extends AdminBaseController
{

    public function _initialize()
    {}

    public function index()
    {
        echo '<pre>', ROOT_PATH, '</pre>';
        // 引入实体类
        $orderModel = new OrderModel();
        // 数据查询
        $orders = Db::name('order')->order("id asc")->select();
        $orderModel1 = OrderModel::get(1);
        echo '<pre>', $orderModel, '</pre>';
        echo '<pre>', $orders, '</pre>';
        echo '<pre>', $orderModel1['paymentType'], '</pre>';
        // $routeModel->getRoutes(true);
        // 把查询的数据 放到对应的前端中去
        $this->assign("orders", $orders);
        return $this->fetch();
    }
    
    /**
     * 订单模块控制器增加编辑功能
     * @return unknown
     */
    public function edit()
    {
        $id = $this->request->param("id", 0, 'intval');
        $order = Db::name('order')->where([
            'id' => $id
        ])->find();
        $this->assign($order);
        print_r($order);
        dump($order);
        //         $this->assign("order", $order);
        // echo '<pre>helloe'.print_r($cart_wrapper, TRUE).'</pre>'; value="{$user_email}"
        echo '<pre>hello--', ROOT_PATH, '--2world</pre>';
        echo '<pre>hello--', $id, '--2world</pre>';
        echo '<pre>hello--', $order['verifyName'], '--world</pre>';
        return $this->fetch();
    }
}