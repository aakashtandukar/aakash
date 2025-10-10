
<?php
require_once 'header.php';
?>

<script type="text/javascript" src="js/jquery.form.js"></script>


</head>
<body data-spy="scroll" data-offset="50" data-twttr-rendered="true">

    <div class="container grid-bg" style="margin-top: 50px;">

       <p align="center"> <legend>Welcome to Mobiba Banking Service</legend>
      
    <div class="span4">
            <form class="form-horizontal" id="registerForm" action="newRegister" method="post" enctype="multipart/form-data">
                <fieldset>
                    <div class="span4 offset1">
                        <div class="form-actions">
                            <button type="submit" class="btn btn-primary" >Register</button>
                        </div>
                    </div>


                </fieldset>
            </form>

        </div>
        <div class="span4">
            <form class="form-horizontal" id="updateForm" action="deposit" method="post" enctype="multipart/form-data">
                <fieldset>
                   
                    <div class="span4 offset1">
                        <div class="form-actions">
                            <button type="submit" class="btn btn-primary" >Update Balance</button>
                        </div>
                    </div>


                </fieldset>
            </form>

        </div>
   
    </div>


</body>
</html>

