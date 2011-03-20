<?php
/*
 *      Nepal Map Generator
 * 		(Based on Nepal Map API)
 *      
 *      Copyright 2011 Jwalanta Shrestha <jwalanta@gmail.com>
 *      GNU/GPL
 *      
 */

if (isset($_POST['generate-map'])){
	
	include ("../nepalmap.php");
	$map = new NepalMap();
	
	// set image width
	$map->setWidth((is_numeric($_POST['iw'])?$_POST['iw']:1000));
	if ($map->getImageWidth()>3000) die("Image size too big");
	
	// set stroke color and width
	$sc = explode(",",$_POST['sc']);
	$r = (is_numeric($sc[0]) && $sc[0]>=0 && $sc[0]<=255?$sc[0]:255);
	$g = (is_numeric($sc[1]) && $sc[1]>=0 && $sc[1]<=255?$sc[1]:255);
	$b = (is_numeric($sc[2]) && $sc[2]>=0 && $sc[2]<=255?$sc[2]:255);
	$sw = (is_numeric($_POST['sw'])?$_POST['sw']:1);
	$map->setStroke(array($r,$g,$b),$sw);
	
	$minc = explode(",",$_POST['minc']);
	$minr = (is_numeric($minc[0]) && $minc[0]>=0 && $minc[0]<=255?$minc[0]:255);
	$ming = (is_numeric($minc[1]) && $minc[1]>=0 && $minc[1]<=255?$minc[1]:0);
	$minb = (is_numeric($minc[2]) && $minc[2]>=0 && $minc[2]<=255?$minc[2]:0);	

	$maxc = explode(",",$_POST['maxc']);
	$maxr = (is_numeric($maxc[0]) && $maxc[0]>=0 && $maxc[0]<=255?$maxc[0]:0);
	$maxg = (is_numeric($maxc[1]) && $maxc[1]>=0 && $maxc[1]<=255?$maxc[1]:0);
	$maxb = (is_numeric($maxc[2]) && $maxc[2]>=0 && $maxc[2]<=255?$maxc[2]:0);
	
	$rrange = $maxr-$minr;
	$grange = $maxg-$ming;
	$brange = $maxb-$minb;
	
	// find the max and min values
	$v=explode("\n",$_POST["v"]);
	$max = $min = null;
	foreach ($v as $l){
		$p=explode(",",$l);
		$p[1]=(int)$p[1];
		
		if ($max==null) { $max = $min = $p[1]; }
		
		$max = ($p[1]>$max?$p[1]:$max);
		$min = ($p[1]<$min?$p[1]:$min);
	}
	
	$range = (float)($max - $min);
	
	// now set the colors for district
    if ($range!=0){
        foreach ($v as $l){
            if (trim($l)=='') continue;
        
            $p=explode(",",$l);
            
            // set color by extrapolating
            $map->setDistrictFillColor(array($p[0]=>array(	$minr + ( ($p[1]-$min)/$range ) * $rrange, 
                                                            $ming + ( ($p[1]-$min)/$range ) * $grange,  
                                                            $minb + ( ($p[1]-$min)/$range ) * $brange)));
                                                            
        
        }
    }
	
	if ($_POST["type"]=="image") $map->generateMap();
	else echo "<html><body><pre>".htmlentities($map->htmlAreaCode())."</pre></body></html>";
	
	die();

	
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

<head>
	<title>Nepal Map Generator</title>
	<meta http-equiv="content-type" content="text/html;charset=utf-8" />
	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.5.1/jquery.min.js"></script>
	<style>
	body{font-family: sans-serif; font-size: 11px;}
	label{display:block;margin-top: 5px;font-weight: bold;}
	</style>
</head>

<body>

<h2>Nepal Map Generator</h2>

<form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>" target="_blank">
<label>Image Width</label>
<input type="text" name="iw" id="iw" size="5" value="1000" />

<label>Stroke Width</label>
<select name="sw" id="sw">
<option selected value="1">1</option>
<option value="2">2</option>
<option value="3">3</option>
<option value="4">4</option>
<option value="5">5</option>
</select>

<label>Stroke Color (R,G,B eg, 100,255,10)</label>
<input type="text" name="sc" id="sc" size="15" value="255,255,255" />

<label>Minimum and Maximum Color (R,G,B eg, 100,255,10)</label>
<input type="text" name="minc" id="minc" size="15" value="255,0,0" />
<input type="text" name="maxc" id="maxc" size="15" value="0,0,0" />


<label>District and Values</label>
<textarea id="v" name="v" cols="40" rows="20"></textarea>
<p><em>district-name,value (one per line)</em>. <a href="#" onclick="$.get('sample.txt',function(d){$('#v').val(d)})">Enter sample values</a></p>

<label><input type="radio" value="image" name="type" checked /> Generate Image</label>
<label><input type="radio" value="areacode" name="type" /> Generate &lt;area&gt; code</label>

<label></label>
<input type="submit" name="generate-map" value="Generate" />

</form>

</body>
</html>
