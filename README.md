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
	*/
	$form->cfElement('select', 'contact', 'col-md-12', ['Male','Female','Other']);
?>
```
