## Architechure Requirements
This document lists the components that our team feels that the project requires from an Architectural Standpoint. It contains mostly object classes that will be used in our database to ensure that a User can manage the Contacts that he/she wants to have in a group. An important note for reading this document, a "User" would be someone that has created an account on our site and is using our product, a "Contact" is someone that the User has created and added to a group to send messages to. 

### Person Object
This will be a list of all persons. It will handle all user accounts that sign up for Carrier Pigeon. This list will also contain all contacts that a user can create. This component will mainly be used for storing the data of each contact and each user. This list will interact with the list of group objects by referencing unique IDs to each person Object. A user can edit a Contacts Person object throught the Edit Groups page.
- First Name – string
- Last Name – string
- Email Address – string
- Four Digit Code – int
- Code Expire Date – Date
- Password – String (Hash to Store)
- Phone Number – (Optional) string
- Carrier.carrierID – int
- isUser (Boolean)
- uniqueId – int
- ownerId – int
- Sign-In, Sign-Up, Contacts 

### Group Object
This will be a list containing all groups created by all users. They will be sorted by a group owner, which references a User's uniqueID. Each group will also be named, given a unique groupID, and a list of all Persons in that group. This Component will mainly be accessed on the Edit groups page, along with when a message is sent.
- groupID – int
- groupName – string
- groupOwner (Person.uniqueID) – int
- members ([ ] Persons.unique)

### Carrier Object
This is a small component, but necessary for sending SMS messages to phone numbers. This class will take a Carrier name and convert it to a proper email address domain. This component will be used strictly when assigning a phone number an "email address"
- Email address – string
- Name – string
- carrierID – int

### MessageHeader Object
This will be used to store message templates for a user to select at a future time. Using a user defined template name, the user may select a template which will pull a message based on the messageID, GroupID, and senderID.
- templateName – string (if populated, shows up in template dropdown)
- messageID – string
- groupID – string
- senderID – string
- lastSent – date

### MessageBody Object
This is the object that actually stores the message. Using 2 stings for storage one for the subject and one for the body, the database will use the messageID as a unique identifier. 
- subject – string
- content – string
- messageID – string (same as message in header)

### MessageQueue Object
This is an important component if a group has a large number of contacts to send a message to, or if 2 users want to send messages at the same time. Using the messageID, a message to be sent will be added to the queue in chronological order to be sent.
- messageID – string

### ContactList Object
This component is a simple list of contacts. This list will be editable by the User from the Edit Groups page. it is a list of Person objects that all share a specific groupID.
- List ([ ] Person)

### Functions
- signin: This function will validate user by comparing password hash with password has stored in backend database based on uniqueId.
- createPerson: This function will create a Person Object and insert the data into the backend database. This function will be used for both user and contact creation. The uniqueId (primary key) field on the Person object will be generated at insert.
- setPassword: Will hash user supplied password and store resulting hash in password field of backend database referncing Person Object.
- generateValidationCode: Will create a one time 4 digit code that will be saved in the backend database referencing Person Object along with an expiration DateTime. This function will also email the 4 digit code to the email specified in the referenced Person Object to facilitate the completion of the signup process.
- verifyUserCode: This function will compare the user supplied 4 digit code with the copy stored in the database for the referenced Person Object 
- getGroups: This function uses the uniqueId of the referenced Person object to retrieve a list of groups owned (groupOwner) by the referenced user.
- getContacts: This function uses the groupId to retrieve the list of Person Objects associated with the referenced Group.
- getAllContacts: This function uses the uniqueId of the referenced Person object to retrieve a full list of all contacts owned (ownerId) by the user.
- getCarriers: This function will return a list of Carrier objects from the backend database to facilitate the assignement of a carrierId to a Person Object allowing the system to email an SMS message and to poplulate the carrier drop down list in the UI.
- getMessage: This function builds a complete email message from the backend database using the messageId. This function is used to display a saved template as well as by the MessageQueue component for sending emails.
- getMessageHeader: This function retrieves a MessageHeader Object from the backend database using the messageId. This function is used by the by getMessage in the assembly of outgoing smtp requests and the template list drop down in the UI.
- getMessageBody: This function retrieves a MessageBody Object from the backend database using the messageId. This function is used by getMessage in the assembly of outgoing smtp requests and to display a selected message template in the UI.
- saveMessage: This function saves the user supplied MessageHeader and MessageBody to the backend database linking both parts with the messageId (message lookup table primary key). This function returns the messageId.
- sendMessage: This function places the supplied messageId to the MessageQueue and notify the user that the message has been scheduled to be sent and they receive a summary via email once the message has been completely processed.

### Components
#### MessageQueueService
This component is responsible for assembling queued messages from the backend database identified by the messageId that has been placed in the queue.  The component is a backend process that will run (wake) periodically to process messages in the memory resident queue. Once the message is assembled the component will resolve the groupId and generate the requisite smtp messages prompting the smtp server to send the messages. Once the smtp messages have been generated and passed to the smtp server, the MessageQueueService will remove the message Id from the queue update the lastSent date in the messageHeader in the backend database and begin processing the next queued message. 