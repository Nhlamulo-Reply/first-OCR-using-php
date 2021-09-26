<?php 
include_once 'dbconnect.php';

//code to extract text


  if(isset($_FILES['image'])){
    $file_name = $_FILES['image']['name'];
    $file_tmp =$_FILES['image']['tmp_name'];
    move_uploaded_file($file_tmp,"images/".$file_name);
    echo "<h3>Image Upload Success</h3>";
    echo '<img src="images/'.$file_name.'" style="width:50%">';
    
    shell_exec('"C:\Program Files (x86)\Tesseract-OCR\tesseract.exe" "C:\\xampp\\htdocs\\OCR\\images\\'.$file_name.'" out');
    
    echo "<br><h3>OCR after reading</h3><br><pre>";
    
    $myfile = fopen("out.txt", "r") or die("Unable to open file!");
    echo fread($myfile,filesize("out.txt"));
    fclose($myfile);
    echo "</pre>";
    }


  if(isset($_POST['submit'])){

    $f = fopen("out.txt", "r");
      while(!feof($f)) { 
         $row = explode(" ", fgets($f));
    
         $name = $row[0];
         $surname = $row[1];
         $place = $row[2];
      
         $sql=("INSERT INTO test(name, surname, place) 
               VALUES ('$name', '$surname', '$place')") ;


  
           if ($conn->query($sql) === TRUE) {
            echo "New record created successfully";
          } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
          }
        }
        fclose($f);
    } 




 



