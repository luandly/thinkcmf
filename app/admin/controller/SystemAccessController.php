<?php
namespace app\admin\controller;

use cmf\controller\AdminBaseController;
use think\Db;

/**
 * 模板文件不存在:/www/wwwroot/thinkcmf/public/themes/admin_simpleboot3/admin/system_access/index.html
 *
 * @author luandly
 *         增加一项 系统模块
 */
class SystemAccessController extends AdminBaseController
{

    public function _initialize()
    {}

    public function index()
    {
        // $content = hook_one('admin_user_add_view');
        // 模板文件不存在:themes/admin_simpleboot3/admin\system_access\index.html
        $gatheringAccountSettings = Db::name('gatheringAccountSetting')->order("id desc")->paginate(10);
        $page = $gatheringAccountSettings->render();
        $this->assign("gathering_account_setting", $gatheringAccountSettings);
        $this->assign("page", $page);
        return $this->fetch();
    }

    /**
     * 新增一条记录跳转 跳转找到的模板名称是add_view.html
     *
     * @return mixed|string
     */
    public function addView()
    {
        // $content = hook_one('admin_user_add_view');
        // 模板文件不存在:themes/admin_simpleboot3/admin\system_access\add_view.html
        return $this->fetch();
    }

    /**
     * 新增一条记录保存
     * array(4) {
     * ["paymentTypeInfo"] => string(6) "春风"
     * ["verifyName"] => string(7) "Jarvan9"
     * ["paymentType"] => string(9) "玉门关"
     * ["accountNum"] => string(4) "9527"
     * }
     */
    public function addPost()
    {
        $data = $this->request->param();
        // dump($data);
        $channelType = $_POST['channel_type'];
        $channelAccountNum = $_POST['channel_account_num'];
        $description = $_POST['description'];
        $grandTotalDepositTimes = $_POST['grand_total_deposit_times'];
        $grandTotalAmountDeposited = $_POST['grand_total_amount_deposited'];
        $usedStatus = $_POST['used_status'];
        $createTime = $_POST['create_time'];
        Db::name('gathering_account_setting')->insert([
            "channel_type" => $channelType,
            "channel_account_num" => $channelAccountNum,
            "description" => $description,
            "grand_total_deposit_times" => $grandTotalDepositTimes,
            "grand_total_amount_deposited" => $grandTotalAmountDeposited,
            "used_status" => $usedStatus,
            "create_time" => $createTime
        ]);
        return $this->success("新增成功！", url("systemAccess/index"));
    }

    // 编辑功能
    public function edit()
    {
        $id = $this->request->param("id", 0, 'intval');
        $gathering_account_setting = Db::name('gathering_account_setting')->where([
            'id' => $id
        ])->find();
        $this->assign($gathering_account_setting);
        return $this->fetch();
    }

    /**
     * 修改后保存
     * array(3) {
     * ["paymentTypeInfo"] => string(20) "微信/Jarvan/测试"
     * ["verifyName"] => string(6) "Jarvan"
     * ["id"] => string(1) "1"
     * }
     */
    public function editPost()
    {
        $data = $this->request->param();
        // dump($data);
        $create_result = Db::name('order')->update($data);
        if ($create_result !== false) {
            return $this->success("保存成功！");
            // return $this->success("保存成功！", url("order/index"));
        } else {
            // $this->error("保存失败！");
            echo '<pre>保存失败--', $data['paymentTypeInfo'], '--2world</pre>';
        }
    }

    /**
     * 删除功能
     */
    public function delete()
    {
        $id = $this->request->param('id', 0, 'intval');
        if (Db::name('order')->delete($id) !== false) {
            $this->success("删除成功" . $id);
        } else {
            $this->error("删除失败！");
        }
    }

    /**
     * 金流设置
     *
     * @return mixed
     */
    public function channelTypeSetting()
    {
        // 方法不存在:app\admin\controller\SystemAccessController->channeltypesetting()
        // 模板文件不存在:themes/admin_simpleboot3/admin\system_access\channel_type_setting.html
        return $this->fetch();
    }

    public function addNewView()
    {
        // 模板文件不存在:themes/admin_simpleboot3/admin\system_access\add_new_view.html //addNewView
        // 模板文件不存在:themes/admin_simpleboot3/admin\system_access\addnewview.html //addnewview
        // 方法不存在:app\admin\controller\SystemAccessController->addnewview()
        return $this->fetch();
    }
}