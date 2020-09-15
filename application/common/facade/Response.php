<?php


namespace app\common\facade;

use think\Facade;
use think\response\Json;

/**
 * @see \think\Cache
 * @mixin \think\Cache
 * @method Json success(array $data, int $code=0, string $msg="") static 正确返回
 * @method Json fail(int $code, string $msg = "") static 错误返回
 */
class Response extends Facade
{
    /**
     * 获取当前Facade对应类名（或者已经绑定的容器对象标识）
     *
     * @access protected
     * @return string
     */
    protected static function getFacadeClass()
    {
        return 'app\common\controller\Response';
    }
}