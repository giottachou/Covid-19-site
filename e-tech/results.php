<!DOCTYPE html>
<html>
<head>
  <title>COVID-19</title>
  <meta charset="utf-8"> 
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"> <!--stylesheet-->
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script> -->
</head>
<body>
<hr>  
<?php

//Define the variables and get the user's input 
$datefrom = date("Y/m/d", strtotime($_POST['datefrom'])); 
$dateto = date("Y/m/d", strtotime($_POST['dateto']));
$country = $_POST['countries'];
	

//Queries that will happen if the user put a specific input
//User given country and date input
if ($country!="notselected" && $datefrom!="1970/01/01" && $dateto!="1970/01/01"){ $query = "select * from outputcsv where countriesAndTerritories like '$country' &&  dateRep between '$datefrom' and '$dateto' ORDER BY dateRep ASC " ;}
//User checked most cases and given date input	
elseif (isset($_POST['mostcases']) && $_POST['mostcases'] == 'checked' && $datefrom!="1970/01/01" && $dateto!="1970/01/01") { $query = "select *,sum(cases) from`outputcsv` where dateRep between '$datefrom' and '$dateto' GROUP BY countriesAndTerritories ORDER BY sum(cases) DESC LIMIT 0,10" ;}
//User checked least cases and given date input	
elseif (isset($_POST['leastcases']) && $_POST['leastcases'] == 'checked' && $datefrom!="1970/01/01" && $dateto!="1970/01/01") { $query = "select *,sum(cases) from`outputcsv` where dateRep between '$datefrom' and '$dateto' GROUP BY countriesAndTerritories ORDER BY sum(cases) ASC LIMIT 0,10" ;}
//User checked most deaths and given date input	
elseif (isset($_POST['mostdeaths']) && $_POST['mostdeaths'] == 'checked' && $datefrom!="1970/01/01" && $dateto!="1970/01/01") { $query = "select *,sum(deaths) from`outputcsv` where dateRep between '$datefrom' and '$dateto' GROUP BY countriesAndTerritories ORDER BY sum(deaths) DESC LIMIT 0,10" ;}
//User checked least deaths and given date input	
elseif (isset($_POST['leastdeaths']) && $_POST['leastdeaths'] == 'checked' && $datefrom!="1970/01/01" && $dateto!="1970/01/01") { $query = "select *,sum(deaths) from`outputcsv` where dateRep between '$datefrom' and '$dateto' GROUP BY countriesAndTerritories ORDER BY sum(deaths) ASC LIMIT 0,10" ;}
//User given country input
elseif ($country!="notselected"){ $query = "select * from outputcsv where countriesAndTerritories like '$country' ORDER BY dateRep ASC " ;}
//User given date input
elseif ($datefrom!="1970/01/01" && $dateto!="1970/01/01") { $query = "select * from outputcsv where dateRep between '$datefrom' and '$dateto' ORDER BY countriesAndTerritories  ASC " ; } 
//User checked most cases
elseif(isset($_POST['mostcases']) && $_POST['mostcases'] == 'checked') {$query = "SELECT *,sum(cases),sum(deaths) FROM outputcsv GROUP BY countriesAndTerritories ORDER BY sum(cases) DESC LIMIT 0,10" ;}
//User checked least cases
elseif(isset($_POST['leastcases']) && $_POST['leastcases'] == 'checked') {$query = "SELECT *,sum(cases),sum(deaths) FROM outputcsv GROUP BY countriesAndTerritories ORDER BY sum(cases) ASC LIMIT 0,10" ;}
//User checked most deaths
elseif(isset($_POST['mostdeaths']) && $_POST['mostdeaths'] == 'checked') {$query = "SELECT *,sum(cases),sum(deaths) FROM outputcsv GROUP BY countriesAndTerritories ORDER BY sum(deaths) DESC LIMIT 0,10" ;}
//User checked least deaths
elseif(isset($_POST['leastdeaths']) && $_POST['leastdeaths'] == 'checked') {$query = "SELECT *,sum(cases),sum(deaths) FROM outputcsv GROUP BY countriesAndTerritories ORDER BY sum(deaths) ASC LIMIT 0,10" ;}

try {
	 //Connect to database
  $db = new PDO("mysql:host=localhost;dbname=etech", "root");
  $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	// Build an SQL query explicitly
	$stmt = $db->query($query); 
?>   
<div class="container">
<h2 class="">COVID-19 </h2>
	<table class="table table-bordered">
    <thead>
      <tr>
        <th>#</th>
        <th>Country</th>
		<th>Cases</th> 
		<th>Deaths</th> 
		<th>Dates</th> 
		<th>Population</th>
      </tr>
    </thead>
  <tbody>
 <?php 
	$no=1;
   while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) { //Print results of the queries specified by the users input
	   //User given country and date input
	  if ($country!="notselected" && $datefrom!="1970/01/01" && $dateto!="1970/01/01")
	  {
		  printf("<tr> <td> %d </td> <td> %s </td> <td> %s </td> <td> %s </td> <td> %s </td> <td> %s </td></tr>", htmlentities($no++), htmlentities($row["countriesAndTerritories"]), htmlentities($row["cases"]),htmlentities($row["deaths"]), htmlentities($row["dateRep"]), htmlentities($row["popData2018"]));
	  }
	   //User checked most cases and given dates input
	  elseif (isset($_POST['mostcases']) && $_POST['mostcases'] == 'checked' && $datefrom!="1970/01/01" && $dateto!="1970/01/01")
	  {
		  printf("<tr> <td> %d </td> <td> %s </td> <td> %s </td> <td> %s </td> <td> %s </td> <td> %s </td> </tr>", htmlentities($no++), htmlentities($row["countriesAndTerritories"]), htmlentities($row["cases"]),htmlentities($row["deaths"]),htmlentities("$datefrom-$dateto"), htmlentities($row["popData2018"]));
	  }
	   //User checked least cases and given dates input
	  elseif (isset($_POST['leastcases']) && $_POST['leastcases'] == 'checked' && $datefrom!="1970/01/01" && $dateto!="1970/01/01")
	  {
		  printf("<tr> <td> %d </td> <td> %s </td> <td> %s </td> <td> %s </td> <td> %s </td> <td> %s </td> </tr>", htmlentities($no++), htmlentities($row["countriesAndTerritories"]), htmlentities($row["cases"]),htmlentities($row["deaths"]),htmlentities("$datefrom-$dateto"), htmlentities($row["popData2018"]));
	  }
	   //User checked most deaths and given dates input
	  elseif (isset($_POST['mostdeaths']) && $_POST['mostdeaths'] == 'checked' && $datefrom!="1970/01/01" && $dateto!="1970/01/01")
	  {
		  printf("<tr> <td> %d </td> <td> %s </td> <td> %s </td> <td> %s </td> <td> %s </td> <td> %s </td> </tr>", htmlentities($no++), htmlentities($row["countriesAndTerritories"]), htmlentities($row["cases"]),htmlentities($row["deaths"]),htmlentities("$datefrom-$dateto"), htmlentities($row["popData2018"]));
	  }
	   //User checked least deaths and given dates input
	  elseif (isset($_POST['leastdeaths']) && $_POST['leastdeaths'] == 'checked' && $datefrom!="1970/01/01" && $dateto!="1970/01/01")
	  {
		  printf("<tr> <td> %d </td> <td> %s </td> <td> %s </td> <td> %s </td> <td> %s </td> <td> %s </td> </tr>", htmlentities($no++), htmlentities($row["countriesAndTerritories"]), htmlentities($row["cases"]),htmlentities($row["deaths"]), htmlentities("$datefrom-$dateto"), htmlentities($row["popData2018"]));
	  }
	   //User given country input
      elseif ($country!="notselected")
	  {
		  printf("<tr> <td> %d </td> <td> %s </td> <td> %s </td> <td> %s </td> <td> %s </td> <td> %s </td> </tr>", htmlentities($no++), htmlentities($row["countriesAndTerritories"]), htmlentities($row["cases"]),htmlentities($row["deaths"]), htmlentities($row["dateRep"]), htmlentities($row["popData2018"]));
	  } 
	   //User given dates input
	  elseif ($datefrom!="1970/01/01" && $dateto!="1970/01/01")
      { 
		printf("<tr> <td> %d </td> <td> %s </td> <td> %s </td> <td> %s </td> <td> %s </td> <td> %s </td></tr>", htmlentities($no++),htmlentities($row["countriesAndTerritories"]),htmlentities($row["cases"]),htmlentities($row["deaths"]),htmlentities($row["dateRep"]), htmlentities($row["popData2018"]));
      }
	   //User checked most cases
	  elseif(isset($_POST['mostcases']) && $_POST['mostcases'] == 'checked') 
	  { 
		printf("<tr> <td> %d </td> <td> %s </td> <td> %s </td> <td> %s </td> <td> %s </td> <td> %s </td> </tr>", htmlentities($no++),htmlentities($row["countriesAndTerritories"]),htmlentities($row["sum(cases)"]),htmlentities($row["sum(deaths)"]), htmlentities("-"),htmlentities($row["popData2018"]));
      }
	   //User checked least cases
	  elseif(isset($_POST['leastcases']) && $_POST['leastcases'] == 'checked') 
	  { 
		printf("<tr> <td> %d </td> <td> %s </td> <td> %s </td> <td> %s </td> <td> %s </td> <td> %s </td> </tr>", htmlentities($no++),htmlentities($row["countriesAndTerritories"]),htmlentities($row["sum(cases)"]),htmlentities($row["sum(deaths)"]), htmlentities("-"),htmlentities($row["popData2018"]));
      }
	   //User checked most deaths
	  elseif(isset($_POST['mostdeaths']) && $_POST['mostdeaths'] == 'checked') 
	  { 
		printf("<tr> <td> %d </td> <td> %s </td> <td> %s </td> <td> %s </td> <td> %s </td> <td> %s </td></tr>", htmlentities($no++),htmlentities($row["countriesAndTerritories"]),htmlentities($row["sum(cases)"]),htmlentities($row["sum(deaths)"]),htmlentities("-"),htmlentities($row["popData2018"]));
      }
	   //User checked least deaths
	  elseif(isset($_POST['leastdeaths']) && $_POST['leastdeaths'] == 'checked') 
	  { 
		printf("<tr> <td> %d </td> <td> %s </td> <td> %s </td> <td> %s </td> <td> %s </td> <td> %s </td></tr>", htmlentities($no++),htmlentities($row["countriesAndTerritories"]),htmlentities($row["sum(cases)"]),htmlentities($row["sum(deaths)"]), htmlentities("-"),htmlentities($row["popData2018"]));
      }
 }
}

//catch error
catch (PDOException $e) {
  printf("We had a problem: %s\n", $e->getMessage());
}

exit();
?>
		</tbody>
		</div>
</hr>
</body>
</html>