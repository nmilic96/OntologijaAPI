create database nmilic_19 default character set utf8;
use nmilic_19;
create table ontologija(
    id int not null primary key auto_increment,
    resourceName varchar(200) not null,
    resourceType varchar(200) not null,
    resourceData text not null
);

