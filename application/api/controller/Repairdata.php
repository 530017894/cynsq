<?php

namespace app\api\controller;

use think\Controller;
use app\admin\service\Es;
use think\Db;

/**
 *
 * Class Index
 *
 */
class Repairdata extends Controller
{
    //根据埋点id聚合
    public static function search($start_time,$end_time)
    {
        $params            = [];
        $params['index']   = "cy_message_log";
        $params['type'] = "_doc";
        $params['body']    = [
            'query' => [
                'bool' => [
                    'must' => [
                        [
                            'range' => [
                                'created_at' => [
                                    'gte' => $start_time,
                                    'lt' => $end_time,
                                ]
                            ]
                        ]
                    ]
                ]
            ]
        ];
        $params['body']['aggs'] = [
            'pre' => [
                'terms' =>  [
                    'script' => "doc['projectid'].value +','+doc['platform'].value +','+doc['pointid'].value +','+doc['expointid'].value",
                    'size' => 10000000
                ]
            ]
        ];
        $params['size'] = 0;

        $response = Es::instance()->searches($params);

        if (isset($response["aggregations"]["pre"]["buckets"]) && count($response["aggregations"]["pre"]["buckets"]) > 0) {
            $insert_day = date("Ymd", strtotime($start_time));
            $insert_hour = date("H", strtotime($start_time));
            foreach ($response["aggregations"]["pre"]["buckets"] as $ke=>$item){
                $pointArr = explode(',',$item['key']);
                $projectId = $pointArr[0];
                $pointId  = $pointArr[2];
                $expointId = 0;
                if($pointArr[3]){
                    $expointId  = substr($pointArr[3],-4);
                }
                $dataRaw = [
                    'platform' => $pointArr[1],
                    'point_id' => $pointId,
                    'expoint' => $expointId,
                    'account' => $item['doc_count'],
                    'day' => $insert_day,
                    'hour' => $insert_hour,
                ];
                $table = 'cy_static_data_'.$projectId;
                $where = [
                    'platform' => $pointArr[1],
                    'point_id' => $pointId,
                    'expoint' => $expointId,
                    'day' => $insert_day,
                    'hour' => $insert_hour,
                ];
                $result = Db::table($table)->where($where)->find();
                if(!$result){
                    Db::table($table)->insert($dataRaw);
                }else{
                    Db::table($table)->where('id',$result['id'])->update($dataRaw);
                }

            }
        }
        return 1;
    }

    //聚合访问人员
    public static function userlog($start_time,$end_time)
    {
        $params            = [];
        $params['index']   = "cy_message_log";
        $params['type'] = "_doc";
        $params['body']    = [
            'query' => [
                'bool' => [
                    'must' => [
                        [
                            'range' => [
                                'created_at' => [
                                    'gte' => $start_time,
                                    'lt' => $end_time,
                                ]
                            ]
                        ]
                    ]
                ]
            ]
        ];
        $params['body']['aggs'] = [
            'pre' => [
                'terms' =>  [
                    'script' => "doc['projectid'].value +','+doc['platform'].value +','+doc['pointid'].value +','+doc['uuid'].value +','+doc['province'].value +','+doc['city'].value +','+doc['device_name'].value +','+doc['device_brand'].value+','+doc['device_type'].value+','+doc['device_version'].value",
                    'size' => 10000000
                ]
            ]
        ];
        $params['size'] = 0;

        $response = Es::instance()->searches($params);
        if (isset($response["aggregations"]["pre"]["buckets"]) && count($response["aggregations"]["pre"]["buckets"]) > 0) {
            $insert_day = date("Ymd", strtotime($start_time));
            $insert_hour = date("H", strtotime($start_time));
            foreach ($response["aggregations"]["pre"]["buckets"] as $ke=>$item){
                $pointArr = explode(',',$item['key']);
                $projectId = $pointArr[0];
                $pointId  = $pointArr[2];
                $dataRaw = [
                    'platform' => $pointArr[1],
                    'point_id' => $pointId,
                    'view_user_id' => $pointArr[3],
                    'device_name' => $pointArr[6],
                    'device_brand' => $pointArr[7],
                    'device_type' => $pointArr[8],
                    'device_version' => $pointArr[9],
                    'province' => $pointArr[4],
                    'city' => $pointArr[5],
                    'day' => $insert_day,
                    'hour' => $insert_hour,
                ];
                $table = 'cy_view_user_'.$projectId;
                $result = Db::table($table)->where($dataRaw)->count();
                if(!$result){
                    Db::table($table)->insert($dataRaw);
                }
            }
        }
        return 1;
    }

    //地域统计
    public static function areaacount($start_time,$end_time)
    {
        $params            = [];
        $params['index']   = "cy_message_log";
        $params['type'] = "_doc";
        $params['body']    = [
            'query' => [
                'bool' => [
                    'must' => [
                        [
                            'range' => [
                                'created_at' => [
                                    'gte' => $start_time,
                                    'lt' => $end_time,
                                ]
                            ]
                        ]
                    ]
                ]
            ]
        ];
        $params['body']['aggs'] = [
            'pre' => [
                'terms' =>  [
                    'script' => "doc['projectid'].value  +','+doc['platform'].value +','+doc['province'].value +','+doc['city'].value",
                    'size' => 10000000
                ]
            ]
        ];
        $params['size'] = 0;

        $response = Es::instance()->searches($params);

        if (isset($response["aggregations"]["pre"]["buckets"]) && count($response["aggregations"]["pre"]["buckets"]) > 0) {
            $insert_day = date("Ymd", strtotime($start_time));
            $insert_hour = date("H", strtotime($start_time));
            foreach ($response["aggregations"]["pre"]["buckets"] as $ke=>$item){
                $pointArr = explode(',',$item['key']);

                $dataRaw = [
                    'platform' => $pointArr[1],
                    'province' => $pointArr[2],
                    'city' => $pointArr[3],
                    'account' => $item['doc_count'],
                    'day' => $insert_day,
                    'hour' => $insert_hour,
                ];
                $table = 'cy_static_area_'.$pointArr[0];
                $where = [
                    'platform' => $pointArr[1],
                    'province' => $pointArr[2],
                    'city' => $pointArr[3],
                    'day' => $insert_day,
                    'hour' => $insert_hour,
                ];
                $result = Db::table($table)->where($where)->find();
                if(!$result){
                    Db::table($table)->insert($dataRaw);
                }else{
                    Db::table($table)->where('id',$result['id'])->update($dataRaw);
                }

            }
        }
        return 1;
    }

    //设备统计
    public static function deviceacount($start_time,$end_time)
    {
        $params            = [];
        $params['index']   = "cy_message_log";
        $params['type'] = "_doc";
        $params['body']    = [
            'query' => [
                'bool' => [
                    'must' => [
                        [
                            'range' => [
                                'created_at' => [
                                    'gte' => $start_time,
                                    'lt' => $end_time,
                                ]
                            ]
                        ]
                    ]
                ]
            ]
        ];
        $params['body']['aggs'] = [
            'pre' => [
                'terms' =>  [
                    'script' => "doc['projectid'].value +','+doc['platform'].value +','+doc['device_name'].value +','+doc['device_brand'].value +','+doc['device_type'].value +','+doc['device_version'].value",
                    'size' => 10000000
                ]
            ]
        ];
        $params['size'] = 0;

        $response = Es::instance()->searches($params);

        if (isset($response["aggregations"]["pre"]["buckets"]) && count($response["aggregations"]["pre"]["buckets"]) > 0) {
            $insert_day = date("Ymd", strtotime($start_time));
            $insert_hour = date("H", strtotime($start_time));
            foreach ($response["aggregations"]["pre"]["buckets"] as $ke=>$item){
                $pointArr = explode(',',$item['key']);

                $dataRaw = [
                    'platform' => $pointArr[1],
                    'device_name' => $pointArr[2],
                    'device_brand' => $pointArr[3],
                    'device_type' => $pointArr[4],
                    'device_version' => $pointArr[5],
                    'account' => $item['doc_count'],
                    'day' => $insert_day,
                    'hour' => $insert_hour,
                ];
                $table = 'cy_static_device_'.$pointArr[0];
                $where = [
                    'platform' => $pointArr[1],
                    'device_name' => $pointArr[2],
                    'device_brand' => $pointArr[3],
                    'device_type' => $pointArr[4],
                    'device_version' => $pointArr[5],
                    'day' => $insert_day,
                    'hour' => $insert_hour,
                ];
                $result = Db::table($table)->where($where)->find();
                if(!$result){
                    Db::table($table)->insert($dataRaw);
                }else{
                    Db::table($table)->where('id',$result['id'])->update($dataRaw);
                }

            }
        }
        return 1;
    }
}
