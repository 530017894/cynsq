function tableRender(config) {
//第一个实例
    layui.use('table', function () {
        let table = layui.table
        table.render({
            height: 600
            , page: true //开启分页
            ,limits:[10,25,50,100,1000]
            , parseData: function (res) { //res 即为原始返回的数据
                res = res.data
                return {
                    "code": 0, //解析接口状态
                    "msg": res.msg, //解析提示文本
                    "count": res.total, //解析数据长度
                    "data": res.data //解析数据列表
                };
            },
            ...config
        });
    })
}