<?php
require_once ('session.php');
require_once ('../Common/database.php');
require_once ('../Common/functions.php');

?>
<?php include_once('layout/header.php'); ?>
<?php include_once('layout/sidebar.php'); ?>
    
<!-- Page wrapper  -->
<div class="page-wrapper">
    <!-- Bread crumb and right sidebar toggle -->
    <div class="page-breadcrumb">
        <div class="row align-items-center">
            <div class="col-md-6 col-8 align-self-center">
                <h3 class="page-title mb-0 p-0">Mass Upload</h3>
                <div class="d-flex align-items-center">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Mass Upload</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <!-- Container fluid  -->
    <div class="container-fluid">
        <div class="header">
            <div class="title">
                <h1>Multi-Create Contacts Tool</h1>
                <p>The tool below allows us to upload multiple contacts at once using queue calls to the <a href="https://filevine-api.api-docs.io/v2/contacts/create-contact" target="_blank">Create Contacts</a> endpoint on the Filevine API.</p>
            </div>
        </div>
        <br/>

        <h3>Step 1: Download and fill in the following CSV templates</h3>
        <p>
            <b>Multi-Create Contacts Template:</b> Add one contact to each row to be created. The only required columns are name; all the rest of the columns are optional. If you add labels or personType, be sure to enter the text exactly as it appears in Filevine with no typos. <a href="sample_templates/Multi-Create%20Contacts.csv" download>Download</a><br>
            <b>Add Person Types:</b> Add one contact to each row and identify the "Person Type" you want to add (the text must exactly match Filevine Person Types with no typos). Keep in mind this does not remove existing person types, only adds a new one. <a href="sample_templates/Add%20Person%20Types.csv" download>Download</a>
        </p>
        
        <h3>Step 2: Upload the completed file, and execute your action button</h3>
        <p>If you are uploading the file for the first time, you can just click "Upload". If a file with the same name has been previously uploaded during the same session, you will need to choose the box to replace the file. Once you receive upload success message, execute the action. Please give the system plenty of time to work - refreshing or closing the page before you receive success messages will end the process.</p>

        <form id="fileToUploadForm" method="post" enctype="multipart/form-data" style="margin-top:50px;">
        <?php if(isset($error_message)){ ?>
            <span style="text-align:center; font-size:14px; font-weight:bold; color:#f00; width:100%; display:inline-block;"><?php echo $error_message;?></span>
        <?php } ?>
        <?php if(isset($message)){ ?>
            <span style="text-align:center; font-size:14px; font-weight:bold; color:#206104; width:100%; display:inline-block;"><?php echo $message;?></span>
        <?php } ?>
            <input type="file" name="fileToUpload" id="fileToUpload" accept=".csv">
            <input type="checkbox" name="removeOriginalFile" value="yes">Replace the Original File
            <input type="submit" value="Upload" name="submit">
        </form>

        <div class="col-md-12 row" style="margin-top:30px;">
            <input type="hidden" id="uploaded_file" data-val="" style="display:none;">
            <button id="addContactsBtn" style="margin-right:50px;">Add Contacts</button>    
            <button id="addPersonTypesBtn">Add PersonTypes</button>    
        </div>

        <hr style="margin-bottom: 50px;">
        <div id="preview"></div><br>
        <div id="err"></div>
    </div>
    
    <?php include_once('layout/footer.php'); ?>
</div>
<?php include_once('layout/footer_assets.php'); ?>
<script src="js/contact.js"></script>

