# WaitMoonMan/monday-shop
****
[演示地址：http://shop.shiguopeng.cn](http://shop.shiguopeng.cn)

[后台地址：http://shop.shiguopeng.cn/admin](http://shop.shiguopeng.cn/admin)
* 账号：`admin`
* 密码：`admin`
****
![PC首页](public/media/index_pc.png)
![支付](public/media/pay.gif)
![个人中心](public/media/map_center.png)
![积分模块](public/media/score.png)
![后台仪表盘](public/media/admin/dash_board.png)
![后台订单列表](public/media/admin/orders.png)
## Feture
- [x] **首页数据全走缓存（推荐使用`Redis`驱动）**
    * [x] 未登录的首页，零数据库查询，通过缓存驱动
    * [x] 计划任务每分钟会更新一次首页数据
    * [x] 开启秒杀模块，零数据库查询，通过`Redis`驱动
    * [ ] 登录之后首页零数据库查询，`Session`驱动数据
- [x] 积分功能
    * [x] 每日首次登录(访问网站)得到积分
    * [x] 连续登录 n 天得到积分
    * [x] 当天浏览商品数量 n 个得到积分
    * [x] 后台可新增 n+ 积分种类
- [x] 秒杀功能
    * 秒杀过期，自动回退库存
    * 使用延时队列，当订单超过三十分钟(可配置)未付款，自动取消订单
    * 秒杀商品，如果用户收藏，发送邮件提醒活动
    * 后台秒杀模块的开启关闭
    * 秒杀的商品数量，皆通过`Redis`读取
- [x] **第三方授权登录 + 登录回跳**
    * `Github`
    * `QQ`
    * 微博 
- [x] **第三方支付(支持自动适应手机，web 支付)**
    - [x] 支付宝支付,退款
    - [ ] 微信支付
- [x] **购物车**
    * 使用`H5`本地存储
    * 登录之后同时显示本地购物车和数据库购物车数量
    * 用户登录之后会询问是否需要持久化到数据库
- [x] **商品搜索**
    * 支持拼音首字母
    * `AJAX`无刷新显示
- [x] **订阅模块**
    * 每周定时推送一封邮件包含最受欢迎，最新，最火卖商品
- [x] **分类排序**
    * 后台使用拖动排序，可以设置在商城首页优先展示的分类
- [x] **评论模块**
    * 用户下订单之后可以评论
- [x] **数据统计**
    * 每天晚上一点进行站点数据统计
- [ ] 全文搜索
- [x] **响应式网站**

## Installation
1. 获取源代码
* 直接下载压缩包或者[monday-shop.zip下载](https://github.com/DavidNineRoc/monday-shop/archive/master.zip)
* 或者`git`克隆源代码
```shell
git clone git@github.com:DavidNineRoc/monday-shop.git
```
2. 安装依赖扩展包
```shell
composer install
```
3. 生成配置文件(修改其中的配置选项:数据库的一定要修改)
```shell
cp .env.example .env
```
4. 开启秒杀功能
    * 安装前可以把`database/seeds/SettingsTablesSeeder.php`中的`is_open_seckill`设置为`1`
    * 安装之后可以直接通过后台管理系统设置中的配置设置管理
5. 使用安装命令(会执行执行数据库迁移，填充，等)
```shell
php artisan moon:install
```
* 任务调度(订阅推荐，数据统计！！！)
    * [windows下使用laravel任务调度](http://blog.csdn.net/forlightway/article/details/77943539)
    * [linux请去看官网](https://d.laravel-china.org/docs/5.5/scheduling)
* 运行队列处理器(发送订阅邮件等耗时任务)
    * `Linux`系统: 
        * `nohup php artisan queue:work --tries=3 &`
    * `windows`系统直接打开一个命令行窗口，运行命令，不要关闭窗口即可
        * `php artisan queue:work --tries=3`
### Commands
| 命令  | 一句话描述 |
| ----- | --- |
|`php artisan moon:install`|安装应用程序|
|`php artisan moon:uninstall`|卸载网站(清空数据库，缓存，路由)|
|`php artisan moon:cache`|执行缓存（缓存配置，路由，类映射）|
|`php artisan moon:clear`|清除缓存|
|`php artisan moon:copy`|复制项目内置的静态资源|
|`php artisan moon:delete`|删除项目及上传的基本静态资源|
|`php artisan moon:count-site`|统计站点任务（每天夜里一点执行）|
|`php artisan moon:del-seckills`|删除秒杀数据 (每小时自动执行一次)|
|`php artisan moon:moon:del-score-data`|删除积分缓存数据 (每天夜里 0 点执行)|
|`php artisan moon:update-home`|更新首页数据 (每分钟自动执行一次)|
|`php artisan moon:send-subscribes`|发送订阅邮件 (每个礼拜六早上八点)|
|`php artisan queue:work --tries=3`|监听队列(邮件发送，处理过期的秒杀数据 !!!|

## 秒杀处理逻辑
```php

## 初始化抢购数据
<?php

// 假设当前秒杀活动的 id 为 9
// 可以在模型的 created 事件做这个事情
$id = 9;;

// 填充一个 redis 队列，数量为抢购的数量，后面的 9 无意义
\Redis::lpush("seckills:{$id}:queue", array_fill(0, $seckill->number, 9));

?>

## 抢购
<?php

// 从路由或者参数中得到当前秒杀活动的 id
$id = 9;
$userId = auth()->id();

// 判断是否已经开始了秒杀

// 返回 0，代表当前用户已经抢购过了
if (0 == Redis::hset("seckills:{$id}:users:{$userId}", 'id', $userId)) {

    return responseJson(403, '你已经抢购过了');
}

// 如果从队列中读取到了 null，代表已经没有库存
if (is_null(Redis::lpop("seckills:{$id}:queue"))) {

    return responseJson(403, '已经抢购完了');
}

// 这里就可以开始入库订单

?>

## 利用 crontab 定时扫描过期数据，回滚库存，删除过期 redis (可选)
<?php

 // 查出已经过期确没有回滚过的秒杀，
Seckill::query()
       ->where('end_at', '<', date('Y-m-d H:i:s'))
       ->get()
       ->map(function (Seckill $seckill) {
           
           // 先模糊查找到所有用户 key
           $ids = Redis::keys("seckills:{$seckill->id}:*");
           Redis::del($ids);
           
           // 回滚库存
           // 做更多的事
       };
       
?>

```

## Packages
| 扩展包 | 一句话描述 | 在本项目中的使用案例 |
| --- | --- | --- |
|[z-song/laravel-admin](https://github.com/z-song/laravel-admin)|后台|快速搭建后台系统|
|[mews/captcha](https://github.com/mewebstudio/captcha)|验证码|登录注册功能使用验证码验证|
|[overtrue/laravel-socialite](https://github.com/overtrue/laravel-socialite)|第三方登录|用户登录可以使用Github,QQ,新浪微博|
|[intervention/image](https://github.com/Intervention/image)|图片处理|是为 Laravel 定制的图片处理工具，加水印|
|[webpatser/laravel-uuid](https://github.com/webpatser/laravel-uuid)|uuid生成|商品添加增加一个uuid，订单号|
|[renatomarinho/laravel-page-speed](https://github.com/renatomarinho/laravel-page-speed)|压缩页面DOM|打包优化您的网站自动导致35％以上的优化（已移除使用）|
|[overtrue/laravel-pinyin](https://github.com/overtrue/laravel-pinyin)|汉语拼音翻译|分类首字母查询|
## Reference
* [Laravel 的中大型專案架構](http://oomusou.io/laravel/laravel-architecture/)
* [十个 Laravel 5 程序优化技巧](https://laravel-china.org/articles/2020/ten-laravel-5-program-optimization-techniques)
## Notice
* 建议开启`bcmath`扩展保证字符串数字运算正确
* 监听队列如果长时间没反应，或者一直重复任务
    * 数据库没配置好，导致队列任务表连接不上
    * 邮件配置出错，导致发送邮件一直失败
* `composer install`安装不上依赖
    * 请删除`composer.lock`文件，重新运行`composer install`
* `SQLSTATE[HY000]: General error: 1215 Cannot add foreign key constraint`
    * 数据库引擎切换到`InnoDB`
## License
MIT
