<?php

include("nepalmap.php");

// Primary Enrollment 
// Source: Flash 2009-10, Department of Education
$pr_enroll_2010 = array("Kathmandu"=>185072,"Morang"=>162763,"Rupandehi"=>136457,"Bara"=>134235,"Kailali"=>132933,
						"Sarlahi"=>126287,"Nawalparasi"=>124844,"Dhanusa"=>118523,"Jhapa"=>115658,"Sunsari"=>114286,
						"Siraha"=>107721,"Parsa"=>105946,"Dang"=>102079,"Mahottari"=>102004,"Kapilbastu"=>100873,
						"Makwanpur"=>92944,"Banke"=>92848,"Saptari"=>90316,"Sindhuli"=>88642,"Rautahat"=>84285,
						"Bardiya"=>81186,"Chitwan"=>81127,"Kavrepalanchok"=>78252,"Kanchanpur"=>78065,"Surkhet"=>77314,
						"Dailekh"=>75567,"Dhading"=>72695,"Kaski"=>70946,"Lalitpur"=>66663,"Gulmi"=>66293,
						"Baitadi"=>64645,"Baglung"=>63872,"Udayapur"=>63739,"Khotang"=>60517,"Bajhang"=>60045,
						"Rukum"=>59793,"Salyan"=>59567,"Palpa"=>58689,"Nuwakot"=>57921,"Tanahu"=>57891,
						"Syangja"=>55907,"Rolpa"=>55765,"Gorkha"=>55332,"Jajarkot"=>55203,"Doti"=>53396,
						"Ramechhap"=>52727,"Pyuthan"=>51313,"Taplejung"=>48972,"Panchthar"=>47439,"Ilam"=>46465,
						"Achham"=>45163,"Arghakhanchi"=>44794,"Dolakha"=>44647,"Sindhupalchok"=>43772,"Bhojpur"=>41875,
						"Lamjung"=>37865,"Kalikot"=>37316,"Sankhuwasabha"=>37018,"Okhaldhunga"=>34845,"Bhaktapur"=>33939,
						"Bajura"=>33606,"Parbat"=>31570,"Dhankuta"=>31569,"Dadeldhura"=>30685,"Darchula"=>29893,
						"Solukhumbu"=>27883,"Terhathum"=>27336,"Jumla"=>27054,"Myagdi"=>21951,"Mugu"=>11655,
						"Humla"=>11654,"Rasuwa"=>9143,"Dolpa"=>6975,"Mustang"=>1856,"Manang"=>577);


$map = new NepalMap();

// set width. height will be set automatically
$map->setWidth(800);

// set stroke color (r,g,b) and width
$map->setStroke(array(255,255,255),1);

// set the fillcolor based on values
foreach ($pr_enroll_2010 as $d=>$n){
	$v = 255 - ($n*255/185072);
	$map->setDistrictFillColor(array($d=>array($v,0,0)));
}

// generate map
$map->generateMap("nepal_pr_enroll.png");

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

<head>
	<title>Primary Level Enrollment in Nepal</title>
	<meta http-equiv="content-type" content="text/html;charset=utf-8" />
	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.5.1/jquery.min.js"></script>
	<script type="text/javascript" src="http://davidlynch.org/js/maphilight/jquery.maphilight.min.js"></script>
	<script>
		$(function() {
			$('.map').maphilight({
				fillColor: 'ffffff',
				fillOpacity: 0.5,
				strokeColor: 'ffffff'
			});
		});
	</script>
</head>

<body>

<h2>Primary Level Enrollment</h2>
<p>Source: Flash 2009-10, Department of Education</p>
<p><em>Hover mouse over districts to reveal name</em></p>
<img class="map" src="nepal_pr_enroll.png" usemap="#nepal">
<map name="nepal" >
<?php 
	echo $map->htmlAreaCode();
?>
</map>

</body>
</html>
