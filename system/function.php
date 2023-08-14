<?php

/* 
 * @Description: 网页接口获取视频真实地址
 * @param: 视频BV号,p号，清晰度qn
 * @return: url/video
*/
function GetVideoSrchtml5($videoid, $p = 1, $qn = 116)
{
    include(DIR . '/system/config.php');
    $cid = GetCid($videoid, $p);
    $header = "cookie:" . $data['cookie'] . "\r\n";
    $Response = MyRequest("https://api.bilibili.com/x/player/playurl?bvid=$videoid&cid=$cid&qn=$qn&type=&otype=json&platform=html5&high_quality=1", $header, "", "", "");
    // 组合完成链接示例 https://api.bilibili.com/x/player/playurl?bvid=BV1TG411c7Hf&cid=894980768&qn=1&type=&otype=json&platform=html5&high_quality=1
    $Response = json_decode($Response['body'], true);
    return stripslashes($Response['data']['durl'][0]['url']);
}

/* 
 * @Description: 安卓接口获取视频真实地址 已失效
 * @param: 视频BV号,p号，清晰度qn
 * @return: url
*/
// function GetVideoSrc($videoid,$p,$qn)
// {
//     include(DIR . '/system/config.php');
//     $cid = GetCid($videoid,$p);
//     $url= GetAppsign($cid,$qn);
//     $header = "cookie:" . $data['cookie'] . "\r\n";
//     echo $url;
//     $Response = MyRequest("https://app.bilibili.com/v2/playurlproj?$url", $header, "", "", "");
//     $Response = json_decode($Response['body'], true);
//     if (!empty($Response['durl'][0]['url'])) 
//     {
//     return stripslashes($Response['durl'][0]['url']);
//     }else
//     {
//       return null;
//     }
// }
/* 
 * @Description: 安卓接口加密 已失效
 * @param: 视频cit，清晰度qn
 * @return: url
*/
// function GetAppsign($cit,$qn)
//     {
//       $appsec = 'aHRmhWMLkdeMuILqORnYZocwMBpMEOdt';
//       $params = [
//       'appkey'=>'iVGUTjsxvpLeuDCf',
//       'cid'=>$cit,
//       'otype'=>'json',
//       'qn'=>$qn,
//       'quality'=>2,
//       'type'=>'mp4'
//       ];
//       $url=urldecode(http_build_query($params));
//       $sign=$url.$appsec;
//       $sign=['sign'=>md5($sign)];
//       $params=$params+$sign;
//       $params=urldecode(http_build_query($params));
//       echo $params;
//       return $params;
//     }

/* 
 * @Description: 获取B站视频CID
 * @param: 视频id 如bv号或av号
 * @return: int/$cid
*/
function GetCid($videoid, $p)
{
    $Response = MyRequest("https://api.bilibili.com/x/player/pagelist?bvid=$videoid", "", "", "", "");
    $Response = json_decode($Response['body'], true);
    return $Response['data'][$p - 1]['cid'];
}

/* 
 * @Description: Web请求函数
 * @param: url 必填
 * @param: header 请求头 为空时使用默认值
 * @param: type 请求类型
 * @param: data 请求数据
 * @param: DataType 数据类型 分为1,2 1为数据拼接传参 2为json传参
 * @param: HeaderType 请求头类型 默认为PC请求头 值为PE时请求头为手机
 * @return: result
*/
function MyRequest($url, $header, $type, $data, $DataType, $HeaderType = "PC")
{
    //常用header
    //$header = "user-agent:" . 1 . "\r\n" . "referer:" . 1 . "\r\n" . "AccessToken:" . 1 . "\r\n" . "cookie:" . 1 . "\r\n";
    if (empty($header)) {
        if ($HeaderType == "PC") {
            $header = "user-agent:Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/88.0.4324.150 Safari/537.36 Edg/88.0.705.63\r\n";
        } else if ($HeaderType == "PE") {
            $header = "user-agent:Mozilla/5.0 (iPhone; CPU iPhone OS 13_2_3 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/13.0.3 Mobile/15E148 Safari/604.1 Edg/88.0.4324.150\r\n";
        }
    }
    if (!empty($data)) {
        if ($DataType == 1) {
            $data = http_build_query($data); //数据拼接
        } else if ($DataType == 2) {
            $data = json_encode($data, JSON_UNESCAPED_UNICODE); //数据格式转换
        }
    }
    $options = array(
        'http' => array(
            'method' => $type,
            "header" => $header,
            'content' => $data,
            'timeout' => 15 * 60, // 超时时间（单位:s）
        )
    );
    $context = stream_context_create($options);
    $result = file_get_contents($url, false, $context);
    $headers = get_headers($url, true); //获取请求返回的header
    $ReturnArr = array(
        'headers' => $headers,
        'body' => $result
    );
    return $ReturnArr;
}

/* 
 * @Description: 响应数据
 * @param: type 类型
 * @param: msg 响应内容
 * @param: data 响应数据
 * @return: json
*/
function ResponseData($msg, $type = 'success', $data = null)
{
    switch ($type) {
        case "success":
            $code = 200;
            break;
        case "warning":
            $code = 201;
            break;
        case "error":
            $code = 404;
            break;
        default:
            $Response = array(
                'code' => 500,
                'msg' => '未知的响应类型',
            );
            exit(json_encode($Response, JSON_UNESCAPED_UNICODE));
            break;
    }
    $Response = array(
        'code' => $code,
        'msg' => $msg,
        'data' => $data
    );
    return json_encode($Response, JSON_UNESCAPED_UNICODE);
}
