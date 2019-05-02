<?php
// +----------------------------------------------------------------------
// | ThinkCMF [ WE CAN DO IT MORE SIMPLE ]
// +----------------------------------------------------------------------
// | Copyright (c) 2013-2018 http://www.thinkcmf.com All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 小夏 < 449134904@qq.com>
// +----------------------------------------------------------------------
namespace app\admin\controller;

use cmf\controller\AdminBaseController;
use app\admin\model\UserAccountModel;
use think\Db;

/**
 * Class UserController
 */
class UserAccountController extends AdminBaseController
{

    public function _initialize()
    {}

    public function index()
    {
        /**
         * 方法:app\admin\controller\UserAccountController->index()
         * 模板文件themes/admin_simpleboot3/admin\black_white_list\index.html
         */
        $commentModel = new UserAccountModel();
        $comments = $commentModel->where([
            'user_type' => 2
        ])
            ->order('create_time DESC')
            ->paginate();
        $this->assign("page", $comments->render());
        $this->assign("users", $comments);
        return $this->fetch();
    }

    public function add()
    {
        /**
         * 方法:app\admin\controller\UserAccountController->add()
         * 模板文件themes/admin_simpleboot3/admin\user_account\add.html
         * date("h:i:sa")
         * date("Y-m-d")
         */
        $time = time();
        $this->assign("datetime", date("Y-m-d H:i:s"));
        $this->assign("time", time());
        return $this->fetch();
    }

    /**
     * array(6) {
     * ["user_login"] => string(8) "zhangsan"
     * ["user_pass"] => string(3) "111"
     * ["user_nickname"] => string(9) "用户名"
     * ["create_time"] => string(19) "2019-05-02 09:49:19"
     * ["account_status"] => string(10) "1556761759"
     * ["user_status"] => string(9) "用户名"
     * }
     */
    public function addPost()
    {
        $data = $this->request->param();
        // dump($data);
        $user_status = 0;
        if (isset($data['checkboxs'])) {
            // $ids = $this->request->param('checkboxs/a');
            // dump($ids);
            $user_status = 1;
        }
        $user_login = $_POST['user_login'];
        $user_nickname = $_POST['user_nickname'];
        $user_dept_name = $_POST['user_dept_name'];
        // $account_status = $_POST['account_status']; "account_status" => $account_status,
        $user_pass = $_POST['user_pass'];
        Db::name('user')->insert([
            "user_type" => 2,
            "user_login" => $user_login,
            "user_nickname" => $user_nickname,
            "create_time" => time(),
            "create_time_var" => date("Y-m-d H:i:s"),
            "user_status" => $user_status,
            "user_dept_name" => $user_dept_name,
            "user_pass" => $user_pass
        ]);
        return $this->success("新增成功！", url("UserAccount/index"));
    }

    /**
     *
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException array(24) {
     *         ["id"] => int(7)
     *         ["user_type"] => int(2)
     *         ["sex"] => int(0)
     *         ["birthday"] => int(0)
     *         ["last_login_time"] => int(0)
     *         ["score"] => int(0)
     *         ["coin"] => int(0)
     *         ["balance"] => string(4) "0.00"
     *         ["create_time"] => int(1556777314)
     *         ["create_time_var"] => string(19) "2019-05-02 14:08:34"
     *         ["user_status"] => int(1)
     *         ["account_status"] => int(1)
     *         ["user_dept_name"] => string(10) "1556777307"
     *         ["user_login"] => string(7) "账户2"
     *         ["user_pass"] => string(3) "111"
     *         ["user_nickname"] => string(10) "用户名2"
     *         ["user_email"] => string(0) ""
     *         ["user_url"] => string(0) ""
     *         ["avatar"] => string(0) ""
     *         ["signature"] => string(0) ""
     *         ["last_login_ip"] => string(0) ""
     *         ["user_activation_key"] => string(0) ""
     *         ["mobile"] => string(0) ""
     *         ["more"] => NULL
     *         }
     */
    public function edit()
    {
        $id = $this->request->param("id", 0, 'intval');
        $user = Db::name('user')->where([
            'id' => $id
        ])->find();
        $this->assign($user);
        // dump($user);
        return $this->fetch();
    }

    /**
     * array(6) {
     * ["user_login"] => string(8) "账户23"
     * ["user_pass"] => string(3) "111"
     * ["user_nickname"] => string(10) "用户名2"
     * ["user_dept_name"] => string(10) "1556777307"
     * ["checkboxs"] => array(1) {
     * [0] => string(2) "on"
     * }
     * ["id"] => string(1) "7"
     * }
     *
     * array(5) {
     * ["user_login"] => string(8) "账户23"
     * ["user_pass"] => string(3) "111"
     * ["user_nickname"] => string(10) "用户名2"
     * ["user_dept_name"] => string(10) "1556777307"
     * ["id"] => string(1) "7"
     * }
     */
    public function editPost()
    {
        $data = $this->request->param();
        // dump($data);
        $user_status = 0;
        if (isset($data['checkboxs'])) {
            $user_status = 1;
        }
        $create_result = Db::name('user')->where('id', $data['id'])->update([
            "user_login" => $data['user_login'],
            "user_nickname" => $data['user_nickname'],
            "user_status" => $user_status,
            "user_dept_name" => $data['user_dept_name'],
            "user_pass" => $data['user_pass']
        ]);
        // $create_result = Db::name('user')->update($data);
        if ($create_result !== false) {
            return $this->success("保存成功！", url("UserAccount/index"));
        } else {
            return $this->error("保存失败！", url("UserAccount/index"));
        }
    }

    public function columnUpdatePost()
    {
        $data = $this->request->param();
        dump($data);
        $this->success("保存成功！");
    }

    /**
     * 删除功能
     */
    public function delete()
    {
        $id = $this->request->param('id', 0, 'intval');
        if (Db::name('user')->delete($id) !== false) {
            $this->success("删除成功");
        } else {
            $this->error("删除失败！");
        }
    }
}