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
//         $routeModel = new RouteModel();
//         $routes = Db::name('order')->order("billTime asc")->select();
//         echo '<pre>', $routes, '</pre>';
//         $routeModel->getRoutes(true);
//         $this->assign("routes", $routes);
        return $this->fetch();
    }
}