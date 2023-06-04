<?php
function grabload(){

$rows_rules = R::findAll('grabrule');
foreach ($rows_rules as $rule){
	$check = '';
	$recurs = "FALSE";
	if ($rule["is_active"]== "1"){
		$check = 'checked="checked"';
	}
	if ($rule["recursively"] == "1")
	{
		$recurs = "TRUE";
	}
	echo '<tr id = '.$rule["id"].'>'.
                                    '<td>'.$rule["name"].'</td>'.
                                    '<td>'.$rule["max_size"].'</td>'.
                                    '<td>'.$rule["path"].'</td>'.
                                    '<td>'.$rule["formats"].'</td>'.
                                    '<td>'.$recurs.'</td>'.
                                    '<td><button type="submit" class="btn btn_deleteRules btn-sm btn-block btn-outline-info">Delete</button></td>'.
                                    '<td>'.
                                        '<div class="custom-control custom-checkbox">'.
                                            '<input type="checkbox" class="checkbox_isActive custom-control-input" id="customCheck'.$rule["id"].'" '.$check.' data-parsley-multiple="groups" data-parsley-mincheck="2">'.
                                            '<label class="custom-control-label" for="customCheck'.$rule["id"].'"></label>'.
                                        '</div>'.
                                    '</td>'.
								'</tr>'
	
	
	;
}
}


?>

