<?php
namespace app\admin\model;

use think\Model;

/**
 * 账户列表增加一个model 继承基类
 * @author luandly
 *
 */
class UserAccountModel extends Model
{
    /**
     * @var string
     * $table和$name两个属性都可以指定模型的数据表名,$table指定的是真实的数据表名,$name指定的是不带表前缀的数据表名,只要设置一个就可以了,如果两个同时设置,以$table设置的为准;
     * protected $table = 'cmf_user';
     */
    protected $name = 'user';
}