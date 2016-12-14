# ConstantContactSingup
This is singup form plugin which integrate the form with constant contact account. 
Using this plugin wordpress site owner can allow their site visitor to singup for email campaigns (Constant contact)

There are two ways to display singup form
1) Widget
User can simply add the constanct contact widget to the sidebar where they want to show.

2) Shortcode
Here is the shortcode to display singup form on site.
Shortcode needs three inputs

cs - Login to your constant contact account. Goto contacts-> list growth tools->select form & click on "Action" -> "embed Code".
		Then you will get the html code, Within this code you have to search for ca:input field and copy its value here 
list - Login to your constant contact account. Goto contacts-> list growth tools->select form & click on "Action" -> "embed Code".
		Then you will get the html code, Within this code you have to search for ca:list field and copy its value here
firstname - If you want to display First name field put Yes otherwise No. By default its Yes.

[ccsingup ca="xxxxxxxx-xxx-xxxx-xxxx-xxxxxxxxxxxx" list="xxxxxxxxxx" firstname="Yes/No"] 
