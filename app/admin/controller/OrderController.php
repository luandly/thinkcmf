<?php
namespace app\admin\controller;

use cmf\controller\AdminBaseController;
use app\admin\model\RouteModel;
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
}