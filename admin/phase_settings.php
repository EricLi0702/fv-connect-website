<?php
require_once('session.php');
require_once('../Common/database.php');
require_once('../Common/functions.php');

$template_name = "";
$message = "";

$db = new db();

if (isset($_POST['RowCount']) && isset($_POST['lstTemplates'])) {
    $rowCount = $_POST['RowCount'];
    $template_name = $_POST['lstTemplates'];

    if ($template_name != "" && $rowCount > 0) {
        //--Update Category Description
        for ($i = 0; $i < $rowCount; $i++) {
            $category_id = $_POST['lstTemplateCategory_' . $i];
            $category_description = $_POST['txtDescription_' . $i];
            $category_description = str_replace("'", "''", $category_description);

            $db->query("update category set Description='" . $category_description . "' where Id=" . $category_id);
        }
        //--Insert phase database
        for ($n = 0; $n < $rowCount; $n++) {
            $category_name = $_POST['SelectedCatName_' . $n];
            $phaseInfo = $db->query("select * from phase_template where Template='" . $template_name . "' and Category='" . $category_name . "'");

            $RecordCount = $phaseInfo->numRows();

            if ($RecordCount == 0) {
                $db->query('insert into phase_template(Template, Category, Created_at, Updated_at) values("' . $template_name . '", "' . $category_name . '", "' . date("Y-m-d H:i:s") . '","' . date("Y-m-d H:i:s") . '"');
            }
        }
        $message = "Phase settings data successfully updated!";
    }
}

$template_data = $db->query("select * from phase_template group by Template order by Id")->fetchAll();
?>
<!-- Header  -->
<?php include_once('layout/header.php'); ?>
<!-- Left Sidebar - style you can find in sidebar.scss  -->
<?php include_once('layout/sidebar.php'); ?>

<?php

$selected_phase_template = "";
if (isset($template_name) && $template_name != "") {
    $selected_phase_template = $template_name;
}
?>

<div class="page-wrapper">

    <div class="page-breadcrumb">
        <div class="row align-items-center">
            <div class="col-md-6 col-8 align-self-center">
                <h3 class="page-title mb-0 p-0">Phase Settings</h3>
                <div class="d-flex align-items-center">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li
                                class="breadcrumb-item active"
                                aria-current="page"
                            >Phase Settings</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <div class="row card card-body">
            <form
                action="<?php echo $_SERVER['PHP_SELF']; ?>"
                method="post"
                class="form-horizontal form-material col-md-10"
            >

                <?php
                if ($message != '') {
                ?>
                <div style="width:100%; padding:5px; font-size:13px; font-weight:bold; color:#0f0; text-align:center;">
                    <?php echo $message; ?></div>
                <?php
                }
                ?>

                <div class="form-group">
                    <div class="col-sm-12 d-flex">
                        <table class="table user-table no-wrap">
                            <tr>
                                <th style="padding:5px;">Phase Template</th>
                                <th style="padding:5px;">Phase Categories</th>
                                <th style="padding:5px;">Category Description</th>
                            </tr>
                            <tr>
                                <td style="padding:5px; vertical-align:top;">
                                    <select
                                        name="lstTemplates"
                                        id="lstTemplates"
                                    >
                                        <option value="">--Select Template--</option>
                                        <?php
                                        foreach ($template_data as $template) {
                                        ?>
                                        <option value="<?php echo $template['Template']; ?>">
                                            <?php echo $template['Template']; ?></option>
                                        <?php
                                        }
                                        ?>
                                    </select>
                                </td>
                                <td
                                    colspan="2"
                                    id="categoryInfo"
                                    style="padding:5px;"
                                ></td>
                            </tr>
                        </table>
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-sm-12 d-flex">
                        <input
                            type="hidden"
                            name="currentTemplateX"
                            id="currentTemplateX"
                            value="<?php echo $selected_phase_template; ?>"
                        />
                        <button class="btn btn-success mx-auto mx-md-0 text-white">Update Data</button>
                        <input
                            id="btnAddRow"
                            type="button"
                            class="btn btn-success text-white"
                            value="Add Row"
                            style="margin-left:20px; display:none;"
                        />
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
var curTemplate = "<?php echo $selected_phase_template; ?>";
if (curTemplate != "") {
    $("#lstTemplates").val(curTemplate);
    setSelectedTemplateInfo(curTemplate);
}

function setSelectedTemplateInfo(curTemplate) {
    if (curTemplate != "") {
        $('#btnAddRow').css('display', '');
        $.ajax(
            'get_category_info.php?template_name=' + curTemplate, {
                success: function(data) {
                    $("#categoryInfo").html(data);
                    var totRows = $("#RowCount").val();
                    var totCats = $("#CategoryCount").val();
                    if (parseInt(totRows) < parseInt(totCats)) {
                        $('#btnAddRow').css('display', '');
                    } else {
                        $('#btnAddRow').css('display', 'none');
                    }
                },
                error: function() {
                    alert('There was some error performing the AJAX call!');
                }
            }
        );
    }
}

$("#lstTemplates").click(function() {
    var current_template = $(this).val();
    $("#categoryInfo").html('');

    if (current_template != "") {
        $('#btnAddRow').css('display', '');
        $.ajax(
            'get_category_info.php?template_name=' + current_template, {
                success: function(data) {
                    $("#categoryInfo").html(data);
                    var totRows = $("#RowCount").val();
                    var totCats = $("#CategoryCount").val();
                    if (parseInt(totRows) < parseInt(totCats)) {
                        $('#btnAddRow').css('display', '');
                    } else {
                        $('#btnAddRow').css('display', 'none');
                    }
                },
                error: function() {
                    alert('There was some error performing the AJAX call!');
                }
            }
        );
    } else {
        $("#categoryInfo").html('');
        $('#btnAddRow').css('display', 'none');
    }

});

$(document).on('focus', '.lstcats', function() {
    previous = this.value;
}).on('change', '.lstcats', function() {
    var allCats = $("#AllSelectedCatIds").val();
    var allCatsArray = allCats.split(",");
    var val = $(this).val();
    var flag = $.inArray(val, allCatsArray);

    if (flag == "-1") {
        $(this).parent().parent().find('textarea').val('');
        var objId = $(this).parent().parent().find('textarea').attr('id');
        var objTextId = $(this).parent().find('.TemplateCatNames').attr('id');
        $(this).parent().find('.TemplateCats').val(val);

        if (val != "0") {
            allCatsArray.push(val);
            $("#AllSelectedCatIds").val(allCatsArray);

            $.ajax(
                'get_category_data.php?cat_id=' + val + '&type=description', {
                    success: function(data) {
                        $("#" + objId).val(data);
                    },
                    error: function() {
                        alert('There was some error performing the AJAX call!');
                    }
                }
            );

            $.ajax(
                'get_category_data.php?cat_id=' + val + '&type=name', {
                    success: function(data) {
                        $("#" + objTextId).val(data);
                    },
                    error: function() {
                        alert('There was some error performing the AJAX call!');
                    }
                }
            );
        }
    } else {
        alert("sected category already exists!");
        $(this).val(previous);
    }

});


$(document).on('click', '#btnAddRow', function() {
    var currentRowCount = $("#RowCount").val();
    var newRowCount = parseInt(currentRowCount) + 1;

    $.ajax(
        'get_category_row.php?row=' + currentRowCount, {
            success: function(data) {
                $("#tblCatInfo").append(data);
                $("#RowCount").val(newRowCount);

                var totRows = newRowCount;
                var totCats = $("#CategoryCount").val();
                if (parseInt(totRows) < parseInt(totCats)) {
                    $('#btnAddRow').css('display', '');
                } else {
                    $('#btnAddRow').css('display', 'none');
                }
            },
            error: function() {
                alert('There was some error performing the AJAX call!');
            }
        }
    );

});
</script>
