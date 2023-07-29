<?php
// https://api.bilibili.com/x/player/playurl?bvid=BV1TG411c7Hf&cid=894980768&qn=1&type=&otype=json&platform=html5&high_quality=1
require('system/init.php');

switch ($_GET['type']) {
    case "geturl":
      $Url = GetVideoSrc($_GET['id'],$_GET['p'],80);
      if (!empty($Url)) {
        echo ResponseData('视频地址获取成功', 'success', $Url);
      } else {
        $Url = GetVideoSrc($_GET['id'],$_GET['p'],64);
        if (!empty($Url)) {
          echo ResponseData('视频地址获取成功', 'success', $Url);
        } else {
          $Url = GetVideoSrchtml5($_GET['id'],$_GET['p'],80);
          if (!empty($Url)) {
            echo ResponseData('视频地址获取成功', 'success', $Url);
          } else {
            echo ResponseData('视频播放地址获取失败', 'error');
          }
        }
      }
        break;
    case "autojump":
        $Url = GetVideoSrc($_GET['id'],$_GET['p'],80);
        if (!empty($Url)) {
            Header("Location: $Url");
        } else {
          $Url = GetVideoSrc($_GET['id'],$_GET['p'],64);
          if (!empty($Url)) {
              Header("Location: $Url");
          } else {
            $Url = GetVideoSrchtml5($_GET['id'],$_GET['p'],80);
            if (!empty($Url)) {
                Header("Location: $Url");
            } else {
              echo ResponseData('视频播放地址获取失败', 'error');
            }
          }
        }
        break;
      case "jump":
        $Url = GetVideoSrchtml5($_GET['id'],$_GET['p'],80);
        if (!empty($Url)) 
        {
          Header("Location: $Url");
        } 
        else 
        {
          echo ResponseData('视频播放地址获取失败', 'error');
        }
        break;
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
        echo ResponseData('Cookie更新成功', 'success',$data['cookie']);
        break;
    default:
        break;
}
