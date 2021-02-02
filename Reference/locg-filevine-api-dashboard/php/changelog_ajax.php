<?php 
include('connection.php');

function mysql_escape($inp){ 
    if(is_array($inp)) return array_map(__METHOD__, $inp);

    if(!empty($inp) && is_string($inp)) { 
        return str_replace(array('\\', "\0", "\n", "\r", "'", '"', "\x1a"), array('\\\\', '\\0', '\\n', '\\r', "\\'", '\\"', '\\Z'), $inp); 
    } 

    return $inp; 
}

if(isset($_POST["operation"])) {

    $operation = $_POST["operation"];

    switch($operation) {
        case 'Create_Changelog' :
            $query = "INSERT INTO change_log (timestamp, description_of_changes, author)
                        VALUES (".strtotime($_POST['chagelog_date']).",'".mysql_escape($_POST['description_of_changes'])."','".mysql_escape($_POST['author'])."')";
            
            if ($con->query($query) === TRUE) {
                $result = array('result' => 'success');
            } else {
                $result = array('result' => 'fail');
            }
            
            echo json_encode($result);
            break;
    }
}
?>