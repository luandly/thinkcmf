<?php
namespace app\admin\controller;

use cmf\controller\AdminBaseController;
use app\admin\model\OrderModel;
use think\Db;

/**
 * 控制器:app\admin\controller\BlackWhiteListController
 * 黑、白名单管
 *
 * @author luandly
 */
class BlackWhiteListController extends AdminBaseController
{

    public function _initialize()
    {}

    public function index()
    {
        /**
         * 模板文件themes/admin_simpleboot3/admin\black_white_list\index.html
         */
        $lists = Db::name('blackWhiteLists')->order("id desc")->paginate(10);
        $page = $lists->render();
        $this->assign("lists", $lists);
        $this->assign("page", $page);
        return $this->fetch();
    }

    public function addBlackListView()
    {
        return $this->fetch();
    }

    public function addWhiteListView()
    {
        return $this->fetch();
    }

    public function addBlackListPost()
    {
        $data = $this->request->param();
        // dump($data);
        $account_status = $_POST['account_status'];
        $ip = $_POST['ip'];
        Db::name('blackWhiteLists')->insert([
            "account_status" => $account_status,
            "ip" => $ip
        ]);
        return $this->success("新增成功！", url("blackWhiteList/index"));
    }

    public function addWhiteListPost()
    {
        $data = $this->request->param();
        // dump($data);
        $account_status = $_POST['account_status'];
        $ip = $_POST['ip'];
        Db::name('blackWhiteLists')->insert([
            "account_status" => $account_status,
            "ip" => $ip
        ]);
        return $this->success("新增成功！", url("blackWhiteList/index"));
    }

    public function edit()
    {
        $id = $this->request->param("id", 0, 'intval');
        $blackWhiteList = Db::name('blackWhiteLists')->where([
            'id' => $id
        ])->find();
        $this->assign($blackWhiteList);
        return $this->fetch();
    }

    public function editPost()
    {
        $data = $this->request->param();
        // dump($data);
        $create_result = Db::name('blackWhiteLists')->update($data);
        if ($create_result !== false) {
            return $this->success("保存成功！", url("blackWhiteList/index"));
        } else {
            return $this->error("保存失败！", url("blackWhiteList/index"));
        }
    }

    /**
     * 删除功能
     */
    public function delete()
    {
        $id = $this->request->param('id', 0, 'intval');
        if (Db::name('blackWhiteLists')->delete($id) !== false) {
            $this->success("删除成功");
        } else {
            $this->error("删除失败！");
        }
    }
}