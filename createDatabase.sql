drop database if exists of_back;
create database of_backstage character set utf8;
use of_backstage;
create table article(
	ID integer(11) not null auto_increment,
	title varchar(255) not null,
	author varchar(255) not null,
	date datetime not null,
	content longtext not null,
	parentID integer not null,
	primary key(ID)
);

create table category(
	categoryID integer(11) not null auto_increment,
	name varchar(255) not null,
	parentID integer(11),
	isvalid integer(1) not null default 1,
	primary key(categoryID)
);

insert into category(categoryID, name) values(-1, '##');

create table user(
	User char(16) not null,
	Password char(41) not null,
	primary key(User)
);

insert into user(User, Password) values('admin', '96e79218965eb72c92a549dd5a330112');
	

