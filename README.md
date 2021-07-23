# file_sharing
## 相关文档

[vuetify](https://v2.vuetifyjs.com/zh-Hans/components/api-explorer/)

[thinkphp5.1文档](http://static.kancloud.cn/manual/thinkphp5_1/353946)
	
### 数据库实现

####管理员用户表

		CREATE TABLE  admin_user(
	    user_id int  PRIMARY KEY AUTO_INCREMENT,
	    user_name varchar(45) NOT NULL COMMENT "账户,用户名",
	    user_password varchar(50) NOT NULL ,
	    user_email varchar(45)  COMMENT "可不写",
	    user_create_time date,
	    user_realname varchar(20) COMMENT "管理员名字,可不填"
);
#### 文件夹表

		CREATE TABLE directory(
	    dir_id int  PRIMARY KEY AUTO_INCREMENT,
	    dir_parentid int NOT null DEFAULT 0 COMMENT "默认为零,即为顶级目录",
	    dir_name varchar(40) NOT null  ,
	    dir_file_num int DEFAULT 0 COMMENT "文件夹下的文件,默认0",
	    dir_acu_path varchar(200) COMMENT "文件夹在静态文件夹下的完整路径",
	    dir_create_time date
	);
	
#### 文件信息表
	
		CREATE TABLE file(
	    file_id int PRIMARY KEY AUTO_INCREMENT,
	    file_name varchar(100) NOT NULL unique COMMENT "文件名字",
	    file_md5_name varchar(200) COMMENT "文件md5名字,或许没有",
	    file_dir_id int not null DEFAULT 1 COMMENT "文件所在文件夹的id,默认为1,即根路径下",
	    file_acu_path varchar(200) not NULL  COMMENT "文件路径",
	    file_download_num int default 0 COMMENT "文件下载量",
	    file_upload_time datetime ,
	    file_type varchar(30) COMMENT "文件类型",
	    file_size varchar(50) COMMENT "文件大小"
	    file_img VARCHAR(100) COMMENT "封面,可有可无"
	)
INSERT INTO directory (
    dir_id,
    dir_parentid,
    dir_name,
    dir_file_num,
    dir_acu_path,
    dir_create_time
  )
VALUES (
    1,
    0,
    "books",
    0,
    "./uploads/",
    now()
  );
#####大文件上传
	nginx配置加上  client_max_body_size 100m;
	php.ini 改变
	upload_max_filesize = 100M;
	post_max_size = 100M;
	