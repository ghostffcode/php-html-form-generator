<?php

//namespace Vendor\Helpers\Form;

class Form
{
    private $rendered = array();
    private $is_form = null;
    
    /*
    * make defined input attribute from array or string
    *
    * @return string
    */
    private function makeInputAttribute($attribute = null)
    {
        $arrangment = null;
        if (is_array($attribute)) {
            foreach ($attribute as $name => $value) {
                if (is_int($name)) {
                    $arrangment .= ' ' . $value;
                }
                else {
                    $arrangment .= ' ' . $name . '="' . $value . '"';
                }
            }
        }
        else {
            $new_attributes = array();
            foreach(explode(',', $attribute) as $randkey => $value) {
                if (strpos($value, ':')) {
                    list($name, $value) = explode(':', $value);
                    $new_attributes[$name] = $value;
                }
                elseif (trim($value) == true) {
                    $new_attributes[$randkey] = trim($value);
                }
            }
            return $this->makeInputAttribute($new_attributes);
        }
        return $arrangment;
    }
    
    /*
    * make defined selected option attribute 
    * from array or string
    *
    * @return string
    */
    private function makeOptionAttribute($attribute)
    {
        $arrangment = null;
        foreach ($attribute as $key => $names)
        {
            if (is_int($key)) {
                $key = null;
            }
            else {
                $key = 'value="' . $key . '"';
            }
            $new_name = $names;
            $selected = null;
            if (strpos($names, '|')) {
                $new_name = strstr($names, '|', true);
                $selected = ltrim(str_replace($new_name, '', $names), '|');
                $selected = ' '. $selected;
            }
            $arrangment .= PHP_EOL . '<option ' . $key . $selected . '>' .
                        $new_name .'</option>';
        }
        return $arrangment;
    }
    
    /*
    * defined an option tag generated from
    * specified loop
    *
    * @return string
    * @param (int) start
    * @param (int) end
    * @param (int) of number that should be marked as
    * selecetd
    */
    private function makeOptionRange($from, $to, $selected = null)
    {
        $arrangment = null;
        if ($from <= $to) {
            for($i = $from; $i <= $to; $i++)
            {
                $select = null;
                if ($i == $selected) {
                    $select = ' selected';
                }
                $arrangment .= PHP_EOL . '<option value="' . $i . '"' .
                              $select . '>' . $i .'</option>';
            }
        }
        else {
            for ($i = $from; $i >= $to; $i--) {
                $select = null;
                if ($i == $selected) {
                    $select = ' selected';
                }
                $arrangment .= PHP_EOL . '<option value="' . $i . '"' .
                              $select . '>' . $i .'</option>';
            }
        }
        return $arrangment;
    }
    
    /*
    * defined an option tag generated from
    * specified loop of months
    *
    * @return string
    * @param (strinf) the type of name to use
    *    full or abriviated
    * @param (string) month name that shoulb be marked
    * as selected
    */
    private function makeOptionMonth($order = null, $selected = null)
    {
        $full = array('January','February', 'March', 'April',
                     'May', 'June', 'July', 'August', 'September',
                     'October', 'November', 'December'
                     );
        $abr = array('Jan', 'Feb', 'Mar', 'Apr', 'May', 'June',
                        'July', 'Aug', 'Sept', 'Oct', 'Nov', 'Dec'
                    );

        $arrangment = null;
        $month = ($order == 'ABR') ? $abr : $full;
        foreach ($month as $value)
        {
            $select = null;
            if ($value == $selected){
                $select = ' selected';
            }
            $arrangment .= PHP_EOL . '<option value="' . $value . '"' .
                          $select . '>' . $value .'</option>';
        }
        return $arrangment;
    }
    private function callInput($method, $name = null, $attribute = null)
    {
        $name = ($name)? ' name="'.$name.'"' : '';
        $this->rendered[] = '<input type="' . $method . '"' . $name .
                          $this->makeInputAttribute($attribute) . '>';
    }
    
    /*
    * Defines a html form
    *
    * @return null
    * @param (string) form method
    * @paran (string) form action
    * @param (array | string) inpute attributes
    */
    public function createForm($method = null, $action = null, $attribute = null)
    {
        $this->is_form += 1;
        
        $method = ($method)? 'method="'.$method.'"' : '';
        $action = ($action)? ' action="'.$action.'"' : '';
        
        $this->rendered[] = '<form ' . $method . $action .
                          $this->makeInputAttribute($attribute) . '>';
        
        return $this;
    }
    
    /*
    * assing a value to an input
    *
    * @return null
    */
    public function val($value)
    {
        $last = end($this->rendered);
        $value = str_replace('>', ' value="' . $value . '">',
                    $last);
        array_pop($this->rendered);
        $this->rendered[] = $value;
        return $this;
    }
    
    /*
    * Defines a clickable input button 
    * (mostly used with a JavaScript to activate a script)
    *
    * @return null
    * @param (string) input name
    * @param (array | string) inpute attributes
    */
    public function button($name = null, $attribute = null)
    {
        $this->callInput('button', $name, $attribute);
        return $this;
    }
    
    /*
    * Defines an input checkbox
    *
    * @return null
    * @param (string) input name
    * @param (array | string) inpute attributes
    */
    public function checkbox($name = null, $attribute = null)
    {
        $this->callInput('checkbox', $name, $attribute);
        return $this;
    }
    
    /*
    * Defines an input color picker
    *
    * @return null
    * @param (string) input name
    * @param (array | string) inpute attributes
    */
    public function color($name = null, $attribute = null)
    {
        $this->callInput('color', $name, $attribute);
        return $this;
    }
    
    /*
    * Defines an input date control 
    * (year, month and day (no time))
    *
    * @return null
    * @param (string) input name
    * @param (array | string) inpute attributes
    */
    public function date($name = null, $attribute = null)
    {
        $this->callInput('date', $name, $attribute);
        return $this;
    }
    /*
    * Defines an input date and time control 
    * (year, month, day, hour, minute, second, 
    *    and fraction of a second (no time zone)    
    *
    * @return null
    * @param (string) input name
    * @param (array | string) inpute attributes
    */
    public function datetime_local($name = null, $attribute = null)
    {
        $this->callInput('datetime-local', $name, $attribute);
        return $this;
    }
    
    /*
    * Defines an input Defines a field for an e-mail address    
    *
    * @return null
    * @param (string) input name
    * @param (array | string) inpute attributes
    */
    public function email($name = null, $attribute = null)
    {
        $this->callInput('email', $name, $attribute);
        return $this;
    }
    
    /*
    * Defines an input file-select field and 
    * a "Browse..." button (for file uploads)    
    *
    * @return null
    * @param (string) input name
    * @param (array | string) inpute attributes
    */
    public function file($name = null, $attribute = null)
    {
        $this->callInput('file', $name, $attribute);
        return $this;
    }
    
    /*
    * Defines a hidden input field
    *
    * @return null
    * @param (string) input name
    * @param (array | string) inpute attributes
    */
    public function hidden($name = null, $attribute = null)
    {
        $this->callInput('hidden', $name, $attribute);
        return $this;
    }
    
    /*
    * Defines an image as the submit button
    *
    * @return null
    * @param (string) input name
    * @param (array | string) inpute attributes
    */
    public function image($name = null, $attribute = null)
    {
        $this->callInput('image', $name, $attribute);
        return $this;
    }
    
    /*
    * Defines a month and year control (no time zone)
    *
    * @return null
    * @param (string) input name
    * @param (array | string) inpute attributes
    */
    public function month($name = null, $attribute = null)
    {
        $this->callInput('month', $name, $attribute);
        return $this;
    }
    
    /*
    * Defines an input field for entering a number
    *
    * @return null
    * @param (string) input name
    * @param (array | string) inpute attributes
    */
    public function number($name = null, $attribute = null)
    {
        $this->callInput('number', $name, $attribute);
        return $this;
    }
    
    /*
    * Defines an input password field (characters are masked)
    *
    * @return null
    * @param (string) input name
    * @param (array | string) inpute attributes
    */
    public function password($name = null, $attribute = null)
    {
        $this->callInput('password', $name, $attribute);
        return $this;
    }
    
    /*
    * Defines an input Defines a radio button
    *
    * @return null
    * @param (string) input name
    * @param (array | string) inpute attributes
    */
    public function radio($name = null, $attribute = null)
    {
        $this->callInput('radio', $name, $attribute);
        return $this;
    }
    
    /*
    * Defines an input control for entering a number 
    * whose exact value is not important 
    * (like a slider control)
    *
    * @return null
    * @param (string) input name
    * @param (array | string) inpute attributes
    */
    public function range($name = null, $attribute = null)
    {
        $this->callInput('range', $name, $attribute);
        return $this;
    }
    
    /*
    * Defines an input reset button 
    * (resets all form values to default values)
    *
    * @return null
    * @param (string) input name
    * @param (array | string) inpute attributes
    */
    public function reset($name = null, $attribute = null)
    {
        $this->callInput('reset', $name, $attribute);
        return $this;
    }
    
    /*
    * Defines an input text field for entering 
    * a search string
    *
    * @return null
    * @param (string) input name
    * @param (array | string) inpute attributes
    */
    public function search($name = null, $attribute = null)
    {
        $this->callInput('search', $name, $attribute);
        return $this;
    }
    
    /*
    * Defines an submit button
    *
    * @return null
    * @param (string) input name
    * @param (array | string) inpute attributes
    */
    public function submit($name = null, $attribute = null)
    {
        $this->callInput('submit', $name, $attribute);
        return $this;
    }
    
    /*
    * Defines an input field for entering a telephone number
    *
    * @return null
    * @param (string) input name
    * @param (array | string) inpute attributes
    */
    public function tel($name = null, $attribute = null)
    {
        $this->callInput('tel', $name, $attribute);
        return $this;
    }
    
    /*
    * Defines an input single-line text field 
    * (default width is 20 characters)
    *
    * @return null
    * @param (string) input name
    * @param (array | string) inpute attributes
    */
    public function text($name = null, $attribute = null)
    {
        $this->callInput('text', $name, $attribute);
        return $this;
    }
    
    /*
    * Defines an input control for entering a time 
    * (no time zone)
    *
    * @return null
    * @param (string) input name
    * @param (array | string) inpute attributes
    */
    public function time($name = null, $attribute = null)
    {
        $this->callInput('time', $name, $attribute);
        return $this;
    }
    
    /*
    * Defines an input field for entering a URL
    *
    * @return null
    * @param (string) input name
    * @param (array | string) inpute attributes
    */
    public function url($name = null, $attribute = null)
    {
        $this->callInput('url', $name, $attribute);
        return $this;
    }
    
    /*
    * Defines an input week and year control 
    * (no time zone)
    *
    * @return null
    * @param (string) input name
    * @param (array | string) inpute attributes
    */
    public function week($name = null, $attribute = null)
    {
        $this->week('url', $name, $attribute);
        return $this;
    }
    
    /*
    * Defines a HTML Label Element  
    *
    * @return null
    * @param (string) for
    * @param (string) content
    * @param (string) form 
    */
    public function label($for = null, $value = null, $form = null)
    {
        $for = ($for)? ' for="' . $for . '"' : '';
        $form = ($form)? ' form="' . $for . '"' : '';
        $this->rendered[] = '<label' . $for . $form . '>' . $value . '</label>';
        return $this;
    }
    
    /*
    * Defines ur own custom form
    *
    * @return null
    * @param (string) input name
    */
    public function custom($attributes)
    {
        $this->rendered[] = $attributes;
        return $this;
    }
    
    /*
    * Defines your own custom form
    *
    * @return null
    * @param (string) input name
    */
    public function select($name = null, $attributes = null)
    {
        $this->rendered[] = '<select name="' . $name . '"' .
                        $this->makeInputAttribute($attributes) . '>';
        $this->rendered[] = true;
        return $this;
    }
    
    /*
    * Defines a HTML Option tags  
    *
    * @return null
    * @param (array) for makeOptionAttribute
    */
    public function options($attribute)
    {
        if (end($this->rendered) === true) {
            array_pop($this->rendered);
            $this->rendered[] = $this->makeOptionAttribute($attribute);
            $this->rendered[] = '</select>';
        }
        else {
            $this->rendered[] = 'Option method is expected to be called right after select method';
        }
        return $this;
    }
    
    /*
    * Defines a HTML Option tags with range
    *
    * @return null
    * @param (array) for makeOptionRange
    */
    public function optionsRange($from, $to, $selected = null)
    {
        if (end($this->rendered) === true) {
            array_pop($this->rendered);
            $this->rendered[] = $this->makeOptionRange($from, $to, $selected);
            $this->rendered[] = '</select>';
        }
        else {
            $this->rendered[] = 'Option method is expected to be called right after select method';
        }
        return $this;
    }
    
    /*
    * Defines a HTML Option tags with months
    *
    * @return null
    * @param (array) for makeOptionMonth
    */
    public function optionsMonth($order = null, $selected = null)
    {
        if (end($this->rendered) === true) {
            array_pop($this->rendered);
            $this->rendered[] = $this->makeOptionMonth($order, $selected);
            $this->rendered[] = '</select>';
        }
        else {
            $this->rendered[] = 'Option method is expected to be called right after select method';
        }
        return $this;
    }
    
    /*
    * chains all attribute
    *
    * @return string
    */
    public function make($is_html = true, $flag = null)
    {
        $form = implode(PHP_EOL, $this->rendered);
        for ($i = 0; $i < $this->is_form; $i++) {
            $form .= PHP_EOL . '</form>';
        }
        unset($this->rendered);
        $this->is_form = null;
        if (!$is_html){
            $form = htmlspecialchars($form, $flag);
        }
        return $form;
    }

}
