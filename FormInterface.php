<?php


interface FormInterface
{
    public function createForm($method = null, $action = null, $attribute = null);
    public function val($value);
    public function button($name = null, $attribute = null);
    public function checkbox($name = null, $attribute = null);
    public function color($name = null, $attribute = null);
    public function date($name = null, $attribute = null);
    public function datetime_local($name = null, $attribute = null);
    
    public function email($name = null, $attribute = null);
    public function file($name = null, $attribute = null);
    public function hidden($name = null, $attribute = null);
    public function image($name = null, $attribute = null);
    public function month($name = null, $attribute = null);
    public function number($name = null, $attribute = null);
    public function password($name = null, $attribute = null);
    
    public function radio($name = null, $attribute = null);
    public function range($name = null, $min = null, $max = null, $attribute = null);
    public function reset($name = null, $attribute = null);
    public function search($name = null, $attribute = null);
    public function submit($name = null, $attribute = null);
    public function tel($name = null, $attribute = null);
    public function text($name = null, $attribute = null);
    public function time($name = null, $attribute = null);
    
    public function url($name = null, $attribute = null);
    public function week($name = null, $attribute = null);
    public function label($for = null, $value = null, $form = null);
    public function BSubmit($name = null, $attributes = null);
    public function BReset($name = null, $attributes = null);
    public function custom($attributes);
    public function select($name = null, $attributes = null);
    public function options($attribute);
    
    public function optionsRange($from, $to, $selected = null);
    public function optionsMonth($order = null, $selected = null);
    public function make($is_html = true, $flag = null);

}