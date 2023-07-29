<?php
/* 
 * @Description: 获取视频真实地址
 * @param: 视频BV号,p号，清晰度qn
 * @return: url/video
*/
function GetVideoSrchtml5($videoid,$p,$qn)
{
  include(DIR . '/system/config.php');
  $cid = GetCid($videoid,$p);
    $header = "cookie:" . $data['cookie'] . "\r\n";
    $Response = MyRequest("https://api.bilibili.com/x/player/playurl?bvid=$videoid&cid=$cid&qn=$qn&type=&otype=json&platform=html5&high_quality=1", $header, "", "", "");
    // echo $Response;
    $Response = json_decode($Response['body'], true);
    // echo $Response;
    return stripslashes($Response['data']['durl'][0]['url']);
    // return stripslashes($Response);
}

/* 
 * @Description: 安卓接口加密
 * @param: 视频cit，清晰度qn
 * @return: url
*/
function GetAppsign($cit,$qn)
    {
      // print_r($qn);
      $appsec = 'aHRmhWMLkdeMuILqORnYZocwMBpMEOdt';
      $params = [
      'appkey'=>'iVGUTjsxvpLeuDCf',
      'cid'=>$cit,
      'otype'=>'json',
      'qn'=>$qn,
      'quality'=>2,
      'type'=>'mp4'
      ];
      // $params=$params+$appkey;
      // asort($params);
      $url=urldecode(http_build_query($params));
      $sign=$url.$appsec;
      // print_r($sign);
      $sign=['sign'=>md5($sign)];
      // print_r($sign);
      $params=$params+$sign;
      $params=urldecode(http_build_query($params));
      // print_r($params);
      return $params;
    }
/* 
 * @Description: 获取视频真实地址
 * @param: 视频BV号,p号，清晰度qn
 * @return: url
*/
function GetVideoSrc($videoid,$p,$qn)
{
    include(DIR . '/system/config.php');
    $cid = GetCid($videoid,$p);
    $url= GetAppsign($cid,$qn);
    // print_r($url);
    $header = "cookie:" . $data['cookie'] . "\r\n";
    // $Response = MyRequest("https://api.bilibili.com/x/player/playurl?cid=$cid&bvid=$videoid&qn=80", $header, "", "", "");
    // echo ("https://interface.bilibili.com/v2/playurl?$url");
    $Response = MyRequest("https://app.bilibili.com/v2/playurlproj?$url", $header, "", "", "");
    // $Response = MyRequest("https://interface.bilibili.com/v2/playurl?$url", $header, "", "", "");
    // print_r("https://api.bilibili.com/x/player/playurl?cid=$cid&bvid=$videoid&qn=80");
    // $Response = json_decode($Response['body'], true);
    $Response = json_decode($Response['body'], true);
    // echo $Response;
    // print_r($Response);
    if (!empty($Response['durl'][0]['url'])) 
    {
    return stripslashes($Response['durl'][0]['url']);
    }else
    {
      return null;
    }
    // return stripslashes($Response);
}

/* 
 * @Description: 获取B站视频CID
 * @param: 视频id 如bv号或av号
 * @return: int/$cid
*/
function GetCid($videoid,$p)
{
    $Response = MyRequest("https://api.bilibili.com/x/player/pagelist?bvid=$videoid", "", "", "", "");
    // print_r($Response);
    $Response = json_decode($Response['body'], true);
    // print_r($Response);
    return $Response['data'][$p-1]['cid'];
}

/* 
 * @Description: 下载视频到本地
 * @param: $videoid
 * @return: 
*/
function DownloadVideo($videoid)
{
    include(DIR . '/system/config.php');
    $VideoUrl = GetVideoSrc($videoid);
    $Referer = "https://www.bilibili.com/video/$videoid";
    $useragent = "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/88.0.4324.150 Safari/537.36 Edg/88.0.705.63";
    $header = "user-agent:" . $useragent . "\r\n" . "referer:" . $Referer . "\r\n" . "cookie:" . $data['cookie'] . "\r\n" . "Origin:https://www.bilibili.com\r\n";
    $Response = MyRequest($VideoUrl, $header, "", "", "");
    $path = DIR . "/download/{$videoid}.flv";
    if (file_exists($path)) exit("此视频本地已存在无需再次下载!-----视频存放路径为{$path}");
    file_put_contents($path, $Response['body']);
    if (file_exists($path)) echo "视频下载成功-----视频存放路径为{$path}";
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
