<?php
class form {
	// Create the contructor
	public function __construct($action='', $method='', $name = '') {
		// Create the form tag using user data
		echo '<form name="'.$name.'" action="'.$action.'" method="'.$method.'">';
	}
	public function cfElement($type = '', $name='', $class='', $val =[]) {
		$res = '';
		// create the form element for the user
		if ($type == 'select') {
			$res .= '<select class="'.$class.'" name="'.$name.'">';
			foreach ($val as $key => $value) {
				$res .= '<option value="'.$value.'">'.$value.'</option>';
			}
			$res .= '</select>';
		} else if ($type == 'radio' || $type == 'checkbox') {
			// Iterate through the values and return them
			foreach ($val as $key => $value) {
				// create form element with $value and append to $res
				$res .= '<input type="'.$type.'" name="'.$name.'" class="'.$class.'" value="'.$value.'">'. $value .'<br />';
			}
		} else if ($type='textarea') {
			//take textarea measurement from form val[] array
			$res = '<textarea name="'.$name.'" class="'.$class.'" row="'.$val[0].'" col="'.$val[1].'"></textarea>';
		} else {
			$res = '<input type="'.$type.'" name="'.$name.'" class="'.$class.'">';
		}
		echo $res;
	}
	public function __destruct(){
		// End the form
		echo '</form>';
	}
}
?>