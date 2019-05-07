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
         * 这里要显示 当前用户的别名 需要关联查询用户表
         */
        $join = [
            [
                '__USER__ u',
                'a.uid = u.id'
            ]
        ];
        $where = [];
        $where['uid'] = session('ADMIN_ID'); // 查询当前表中当前用户的记录

        $result = Db::name('daily')->field('a.*,u.user_login,u.user_nickname')
            ->alias('a')
            ->where($where)
            ->join($join)
            ->order('optdt', 'DESC')
            ->paginate(10);

        $this->assign("page", $result->render());
        $this->assign("users", $result);
        return $this->fetch();
    }

    /**
     * 方法不存在:app\admin\controller\LogOwnController->add()
     * 模板文件不存在:themes/admin_simpleboot3/admin\log_own\add.html
     *
     * @return mixed
     */
    public function add()
    {
        // $admin_id = session('ADMIN_ID');
        $user_name = session('name');
        // $todayStartTime = strtotime(date('Y-m-d', $currentTime));
        $this->assign("user_name", $user_name);
        $this->assign("current_time", date('Y-m-d H:i:s'));
        return $this->fetch();
    }

    public function addPost()
    {
        // $request = input('request.');
        // $data = $this->request->param();
        // dump($data);
        $title = $_POST['title'];
        $content = $_POST['content'];
        $optname = session('name');
        $uid = session('ADMIN_ID');
        $createTime = date('Y-m-d H:i:s');
        Db::name('daily')->insert([
            "title" => $title,
            "content" => $content,
            "optname" => $optname,
            "optdt" => time(),
            "uid" => $uid,
            "create_time" => $createTime
        ]);
        return $this->success("新增成功！", url("LogOwn/index"));
    }

    /**
     * 日志列表中的 查看功能 查看显示功能，禁止编辑。并且在查看记录表中产生一条数据 ->find();
     * echo '<li title="共查阅'.$rs['visit_time'].'次&#13;最后查阅'.$rs['visit_time'].'" ><img src="'.$rs['visit_time'].'" align="absmiddle"><br><span>'.$rs['visit_time'].'</span></li>';
     *
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException array(16) {
     *         ["id"] => int(21)
     *         ["dt"] => NULL
     *         ["title"] => string(18) "标题 admin2"
     *         ["content"] => string(18) "内容 admin2"
     *         ["create_time"] => string(19) "2019-05-06 08:57:19"
     *         ["optdt"] => NULL
     *         ["uid"] => int(7)
     *         ["optname"] => string(6) "admin2"
     *         ["type"] => int(0)
     *         ["plan"] => NULL
     *         ["status"] => int(0)
     *         ["enddt"] => NULL
     *         ["optid"] => NULL
     *         ["mark"] => int(0)
     *         ["user_login"] => string(6) "admin2"
     *         ["user_nickname"] => string(21) "2号管理员的nname"
     *         }
     */
    public function view()
    {
        $id = $this->request->param("id", 0, 'intval');
        $admin_id = session('ADMIN_ID');
        $user_login = session('name');
        $data = $this->request->param();
        // dump($data);
        // $request = input('request.');
        $user_nickname = $data['usernicknameview'];
        $createTime = date('Y-m-d H:i:s');

        $daily = Db::name('daily')->where([
            'id' => $id
        ])->find();
        if ($daily) {
            $daily['user_login'] = $user_login;
            $daily['user_nickname'] = $user_nickname;
            $this->assign($daily);
            // dump($daily);
            Db::name('daily_log')->insert([
                "daily_id" => $id,
                "uid" => $admin_id,
                "user_nickname" => $user_nickname,
                "visit_time" => time(),
                "visit_time_var" => $createTime,
                "create_time_var" => $createTime
            ]);

            $where = [];
            $where['daily_id'] = $id; // 查询当前表中当前日志的记录
            $order = "visit_time,usercount DESC"; // 根据访问次数和访问时间排序

            $dailyLogs = Db::name('dailyLog')->field(' user_nickname,visit_time_var,visit_time,count(user_nickname) as usercount')
                ->where($where)
                ->group('user_nickname')
                ->order($order)
                ->paginate(10);
            $this->assign("dailyLogs", $dailyLogs);
            // echo Db::name('dailyLog')->getLastSql();
            // dump($dailyLogs);
            return $this->fetch();
        }
    }
}