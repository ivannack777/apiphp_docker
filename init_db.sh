#!/bin/bash
mysqladmin password mysqlsenha
mysql -uroot -e "CREATE DATABASE desenvolvedores"
mysql -uroot desenvolvedores < /var/www/html/apiphp/db.sql


