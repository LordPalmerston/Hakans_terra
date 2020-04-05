<html>

<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8"> 
    <title> 
        Hakans Terrarium
    </title> 
</head> 
<body style="text-align:center;">

<h1 style="color:green;"> 
        Hakans Terrarium
    </h1> 
      
    <h4> 
        Terrarium temps and humidity
    </h4>

<form method="post"> 
        <input type="submit" name="today"
                class="button" value="Today" /> 
          
        <input type="submit" name="this_week"
                class="button" value="Yesterday" /> 
</form> 	
	
<?php 


        if(array_key_exists('today', $_POST)) { 
            today(); 
        } 
        else if(array_key_exists('this_week', $_POST)) { 
            this_week(); 
        } 
        function today() { 
            echo "<font size='15pt'> Data from today";
			$date = date("Y-m-d");
			post_data($date);
        } 
        function this_week() { 
            echo "<font size='15pt'> Data from yesterday";
			$date = date("Y-m-d", strtotime("yesterday"));
			post_data($date);
        } 

function post_data($date) {
$username = "nhep_test"; 
$password = "Wyf1wyawy"; 
$database = "nhep_test"; 
$host = "johnny.heliohost.org";

$mysqli = new mysqli($host, $username, $password, $database); 
$query_S1 = "SELECT * FROM Sensor1 WHERE DATE(time) = '".$date."'";
$query_S2 = "SELECT * FROM Sensor2 WHERE DATE(time) = '".$date."'";
 

echo '
    <div align="center">
    <table border="0.5" cellspacing="2" cellpadding="2"> 
      <tr>
          <th>
          <th>&nbsp</th>
          <th style="text-align:center"> <font face="Arial">Sensor air left</font> </th>
          <th>
          <th>
          <th style="text-align:center"> <font face="Arial">Sensor air right</font> </th>
          <th>
      
      <tr> 
          <td> <font face="Arial">Time</font> </td>
          <td>
          <td> <font face="Arial">Temperature</font> </td> 
          <td> <font face="Arial">Humidity</font> </td> 
          <td>
          <td> <font face="Arial">Temperature</font> </td> 
          <td> <font face="Arial">Humidity</font> </td> 
      
';
 
if ($result_S1 = $mysqli->query($query_S1) and $result_S2 = $mysqli->query($query_S2)) {
    while ($row_S1 = $result_S1->fetch_assoc() and $row_S2 = $result_S2->fetch_assoc()) {
		$time_S1 = substr($row_S1["time"],11);
        $temp_S1 = $row_S1["temp"];
        $hum_S1 = $row_S1["hum"];
        $temp_S2 = $row_S2["temp"];
        $hum_S2 = $row_S2["hum"];

 
        echo '<tr>
				  <td>'.$time_S1.'</td>
				  <td>&nbsp</th>
                  <td>'.$temp_S1.'</td> 
                  <td>'.$hum_S1.'</td>
                  <td>
                  <td>'.$temp_S2.'</td> 
                  <td>'.$hum_S2.'</td>
              </tr>
        ';
    }
    $result->free();
}

} 
?>
</body>
</html>