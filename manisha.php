<html>
<head>
</head>
<body>

<form method="get" action="">
  <input type="text" name="city" placeholder="Enter city name" autocomplete="off">
  <input type="submit" name="submit" value="Search">
</form>
<style>
body {
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  height: 100%;
  background-size: cover;
	font-family: Arial, sans-serif;
  background-image: url("cc.jpg");
  background-size: cover;
	margin: 0;
  padding: 0;
	}
form {
	margin: 20px auto;
	text-align: center;
}
input[type=text] {
	padding: 10px;
	border: 1px solid #ccc;
	border-radius: 4px;
	box-sizing: border-box;
	width: 250px;
	margin-right: 10px;
	color:indigo;
  
}
input[type=submit] {
	background-color:black;
	color: white;
	padding: 10px 20px;
	border: none;
	border-radius: 4px;
	cursor: pointer;
}
input[type=submit]:hover {
	background-color: purple;
}
table {
	border-collapse: collapse;
	margin: 20px auto;
	box-sizing: border-box;
	border radius:20px;
	background-color: white;
	box-shadow: 0 0 20px rgba(0, 0, 0, 0.2);
  border: 2px solid #000; 

  
}
th, td {
    padding: 10px;
    text-align: center;
	border: 1px solid #000;
 

}
th {
	background-color: #f2f2f2;
	color: #000;
}
table {
  border-collapse: collapse;
  margin: 20px auto;
  font-size: 14px;
  box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
  background-image: url("cc.jpg");
  border-radius: 20px;
  border-spacing: 10px;
  border: 2px solid #000; 

}

table th,
table td {
  padding: 20px;

  text-align: center;
}

table th {
  background-color: gainsboro;
  margin: 1rem;
  color: black;

}

table tr:nth-child(odd) {
  background-color: white;
}
td img {
	width: 50px;
	height: 50px;
	margin: 0 auto;
	display: block;
	box-sizing: border-box;
}
		
tr:hover {
			
	background-color: #f5f5f5;
}
#back{
  width: 18%;
  height: 35px;
  background-color: black;
  color: white;
  border: none;
  border-radius: 5px;
  text-align: center;
  margin-top: 25px;
  margin-bottom: 10px;
  padding: 1%;
  margin-left: 7rem;
  margin-right: 7rem;
  text-decoration: none;}
.back{
	/* text-align: center;
    /* background-color: white; */
    /* margin-top: 15px;
    padding: 10px;
    border-radius: 50px;
    width:5%;
    margin-left: 10rem; */ */

       }
    </style>
<?php

if (isset($_GET['submit'])) {
  $city = $_GET['city'];
} else {
  $city = "Reading";
}

$url = "https://api.openweathermap.org/data/2.5/weather?q={$city}&appid=25bc889758f52fbf19758448e96ffbb3&units=metric";

// Make API request and parse JSON response
$response = file_get_contents($url);
$data = json_decode($response, true);

if (!$data) {
  // Handle API error
  die("Error: Failed to retrieve data from OpenWeatherMap API.");
}

// Extract relevant weather data
$city = $data['name'];
$temperature = $data['main']['temp'];
$pressure = $data['main']['pressure'];
$humidity = $data['main']['humidity'];
$windspeed = $data['wind']['speed'];



// Insert or update weather data in database
$host = 'localhost';
$username = 'root';
$password = "";
$dbname = 'weather';

$conn = mysqli_connect($host,$username,$password,$dbname);

if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}else{
//   echo"Connection established";
}

// Check if data for the current hour is already present in database
$sql = "SELECT * FROM `weatherdata` WHERE `city`='$city' AND DATE(`date`) = CURDATE()";

$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
  // Update existing row with latest weather data
  $sql = "UPDATE `weatherdata` SET `temperature`='$temperature',`pressure`='$pressure',`humidity`='$humidity', `windspeed`='$windspeed' WHERE `city`='$city' AND `date`= DATE_FORMAT(NOW(), '%Y-%m-%d %H:00:00')";
} else {
  // Insert new row with current weather data
 
  $sql = "INSERT INTO `weatherdata` (`city`, `date`, `temperature`,`pressure`,`humidity`,`windspeed`)
        VALUES ('$city', NOW(),'$temperature','$pressure', '$humidity', '$windspeed')";
}

mysqli_query($conn, $sql);

// Retrieve latest weather data from database
$sql = "SELECT * FROM  `weatherdata` WHERE `city`='$city' ORDER BY `date` DESC LIMIT 7";
$result = mysqli_query($conn, $sql);

echo "<table border='1'>";
echo "<tr class='sty'>";
echo "<th>City</th>";
echo "<th>Date</th>";
echo "<th>Temperature</th>";
echo "<th>Pressure</th>";
echo "<th>Humidity</th>";
echo "<th>Wind Speed</th>";
echo "</tr>";
while ($row = mysqli_fetch_assoc($result)) {
  $date = date('Y-m-d H:i:s', strtotime($row['date']));
  $temperature = $row['temperature'];
  $pressure = $row['pressure'];
  $humidity = $row['humidity'];
  $windspeed = $row['windspeed'];

  echo "<tr>";
  echo "<td>{$city}</td>";
  echo "<td>{$date}</td>";
  echo "<td>{$temperature}°C</td>";
  echo "<td>{$pressure}hPA</td>";
  echo "<td>{$humidity}%</td>";
  echo "<td>{$windspeed} m/s</td>";
  echo "</tr>";
}
echo "</table>";


// Close database connection
mysqli_close($conn);
?>
<div class="back">
<a href="ManishaTamang_2358425.html" id="back">Back</a>
</div>

</body>
</html>