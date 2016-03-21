<?php
	require 'form.php';

	$form = new form('form_process.php', 'post', 'bliss');

	$form->cfElement('select', 'contact', 'col-md-12', ['Male','Female','Other']);

?>