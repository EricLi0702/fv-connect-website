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

## Custom Field value
$start_date = $_POST['start_date'];
$end_date = $_POST['end_date'];

## Search 
$searchQuery = " ";
if($start_date != '' and $end_date != ''){
   $start_date = DateTime::createFromFormat("Y-m-d H:i:s", $start_date.' 00:00:00');
   $start_date_timestamp = $start_date->getTimestamp()*1000;
   $end_date = DateTime::createFromFormat("Y-m-d H:i:s", $end_date.' 23:59:59');
   $end_date_timestamp = $end_date->getTimestamp()*1000;
   $searchQuery .= " and (timestamp > ".$start_date_timestamp." and timestamp < ".$end_date_timestamp.") ";
}
if($searchValue != ''){
   $searchQuery .= " and (project_id like '%".$searchValue."%' or 
      webhook_url like'%".$searchValue."%' ) ";
}

## Total number of records without filtering
$sel = mysqli_query($con,"select count(*) as allcount from collectionitem_updated");
$records = mysqli_fetch_assoc($sel);
$totalRecords = $records['allcount'];

## Total number of records with filtering
$sel = mysqli_query($con,"select count(*) as allcount from collectionitem_updated WHERE 1 ".$searchQuery);
$records = mysqli_fetch_assoc($sel);
$totalRecordwithFilter = $records['allcount'];

## Fetch records
$query = "select * from collectionitem_updated WHERE 1 ".$searchQuery." order by ".$columnName." ".$columnSortOrder." limit ".$row.",".$rowperpage;
$statement = $con->query($query);
$data = array();
while($row = $statement->fetch_object()) {
    $sub_array = array();
	  $sub_array['id'] = $row->id;
    $sub_array['datetime'] = date("Y-m-d H:i:s", $row->timestamp/1000);
    $sub_array['project_id'] = $row->project_id;
    $sub_array['section_selector'] = $row->section_selector;
    $sub_array['collectionitem_id'] = $row->collectionitem_id;
    $sub_array['webhook_url'] = $row->webhook_url;
	  $data[] = $sub_array;
}

## Response
$response = array(
  "draw" => intval($draw),
  "iTotalRecords" => $totalRecords,
  "iTotalDisplayRecords" => $totalRecordwithFilter,
  "aaData" => $data
);

echo json_encode($response);
?>