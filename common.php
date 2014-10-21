<?php

$rab_settings = array(
	'cache' => array(
		'sectors' => 86400,
		'brands' => 1800
	)
);

function cmpname($a, $b)
{
    if(is_object($a))
    {
	    if(isset($a->brandname))
	    {
	    	$A = $a->brandname;		    
	    	$B = $b->brandname;
	    }
	    else
	    {
	    	$A = $a->name;
	    	$B = $b->name;		    
	    }
    }
    else
    {
	    if(isset($a['brandname']))
	    {
	    	$A = $a['brandname'];
	    	$B = $b['brandname'];
		    
	    }
	    else
	    {
	    	$A = $a['name'];
	    	$B = $b['name'];		    
	    }
	}

    return strnatcmp($A, $B);
}

function cmppercent($a, $b)
{
	//var_dump($a->score, $b->score);
    $perca = $a['score'] / $a['score_total'];
    $percb = $b['score'] / $b['score_total'];
        
    if($perca == $percb)
       return 0;
    
     return $perca < $percb ? 1 : -1;
}

function getFromAPI($command)
{
	global $language;
	$ch = curl_init();
	
	curl_setopt($ch, CURLOPT_HEADER, 0);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); //Set curl to return the data instead of printing it to the browser.
	curl_setopt($ch, CURLOPT_URL, 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . '/rankabrandproxy.php?command='.urldecode($command).'&lang='.$language['simple']);
	
	$data = curl_exec($ch);
	curl_close($ch);
	
	return json_decode($data, true);
}

function checkCache($filename, $cache_setting)
{
	global $rab_settings;
	$cache = true;
	
	//check the cache first
	if(!file_exists('cache/'.$filename) || !is_readable('cache/'.$filename))
		$cache = false;
	
	//if cache is still there and accessible, load it and check its oldness
	if($cache)
	{
		$file = @file_get_contents('cache/'.$filename);
		$raw = explode(';', $file, 2);
		$json = $raw[1];
		$cache_stamp = $raw[0];
		
		if(time() - $cache_stamp > $rab_settings['cache'][$cache_setting])
			$cache = false;
	}
		
	return !$cache ? false : $json;
}

function saveCache($json, $filename)
{
	$timestamp = time();
	@file_put_contents('cache/'.$filename, $timestamp.';'.$json);
}

function getSectorsData($id = false)
{	
	$cache = checkCache('sectordata.json', 'sectors');
	
	//if the cache is too old, unlucky user, this one needs to load it then
	if($cache === false)
	{
		$topsectors = getFromAPI('sectors');
		
		for($i = 0; $i < count($topsectors); $i++)
		{								
			$subsectors = getFromAPI('sectors/parent/'.$topsectors[$i]['id']);
			
			//echo "<!--".print_r($subsectors, true)."-->";
			
			$topsectors[$i]['subsectors'] = $subsectors;
		}
		
		//encode and save to cache
		$json = json_encode($topsectors);
		saveCache($json, 'cache/sectordata.json');
	}
	else
	{
		$json = $cache;
	}
	
	//do we need only a specific sector?
	if($id)
	{
		$data = json_decode($json);
		foreach($data as $sector)
		{
			if($sector->id == $id)
				$json = json_encode($sector);
		}
	}
	
	//return
	return json_decode($json);
}

function getBrandsData($id = false)
{
	$cache = checkCache('brandsdata.json', 'brands');
			
	//if the cache is too old, unlucky user, this one needs to load it then
	if($cache === false)
	{
		$allbrands = getFromAPI('search/brand/');
		
		//var_dump($allbrands);
				
		//encode and save to cache
		$json = json_encode($allbrands);
		saveCache($json, 'brandsdata.json');
	}
	else
	{
		$json = $cache;
	}
		
	//return
	return json_decode($json);
}

function detectLanguage()
{
	$lang = detectTLD();
	
	if(strlen($lang) > 3 || $lang == 'org' || $lang == 'com' || $lang == 'net') //probably not a proper language TLD determiner like localhost or .museum or a general purpose TLD is used
		return array('simple' => 'en', 'full' => 'en_GB', 'complete' => 'en_GB.UTF-8'); //international language (English)
	
	return array('simple' => $lang, 'full' => $lang.'_'.strtoupper($lang), 'complete' => $lang.'_'.strtoupper($lang).'.UTF-8');
}

function detectTLD($host = NULL)
{
	if($host === NULL)
		$host = $_SERVER['HTTP_HOST'];
		
	//explode the host string on dots and only use the last element in the returned array
	//this should be a string like "de", "nl", "fr", etc. or "org" for English / default
	$host_segments = explode('.', $host);
	
	return array_pop($host_segments);
}

function getFullURL()
{
    $s = empty($_SERVER["HTTPS"]) ? '' : ($_SERVER["HTTPS"] == "on") ? "s" : "";
    $sp = strtolower($_SERVER["SERVER_PROTOCOL"]);
    $protocol = substr($sp, 0, strpos($sp, "/")) . $s;
    $port = ($_SERVER["SERVER_PORT"] == "80") ? "" : (":".$_SERVER["SERVER_PORT"]);
    $host = (isset($_SERVER['HTTP_HOST']) && !empty($_SERVER['HTTP_HOST']))? $_SERVER['HTTP_HOST']:$_SERVER['SERVER_NAME'];
    return $protocol . "://" . $host . $port . $_SERVER['REQUEST_URI'];
}

function getFullPath()
{
	$fullurl = explode('/', getFullURL());
	array_pop($fullurl);
	return join('/', $fullurl);
}

function calculateBrandRanking($score, $score_total)
{
	$percentage = calculatePercentage($score, $score_total);
	$grade = 'E';
		 
	if($percentage < 15)
		$grade = 'E';
	else if($percentage < 35)
		$grade = 'D';
	else if($percentage < 55)
		$grade = 'C';
	else if($percentage < 75)
		$grade = 'B';
	else if($percentage < 100)	
		$grade = 'A';
	
	return $grade;
}

function calculatePercentage($score, $score_total)
{
	return round(($score / $score_total) * 100);
}
