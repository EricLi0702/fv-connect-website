<?php
include('connection.php');

## Read value
$draw = $_POST['draw'];
$row = $_POST['start'];
$rowperpage = $_POST['length']; // Rows display per page
$columnIndex = $_POST['order'][0]['column']; // Column index
$columnName = $_POST['columns'][$columnIndex]['data']; // Column name
$columnSortOrder = $_POST['order'][0]['dir']; // asc or desc
$searchValue = $_POST['search']['value']; // Search value

## Search 
$searchQuery = " ";
if($searchValue != ''){
   $searchQuery .= " and (description_of_changes like '%".$searchValue."%' or 
      author like'%".$searchValue."%' ) ";
}

## Total number of records without filtering
$sel = mysqli_query($con,"select count(*) as allcount from change_log");
$records = mysqli_fetch_assoc($sel);
$totalRecords = $records['allcount'];

## Fetch records
$query = "select * from change_log WHERE 1 ".$searchQuery." order by ".$columnName." ".$columnSortOrder." limit ".$row.",".$rowperpage;
$statement = $con->query($query);
$data = array();
while($row = $statement->fetch_object()) {
    $sub_array = array();
	  $sub_array['id'] = $row->id;
    $sub_array['datetime'] = date("Y-m-d", $row->timestamp);
    $sub_array['description_of_changes'] = $row->description_of_changes;
    $sub_array['author'] = $row->author;
	  $data[] = $sub_array;
}

## Response
$response = array(
  "draw" => intval($draw),
  "iTotalRecords" => $totalRecords,
  "iTotalDisplayRecords" => $totalRecords,
  "aaData" => $data
);

echo json_encode($response);
?>