## **Requirements:** 
---
### **Overall:**
  - Must be accessible on all desktop web browsers
  -	Email addresses must be in a valid email format
  -	All text font should be tentatively Arial Rounded MT Bold
  -	Font size should vary between heading and comments: 24 and 14 pt. (tentatively)
### **Homepage/Sign in:**
  -	Main Page will have our title, 2 textboxes for Username and Password, Sign-In Button, Sign-Up Button, Forgot Password Button centered on the screen. 
  -	Text box fields cannot be empty.
  -	Forgot Password button sends a randomly Generated password to a desired email Address
### **Sign-Up:**
  -	Requires First Name, Last Name, Email Address, Password, Confirm Password
  -	Optional Phone number
  -	Every text Box must be filled, none can be blank (Except Phone Number)
  -	Sign-up button, runs verification method and takes user to their main page.
### **User Main page:**
  -	Welcome, %firstName% %lastName% Displayed across top of page.
  -	A large text box for a message to be written is in the center of the Screen. 
  -	A dropdown menu to select Groups from an ordered list, is on the top left of the text box
  -	The top right of the text box is a button to go to the Groups Page.
  -	Bottom left of the text box is the Send button
    -	Sends the message to group selected, If no group is selected, display an error message
    -	Displays a confirmation Pop-Up if message was sent
  -	Bottom right is a logout button, sends user back to Sign-in Screen
### **Groups Page:**
  -	Displays a list of groups in alphabetical Order
  -	One Group can be selected, allowing an edit button and a delete button to become clickable
  -	Add Group button (Top left) goes to a blank Edit Group page.
### **Edit Group Page:**
  -	Allows user to Edit (or create) group name within a text box in the top left.
  -	Center of Screen is an Alphabetical list of Group members by last name
  -	Clicking on a member shifts the list down
    o	Shows all member fields as editable text boxes: First name, Last Name, Email Address, Phone number
  -	Top right is a button that allows you to add a member
    -	Adding a member Creates a default Member: “Johnny Appleseed”
    -	Default Member can then be clicked on and edited.
  -	Save button is on the bottom right
  -	Exit button is next to save button
    -	If group was not saved before clicking exit, Prompt user to save, or exit without Saving.

