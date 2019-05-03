<?php
namespace app\admin\controller;

use cmf\controller\AdminBaseController;
use app\admin\model\UserAccountModel;
use think\Db;

/**
 * 控制器app\admin\controller\LogOwnController
 * Class LogOwnController
 */
class LogOwnController extends AdminBaseController
{

    public function _initialize()
    {}

    public function index()
    {
        /**
         * 方法app\admin\controller\LogOwnController->index()
         * 模板文件themes/admin_simpleboot3/admin\log_own\index.html
         */
        $commentModel = new UserAccountModel();
        $admin_id = session('ADMIN_ID');
        $user_name = session('name');
        $comments = $commentModel->where([
            'id' => $admin_id
        ])
            ->order('create_time DESC')
            ->paginate();

        // $comments = Db::name('user')->order("id desc")->paginate(10);
        $this->assign("page", $comments->render());
        $this->assign("users", $comments);
        return $this->fetch();
    }
}