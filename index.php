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
             ->submit('submit')->val('Submit Form')
             ->make();

echo $Form;

//assigning attribute
//array array('class' => 'clsname', 'id' => 'idname', 'data-type' => 'dataname')
//is same as
//string 'class:clsname, id:idname, data-type:dataname'

$Form = $form->createForm('post', 'index.php', array('class' => 'newclass')) //array atrribute method
             ->text('fname', 'class:fnameclass') //string atrribute method
             ->text('lname', array('class' => 'lnameclass')) //array atrribute method
             ->email('email', 'class:emailclass') //string atrribute method
             ->password('password', array('class' => 'passwordclass')) //array atrribute method
             ->hidden('token')
             ->select('month')->optionsMonth()
             ->label('custom', 'your custom input')
             ->custom('<input type="text" name="custom">')
             ->checkbox('TOS')
             ->submit('submit')
             ->make();

echo $Form;





//an empty form with post method
$Form = $form->createForm('post')
               ->make();
//outputs <form method="post"></form>


//an empty form with post method and action
$Form = $form->createForm('post', 'proceess.php')
               ->make();
//outputs <form method="post" action="proceess.php"></form>


//there are two ways to use attribute
//1: array (faster) eg (array('class' => 'myclass', 'id' => 'myid'))
//2: string        eg ('class:myclass, 'id:myid')

//USING ARRAY
$attr = array('class'       => 'new_class',
              'id'            => 'new_id',
              'data_id' => 'new_dataId'
             );
$Form = $form->createForm('post', 'proceess.php', $attr) //or $form->createForm('post', null, $attr)
               ->make();
//outputs <form method="post" action="proceess.php" class="new_class" id="new_id" data_id="new_dataId"></form>

//USING String
$attr = 'class:new_class, id:new_id, data_id:new_dataId';
$Form = $form->createForm('post', 'proceess.php', $attr) //or $form->createForm('post', null, $attr)
               ->make();
//outputs <form method="post" action="proceess.php" class="new_class" id="new_id" data_id="new_dataId"></form>



///------------------------------------------------------------------------------------------------------------------------


//using inputs
/*
methods 
	button, checkbox, color, date, datetime-local, email, file, hidden, image, month, number, 
	password, radio, range, reset, search, submit, tel, text, time, url, week

*/

//creat a form with an input type of text and name of usernmae
$Form = $form->createForm('post')
             ->text('username')
             ->make();
//outputs <form method="post"><input type="text" name="username"></form>

//passing attributes to input
$Form = $form->createForm('post')
             ->text('firstname', array('class' => 'fname'))
             ->text('lastname', 'class:lastname')
             ->make();
/*
outputs
    <form method="post">
        <input type="text" name="firstname" class="fname">
        <input type="text" name="lastname" class="lastname">
    </form>
*/

//passing attributes to input
$Form = $form->createForm('post')
             ->text('username')
             ->email('email')
             ->password('password')
             ->make();
/*
outputs
    <form method="post">
        <input type="text" name="username">
        <input type="email" name="email">
        <input type="password" name="password">
    </form>
*/

//passing values
//there are two ways to pass an input value
//1: through attributes (faster)
//2: using val constrain

//USING ATTRIBUTES
$Form = $form->text('username', array('value' => 'foo')) //or $form->text('username', 'value:foo')
             ->make();
//outputs <input type="text" name="username" value="foo">

//USING CONSTRAIN
$Form = $form->text('username')->val('foo')
             ->make();
//outputs <input type="text" name="username" value="foo">



///------------------------------------------------------------------------------------------------------------------------


//using the custom method

$Form = $form->custom('<input type="text" name="usernmae" class="newclass">')
             ->make();
//outputs <input type="text" name="usernmae" class="newclass">




///------------------------------------------------------------------------------------------------------------------------


//using select 
/*
    options
    optionsRange
    optionsMonth
*/

$Form = $form->select('days')
             ->make();
//outputs <select name="days">

//wtih attribute
$Form = $form->select('days', array('class' => 'newclass')) // or  $form->select('days', 'class:newclass')
             ->make();
//output <select name="days" class="newclass">

//adding options
$option = array('volvo' => 'Volvo',
                'saab'    => 'Saab',
                'audi'  => 'Audi|selected'
               );
$Form = $form->select('days', array('class' => 'newclass')) // or  $form->select('days', 'class:newclass')
             ->options($option)
             ->make();
/*
    outputs
    <select name="days" class="newclass">
        <option value="volvo">Volvo</option>
        <option value="saab">Saab</option>
        <option value="audi" selected>Audi</option>
    </select>
*/

//using optionsRange
//@param loop start
//@param loop end
//@param selected 
$Form = $form->select('days', array('class' => 'newclass')) // or  $form->select('days', 'class:newclass')
             ->optionsRange(2, 5, 3) //were 3 is the selected value
             ->make();
echo $Form;
/*
    outputs
    <select name="days" class="newclass">
        <option value="2">2</option>
        <option value="3" selected>3</option>
        <option value="4">4</option>
        <option value="5">5</option>
    </select>
*/

//using optionsMonth
//@param type of month name (full or abbriviated)
//@param name of selected month
$Form = $form->select('days', array('class' => 'newclass')) // or  $form->select('days', 'class:newclass')
             ->optionsMonth('ABR', 'Feb')
             ->make();
/*
    outputs
    <select name="days" class="newclass">
        <option value="Jan">Jan</option>
        <option value="Feb" selected>Feb</option>
        ....
    </select>
*/

$Form = $form->select('days', array('class' => 'newclass')) // or  $form->select('days', 'class:newclass')
             ->optionsMonth(null, 'March')
             ->make();
echo $Form;
/*
    outputs
    <select name="days" class="newclass">
        <option value="January">January</option>
        <option value="February">February</option>
        <option value="March" selected>March</option>
        <option value="April">April</option>
        <option value="May">May</option>
        ...
    </select>
*/


///------------------------------------------------------------------------------------------------------------------------


//label
//@param for
//@param content
$Form = $form->label('email', 'Email Address')
             ->make();
//output <label for="emai">Email Address</label>
?>