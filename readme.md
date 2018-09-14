<div data-type="alignment" data-value="center" style="text-align:center">
  <h1 id="ug5gkf" data-type="h">
    <a class="anchor" id="钉钉-sdk" href="#ug5gkf"></a>钉钉 SDK</h1>
</div>

<div data-type="alignment" data-value="center" style="text-align:center">
  <div data-type="p"></div>
</div>


## 请先阅读 [钉钉文档](https://open-doc.dingtalk.com/microapp/serverapi2)

## 配置
```php
$config = [
    'corpid' => '',
    'corpsecret' => '',
    'socialite' => [
        'dashboard' => [
        'appid' => '',
        'appserect' => '',
        ]
    ], 
    'microapp' => [
        'default' => '191027579',
    ]
];
```
## 群机器人
### 使用

首先[获取 access\_toekn](https://open-doc.dingtalk.com/microapp/serverapi2/qf2nxq)

```php
// 传入 access_token= 后面的部分
$ding = new Robot($access_token);
```

#### @功能

to 方法支持 @ 某人 或 @ 所有人，
@ 指定人，可以是对应的手机号数组或以英文逗号分隔的字符串
@ 所有人，传入字符串 all

### 消息类型

#### text 类型

```php
$message = new Text('hello world');
$result = $ding->to('all')->send($message);
// or
$result = $ding->to(['18912341234'])->send('hello world');
```

#### link 类型

```php
$link = new Link([
    "text" => "文字主体部分",
    "title" => "文字标题",
    "picUrl" => "",
    "messageUrl" => "https://mp.weixin.qq.com"
]);
$result = $notice->send($link);
```

#### markdown

```php
$markdown = new Markdown([
    "title" => "杭州天气",
    "text" => "#### 杭州天气 @156xxxx8827\n".
        "> 9度，西北风1级，空气良89，相对温度73%\n\n".
        "> ![screenshot](http://image.jpg)\n".
        "> ###### 10点20分发布 [天气](http://www.thinkpage.cn/) \n"
]);
$result = $notice->send($markdown);
```

#### 整体跳转ActionCard类型

```php
$card = new ActionCard([
    "title" => "乔布斯 20 年前想打造一间苹果咖啡厅，而它正是 Apple Store 的前身",
    "text" => "![screenshot](@lADOpwk3K80C0M0FoA)
               ### 乔布斯 20 年前想打造的苹果咖啡厅
               Apple Store 的设计正从原来满满的科技感走向生活化，而其生活化的走向其实可以追溯到 20 年前苹果一个建立咖啡馆的计划",
    "hideAvatar" => "0",
    "btnOrientation" => "0",
    "singleTitle" => "阅读全文",
    "singleURL" => "https://www.dingtalk.com/"
    ]);
$result = $notice->send($card);
```

#### 独立跳转ActionCard类型

```php
$card = new ActionCard([
    "title" => "乔布斯 20 年前想打造一间苹果咖啡厅，而它正是 Apple Store 的前身",
    "text" => "![screenshot](@lADOpwk3K80C0M0FoA) 
               ### 乔布斯 20 年前想打造的苹果咖啡厅 
                Apple Store 的设计正从原来满满的科技感走向生活化，而其生活化的走向其实可以追溯到 20 年前苹果一个建立咖啡馆的计划",
    "hideAvatar" => "0",
    "btnOrientation" => "0",
    "btns" => [
        [
            "title" => "内容不错",
            "actionURL" => "https://www.dingtalk.com/"
        ],
        [
            "title" => "不感兴趣",
            "actionURL" => "https://www.dingtalk.com/"
        ]
    ]
]);
$result = $notice->send($card);
```

#### FeedCard类型

```php
$feedCard = new FeedCard([
    "links" => [
        [
            "title" => "时代的火车向前开",
            "messageURL" => "https://mp.weixin.qq.com/s?__biz=MzA4NjMwMTA2Ng==&mid=2650316842&idx=1&sn=60da3ea2b29f1dcc43a7c8e4a7c97a16&scene=2&srcid=09189AnRJEdIiWVaKltFzNTw&from=timeline&isappinstalled=0&key=&ascene=2&uin=&devicetype=android-23&version=26031933&nettype=WIFI",
            "picURL" => "https://www.dingtalk.com/"
        ],
        [
            "title" => "时代的火车向前开2",
            "messageURL" => "https://mp.weixin.qq.com/s?__biz=MzA4NjMwMTA2Ng==&mid=2650316842&idx=1&sn=60da3ea2b29f1dcc43a7c8e4a7c97a16&scene=2&srcid=09189AnRJEdIiWVaKltFzNTw&from=timeline&isappinstalled=0&key=&ascene=2&uin=&devicetype=android-23&version=26031933&nettype=WIFI",
            "picURL" => "https://www.dingtalk.com/"
        ]
    ]
]);

$result = $notice->send($feedCard);
```


## 扫码登录第三方Web网站

```php
/**
 * @param $url 需自行编码
 * @return string 单独页面扫码方式打开的地址
 */
$dingtalk->socialite('config.socialite.name')->getRedirectUrl($url);
```

### 通过 code 获取用户信息
```php
/**
 * @param $code 前台获取的 code
 * @return array|string 用户的信息
*/
$dingtalk->socialite('config.socialite.name')->getUserInfo($code);
```

## 智能人事
### 所有在职员工的 id
```php
$dingtalk->employee()->all();
```

## 消息通知
### 发送工作通知消息
```php
$dingtalk->microapp()->send();
// todo 未完善
$dingtalk->microapp()->to()->send();
```

## 通讯录
### 用户管理
```php
// 获取用户信息
$dingtalk->user()->getUserInfo($userId);
```
### 部门管理
```php
// 所有部门，会递归子部门
$dingtalk->department()->all()
```
