drop database if exists Wi2017_436_kbledsoe3;
create database Wi2017_436_kbledsoe3;
use Wi2017_436_kbledsoe3;

drop table if exists Queue;
drop table if exists Message;
drop table if exists Group_JT;
drop table if exists Groups;
drop table if exists Person;
drop table if exists Carrier;

create table Carrier
(
  carrierId int not null auto_increment primary key,
  carrierName varchar(80) not null,
  emailAddress varchar(80) not null
);

create table Person
(
  uniqueId int not null auto_increment primary key,
  firstName varchar(80) not null,
  lastName varchar(80) not null,
  emailAddress varchar(80) not null,
  verifyCode int,
  passwordHash varchar(500),
  phoneNumber varchar(15),
  carrierID int,
  ownerId int,
  foreign key (carrierId) references Carrier (carrierId)
);

create table Groups
(
  groupId int not null auto_increment primary key,
  groupName varchar(80),
  ownerId int not null,
  foreign key (ownerId) references Person (uniqueId)
);

create table Group_JT
(
  primary_key int not null auto_increment primary key,
  groupOwnerId int not null,
  groupId int not null,
  contactId int not null,
  foreign key (groupOwnerId) references Person (uniqueId),
  foreign key (groupId) references Groups (groupId),
  foreign key (contactId) references Person (uniqueId)
);

create table Message
(
  messageId int not null auto_increment primary key,
  ownerId int not null,
  groupId int,
  subject varchar(80) not null,
  content longtext,
  templateName varchar(80),
  foreign key (ownerId) references Person (uniqueId)
);

create table Queue
(
  taskNum int not null auto_increment primary key,
  messageId int not null
);

insert into `Person`
  (uniqueId, firstName, lastName, emailAddress)
  values
  (1, 'carrier', 'pigeon', 'carrierpigeon@tryingtograduate.com');

insert into `Carrier`
  values
  (1,'Verizon','@vtext.com'),
  (2,'Sprint','@messaging.sprintpcs.com'),
  (3,'T-mobile','@tmomail.net'),
	(4,'AT&T','@txt.att.net'),
  (5,'Cricket','@mms.cricketwireless.net'),
	(6, 'Virgin Mobile', '@vmobl.com'),
	(7, 'Metro PCS', '@mymetropcs.com'),
	(8, 'Boost Mobile', '@sms.myboostmobile.com'),
	(9, 'Google Fi', '@msg.fi.google.com'),
	(10, 'U.S. Cellular', '@email.uscc.net'),
	(11, 'Ting', '@email.uscc.net'),
	(12, 'XFinity Mobile', '@vtext.com'),
	(13, 'Consumer Cellular', '@mailmymobile.net'),
	(14, 'C-Spire', '@cspire1.com'),
	(15, 'Page Plus', '@vtext.com'),
	(99, 'Select Carrier', 'noEmail')
;
