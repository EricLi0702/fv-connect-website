var dataTable;
$(document).ready(function() {  
    var today = getInputDateFromDate(new Date());
    $('#chagelog_date').attr('value', today);
  
    dataTable = $('#changelogs_table').DataTable({
        "processing": true,
        "serverSide": true,
        "serverMethod": 'post',
        "ajax": {
           'url':'./php/changelog_datatable.php',
        },
        "columns": [
           { data: 'id' },
           { data: 'datetime' },
           { data: 'description_of_changes' },
           { data: 'author' },
        ],
        "columnDefs":[
            {
                "targets":[1],
                "orderable":false,
            },
        ],
        "order": [[ 0, "desc" ]]
    });
    
    
});  

$(document).on('click', '#change_log_subimt', function(event) {
  var chagelog_date = $('#chagelog_date').val();
  var author = $('#author').val();
  var description_of_changes = $('#description_of_changes').val();
  event.preventDefault();
	var operation = "Create_Changelog";
  
  $.ajax({
    url: "./php/changelog_ajax.php",
    type: 'POST',
    dataType:'json',
    data: "operation="+operation+"&chagelog_date="+chagelog_date+"&author="+author+"&description_of_changes="+description_of_changes,
    success: function(data) {
      if (data.result == "success") {
        $('#changelogs_table').DataTable().ajax.reload();
      }
    }
  });
});

function getInputDateFromDate(date) {
    var input_date = '';
    var dd = date.getDate();
    var mm = date.getMonth() + 1; //January is 0!
    var yyyy = date.getFullYear();

    if(dd<10){dd='0'+dd} 
    if(mm<10){mm='0'+mm} 
    input_date = yyyy+'-'+mm+'-'+dd;
    return input_date;
}



