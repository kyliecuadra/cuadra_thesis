<?php

$con = mysqli_connect("localhost","root","","contribution_monitoring_system");

        if($con){
             echo "";
        } else{
            die(mysqli_error($con));
        }
?>
