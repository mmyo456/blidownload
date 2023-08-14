基于PHP的哔哩哔哩视频下载<br>
$type类型get/jump<br>
$id为视频的AV号/BV号<br>

```javascript
   演示DEMO 此接口使用腾讯云函数搭建 
   演示DEMO:https://6256k648y6.zicp.fun/blidownload/?type=get&id=BV19F411Q7f5
   仅需更改尾部id=bv号即可返回视频真实地址
   > 示例项目中的cookie可能会过期建议自行搭建使用，可配套本项目中浏览器插件进行实时更新
```


# 部署方法
> 
额，懂得都得


# 1.获取视频地址示例 推荐
>  
解析视频示例:https://6256k648y6.zicp.fun/blidownload/?type=get&id=BV1Wh4y1C712&p=5&qn=16<br>
解析并跳转视频示例:https://6256k648y6.zicp.fun/blidownload/?type=jump&id=BV1Wh4y1C712&p=5&qn=16<br>
解析并跳转视频懒人方法示例：https://6256k648y6.zicp.fun/?url=https://www.bilibili.com/video/BV1Wh4y1C712?p=2&vd_source=9cf00fe126483a7d41b52e407376a37a<br>
其中qn和p均为可选参数 不指定默认qn=116 p=1
返回结果:<br>

```javascript
{
"code": 200,
"msg": "视频地址获取成功",
"data": "https://upos-sz-mirrorcoso1.bilivideo.com/upgcxcode/28/96/292329628/292329628_nb2-1-32.flv?e=ig8euxZM2rNcNbNM7WdVhoMg7wUVhwdEto8g5X10ugNcXBlqNxHxNEVE5XREto8KqJZHUa6m5J0SqE85tZvEuENvNo8g2ENvNo8i8o859r1qXg8xNEVE5XREto8GuFGv2U7SuxI72X6fTr859r1qXg8gNEVE5XREto8z5JZC2X2gkX5L5F1eTX1jkXlsTXHeux_f2o859IB_&uipk=5&nbs=1&deadline=1614334765&gen=playurlv2&os=coso1bv&oi=3729533076&trid=f08874a409264862a24795c07d0a5cccu&platform=pc&upsig=b2ab93c04ef89db92a4fec2103cf787e&uparams=e,uipk,nbs,deadline,gen,os,oi,trid,platform&mid=0&orderid=0,3&agrr=1&logo=80000000"
}
```

# 折腾笔记

使用到的B站接口如下<br>

```javascript
1.转换bv或av号获取视频Cid
https://api.bilibili.com/x/player/pagelist?bvid=BV号
2.通过BV号以及Cid获取视频真实播放地址
https://api.bilibili.com/x/player/playurl?bvid=BV号&cid=cid号&qn=qn号&type=&otype=json&platform=html5&high_quality=1
qn对照表:
"超清 1080P+",116,
"高清 1080P",80,
"高清 720P",64,
"清晰 480P",32,
"流畅 360P",16,
PS：64和32我测试貌似不起作用
# 仅供学习交流，严禁用于商业用途! 点个Star吧,秋梨膏！

