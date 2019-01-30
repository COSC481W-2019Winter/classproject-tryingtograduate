### Person Object
- First Name – String
- Last Name – String
- Email Address – String
- Four Digit Code – Int
- Password – String (Hash to Store)
- Phone Number – (Optional) String
- Carrier.carrierID – Int
- isUser (Boolean)
- uniqueID – int 
- Sign-In, Sign-Up, Contacts 

### Group Object
- groupID – int
- groupName – String
- groupOwner (Person.uniqueID) – int
- members ([ ] Persons)

### Carrier Object
- Email address – string
- Name – string
- carrierID – int

### MessageHeader Object
- templateName – string (if populated, shows up in template dropdown)
- messageID – string
- gourpID – string
- senderID - string

### MessageBody Object
- subject – string
- content – string
- messageID – string (same as message in header)

### MessageQueue Object
- messageID – string

### ContactList Object
- List ([ ] Person)

