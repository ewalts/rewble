
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
