
<?php
require_once 'header.php';
?>

<script type="text/javascript" src="js/jquery.form.js"></script>

<script type="text/javascript">
                    
    if(typeof(EventSource)!=="undefined")
    {
        
        var source=new EventSource("getExcel");
        source.onmessage=function(event)
        {
          
            document.getElementById("resultDiv").innerHTML+=event.data + "<br>";
        };
    }
    else
    {
      
        document.getElementById("resultDiv").innerHTML="Sorry, your browser does not support server-sent events...";
    }
		
		
    $(document).ready(function() {
				
        // make it an "ajax form"
        $('#updateForm').ajaxForm({
					
            success: function(responseText, statusText, xhr, $form) {
                $("#resultDiv").html(responseText);
                $("#importProgress").removeClass("active");
                $("#importProgress").removeClass("progress-striped");
            }
					
        });
				
        // show modal dialog on submit
        $('#updateForm').submit(function() {
            $('#progressModal').modal('show');
        });
				
				
				
				
				
        $('#progressModal').on('hidden', function () {
            console.log("This is getting called.");
            var option = $("#countrySelect option:selected").val();
            var appendHTML = true;
					
            $("#resultDiv").html("");
            $("#importProgress").addClass("active");
            $("#importProgress").addClass("progress-striped");
        });
				
    });
</script>

</head>
<body data-spy="scroll" data-offset="50" data-twttr-rendered="true">

    <div class="container grid-bg" style="margin-top: 50px;">

        <div class="modal fade" id="progressModal">
            <div class="modal-header">
                <button class="close" data-dismiss="modal">×</button>
                <h3>Updating balance...</h3>
            </div>
            <div class="modal-body">
                <div id="importProgress" class="progress progress-striped progress-success active">
                    <div class="bar" style="width:100%"></div>
                </div>
                <div id="resultDiv"></div>
            </div>
            <div id="outputDiv" class="modal-footer">
                Depending on your internet speed, this might take a while.
            </div>
        </div>



        <div class="span4">
            <form class="form-horizontal" id="updateForm" action="update" method="post" enctype="multipart/form-data">
                <fieldset>
                    <legend>Please enter relevant information  to Update Balance</legend>


                    <div class="control-group">
                        <label class="control-label" for="account_no">Account Number:</label>
                        <div class="controls">
                            <input class="input-xlarge" required="required" type="text" id="account_no" 
                                   placeholder= 'Enter Account Number.' name="account_no">
                        </div>
                    </div>



                    <div class="control-group">
                        <label class="control-label" for="balance">Deposit Amount</label>
                        <div class="controls">
                            <input class="input-xlarge" required="required" type="text" id="balance" 
                                   placeholder= 'Enter Amount to Deposit.' name="balance">
                        </div>
                    </div>



                    <div class="span4 offset1">
                        <div class="form-actions">
                            <button type="submit" class="btn btn-primary">Update</button>
                        </div>
                    </div>
                </fieldset>
            </form>

        </div>

    </div>

</body>
</html>

