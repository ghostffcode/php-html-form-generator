# phpform
This PHP script generates fully functional HTML form

```php
<?php
    require 'form.php';
	// Create an instance of the class
	// ('URL to submit form data', 'post or get', 'name of form')
	$form = new form('form_process.php', 'post', 'bliss');
	/* cFElement() Function creates the form element
	It accepts its arguments as: ('input type','input name', 'input class',,values');
	the input type => string,
	the input name => string,
	the input class value => string,
	the input value(s) => array
	*/
	$form->cfElement('select', 'cardType', 'selectElement', ['Credit Card','Debit Card']); // This creates a select input
	
	$form->cfElement('radio', 'sex', 'myRadio', ['Male','Female','Other']); // This creates a radio button
	
	$form->cfElement('checkbox', 'phoneType', 'myCheckbox', ['Android','iPhone','Other']); // This creates a checkbox
	
	/* The textbox value array accepts two values:
	The first value is row height and the second value is column height
	*/
	$form->cfElement('textarea', 'myTextarea', 'col-md-12', ['10','20']); // This creates a textarea
	
	$form->cfElement('text', 'username', 'myTextbox', []); // This creates a textbox
	
	$form->cfElement('password', 'uPassword', 'myPassword', []); // This creates a password field
?>
```
