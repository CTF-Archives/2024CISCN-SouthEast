#!/bin/bash
###
 # @Author: nzp
 # @Date: 2022-10-21 17:06:38
 # @LastEditors: nzp
 # @LastEditTime: 2022-10-21 17:28:49
 # @FilePath: /web_ctf/files/start.sh
### 

# # 启动 Mysql 服务器
# mysqld_safe &

# # 等待 Mysql 服务器启动完成
# mysql_ready() {
# 	mysqladmin ping --socket=/run/mysqld/mysqld.sock --user=root --password=root > /dev/null 2>&1
# }

# while !(mysql_ready)
# do
# 	echo "waiting for mysql ..."
# 	sleep 3
# done

# # 修改 root 用户密码
# mysql -e "ALTER USER 'root'@'localhost' IDENTIFIED WITH mysql_native_password BY 'root';flush privileges;" -uroot -proot

# # 导入数据库文件，初始化
# if [[ -f /db.sql ]]; then
#     mysql -e "source /db.sql" -uroot -proot
#     rm -f /db.sql
# fi

# 有自定义 FLAG 脚本则需要执行它，这里是从环境变量获取 FLAG，则需要 source 来执行这个脚本从而改写环境变量，避免非预期解
if [[ -f /flag.sh ]]; then
	source /flag.sh
	rm -f /flag.sh
fi

service ssh start

# 启动 Apache2 网站服务器
apache2-foreground
