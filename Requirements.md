## **Requirements:** 
---
![alt text](BasicFlow.PNG)
### **Overall:**
  - Must be accessible on all desktop web browsers
  -	Email addresses must be in a valid email format
  - Website Asethetics
	- All text font should be tentatively Arial Rounded MT Bold
	- Font size should vary between heading and comments: 24 and 14 pt
	- Background color will be green
	- Text will be white and black
	- Buttons will be green with darker shadow
	- Buttons will have rounded edges
### **Homepage/Sign in:**
  -	Homepage will display the company name (logo?) at top center.
  - "Sign-In" Button displayed below two text boxes for username and password.
  - "Sign-Up" Button displayed below five texboxes for name, email, phone, password, and confirm password. 
  - "Forgot Password" hyperlink below "Sign-In" button. 
### **Sign-Up:**
  -	Form: Name, Email Address, Phone, Password, Confirm Password
	- Required fields are Name, Email Address, Password, Confirm Password
	- Optional field: Phone number
  -	Sign-up button, runs verification method and takes user to their message dashboard.
### **Sign-In:** 
  - Form: Username (email address) and Password
	-All fields are required
  - Forgot Password hyperlink will allow the user to enter a registered eamil address to receive the forgotten password.
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

