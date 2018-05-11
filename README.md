# sparrowPHP



[![php版本支持>=5.2](https://img.shields.io/badge/php--version-%3E%3D5.2-brightgreen)](http://www.ldos.net/)
[![预览](https://img.shields.io/badge/%E9%A2%84%E8%A7%88-blue)](http://www.ldos.net/)

## 说明

1.sparrowPHP是一个简美的php框架，易于新手上路，适合开展服务器渲染页面的项目。改编此文档时，这个项目可能停止更新，
<br/>    
如果你想创建后台单页应用，建议使用[PHPapi](https://github.com/pqshawn/PHPapi-Framework) + [LdosCms](https://github.com/pqshawn/LdosCms)，我会在里面加入前台页面生成等，前台页面即改即生成。
<br/>     
关于这个项目会继续维护，像这个lastest版本，大于等于php5.2都可以支持，
<br/>  
如果低于php7的，建议修改config文件： define('DB_DRIVER', 'mysql'); 如果是php7以上版本，建议改为mysqli。
<br/>  
2.others文件夹里有针对版本的php.ini，注意要打开short_open_tag = On 。
<br/>  
3.另外nginx与apache环境的rewrite规则，apache服务可把others/.htaccess拷贝到项目application里。nginx的vhost项目配置可直接拷走使用。
<br/>  

## 一、部署环境
    假设你已经有PHP可执行项目的环境。如果没有，可安装xampp等集成包。
    推荐使用docker安装：
    下载
    $ sudo docker pull nginx
    $ sudo docker pull mysql
    $ sudo docker login --username=xxx@xxx.com registry.cn-shanghai.aliyuncs.com
    $ sudo docker pull registry.cn-shanghai.aliyuncs.com/ldos/centosphp7.4
    启动
    $ docker run -d --name php-fpm -p 9000:9000 -v /data/www:/data/www  php7.4
    $ docker run --name nginx --link php-fpm:php-fpm  -p 80:80 -v /data/www:/usr/share/nginx/html -v /var/3h3d/nginx/conf.d:/etc/nginx/conf.d  -d nginx
    docker run -p 3306:3306 -v /var/3h3d/mysql/config/my.cnf:/etc/mysql/my.cnf -v /var/3h3d/mysql/data:/var/lib/mysql -e MYSQL_ROOT_PASSWORD=123456  -d mysql

    /data/www 是宿主机的项目目录
    /var/3h3d/nginx/conf.d 是宿主机的nginx配置目录
    分别作下映射
    
## 二、安装

### 1.拷贝或git clone到项目指定目录
    根据你的用户，自己更改文件所属
    $ chown www:www -R .
    打开写权限
    $ chmod 757 mylogs/ -R
### 2.修改web服务器配置
    如果是nginx服务器，修改nginx指向application目录，把others/nginx/conf.d/test.conf可直接拷过去。
### 3.修改php.ini  
    short_open_tag = On
### 4.执行mysql命令
    在/databases文件夹下,如果是Linux系统，直接命令导入
    mysql -hlocalhost -uroot -p123456 < post.sql 
### 5.访问
    显示css叠云映射镜像的简单页面，如果vr虚拟技术支持的话，可在空气中滑动（很超前吧，vr可运行在空气中的话，我们就可以）


    

