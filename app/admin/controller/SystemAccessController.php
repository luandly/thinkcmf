<?php
namespace app\admin\controller;

use cmf\controller\AdminBaseController;
use app\admin\model\OrderModel;
use think\Db;

/**
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
         echo '<pre>', ROOT_PATH, '</pre>';

//        return $this->fetch();
    }

    /**
     * 新增一条记录跳转 跳转找到的模板名称是add_view.html
     *
     * @return mixed|string
     */
    public function addView()
    {
        // $content = hook_one('admin_user_add_view');

        // if (! empty($content)) {
        // return $content;
        // }
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
        $paymentTypeInfo = $_POST['paymentTypeInfo'];
        $verifyName = $_POST['verifyName'];
        $paymentType = $_POST['paymentType'];
        $accountNum = $_POST['accountNum'];
        Db::name('order')->insert([
            "paymentTypeInfo" => $paymentTypeInfo,
            "verifyName" => $verifyName,
            "accountNum" => $accountNum,
            "paymentType" => $paymentType
        ]);
        // Db::name('order')->insert($hook);
        return $this->success("新增成功！", url("order/index"));
    }

    // 编辑功能
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
}