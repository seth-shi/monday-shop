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

## Reference
* [Laravel 的中大型專案架構](http://oomusou.io/laravel/laravel-architecture/)
## License
MIT