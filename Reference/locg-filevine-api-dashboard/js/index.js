var project_dataTable;
var collectionItem_create_dataTable;
var collectionItem_update_dataTable;
$(document).ready(function() {  
    // Set the Start and End Dates as default for last one week
    var today = getInputDateFromDate(new Date());
    $('#end_date').attr('value', today);
    var week_ago = getInputDateFromDate(new Date(new Date().getTime() - 7 * 24 * 60 * 60 * 1000));
    $('#start_date').attr('value', week_ago);
  
    project_dataTable = $('#project_phasechanegd_table').DataTable({
        "pageLength": 100,
        "processing": true,
        "serverSide": true,
        "serverMethod": 'post',
        "ajax": {
           'url':'./php/project_phasechanged_datatable.php',
           'data': function(data){
              // Read values
              var start_date = $('#start_date').val();
              var end_date = $('#end_date').val();

              // Append to data
              data.start_date = start_date;
              data.end_date = end_date;
           }
        },
        "columns": [
           { data: 'id' }, 
           { data: 'datetime' },
           { data: 'project_id' },
           { data: 'phase_name' },
           { data: 'webhook_url' },
        ],
        "columnDefs":[
            {
                "targets":[1],
                "orderable":false,
            },
        ],
        "order": [[ 0, "desc" ]]
    });
    
    collectionItem_create_dataTable = $('#collectionitem_created_table').DataTable({
        "pageLength": 100,
        "processing": true,
        "serverSide": true,
        "serverMethod": 'post',
        "ajax": {
           'url':'./php/collectionitem_created_datatable.php',
           'data': function(data){
              // Read values
              var start_date = $('#start_date').val();
              var end_date = $('#end_date').val();

              // Append to data
              data.start_date = start_date;
              data.end_date = end_date;
           }
        },
        "columns": [
           { data: 'id' }, 
           { data: 'datetime' },
           { data: 'project_id' },
           { data: 'section_selector' },
           { data: 'demand_type' },
           { data: 'collectionitem_id' },
           { data: 'webhook_url' },
        ],
        "columnDefs":[
            {
                "targets":[1],
                "orderable":false,
            },
        ],
        "order": [[ 0, "desc" ]]
    });
	
	collectionItem_update_dataTable = $('#collectionitem_updated_table').DataTable({
        "pageLength": 100,
        "processing": true,
        "serverSide": true,
        "serverMethod": 'post',
        "ajax": {
           'url':'./php/collectionitem_updated_datatable.php',
           'data': function(data){
              // Read values
              var start_date = $('#start_date').val();
              var end_date = $('#end_date').val();

              // Append to data
              data.start_date = start_date;
              data.end_date = end_date;
           }
        },
        "columns": [
           { data: 'id' }, 
           { data: 'datetime' },
           { data: 'project_id' },
           { data: 'section_selector' },
           { data: 'collectionitem_id' },
           { data: 'webhook_url' },
        ],
        "columnDefs":[
            {
                "targets":[1],
                "orderable":false,
            },
        ],
        "order": [[ 0, "desc" ]]
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
    
//     displayProjectPhaseChangedTable();
    
    $('#event_select').on('change', function() {
        if (this.value == 'project_phasechanged')
            displayProjectPhaseChangedTable();
        else if (this.value == 'collectionitem_created')
            displayCollectionItemCreatedTable();
		else if (this.value == 'collectionitem_updated')
			displayCollectionItemUpdatedTable();
    });
});  

function displayProjectPhaseChangedTable() {
    $('#project_phasechanegd_table_wrapper').css('display','block');
    $('#collectionitem_created_table_wrapper').css('display','none');
    $('#collectionitem_updated_table_wrapper').css('display','none');
}

function displayCollectionItemCreatedTable() {
    $('#project_phasechanegd_table_wrapper').css('display','none');
    $('#collectionitem_created_table_wrapper').css('display','block');
    $('#collectionitem_updated_table_wrapper').css('display','none');
}

function displayCollectionItemUpdatedTable() {
    $('#project_phasechanegd_table_wrapper').css('display','none');
    $('#collectionitem_created_table_wrapper').css('display','none');
    $('#collectionitem_updated_table_wrapper').css('display','block');
}

function filter_table(e) {
    project_dataTable.draw();
    collectionItem_create_dataTable.draw();
	collectionItem_update_dataTable.draw();
}