<?php
	require 'form.php';

	// Create an instance of the class
	// In the following order
	// ('URL to submit form data', 'post or get', 'name of form')
	$form = new form('form_process.php', 'post', 'bliss');

	// Create a form element
	$form->cfElement('select', 'contact', 'col-md-12', ['Male','Female','Other']);

?>