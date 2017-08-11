<p align="center"><img src="https://laravel.com/assets/img/components/logo-laravel.svg"></p>

## 介绍
  
  该项目后台是基于vue和laravel搭建的单页面CMS系统，包含了文章管理，权限管理，用户管理等基本模块。
  前台使用了传统web技术，laravel渲染搭建了个博客系统
 
## 搭建
 
- npm install
- composer install
- npm run dev / npm run prod
- 修改根目录下的env文件 填写自己的数据库信息
- php artisan migrate (也可使用目录下的cms.sql直接导入数据)
- php artisan db:seed


## demo

- <a href="http://112.74.160.25:8080/login">demo</a>
- 默认管理员账号: admin   
- 默认管理员密码：admin