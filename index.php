<?php
require 'Form.php';

$form = new Form;

//simple usage
$Form = $form->createForm('post', 'index.php')
             ->text('fname')
             ->text('lname')
             ->email('email')
             ->password('password')
             ->hidden('token')
             ->select('age')->optionsRange(15, 80)
             ->label('custom', 'your custom input')
             ->custom('<input type="text" name="custom">')
             ->checkbox('TOS')
             ->submit('submit')
             ->make();

echo $Form;

//assigning values
$Form = $form->createForm('post', 'index.php')
             ->text('fname')->val('foo')
             ->text('lname')->val('bar')
             ->email('email')->val('foo@bar.com')
             ->password('password')
             ->hidden('token')
             ->select('car')->options(array('volvo' => 'Volvo',
											'saab'    => 'Saab',
											'audi'  => 'Audi|selected'
										   ))
             ->label('custom', 'your custom input')
             ->custom('<input type="text" name="custom">')
             ->checkbox('TOS')
             ->BSubmit('submit')->val('Submit Form')
             ->make();

echo $Form;

//assigning attribute
//array: array('class' => 'clsname', 'id' => 'idname', 'data-type' => 'dataname')
//  is same as
//string: 'class:clsname, id:idname, data-type:dataname'

$Form = $form->createForm('post', 'index.php', array('id' => 'formid'))
             ->text('fname', 'id:fnameid')
             ->text('lname', array('id' => 'lnameid'))
             ->email('email', 'id:emailid')
             ->password('password', array('id' => 'passwordid'))
             ->hidden('token')
             ->select('month')->optionsMonth()
             ->label('custom', 'your custom input')
             ->custom('<input type="text" name="custom">')
             ->checkbox('TOS')
             ->submit('submit')
             ->make();

echo $Form;

?>