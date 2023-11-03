#!/usr/bin/php
<?PHP
###################################################################################################
###> New x php -> _nginx_mysql_php.php  -> Initial creation user => eric => 2023-10-20_19:15:20 ###
###################################################################################################
#_#>

###> First this container needs to be created and started.
###> During the first start the default.conf file is written to /etc/nginx/conf.d/default.conf.
###> Do not recreate the container from image when adding php-fpm in the later step. The conf file will be created again over anything copied there.
###> Other options are to define the a different conf file with the hostname/fqdn, etc.

#######################################################################################################
###>	NGINX and PHP docker

$nginx_docker_compose_1='
---
services:
  nginx:
    image: nginx:latest
    container_name: rewbin-nginx
    ports:
      - "80:80"
';
function create_nginx_compose_1($loc,$nginx_docker_compose_1){
        if(trim($loc)=='')
                $loc='./';
        }
        $fh=fopen($loc.'docker-compose.yml','w');
        try{
                if(!fwrite($fh,$nginx_docker_compose_1)){
                        throw new exception();
                }
        }
        catch(exception($e)){
                echo $e->getMessage();
        }
}

$nginx_docker_compose_2='
---
services:
  nginx:
    build: ./nginx/
    container_name: rewbin-nginx
    ports:
      - "80:80"
      - "443:443"
    links:
      - php
    volumes:
      - ./www/html/:/var/www/html/

  php:
    image: php:8.1-fpm
    container_name: php-container
    expose:
      - 9000
    volumes:
      - ./www/html/:/var/www/html/ 
';
function create_nginx_compose_2($loc,$nginx_docker_compose_2){
        if(trim($loc)=='')
                $loc='./';
        }
        $fh=fopen($loc.'docker-compose.yml','w');
        try{
                if(!fwrite($fh,$nginx_docker_compose_2)){
                        throw new exception();
                }
        }
        catch(exception($e)){
                echo $e->getMessage();
        }
}
$nginx_config='
server {  

     listen 80 default_server;  
     root /var/www/html;  
     index index.html index.php;  

     charset utf-8;  

     location / {  
      try_files $uri $uri/ /index.php?$query_string;  
     }  

     location = /favicon.ico { access_log off; log_not_found off; }  
     location = /robots.txt { access_log off; log_not_found off; }  

     access_log off;  
     error_log /var/log/nginx/error.log error;  

     sendfile off;  

     client_max_body_size 100m;  

     location ~ .php$ {  
      fastcgi_split_path_info ^(.+.php)(/.+)$;  
      fastcgi_pass php:9000;  
      fastcgi_index index.php;  
      include fastcgi_params;  
      fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;  
      fastcgi_intercept_errors off;  
      fastcgi_buffer_size 16k;  
      fastcgi_buffers 4 16k;  
    }  

     location ~ /.ht {  
      deny all;  
    }  
} 
';
function create_nginx_config($loc,$nginx_config){
        if(trim($loc)=='')
                $loc='./';
        }
        $fh=fopen($loc.'default.conf','w');
        try{
                if(!fwrite($fh,$nginx_config)){
                        throw new exception();
                }
        }
        catch(exception($e)){
                echo $e->getMessage();
        }
}



###>  The Dockerfile for connecting with php-fpm
$nginx_dockerfile='
# syntax=docker/dockerfile:1
FROM nginx:latest
WORKDIR /var/www/html
COPY ./default.conf /etc/nginx/conf.d/default.conf
';
function create_nginx_dockerfile($loc,$nginx_dockerfile){
        if(trim($loc)=='')
                $loc='./';
        }
        $fh=fopen($loc.'Dockerfile','w');
        try{
                if(!fwrite($fh,$nginx_dockerfile)){
                        throw new exception();
                }
        }
        catch(exception($e)){
                echo $e->getMessage();
        }
}

###################################################################################################
###>	MySQL docker
$mysql_docker_compose='
version: '3.3'
services:
    db:
      platform: linux/x86_64
      image: mysql:8.0
      container_name: rew_mysql
      ports:
        - "3306:3306"
      volumes:
        - /home/ubuntu/wrk/docker/mysqld/data:/var/lib/mysql
      environment:
        - DEBIAN_FRONTEND=noninteractive
        - MYSQL_ROOT_PASSWORD=${MYSQL_ROOT_PASSWORD}
        - MYSQL_USER=${MYSQL_USER}
        - MYSQL_PASSWORD=${MYSQL_PASSWORD}
        - MYSQL_DATABASE=${MYSQL_DATABASE}
        - MYSQL_DATA=${MYSQL_DATA}
';
function create_mysql_compose($loc,$mysql_docker_compose){
        if(trim($loc)=='')
                $loc='./';
        }
        $fh=fopen($loc.'docker-compose.yml','w');
        try{
                if(!fwrite($fh,$mysql_docker_compose)){
                        throw new exception();
                }
        }
        catch(exception($e)){
                echo $e->getMessage();
        }
}

$mysql_dockerfile='

##############################################################################################
###> New Dockerfile  -> Richard Eric Walts as eric ---> 2023-06-24_15:16:37 init <<<
##############################################################################################
# syntax=docker/dockerfile:1
FROM ubuntu:22.04
WORKDIR .
# install app dependencies
RUN apt-get update
RUN apt-get install -y apt-utils expect

# variables for mysql install
ARG DEBIAN_FRONTEND
ARG MYSQL_ROOT_PASSWORD
ARG MYSQL_USER
ARG MYSQL_PASSWORD
ARG MYSQL_DATABASE
ARG MYSQL_PORT
ARG MYSQL_DATA


ENV DEBIAN_FRONTEND=$DEBIAN_FRONTEND
ENV MYSQL_ROOT_PASSWORD=$MYSQL_ROOT_PASSWORD
ENV MYSQL_USER=$MYSQL_USER
ENV MYSQL_PASSWORD=$MYSQL_PASSWORD
ENV MYSQL_DATABASE=$MYSQL_DATABASE
ENV MYSQL_PORT=$MYSQL_PORT
ENV MYSQL_DATA=$MYSQL_DATA

ADD npti.sql /etc/mysql/npti.sql


# mount data volume
VOLUME /var/lib/mysql

# install app
RUN apt-get install -y mysql-client mysql-server


RUN apt-get install -y  iptables


# start the app
#RUN /usr/sbin/mysqld start
# final configuration

RUN cp /etc/mysql/npti.sql /docker-entrypoint-initdb.d

EXPOSE 3306
';
function create_mysql_dockerfile($loc,$mysql_dockerfile){
        if(trim($loc)=='')
                $loc='./';
        }
        $fh=fopen($loc.'Dockerfile','w');
        try{
                if(!fwrite($fh,$mysql_dockerfile)){
                        throw new exception();
                }
        }
        catch(exception($e)){
                echo $e->getMessage();
        }
}

$mysql_env='
DEBIAN_FRONTEND=noninteractive
MYSQL_ROOT_PASSWORD=mySQL123!~
MYSQL_USER=ptDBUser
MYSQL_PASSWORD=dBp@ss4ptUs3r
MYSQL_DATABASE=npti
MYSQL_PORT=3306
MYSQL_DATA=/var/lib/mysql/data
';
function create_mysql_env($loc,$mysql_env){
	if(trim($loc)=='')
		$loc='./';
	}
	$fh=fopen($loc.'.env','w');
	try{
		if(!fwrite($fh,$mysql_env)){
			throw new exception();
		}
	}
	catch(exception($e)){
		echo $e->getMessage();
	}
}

function web_test_($str){
	$ch=curl_init();
	curl_setopt($ch,CURLOPT_URL,'http://localhost');
	curl_setopt($ch,CURLOPT_HEADER, 0);
	$out=curl_exec($ch);
	echo $out;
}


		
?>	
