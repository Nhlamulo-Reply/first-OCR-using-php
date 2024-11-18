<?php//
//include_once 'dbconnect.php';
//?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Capture Image with Location Verification The perform OCR</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 20px;
            background-color: #f4f4f9;
        }

        h1 {
            color: #333;
        }

        video, canvas {
            border: 2px solid #333;
            border-radius: 10px;
        }

        .info {
            margin-top: 20px;
            font-size: 16px;
            color: #555;
        }

        .captured {
            margin-top: 20px;
            border: 2px dashed #333;
            padding: 20px;
            border-radius: 10px;
            display: inline-block;
            background-color: #e9ecef;
        }

        #canvas {
            visibility: hidden;
        }

        button {
            margin-top: 20px;
            padding: 10px 20px;
            font-size: 16px;
            border: none;
            background-color: #007bff;
            color: white;
            border-radius: 5px;
            cursor: pointer;
        }

        button[disabled] {
            background-color: #cccccc;
            cursor: not-allowed;
        }

        button:hover:not([disabled]) {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
<h1>Capture Image from Webcam and Verify Location</h1>

<video id="video" width="640" height="480" autoplay></video>

<button id="capture" disabled>Capture Photo</button> <!-- Disabled initially -->

<div class="captured">
    <h2>Captured Image</h2>
    <img id="capturedImage" src="" alt="Captured Image" width="320" height="240" />
    <div id="info" class="info"></div>
    <div id="address" class="info"></div>
</div>

<canvas id="canvas" width="640" height="480"></canvas>

<!-- Form to Submit the Captured Image -->
<!--<form id="uploadForm"  action="uploadOCR.php" method="POST" enctype="multipart/form-data">-->
<!--    <input type="file" name="image" id="imageInput" style="display:none;">-->
<!--    <input type="submit" value="Upload Image" style="display:none;">-->
<!--</form>-->
<form action="uploadOCR.php" method="POST" enctype="multipart/form-data">
    <input type="file" name="image" id="imageInput" required>
    <input type="text" name="Longitude" placeholder="Longitude" >
    <input type="text" name="Latitude" placeholder="Latitude" >
    <input type="text" name="UserID" placeholder="User Name" >
    <input type="submit" value="Upload Image">
</form>
<script>
    var video = document.getElementById('video');
    var captureButton = document.getElementById('capture');
    var canvas = document.getElementById('canvas');
    var capturedImage = document.getElementById('capturedImage');
    var imageInput = document.getElementById('imageInput');
    var info = document.getElementById('info');
    var addressDisplay = document.getElementById('address');
    let locationGranted = false;

    navigator.mediaDevices.getUserMedia({ video: true })
        .then((stream) => {
            video.srcObject = stream;
        })
        .catch((err) => {
            console.error("Error accessing webcam: ", err);
        });


    function getLocation() {
        if ("geolocation" in navigator) {
            navigator.geolocation.getCurrentPosition(
                (position) => {
                    var { latitude, longitude } = position.coords;
                    var now = new Date();
                    var date = now.toLocaleDateString();
                    var time = now.toLocaleTimeString();
                    info.innerHTML = `Location: Latitude: ${latitude}, Longitude: ${longitude} <br> Captured on ${date} at ${time}`;

                    // Use reverse geocoding to get the address from the coordinates
                    fetch(`https://maps.googleapis.com/maps/api/geocode/json?latlng=${latitude},${longitude}&key=AIzaSyDT5K0RiNb2cdvytuXCUmTk65oEzcwwqso`)
                        .then(response => response.json())
                        .then(data => {
                            if (data.results && data.results.length > 0) {
                                var address = data.results[0].formatted_address;
                                addressDisplay.innerHTML = `Approximate Address: ${address}`;
                            } else {
                                addressDisplay.innerHTML = "Address not found.";
                            }
                        })
                        .catch(error => {
                            console.error("Error fetching address: ", error);
                            addressDisplay.innerHTML = "Unable to fetch address.";
                        });

                    // Enable the capture button once location is granted
                    locationGranted = true;
                    captureButton.disabled = false;
                },
                (error) => {
                    info.innerHTML = "Location access denied. Please enable location to capture the image.";
                }
            );
        } else {
            info.innerHTML = "Geolocation not supported. Please use a browser that supports it.";
        }
    }

    // Call getLocation immediately to prompt for location access
    getLocation();

    // Capture image from the video stream
    captureButton.addEventListener('click', () => {
        if (!locationGranted) {
            alert("Please allow location access to capture the image.");
            return;
        }

        // Draw the video frame to the canvas
        var context = canvas.getContext('2d');
        context.drawImage(video, 0, 0, canvas.width, canvas.height);

        // Convert canvas data to base64 image format
        canvas.toBlob((blob) => {
            var file = new File([blob], 'captured-image.jpg', { type: 'image/jpeg' });

            // Set the file input value programmatically
            var dataTransfer = new DataTransfer();
            dataTransfer.items.add(file);
            imageInput.files = dataTransfer.files;

            // Show the image on the page
            var imageUrl = URL.createObjectURL(file);
            capturedImage.src = imageUrl;

            // Automatically submit the form
            document.getElementById('uploadForm').submit();
        });
    });
</script>
</body>
</html>



<!---->
<!--<DOCTYPE html>-->
<!--<html lang="en">-->
<!--<head>-->
<!--    <meta charset="UTF-8">-->
<!--    <meta http-equiv="X-UA-Compatible" content="IE=edge">-->
<!--    <meta name="viewport" content="width=device-width, initial-scale=1.0">-->
<!--    <title>OCR</title>-->
<!--</head>-->
<!--<body>-->
<!--      -->
<!--<h3>Upload image</h3>-->
<!--<form action="uploadOCR.php" method="POST" enctype="multipart/form-data" >-->
<!--    <input type="file" name="image" accept="image/*" required>-->
<!--    <input type="submit" name="submit" value="Upload Image">-->
<!--</form> -->
<!---->
<!---->
<!--</section>-->
<!---->
<!---->
<!--	--><?php
//        	$sql = "SELECT id, name,surname, MAX(place) as Highest  FROM test";
//			$resultset = mysqli_query($conn, $sql) or die("database error:". mysqli_error($conn));
//            while( $record = mysqli_fetch_assoc($resultset) ) {
//                ?>
<!---->
<!--    <section class="wrapper-numbers" style="margin-bottom:50px">-->
<!--       <div class="container">-->
<!--           <div class="row countup text-center">-->
<!--               <div class="col-md-8 offset-md-2 header-numbers">-->
<!--                   <h1>Voting Report</h1>-->
<!--                   <p>These reports specify the number of votes and counting, number of voting stations, number of parties participating and the leading party that has the great number of votes so far, check the dashboard for a full report.</p>-->
<!--               </div>-->
<!--               <div class="col-sm-6 col-md-3 column">-->
<!--                   <p><i class="icon-graduation" aria-hidden="true"></i></p>-->
<!--                   <p> <span class="count">--><?php //echo  $record['Highest']?><!--</span></p>-->
<!--                   <h2>Number of Votes </h2>-->
<!--               </div>-->
<!--               <div class="col-sm-6 col-md-3 column">-->
<!--                   <p><i class="icon-location-pin" aria-hidden="true"></i></p>-->
<!--                   <p> <span class="count replay">328</span></p>-->
<!--                   <h2>Voting Stations</h2>-->
<!--               </div>-->
<!--               <div class="col-sm-6 col-md-3 column">-->
<!--                   <p><i class="icon-paper-plane" aria-hidden="true"></i></p>-->
<!--                   <p> <span class="count">95.60</span><span class="sup"> </span></p>-->
<!--                   <h2>Participating Parties</h2>-->
<!--               </div>-->
<!--               <div class="col-sm-6 col-md-3 column">-->
<!--                   <p><i class="icon-cloud-download" aria-hidden="true"></i></p>-->
<!--                   <p> <span class="count">9157</span><span class="sup"></span></p>-->
<!--                   <h2>Leading Party</h2>-->
<!--               </div>-->
<!--           </div>-->
<!--       </div>-->
<!--   </section>-->
<!--   --><?php //} ?>
<!--   -->
<!--   <div class="progress" style="margin:30px">-->
<!-- <div class="progress-bar bg-success" role="progressbar" style="width: 25%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">ANC 25%</div>-->
<!--</div>-->
<!--<div class="progress" style="margin:30px">-->
<!-- <div class="progress-bar bg-info" role="progressbar" style="width: 50%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100">DA 50%</div>-->
<!--</div>-->
<!--<div class="progress" style="margin:30px">-->
<!-- <div class="progress-bar bg-warning" role="progressbar" style="width: 10%" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100">NFP 10%</div>-->
<!--</div>-->
<!--<div class="progress" style="margin:30px">-->
<!-- <div class="progress-bar bg-danger" role="progressbar" style="width: 15%" aria-valuenow="15" aria-valuemin="0" aria-valuemax="100">EFF 15%</div>-->
<!--</div>-->
<!---->
<!--</body>-->
<!--</html> -->
