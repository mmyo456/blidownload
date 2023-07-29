# BiliVideoDownload

> 基于 PHP 的哔哩哔哩视频下载<br>
> $type类型geturl/jump/autojump<br>
$id 为视频的 AV 号/BV 号/<br>
> $p 为视频的分 P 号/<br>
> ~~暂不支持番剧解析/下载<br>~~

```javascript
经测试部分大会员账户无法使用！

```

```javascript
   演示DEMO
   视频下载演示DEMO:
   仅需更改尾部id=bv号即可返回视频真实地址
   > 示例项目中的cookie可能会过期建议自行搭建使用!
```

# 部署方法

> 无<br>

# 1.获取视频地址示例 推荐

> 解析视频示例:http://您的 IP/blidownload/?type=geturl&id=BV1Qv4y1o7bT&p=1<br>

返回结果:<br>

```javascript
{
"code": 200,
"msg": "视频地址获取成功",
"data": "https://upos-sz-mirrorcoso1.bilivideo.com/upgcxcode/28/96/292329628/292329628_nb2-1-32.flv?e=ig8euxZM2rNcNbNM7WdVhoMg7wUVhwdEto8g5X10ugNcXBlqNxHxNEVE5XREto8KqJZHUa6m5J0SqE85tZvEuENvNo8g2ENvNo8i8o859r1qXg8xNEVE5XREto8GuFGv2U7SuxI72X6fTr859r1qXg8gNEVE5XREto8z5JZC2X2gkX5L5F1eTX1jkXlsTXHeux_f2o859IB_&uipk=5&nbs=1&deadline=1614334765&gen=playurlv2&os=coso1bv&oi=3729533076&trid=f08874a409264862a24795c07d0a5cccu&platform=pc&upsig=b2ab93c04ef89db92a4fec2103cf787e&uparams=e,uipk,nbs,deadline,gen,os,oi,trid,platform&mid=0&orderid=0,3&agrr=1&logo=80000000"
}
```

# 由于原接口变更 如需解析1080以上需要使用cookie 更新接口已写 可配合我的浏览器插件更新服务器cookie
# 仅供学习交流，严禁用于商业用途! 点个 Star 吧,秋梨膏！
