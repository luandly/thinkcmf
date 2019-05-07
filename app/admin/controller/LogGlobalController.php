<?php
namespace app\admin\controller;

use cmf\controller\AdminBaseController;
use app\admin\model\UserAccountModel;
use think\Db;

/**
 * 控制器app\admin\controller\LogGlobalController
 * Class LogGlobalController
 */
class LogGlobalController extends AdminBaseController
{

    public function _initialize()
    {}

    public function index()
    {
        /**
         * 模板文件themes/admin_simpleboot3/admin\log_global\index.html
         */
        $content = hook_one('admin_log_global_index_view');

        if (! empty($content)) {
            return $content;
        }

        $where = [];
        /**
         * 搜索条件*
         */
        $userLogin = $this->request->param('user_login');
        $lastVisitTime = $this->request->param('last_visit_time');
        $ip = $this->request->param('ip');
        $keyword = $this->request->param('keyword');
        // $userEmail = trim($this->request->param('user_login'));

        dump($lastVisitTime);

        if ($userLogin) {
            $where['user_login'] = [
                'like',
                "%$userLogin%"
            ];
        }

        // date("Y-m-d H:i:s"),
        if ($lastVisitTime) {
            $where['last_visit_time'] = [
                'like',
                "%$lastVisitTime%"
            ];
        }
        if ($ip) {
            $where['ip'] = [
                'like',
                "%$ip%"
            ];
        }

        $keywordComplex = [];
        if (! empty($keyword)) {
            $keywordComplex['user_login|user_nickname|ip|last_visit_time'] = [
                'like',
                "%$keyword%"
            ];
        }

        $commentModel = new UserAccountModel();
        // $comments = $commentModel->where([
        // 'user_type' => 1
        // ])
        // ->order('create_time DESC')
        // ->paginate();
        //
        $join = [
            [
                '__USER__ u',
                'a.user_id = u.id'
            ]
        ];
        // $comments = Db::name('user_action_log')->order("id desc")->paginate(10);

        $result = Db::name('user_action_log')->field('a.*,u.user_login,u.user_email,u.user_nickname')
            ->alias('a')
            ->whereOr($keywordComplex)
            ->where($where)
            ->join($join)
            ->order('last_visit_time', 'DESC')
            ->paginate(10);
        // echo Db::name('user_action_log')->getLastSql();
        // dump($result);
        dump(Db::name('user_action_log')->getLastSql());
        $this->assign("page", $result->render());
        $this->assign("users", $result->items());
        return $this->fetch();
    }
}