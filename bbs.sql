#1、创建数据库
create database bbs;
#2、选择数据库
use bbs;
#3、创建用户表
create table user(
	user_id int unsigned primary key auto_increment comment '主键id',
	user_name varchar(20) not null unique key comment '用户名',
	user_password char(20) not null comment '密码'
);
#4、创建帖子表
create table publish(
	pub_id int unsigned primary key auto_increment comment '主键ID',
	pub_title varchar(50) not null comment '帖子标题',
	pub_content text not null comment '帖子内容',
	pub_owner varchar(20) not null comment '楼主',
	pub_time int unsigned not null comment '发帖的时间戳',
	pub_hits int unsigned not null default 0 comment '帖子浏览次数'
);
#5、创建回帖表
create table reply(
	rep_id int unsigned primary key auto_increment comment '主键id',
	rep_pub_id int unsigned not null comment '楼主的id',
	rep_user varchar(20) not null comment '回复者',
	rep_content text not null comment '回复内容',
	rep_time int unsigned not null comment '回帖的时间戳',
	rep_num int unsigned not null default 0 comment '被引用的楼层数',
	rep_quote_id int unsigned not null default 0 comment '被引用的帖子的id'
);

