insert into Person (uniqueId, firstName, lastName, emailAddress, isUser)
            values (10, 'first', 'user', 'first.user@cpigeon.com', true);

insert into Person (uniqueId, firstName, lastName, emailAddress, isUser)
            values (20, 'second', 'user', 'second.user@cpigeon.com', true);
            
insert into Person (uniqueId, firstName, lastName, emailAddress, isUser, ownerId)
            values (100, 'contact', '100', 'contact100@cpigeon.com', false, 10);
            
insert into Person (uniqueId, firstName, lastName, emailAddress, isUser, ownerId)
            values (101, 'contact', '101', 'contact101@cpigeon.com', false, 10);
            
insert into Person (uniqueId, firstName, lastName, emailAddress, isUser, ownerId)
            values (200, 'contact', '200', 'contact200@cpigeon.com', false, 20);
            
insert into Person (uniqueId, firstName, lastName, emailAddress, isUser, ownerId)
            values (201, 'contact', '201', 'contact201@cpigeon.com', false, 20);
            
insert into Groups (groupId, groupName, ownerId)
            values (10, 'Group 10', 10);
            
insert into Groups (groupId, groupName, ownerId)
            values (20, 'Group 20', 20);
            
insert into Group_JT (groupOwnerId, groupId, contactId)
            values (10, 10, 100);

insert into Group_JT (groupOwnerId, groupId, contactId)
            values (10, 10, 101);
            
insert into Group_JT (groupOwnerId, groupId, contactId)
            values (20, 20, 200);
            
insert into Group_JT (groupOwnerId, groupId, contactId)
            values (20, 20, 201);

insert into Message(messageId, ownerId, groupId, subject, content)
            values(100, 10, 10, 'Message 1', 'This is test message 1');
            
insert into Message(messageId, ownerId, groupId, subject, content)
            values(200, 20, 20, 'Message 2', 'This is test message 2');
            
insert into Queue (messageId) values (100);
insert into Queue (messageId) values (200);

select
    *
  from
    Message
;

select
    *
  from
    Queue
;

delete
  from
    Message
;

select
    Queue.messageId as messageId,
    firstName,
    lastName,
    emailAddress,
    phoneNumber,
    carrierId,
    groupId,
    subject,
    content
  from
  (
    select
        min(taskNum) as taskNum,
        messageId
      from
        Queue
  ) as Queue
  inner join
    Message
  on
    Queue.messageId = Message.messageId
  inner join
  (
    select
        uniqueId,
        firstName,
        lastName,
        emailAddress,
        phoneNumber,
        carrierId
      from
        Person
    ) as Owner
  on
    Message.ownerId = Owner.uniqueId
;


select
    emailAddress,
    phoneNumber
  from
  (
    select
        contactId
      from
        Group_JT
      where
        groupId = 10
  ) as ContactId
  left join
  (
    select
        uniqueId,
        emailAddress,
        phoneNumber
      from
        Person
  ) as Contact
  on
    contactId = uniqueId
;

select
    emailAddress
  from
    Carrier
  where
    carrierId = 1
;

select
    count(*)
  from
    Queue
;

delete
  from
    Queue
  where
    messageId = 100
;

update
    Message
  set
    lastSent = sysdate()
  where
    messageId = 100
;