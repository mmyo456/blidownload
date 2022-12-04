// ==UserScript==
// @name         哔哩哔哩一键解析
// @namespace    https://bbs.tampermonkey.net.cn/
// @version      0.1.0
// @description  try to take over the world!
// @author       Miro
// @match        https://www.bilibili.com/video*
// @grant        GM_xmlhttpRequest
// @grant        GM_notification
// ==/UserScript==

(function() {
  'use strict';
  var button = document.createElement("button");
  button.textContent = "一键解析";
  button.style.width = "40px";
  button.style.align = "center";
  button.style.color = "#FFFFFF";
  button.style.background = "#00AEEC";
  button.style.border = "1px solid #F1F2F3";
  button.style.borderRadius = "6px";
  button.style.transition="all 0.3s";
  button.style.boxSizing="border-box"
  button.style.padding='8px 4px 4px';
  button.style.lineHeight='14px';
  button.style.fontSize='12px';
  button.style.cursor='pointer';
  button.style.textalign='center';
  button.style.display='block';
  button.style.fontFamily='-apple-system, BlinkMacSystemFont, Helvetica Neue, Helvetica, Arial, PingFang SC, Hiragino Sans GB, Microsoft YaHei, sans-serif';
  button.style.marginBottom='12px';
  button.style.margin='0';
  button.addEventListener("click", clickBotton) //监听按钮点击事件
  var url=window.location.href;
  var BV = /(?<=\?p=).*?(?=&)/;
  var P = /(?=BV).*?(?=\?|\&)/;
  var BV1=url.match(BV)
  var P1=url.match(P);
  alert(BV1+P1);
  function clickBotton(){

  }
  setTimeout(function(){
      var like_comment = document.getElementsByClassName('fixed-nav')[0];
      like_comment.appendChild(button); //把按钮加入到 x 的子节点中
  },2000)
})();