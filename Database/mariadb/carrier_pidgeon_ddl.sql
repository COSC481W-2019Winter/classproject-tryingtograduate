drop database if exists carrier_pidgeon;
create database carrier_pidgeon;
use carrier_pidgeon;

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
  verifyCodeExp int,
  passwordHash varchar(80),
  phoneNumber varchar(15),
  carrierID int,
  isUser bool,
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
  foreign key (groupOwnerId) references Person (uniqueId),
  foreign key (groupId) references Groups (groupId)
);

create table Message
(
  messageId int not null auto_increment primary key,
  ownerId int not null,
  groupId int not null,
  subject varchar(80) not null,
  content longtext,
  lastSent date,
  templateName varchar(80),
  foreign key (ownerId) references Person (uniqueId),
  foreign key (groupId) references Groups (groupId)
);