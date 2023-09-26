<?php
require('system/init.php');
if (!empty($_GET['keyword']) && !empty($_GET['page'])) {
  Bilisearch($_GET['keyword'], $_GET['page']);
}
if (!empty($_GET['keyword']) && empty($_GET['page'])) {

  Bilisearch($_GET['keyword'], 1);
}
//懒狗接口 
if (!empty($_GET['url'])) {
  // 检测是不是直播链接
  if (strpos($_GET['url'], "live.bilibili") !== false) {
    $roomidpattern  = "/\d+/";
    preg_match($roomidpattern, $_GET['url'], $roomid);
    // echo $roomid[0];
    if (!empty($roomid)) {
      $Url = GetLiveRoomSrchtml5($roomid[0]);
      if (!empty($Url)) {
        // 直接跳转到视频地址
        Header("Location: $Url");
      } else {
        echo ResponseData('直播播放地址获取失败', 'error');
      }
    } else {
      echo ResponseData('请检测房间号是否存在', 'error');
    }
  }
  if (strpos($_GET['url'], "www.bilibili.com") !== false) {
    // 正则获取视频BV号
    preg_match_all('/BV([a-zA-Z0-9]{10})/', $_GET['url'], $bvid);
    if (empty($bvid)) {
      echo ResponseData('请检测BV号是否存在', 'error');
    }
    // 正则获取视频p号
    preg_match_all('/p=([0-9]{1,})/', $_GET['url'], $p);
    // 未指定p号时默认获取第一p
    if (empty($p[1][0])) {
      $p[1][0] = 1;
    }
    if (empty($_GET['qn'])) {
      //未指定清晰度时默认获取116清晰度
      $Url = GetVideoSrchtml5($bvid[0][0], $p[1][0], 116);
      if (!empty($Url)) {
        // 直接跳转到视频地址
        Header("Location: $Url");
      } else {
        echo ResponseData('视频播放地址获取失败', 'error');
      }
    } else {
      //指定清晰度 一般用于少数视频1080p无法播放时
      $Url = GetVideoSrchtml5($bvid[1][0], $p[1][0], $_GET['qn']);
      if (!empty($Url)) {
        // 直接跳转到视频地址
        Header("Location: $Url");
      } else {
        echo ResponseData('视频播放地址获取失败', 'error');
      }
    }
  }
  if (strpos($_GET['url'], "music.163.com") !== false) {
    $pattern = "/\?id=(\d+)/";
    preg_match($pattern, $_GET['url'], $matches);
    $id = $matches[1];
    // echo $id;
    $Url = GetMusicUrl($id);
    if (!empty($Url)) {
      // 直接跳转到视频地址
      Header("Location: $Url");
    } else {
      echo ResponseData('视频播放地址获取失败', 'error');
    }
  }
}
if (!empty($_GET['type'])) {
  switch ($_GET['type']) {
    case "get":
      // 未指定p号时默认获取第一p
      if (empty($_GET['p'])) {
        $_GET['p'] = 1;
      }
      if (empty($_GET['qn'])) {
        //未指定清晰度时默认获取116清晰度
        $Url = GetVideoSrchtml5($_GET['id'], $_GET['p'], 116);
        if (!empty($Url)) {
          echo ResponseData('视频地址获取成功', 'success', $Url);
        } else {
          echo ResponseData('视频播放地址获取失败', 'error');
        }
      } else {
        //指定清晰度 一般用于少数视频1080p无法播放时
        $Url = GetVideoSrchtml5($_GET['id'], $_GET['p'], $_GET['qn']);
        if (!empty($Url)) {
          echo ResponseData('视频地址获取成功', 'success', $Url);
        } else {
          echo ResponseData('视频播放地址获取失败', 'error');
        }
      }
      break;
      // 直接跳转到视频地址 一般适用于VLC等播放器 
      // http://ip+端口/blidownload/?type=jump&id=BV1W64y1v75s&qn=16
    case "jump":
      // 未指定p号时默认获取第一p
      if (empty($_GET['p'])) {
        $_GET['p'] = 1;
      }
      if (empty($_GET['qn'])) {
        //未指定清晰度时默认获取116清晰度
        $Url = GetVideoSrchtml5($_GET['id'], $_GET['p'], 116);
        if (!empty($Url)) {
          // 直接跳转到视频地址
          Header("Location: $Url");
        } else {
          echo ResponseData('视频播放地址获取失败', 'error');
        }
      } else {
        //指定清晰度 一般用于少数视频1080p无法播放时
        $Url = GetVideoSrchtml5($_GET['id'], $_GET['p'], $_GET['qn']);
        if (!empty($Url)) {
          // 直接跳转到视频地址
          Header("Location: $Url");
        } else {
          echo ResponseData('视频播放地址获取失败', 'error');
        }
      }
      break;
      // 更新cookie接口 可配合浏览器插件进行实时更新
    case "updatecookie":
      $cookie = $_GET['cookie'];
      $buvid3 = $_GET['buvid3'];
      $MUSIC_U = $_GET['MUSIC_U'];
      $file = fopen("system/config.php", "w");
      $txt = "<?php
    \$data = array(
      'cookie' => '$cookie;buvid3=$buvid3;MUSIC_U=$MUSIC_U;'
    );
    ?>";
      fwrite($file, $txt);
      fclose($file);
      echo ResponseData('Cookie更新成功', 'success', $data['cookie']);
      break;
    default:
      break;
  }
}

// 添加默认的HTML页面
if (empty($_GET)) {
  include('default.html');
}
?>