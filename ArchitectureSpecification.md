## Architechure Requirements
This document lists the components that our team feels that the project requires from an Architectural Standpoint. It contains mostly object classes that will be used in our database to ensure that a User can manage the Contacts that he/she wants to have in a group. An important note for reading this document, a "User" would be someone that has created an account on our site and is using our product, a "Contact" is someone that the User has created and added to a group to send messages to. 

### Person Object
This will be a list of all persons. It will handle all user accounts that sign up for Carrier Pigeon. This list will also contain all contacts that a user can create. This component will mainly be used for storing the data of each contact and each user. This list will interact with the list of group objects by referencing unique IDs to each person Object. A user can edit a Contacts Person object throught the Edit Groups page.
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
This will be a list containing all groups created by all users. They will be sorted by a group owner, which references a User's uniqueID. Each group will also be named, given a unique groupID, and a list of all Persons in that group. This Component will mainly be accessed on the Edit groups page, along with when a message is sent.
- groupID – int
- groupName – String
- groupOwner (Person.uniqueID) – int
- members ([ ] Persons)

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
- senderID - string

### MessageBody Object
This is the object that actually stores the message. Using 2 stings for storage, one for the subject and one for the body, the database will use the messageID as a unique identifier. 
- subject – string
- content – string
- messageID – string (same as message in header)

### MessageQueue Object
This is an important component if a group has a large number of contacts to send a message to, or if 2 users want to send messages at the same time. Using the messageID, a message to be sent will be added to the queue in chronological order to be sent.
- messageID – string

### ContactList Object
This component is a simple list of contacts. This list will be editable by the User from the Edit Groups page. it is a list of Person objects that all share a specific groupID.
- List ([ ] Person)

