<?php

namespace app\admin\controller;

use app\common\facade\Response;
use think\Controller;
use think\Request;
use app\admin\model\Projects as ProjectsModel;
use Elasticsearch\ClientBuilder;

class Projects extends Controller
{
    /**
     * 显示资源列表
     *
     * @return \think\Response
     */
    public function index()
    {
        //获取项目数据
        if ($this->request->isAjax()) {
            $where = [];
            $limit = $this->request->param('limit', 10);
            //用户id
            $name = $this->request->param("name");
            if ($name) {
                $where['name'] = array("like", "%" . $name . "%");
            }
            $data = ProjectsModel::where($where)->paginate($limit)->toArray();
            return Response::success($data);
        }
        return $this->fetch();
    }

    /**
     * 显示创建资源表单页.
     *
     * @return \think\Response
     */
    public function create()
    {
        //
    }

    /**
     * 保存新建的资源
     *
     * @param \think\Request $request
     *
     * @return \think\Response
     */
    public function save(Request $request)
    {
        //
    }

    /**
     * 显示指定的资源
     *
     * @param int $id
     *
     * @return \think\Response
     */
    public function read($id)
    {
        //
    }

    /**
     * 显示编辑资源表单页.
     *
     * @param int $id
     *
     * @return \think\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * 保存更新的资源
     *
     * @param \think\Request $request
     * @param int            $id
     *
     * @return \think\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * 删除指定资源
     *
     * @param int $id
     *
     * @return \think\Response
     */
    public function delete($id)
    {
        //
    }
}
