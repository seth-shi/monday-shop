# WaitMoonMan/monday-shop

## Feture
* `Model` : 仅当成`Eloquent class`
* `Service` : 辅助`controller`，处理程序逻辑，然后注入到`controller`
* `Controller` : 接收`HTTP request`调用其他`service`
* `Presenter` : 处理显示逻辑，然後注入到`view`
* `View` : 使用`blade`將数据`binding`到`HTML`
## Requirement
1. Laravel 5.5.13

## Installation
1. 获取源代码
* 直接下载压缩包或者[monday-shop.zip下载](https://github.com/WaitMoonMan/monday-shop/archive/master.zip)
* 或者`git`克隆源代码
```shell
git clone git@github.com:WaitMoonMan/monday-shop.git master
```
2. 安装依赖扩展包
```shell
composer install
```
3. 生成配置文件(修改其中的配置选项:数据库的一定要修改)
```shell
cp .env.example .env
```
4. 使用安装命令(会执行执行数据库迁移，填充，监听队列 !!! 不需要再监听队列，此命令已包含)
```shell
php artisan gps:install
```
```
## Usage
* 监听队列(邮件发送，图片裁剪 !!!)
```shell
php artisan queue:work --tries=3

## Optimize
* 执行缓存（缓存配置，路由，类映射）
```shell
php artisan gps:cache
```
* 清除缓存
```shell
php artisan gps:clear
```
* 使用`redis`或者`memcache`存储会话
```shell
config/session.php
```
* 使用`redis`或者`memcache`做缓存驱动
```shell
config/cache.php
```
## Errors
* 监听队列如果长时间没反应，或者一直重复任务
    * 数据库没配置好，导致队列任务表连接不上
    * 邮件配置出错，导致发送邮件一直失败
## Packages
| 扩展包 | 一句话描述 | 在本项目中的使用案例 |  
| --- | --- | --- |   
|[mews/captcha](https://github.com/mewebstudio/captcha)|验证码|登录注册功能使用验证码验证|
|[overtrue/laravel-socialite](https://github.com/overtrue/laravel-socialite)|第三方登录|用户登录可以使用Github,QQ,新浪微博|
|[spatie/laravel-permission](https://github.com/spatie/laravel-permission)|权限管理包|后台管理员操作权限|  
|[etrepat/baum](https://github.com/etrepat/baum)|无限分类|递归效率很低,快速让你的数据模型支持无限极树状层级结构，并且兼顾效率。|  
|[intervention/image](https://github.com/Intervention/image)|图片处理|是为 Laravel 定制的图片处理工具，加水印|  
|[webpatser/laravel-uuid](https://github.com/webpatser/laravel-uuid)|uuid生成|商品添加增加一个uuid，订单号|  
## Reference
* [Laravel 的中大型專案架構](http://oomusou.io/laravel/laravel-architecture/)
* [十个 Laravel 5 程序优化技巧](https://laravel-china.org/articles/2020/ten-laravel-5-program-optimization-techniques)
## TODO
* 数据库填充注释了部分代码，上线前记得开启
* 分类列表的分类加上排序
* 定时删除上传图片中多余的文件
* libpng warning: iCCP: known incorrect sRGB profile(裁剪图片队列出现的信息)
* 上传文件的路径写入 config 方便配置
## License
MIT
