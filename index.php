<?php
require('system/init.php');
if (!empty($_GET['url'])) {
  //懒狗接口 
  // http://ip+端口/blidownload/?type=url&url=https://www.bilibili.com/video/BV1W64y1v75s/?spm_id_from=333.337.search-card.all.click
  // 正则获取视频BV号
  preg_match_all('/BV([a-zA-Z0-9]{10})/', $_GET['url'], $bvid);
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
} else {
  switch ($_GET['type']) {
      // 获取链接 
      // http://ip+端口/blidownload/?type=get&id=BV1W64y1v75s&qn=16
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
      $file = fopen("system/config.php", "w");
      $txt = "<?php
        \$data = array(
          'cookie' => '$cookie'
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
