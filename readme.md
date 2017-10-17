# WaitMoonMan/monday-shop

![开发图](http://or2pofbfh.bkt.clouddn.com/monday-shopmvc.png)
## Feture
* `Model` : 仅当成`Eloquent class`
* `Repository` : 辅助`model`，处理数据库逻辑，然后注入到`controller`
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
4. 使用安装命令(会执行执行数据库迁移，填充，监听队列)
```shell
php artisan gps:install
```
## Usage
1 监听队列（执行`php artisan gps:install`后会自动执行监听队列，无需重复）
```shell
php artisan queue:work
```

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

## Reference
* [Laravel 的中大型專案架構](http://oomusou.io/laravel/laravel-architecture/)
* [十个 Laravel 5 程序优化技巧](https://laravel-china.org/articles/2020/ten-laravel-5-program-optimization-techniques)
## License
MIT