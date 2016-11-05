PHP Html form generator [Documentation](http://ghostff.com/library/php/Html_form_generator)
----------
Generates a clean and functional HTML5 form markup

#USAGE
```php
$form = new Form('auth.php');
echo $form->text('username')
          ->password('password')
          ->hidden('token')->val('__token')
          ->submit('submit')
          ->rest();
```
