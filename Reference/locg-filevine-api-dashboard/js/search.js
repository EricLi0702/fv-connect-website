$(document).ready(function (e) {
    $("#clientLookup_btn").on('click',(function(e) {
        e.preventDefault();
        var operation = "clientlookup";
        var firstname = $("#clientFirst").val();
        var lastname = $("#clientLast").val();
        
        if (firstname == "" || lastname == "") {
            alert("Input Both Firstname and Lastname");
            return;
        }
            
        $.ajax({
            url: "./php/search.php",
            type: 'POST',
            dataType:'json',
            data: "operation="+operation+"&firstname="+firstname+"&lastname="+lastname,
            success: function(res) {
                console.log(res);
                if (res.attorneyName == "") 
                    $('#attorney').text("Your Attorney: None");
                else
                    $('#attorney').text("Your Attorney: "+res.attorneyName);
                if (res.paralegalName == "") 
                    $('#paralegal').text("Paralegal: None");
                else
                    $('#paralegal').text("Paralegal: " + res.paralegalName + "-" + res.paralegalName);
                if (res.legalassistantName == "") 
                    $('#legalassistant').text("Legal Assistant: None");
                else
                    $('#legalassistant').text("Legal Assistant: " + res.legalassistantName + "-" + res.legalassistantEmail);
            }
        });
    }));
});