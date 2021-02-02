$(document).ready(function (e) {
    $("#fileToUploadForm").on('submit',(function(e) {
        e.preventDefault();
        $.ajax({
            url: "common/upload.php",
            type: "POST",
            data:  new FormData(this),
            contentType: false,
            cache: false,
            processData:false,
            beforeSend : function()
            {
                //$("#preview").fadeOut();
                $("#err").fadeOut();
            },
            success: function(data) {
                if(data=='invalid') {
                     // invalid file format.
                     $("#err").html("Invalid File !").fadeIn();
                } else {
                    // view uploaded file.
                    $("#uploaded_file")[0].setAttribute('data-val', $("#fileToUpload")[0].files.item(0).name);
                    $("#preview").html(data).fadeIn();
                    $("#fileToUploadForm")[0].reset(); 
                }
          },
          error: function(e) {
            $("#err").html(e).fadeIn();
          }          
        });
    }));
    
    $("#addContactsBtn").on('click',(function(e) {
        
        var operation = "contact";
        var filename = $("#uploaded_file").attr('data-val');
        console.log(filename);
        e.preventDefault();
        
        callAction(operation, filename);
    }));
    
    $("#addPersonTypesBtn").on('click',(function(e) {
        
        var operation = "personType";
        var filename = $("#uploaded_file").attr('data-val');
        console.log(filename);
        e.preventDefault();
        
        callAction(operation, filename);
    }));
    
    function callAction(operation, filename) {
        $.ajax({
            url: "./php/contact.php",
            type: 'POST',
            dataType:'json',
            data: "operation="+operation+"&filename="+filename,
            beforeSend : function() {
                $("#preview").fadeOut();
            },
            success: function(data) {
                var html_result = "";
                data.result.forEach(function (v, j) {
                    html_result += '<p>' + v + '</p>';
                });
                $("#preview").html(html_result).fadeIn();
            }
        });
    }
});