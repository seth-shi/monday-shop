# WaitMoonMan/monday-shop

![开发图](http://or2pofbfh.bkt.clouddn.com/monday-shopmvc.png)
## Feture
* `Model` : 仅当成`Eloquent class`
* `Repository` : 辅助`model`，处理数据库逻辑，然後注入到`service`
* `Service` : 辅助`controller`，处理程序逻辑，然後注入到`controller`
* `Controller` : 接收`HTTP request`調用其他`service`
* `Presenter` : 处理显示逻辑，然後注入到`view`
* `View` : 使用`blade`將数据`binding`到`HTML`
## Requirement
1. Laravel 5.5.13

## Installation
通过`git`下载源码或者直接下载压缩包
```shell
git clone / download zip
```
**修改数据库等配置**

在根目录下执行数据库迁移生成表
```shell
php artisan migrate
```
在根目录下执行数据库填充生成数据
```shell
php artisan db:seed

```

## Usage


## Support

## Reference
* [Laravel 的中大型專案架構](http://oomusou.io/laravel/laravel-architecture/)
## License
MIT