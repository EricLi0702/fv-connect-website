<?php
require_once ('session.php');
require_once ('../Common/database.php');
require_once ('../Common/functions.php');

$message = "";
$db=new db();

if(isset($_POST['AllIds']))
{
	$IdsArray = explode(",", $_POST['AllIds']);

	for($i=0; $i<count($IdsArray); $i++)
	{
		$ID = $_POST['Id_' . $IdsArray[$i]];
		$status = $_POST['Status_' . $IdsArray[$i]];
		$full_name = $_POST['Full_name_' . $IdsArray[$i]];
		$email = $_POST['Email_' . $IdsArray[$i]];
		$phone_number = $_POST['Phonenumber_' . $IdsArray[$i]];
		
		$db->query("update legalteam_config set Status='" . $status . "', Full_name='" . $full_name . "', Email='" . $email . "', Phonenumber='" . $phone_number . "', Updated_at = '" . date("Y-m-d H:i:s") . "' where Id=" . $ID);
	}

	$message = "Legal team config data successfully updated!";
}

$data = $db->query("select * from legalteam_config order by Id")->fetchAll();
?>
<?php include_once('layout/header.php'); ?>
<?php include_once('layout/sidebar.php'); ?>

<!-- Page wrapper -->
<div class="page-wrapper">
	<!-- Bread crumb and right sidebar toggle -->
	<div class="page-breadcrumb">
		<div class="row align-items-center">
			<div class="col-md-6 col-8 align-self-center">
				<h3 class="page-title mb-0 p-0">Legal Team Config</h3>
				<div class="d-flex align-items-center">
					<nav aria-label="breadcrumb">
						<ol class="breadcrumb">
							<li class="breadcrumb-item"><a href="#">Home</a></li>
							<li class="breadcrumb-item active" aria-current="page">Legal Team Config</li>
						</ol>
					</nav>
				</div>
			</div>
		</div>
	</div>
			
	<!-- Container fluid  -->
	<div class="container-fluid">
		<div class="row card card-body">
			<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" class="form-horizontal form-material col-md-10">
			<?php if($message != '') { ?>
				<div style="width:100%; padding:5px; font-size:13px; font-weight:bold; color:#0f0; text-align:center;"><?php echo $message;?></div>
			<?php } ?>
				<div class="form-group">
					<table>
						<tr>
							<th style='padding:5px;'>Type</th>
							<th style='padding:5px; text-align:center;'>Enable</th>
							<th style='padding:5px; text-align:center;'>Disable</th>
							<th style='padding:5px; text-align:center;'>Override</th>
							<th style='padding:5px;'>Full Name</th>
							<th style='padding:5px;'>Email</th>
							<th style='padding:5px;'>Phone Number</th>
						</tr>
						
						<?php
						$all_ids = "";
						foreach($data as $item)
						{
							if($all_ids == "")
								$all_ids = $item['Id'];
							else
								$all_ids .= "," . $item['Id'];
							
							$enableSelect = "";
							$disableSelect = "";
							$verrideSelect = "";
							
							$disableValue = "0";
							$enableValue = "1";
							$verrideValue = "2";
							$visible='style="display:none;"';
							$clientVisible='style="display:none;"';
							
							if($item['Type'] == "Client Relations Manager"){
								if($item['Status'] == "0"){
									$clientVisible='style="display:" required';
								}
							}
							
							if($item['Status'] == "0"){
								$disableValue = "0";
								$enableValue = "0";
								$verrideValue = "0";
								
								$enableSelect = "";
								$disableSelect = 'checked="checked"';
								$verrideSelect = "";
							}
							
							if($item['Status'] == "1"){
								$disableValue = "0";
								$enableValue = "1";
								$verrideValue = "0";
								
								$enableSelect = 'checked="checked"';
								$disableSelect = "";
								$verrideSelect = "";
							}
							
							if($item['Status'] == "2"){
								$disableValue = "0";
								$enableValue = "0";
								$verrideValue = "2";
								
								$enableSelect = "";
								$disableSelect = "";
								$verrideSelect = 'checked="checked"';
								$visible='style="display:" required';
							}
						?>
						<tr>
							<td style='padding:5px;'><?php echo $item['Type'];?><input type="hidden" name="Id_<?php echo $item['Id'];?>" value="<?php echo $item['Id'];?>" /></td>
							<td style='padding:5px; text-align:center;'>
								<input type="hidden" class="chStatus" id="Status_<?php echo $item['Id'];?>" name="Status_<?php echo $item['Id'];?>" value="<?php echo $item['Status'];?>" />
								<?php if($item['Type'] != "Client Relations Manager"){ ?>
								<input type="radio" class="RdStatus" id="RdEnableStatus_<?php echo $item['Id'];?>" name="RdStatus_<?php echo $item['Id'];?>" data-id="<?php echo $item['Id'];?>" value="1" <?php echo $enableSelect;?> />
								<?php } else { ?>
								<input type="radio" class="RdStatus clientEnable" id="RdEnableStatus_<?php echo $item['Id'];?>" name="RdStatus_<?php echo $item['Id'];?>" data-id="<?php echo $item['Id'];?>" value="1" <?php echo $enableSelect;?> />
								<?php } ?>
							</td>
							<td style='padding:5px; text-align:center;'>
							<?php if($item['Type'] != "Client Relations Manager"){ ?>
								<input type="radio" class="RdStatus" id="RdDisableStatus_<?php echo $item['Id'];?>" name="RdStatus_<?php echo $item['Id'];?>" data-id="<?php echo $item['Id'];?>" value="0" <?php echo $disableSelect;?> />
							<?php } else { ?>
							<input type="radio" class="RdStatus clientDisable" id="RdDisableStatus_<?php echo $item['Id'];?>" name="RdStatus_<?php echo $item['Id'];?>" data-id="<?php echo $item['Id'];?>" value="1" <?php echo $disableSelect;?> />
							<?php } ?>
							</td>
							<td style='padding:5px; text-align:center;'>
							<?php
							if($item['Type'] != "Client Relations Manager"){ ?>
								<input type="radio" class="RdStatus" name="RdStatus_<?php echo $item['Id'];?>" data-id="<?php echo $item['Id'];?>" value="2" <?php echo $verrideSelect;?> />
							<?php } ?>
							</td>
							<?php if($item['Type'] != "Client Relations Manager"){ ?>
							<td style='padding:5px;'><input type="text" class="txtStatus"  id="Full_name_<?php echo $item['Id'];?>" name="Full_name_<?php echo $item['Id'];?>" value="<?php echo $item['Full_name'];?>" <?php echo $visible;?> /></td>
							<td style='padding:5px;'><input type="email" class="txtStatus" id="Email_<?php echo $item['Id'];?>" name="Email_<?php echo $item['Id'];?>" value="<?php echo $item['Email'];?>" <?php echo $visible;?> /></td>
							<td style='padding:5px;'><input type="text" class="txtStatus" id="Phonenumber_<?php echo $item['Id'];?>" name="Phonenumber_<?php echo $item['Id'];?>" value="<?php echo $item['Phonenumber'];?>" <?php echo $visible;?> /></td>
							<?php } else { ?>
							<td style='padding:5px;'><input type="text" class="txtStatus"  id="Full_name_<?php echo $item['Id'];?>" name="Full_name_<?php echo $item['Id'];?>" value="<?php echo $item['Full_name'];?>" <?php echo $clientVisible;?> /></td>
							<td style='padding:5px;'><input type="email" class="txtStatus" id="Email_<?php echo $item['Id'];?>" name="Email_<?php echo $item['Id'];?>" value="<?php echo $item['Email'];?>" <?php echo $clientVisible;?> /></td>
							<td style='padding:5px;'><input type="text" class="txtStatus" id="Phonenumber_<?php echo $item['Id'];?>" name="Phonenumber_<?php echo $item['Id'];?>" value="<?php echo $item['Phonenumber'];?>" <?php echo $clientVisible;?> /></td>
							<?php } ?>
						</tr>
						<?php } ?>
					</table>
				</div>
				<div class="form-group">
					<div class="col-sm-12 d-flex">
						<input type="hidden" name="AllIds" value="<?php echo $all_ids;?>" />
						<button class="btn btn-success mx-auto mx-md-0 text-white">Update Data</button>
					</div>
				</div>
			</form>
		</div>
	</div>

	<?php include_once('layout/footer.php'); ?>
</div>

<!-- Footer asstes  -->
<?php include_once('layout/footer_assets.php'); ?>

<script type="text/javascript">
$(".RdStatus").click(function(){
	if($(this).is(':checked')){
		var current_id = $(this).attr('data-id');
		var status_obj = "Status_" + current_id;
		var current_status = $(this).val();
		
		$('#' + status_obj).val(current_status);
		
		var strName = "Full_name_" + current_id;
		var strEmail = "Email_" + current_id;
		var strPhone = "Phonenumber_" + current_id;

		var objId = $(this).attr('id');
		if(current_status != "2")
		{
			$("#" + strName).css('display', 'none');
			$("#" + strName).prop('required',false);
			$("#" + strEmail).css('display', 'none');
			$("#" + strEmail).prop('required',false);
			$("#" + strPhone).css('display', 'none');
			$("#" + strPhone).prop('required',false);
		}
		
		if(current_status == "2")
		{
			$("#" + strName).css('display', '');
			$("#" + strName).prop('required',true);
			$("#" + strEmail).css('display', '');
			$("#" + strEmail).prop('required',true);
			$("#" + strPhone).css('display', '');
			$("#" + strPhone).prop('required',true);
		}
	}
});

$(".clientEnable").click(function(){
	if($(this).is(':checked')){
		var current_id = $(this).attr('data-id');
		var strName = "Full_name_" + current_id;
		var strEmail = "Email_" + current_id;
		var strPhone = "Phonenumber_" + current_id;
		
		$("#" + strName).css('display', 'none')
		$("#" + strName).prop('required',false);
		$("#" + strEmail).css('display', 'none');
		$("#" + strEmail).prop('required',false);
		$("#" + strPhone).css('display', 'none');
		$("#" + strPhone).prop('required',false);
		
		var status_obj = "Status_" + current_id;
		$('#' + status_obj).val("1");
	}
});

$(".clientDisable").click(function(){
	if($(this).is(':checked')){
		var current_id = $(this).attr('data-id');
		var strName = "Full_name_" + current_id;
		var strEmail = "Email_" + current_id;
		var strPhone = "Phonenumber_" + current_id;
		
		$("#" + strName).css('display', '');
		$("#" + strName).prop('required',true);
		$("#" + strEmail).css('display', '');
		$("#" + strEmail).prop('required',true);
		$("#" + strPhone).css('display', '');
		$("#" + strPhone).prop('required',true);
		
		var status_obj = "Status_" + current_id;
		$('#' + status_obj).val("0");
	}
});
</script>