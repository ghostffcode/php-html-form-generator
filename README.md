# phpform
This PHP script generates fully functional HTML form  

createForm Functions:  
``createForm(method, action, attribute)`` :  creates a html form
---
Input Functions:  
``text(name, attribute)`` : Creates an Input field with type text   
``email(name, attribute)`` : Creates an Input field with type email   
``button(name, attribute)`` :  Creates an Input field with type button   
``color(name, attribute)`` :  Creates an Input field with type color    
``date(name, attribute)`` :  Creates an Input field with type date    
``file(name, attribute)`` :  Creates an Input field with type file   
``hidden(name, attribute)`` :  Creates an Input field with type hidden   
``image(name, attribute)`` :  Creates an Input field with type image   
``month(name, attribute)`` :  Creates an Input field with type month      
``number(name, attribute)`` :  Creates an Input field with type number   
``password(name, attribute)`` :  Creates an Input field with type password   
``radio(name, attribute)`` :  Creates an Input field with type radio   
``range(name, min, max, attribute)`` :  Creates an Input field with type password    
``reset(name, attribute)`` :  Creates an Input field with type reset   
``search(name, attribute)`` :  Creates an Input field with type search   
``submit(name, attribute)`` :  Creates an Input field with type submit  
``tel(name, attribute)`` :  Creates an Input field with type tel   
``time(name, attribute)`` :  Creates an Input field with type time   
``url(name, attribute)`` :  Creates an Input field with type url   
``week(name, attribute)`` :  Creates an Input field with type week    
``tel(name, attribute)`` :  Creates an Input field with type tel    
``datetime_local`` :  Creates an Input field with type datetime_local  

----
Button Functions:  
``BSubmit(name, attribute)`` :  Creates a button field with type submit   
``BReset(name, attribute)`` :  Creates a button field with type reset   

---
Select Functions:   
``select(name, attribute)`` :  Creates a selection field  
calls:   
``options(array(key => body))`` where ``key`` is the option value and ``body`` the option body   
``optionsRange(from, to, selected)`` creates number options from ``from`` to ``to``   
``optionsMonth(order, selected)`` creates month options. ``order('ABR' (abriviated)|null)  

---
Label Functions:   
``label(for, value, form)`` :  Creates a label tag 

---
Custom Functions:   
``custom(attribute)`` :  adds a custom code to form

---
Val Functions alias to ``attribute(value):``   
``val(string)`` :  add value to the last opened tag


**Usage**  
creating an empty html form
```php
$form = new Form;
$form = $form->createForm('post')
             ->make();
//result <form method="post"></form>
```
using an input function  
```php
$form = new Form;
$form = $form->createForm('post')
             ->text('name')
             ->make();

/* Result
<form method="post">
    <input type="text" name="name">
</form>
*/
```
passing a value to input  
There are three different methods used to pass values to an open tag   
``method 1`` as an array: `` array('value' => 'username')``   
``method 2`` as a string: ``'value:username``   
``method 3`` using ``val`` function: ``->val('username')`` takes only value  
```php
$form = new Form;
$form = $form->createForm('post')
             ->text('name', array('value' => 'username')) //method 1
             ->text('fname', 'value:first_name') //method 2
             ->text('lname')->val('last_name') //method 3
             ->make();
             

/* Result
<form method="post">
    <input type="text" name="name" value="username">
    <input type="text" name="fname" value="first_name">
    <input type="text" name="lname" value="last_name">
</form>
*/
```
*Note the ``attributes`` argurment does not take only value but ``val()`` does*  
So we can do this:  
```php
 $form->text('name', array('value' => 'newValue', 'class' => 'newClass', 'id' => 'newId')) //method 1
 //result: <input type="text" name="name" value="newValue" class="newClass" id="newId">
```
OR  
```php
 $form->text('name', 'value:newValue, class:newClass, id:newId') //method 2
 //result: <input type="text" name="name" value="newValue"  class="newClass"  id="newId">
```
But we cant do anything with ``val`` function except passing the value:
```php
 $form->text('name')->val(...) //method 3
```
Calling an attribute and also using the ``val`` function
```php
$form = new Form;
$form = $form->createForm('post')
             ->text('name', 'class:newClass')->val('FooBar')
             ->make();

/* Result 
<form method="post">
	<input type="text" name="name" class="newClass" value="FooBar">
</form>
*/
```
using an option function  
*Note:* you must call the ``select`` function before calling any of these auxiliaries:   
``options``   
``optionsRange``   
``optionsMonth``  
also you cant call the ``select`` function without calling any of the above auxiliaries   
```php
$form = new Form;
$form = $form->createForm('post')
             ->options(array('day' => 'Day'))
             ->make();

/* Result
<form method="post">
	Option method is expected to be called right after select method
</form>
*/
```
And
```php
$form = new Form;
$form = $form->createForm('post')
             ->select('day')
             ->make();

/* Result
<form method="post">
	<select name="day">
</form>
*/
```
with that said  
``options`` function   
``@param`` array of value and body
```php
$form = new Form;
$form = $form->createForm('post')
			 ->select('city')->options(array('texas' => 'TX USA', 'lagos' => 'LG Nigeria'))
             ->make();

/* Result
<form method="post">
	<select name="city">
		<option value="texas">TX USA</option>
		<option value="lagos">LG Nigeria</option>
	</select>
</form>
*/
```
``optionsRange`` function.  
``@param`` from  
``@param`` to  
``@param`` default selected number
```php
$form = new Form;
$form = $form->createForm('post')
			 ->select('day')->optionsRange(2, 4, 3)
             ->make();

/* Result
<form method="post">
	<select name="day">
      <option value="2">2</option>
      <option value="3" selected>3</option>
      <option value="4">4</option>
	</select>
</form>
*/
```
``optionsRange`` function   
``@param``order ``('ABR' | null)`` If ``ABR``: months name will be abriviated  
``@param`` default selected month
```php
$form = new Form;
$form = $form->createForm('post')
			 ->select('month')->optionsMonth('ABR', 'Aug')
             ->make();

/* Result
<form method="post">
	<select name="month">
    ...
      <option value="July">July</option>
      <option value="Aug" selected>Aug</option>
      <option value="Sept">Sept</option>
    ....
	</select>
</form>
*/
```

using ``label`` function
```php
$form = $form->label('custom', 'your custom input')
//Result: <label for="custom">your custom input</label>
```
using ``label`` with ``radio`` function
```php
$form = $form->createForm('post')
			 ->label('female', 'Female')
			 ->radio('gender', 'id:female')
             ->make();

/* Result
<form method="post">
	<label for="female">Female</label>
	<input type="radio" name="gender" id="female">
</form>
*/
```
``custom`` function
```php
$form = $form->custom('<input name="user" type="text" value="FooBar">')
			 ->make();
//Result: <input name="user" type="text" value="FooBar">
```

use ``hidden`` function  
``@param``: name   
``@param``: attribute  
If the ``attribute`` value of hidden is ``__token`` a random uniqe key in generated using ``sha512``   
On ``form.php`` you can store the generated token in a session to prevent ``CSRF`` on  ``function token($name)`` ``line: 162``

```php
$form = $form->hidden('token')->val('__token')
			 ->make();
//Result: <input type="hidden" name="token" value="59a869b5c3fdfa580e9...">
```
---
**DEMO**   
```php
$form = new Form;
$form = $form->createForm('post', 'index.php', array('id' => 'formid'))
			 ->text('fname', 'id:fnameid')
			 ->text('lname', array('id' => 'lnameid'))
			 ->email('email', 'id:emailid')
			 ->password('password', array('id' => 'passwordid'))
			 ->hidden('token')->val('__token') // ('token', 'value:__token') or ('token', array('value' => 'token')
			 ->select('month')->optionsMonth()
			 ->label('custom', 'your custom input')
			 ->custom('<input type="text" name="custom">')
			 ->checkbox('TOS')
			 ->submit('submit')
			 ->make();
/*Result:

<form method="post" action="index.php" id="formid">
    <input type="text" name="fname" id="fnameid">
    <input type="text" name="lname" id="lnameid">
    <input type="email" name="email" id="emailid">
    <input type="password" name="password" id="passwordid">
    <input type="hidden" name="token" value="d9cbd7c5600ed41ac7a63...">
    <select name="month">
        ...
        <option value="September">September</option>
        <option value="October">October</option>
        ...
    </select>
    <label for="custom">your custom input</label>
    <input type="text" name="custom">
    <input type="checkbox" name="TOS">
    <input type="submit" name="submit">
</form
*/
```