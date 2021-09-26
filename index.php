<?php

include_once 'dbconnect.php';
?>

<DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OCR</title>
</head>
<body>
      
<h3>Convert image into text file</h3>
<form action="uploadOCR.php" method="POST" enctype="multipart/form-data" >
<input type="file" name="image" />
<input type="submit" name = "submit"/><br>
</form> 


</section>


	<?php
        	$sql = "SELECT id, name,surname, MAX(place) as Highest  FROM test";
			$resultset = mysqli_query($conn, $sql) or die("database error:". mysqli_error($conn));	
            while( $record = mysqli_fetch_assoc($resultset) ) {
                ?>

    <section class="wrapper-numbers" style="margin-bottom:50px">
       <div class="container">
           <div class="row countup text-center">
               <div class="col-md-8 offset-md-2 header-numbers">
                   <h1>Voting Report</h1>
                   <p>These reports specify the number of votes and counting, number of voting stations, number of parties participating and the leading party that has the great number of votes so far, check the dashboard for a full report.</p>
               </div>
               <div class="col-sm-6 col-md-3 column">
                   <p><i class="icon-graduation" aria-hidden="true"></i></p>
                   <p> <span class="count"><?php echo  $record['Highest']?></span></p>
                   <h2>Number of Votes </h2>
               </div>
               <div class="col-sm-6 col-md-3 column">
                   <p><i class="icon-location-pin" aria-hidden="true"></i></p>
                   <p> <span class="count replay">328</span></p>
                   <h2>Voting Stations</h2>
               </div>
               <div class="col-sm-6 col-md-3 column">
                   <p><i class="icon-paper-plane" aria-hidden="true"></i></p>
                   <p> <span class="count">95.60</span><span class="sup"> </span></p>
                   <h2>Participating Parties</h2>
               </div>
               <div class="col-sm-6 col-md-3 column">
                   <p><i class="icon-cloud-download" aria-hidden="true"></i></p>
                   <p> <span class="count">9157</span><span class="sup"></span></p>
                   <h2>Leading Party</h2>
               </div>
           </div>
       </div>
   </section>
   <?php } ?>
   
   <div class="progress" style="margin:30px">
 <div class="progress-bar bg-success" role="progressbar" style="width: 25%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">ANC 25%</div>
</div>
<div class="progress" style="margin:30px">
 <div class="progress-bar bg-info" role="progressbar" style="width: 50%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100">DA 50%</div>
</div>
<div class="progress" style="margin:30px">
 <div class="progress-bar bg-warning" role="progressbar" style="width: 10%" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100">NFP 10%</div>
</div>
<div class="progress" style="margin:30px">
 <div class="progress-bar bg-danger" role="progressbar" style="width: 15%" aria-valuenow="15" aria-valuemin="0" aria-valuemax="100">EFF 15%</div>
</div>

</body>
</html> 
