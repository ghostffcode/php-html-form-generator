<?php

class Form
{    
    private $debug = true;
    
    private $rendered = array();
    
    private $is_form = null;
    
    const TOKEN = '__token';
    
    /*
    * creates tag attributes
    *
    * @return string
    * @param (string | array) of attributes
    */
    private static function makeAttribute($attributes = null)
    {
        $arrangment = null;
        if (is_array($attributes)) {
            foreach ($attributes as $name => $value) {
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
            foreach(explode(',', $attributes) as $randkey => $value) {
                if (strpos($value, ':')) {
                    list($name, $value) = explode(':', $value);
                    $new_attributes[$name] = $value;
                }
                elseif (trim($value) == true) {
                    $new_attributes[$randkey] = trim($value);
                }
            }
            return self::makeAttribute($new_attributes);
        }
        return $arrangment;
    }
    
    private static function callInput($method, $name = null, $attributes = null)
    {
        if (is_array($name))
        {
            if ($name['data'] == 'range') {
                $new  = (isset($name['name']))? ' name="'.$name['name'].'"' : '';
                $new .= (isset($name['min']))? ' min="'.$name['min'].'"' : '';
                $new .= (isset($name['max']))? ' max="'.$name['max'].'"' : '';
            }
            $name = $new;
        }
        else {
            if ($method == 'custom') {
                return $name;
            }
            else {
                $name = ($name)? ' name="'.$name.'"' : '';
            }
        }
        
        return sprintf('<input type="%s"%s>',$method, $name . self::makeAttribute($attributes));
    }
    
    private static function makeLabellabel($for = null, $value = null, $form = null)
    {
        $form = ($form) ? ' form="' . $for . '"' : '';
        $for = ($for) ? ' for="' . $for . '"' : '';
        return '<label' . $for . $form . '>' . $value . '</label>';
    }
    
    private function makeOptionAttribute($attributes)
    {
        if (is_string($attributes)) {
            $new_attributes = array();
            foreach(explode(',', $attributes) as $randkey => $value) {
                if (strpos($value, ':')) {
                    list($name, $value) = explode(':', $value);
                    $new_attributes[$name] = $value;
                }
                elseif (trim($value) == true) {
                    $new_attributes[$randkey] = trim($value);
                }
            }
            $attributes = $new_attributes;
        }
        $arrangment = null;
        foreach ($attributes as $key => $names)
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
            if ($arrangment != null) {
                $arrangment .= PHP_EOL;    
            }
            $arrangment .= '<option ' . $key . $selected . '>' . $new_name .'</option>';
        }
        return $arrangment;
    }
    
    /*
    * define an option tag generated from
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
        $range = range($from, $to);
        $arrangment = null;
        foreach ($range as $values) {
            $select = null;
            if ($values == $selected) {
                $select = ' selected';
            }
            if ($arrangment != null) {
                $arrangment .= PHP_EOL;    
            }
            $arrangment .= '<option value="' . $values . '"' . $select . '>' . $values .'</option>';
            
        }
        return $arrangment;
    }
    
    /*
    * define an option tag generated from
    * specified loop of months
    *
    * @return string
    * @param (strinf) the type of name to use
    *    full or abriviated
    * @param (string) month name that shoulb be marked
    * as selected
    */
    private function makeOptionMonth($selected, $abbreviated)
    {
        $full = array(
            'January','February', 'March', 'April',
            'May', 'June', 'July', 'August', 'September',
            'October', 'November', 'December'
        );
        $abr = array(
            'Jan', 'Feb', 'Mar', 'Apr', 'May', 'June',
            'July', 'Aug', 'Sept', 'Oct', 'Nov', 'Dec'
        );

        $arrangment = null;
        $month = ($abbreviated) ? $abr : $full;
        foreach ($month as $value)
        {
            $select = null;
            if (strcasecmp($value, $selected) == 0){
                $select = ' selected';
            }
            if ($arrangment != null) {
                $arrangment .= PHP_EOL;    
            }
            $arrangment .= '<option value="' . $value . '"' . $select . '>' . $value .'</option>';
        }
        return $arrangment;
    }
    
    private static function makeButtons($method, $name = null, $value = null, $attributes = null)
    {
        $name = ($name) ? ' name="' . $name . '"' : '';
        return sprintf(
            '<button type="%s"%s>%s</button>',
            $method, $name . self::makeAttribute($attributes), $value
        );
    }
    
    private static function makeSelect($name = null, $attributess = null, $tag = 'open')
    {
        self::$selected = true;
        if ($tag == 'open') {
            return '<select name="' . $name . '"' . self::makeAttribute($attributess) . '>';
        }
        elseif ($tag == 'close') {
            return '</select>';    
        }
        else {
            return '<select name="' . $name . '"' . self::makeAttribute($attributess) . '></select>';
        }
    }
    
    private function token($name)
    {
        $token = range('a', 'z');
        $token = array_merge($token, range(1, 10));
        $token = array_merge($token, range('A', 'Z'));
        $token = array_merge($token, array('+~!@#$%&*_+=-'));
        $token = implode('', $token);
        $token = hash('sha512', str_shuffle($token));
        
        $this->{self::TOKEN} = $token;
        return $token;
    }
    
    /*
    * assing a value to an input
    *
    * @return object
    * @param (string) value to assign to last called method
    */
    public function val($value)
    {
        $last = end($this->rendered);
        if ($value == self::TOKEN) {
            $name = preg_match('/name=("|\')(.*?)("|\')/', $last, $matched);
            if (! isset($matched[2])) {
                die('a name must be assigned to '. self::TOKEN);
            }
            else {
                $name = trim($matched[2]);
                $value = $this->token($name);
            }
        }
        
        if (substr($last, 1, 6) == 'button') {        
            $value = str_replace('></button>', '>' . $value .
                 '</button>', $last);
        }
        elseif (substr($last, 1, 5) == 'input') {
            $value = str_replace('>', ' value="' . $value . '">',
                    $last);
        }
        array_pop($this->rendered);
        $this->rendered[] = $value;
        
        return $this;
    }
    
    /*
    * Defines your own custom form
    *
    * @return null
    * @param (string) input name
    */
    public function select($name = null, $attributess = null)
    {
        $this->rendered[] = '<select name="' . $name . '"' . self::makeAttribute($attributess) . '>';
        $this->rendered[] = true;
        return $this;
    }
    
    /*
    * Defines a HTML Option tags  
    *
    * @return object
    * @param (array) for makeOptionAttribute
    */
    public function options($attributes)
    {
        if (end($this->rendered) === true) {
            array_pop($this->rendered);
            $this->rendered[] = $this->makeOptionAttribute($attributes);
            $this->rendered[] = '</select>';
        }
        else {
            if ($this->debug) {
                $this->rendered[] = 'Option method is expected to be called right after select method';
            }
        }
        return $this;
    }
    
    /*
    * Defines a HTML Option tags with range
    *
    * @return object
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
            if ($this->debug) {
                $this->rendered[] = 'Option method is expected to be called right after select method';
            }
        }
        return $this;
    }
    
    /*
    * Defines a HTML Option tags with months
    *
    * @return object
    * @param (array) for makeOptionMonth
    */
    public function optionsMonth($selected = null, $abbreviated = false)
    {
        if (end($this->rendered) === true) {
            array_pop($this->rendered);
            $this->rendered[] = $this->makeOptionMonth($selected, $abbreviated);
            $this->rendered[] = '</select>';
        }
        else {
            if ($this->debug) {
                $this->rendered[] = 'Option method is expected to be called right after select method';
            }
        }
        return $this;
    }
    
    /*
    * construct a html form tag
    *
    * @return object
    * @param (string) form action
    * @param (string) form method
    * @param (string | array) form attributes
    */
    public function __construct($action = null, $method = 'post', $attributes = null)
    {
        $this->is_form += 1;
        $method = ($method)? 'method="'.$method.'"' : '';
        $action = ($action)? ' action="'.$action.'"' : '';
        $this->rendered[] = '<form ' . $method . $action . self::makeAttribute($attributes) . '>';
    }
    
    private static function messanger($name, $arguments)
    {
        $method = 'Form::callInput';
        
        if ($name == 'range')
        {
            $data = array(
                'name' => $name,
                'min'  => $arguments[1],
                'data' => 'range',
                'max'  => $arguments[2]
            );
            $arguments = array_merge(array($name), array($data), $arguments);
        }
        elseif ($name == 'label')
        {
            $method = 'Form::makeLabellabel';
        }
        elseif (substr($name, 0, 1) === '_')
        {    
            $method = 'Form::makeButtons';
            $name = strtolower(str_replace('_', '', $name));
            $arguments = array_merge(array($name), $arguments);
        }
        else
        {
            $arguments = array_merge(array($name), $arguments);
        }
        $tag = call_user_func_array($method, $arguments);
        return $tag;
        
    }
    
    public function __call($name, $arguments)
    {
        $this->rendered[] = self::messanger($name, $arguments);
        return $this;
    }
    
    public static function __callStatic($name, $arguments)
    {
        return self::messanger($name, $arguments);
    }
    
    /*
    * chains all method changes
    *
    * @return string
    * @param (bool) if false html entities are returned
    * @param (constant) htmlspecialchar flag
    */
    public function rest($is_html = true, $flag = null)
    {
        $form = implode(PHP_EOL, $this->rendered);
        for ($i = 0; $i < $this->is_form; $i++) {
            $form .= PHP_EOL . '</form>';
        }
        
        unset($this->rendered);
        $this->is_form = null;
        if ( ! $is_html){
            $form = htmlspecialchars($form, $flag);
        }
        //remove empty line
        //$form = preg_replace("/[\r\n]+/", "\n", $form);
        
        return $form;
    }
}