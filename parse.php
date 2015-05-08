<?php
function writeContentToFile($text, $file = 'content', $mode = 'a')
{
	$fh = fopen($file, $mode) or die('Cannot create file');
	fwrite($fh, $text);
	fclose($fh);
}

function combineContent($a, $b)
{
	foreach($b as $key => $value)
	{
		$key = trim($a[$key]);
		$output[$key] = trim($value);
	}

	return $output;
}





// Get content
$content = file_get_contents('skoler.csv');
$content = explode("\n", $content);


$keys = explode(';', $content['0']);
$keys = array_map('strtolower', $keys);
unset($content['0']);





// Check if content are available
if($content)
{
	foreach($content as $value)
	{
		if($value)
		{
			$value = explode(';', $value);
			if($value['1'])
			{
				$value = combineContent($keys, $value);


				$skoler[$value['inst_type_nr']][$value['postnr']][] = $value;
				$skoletyper[$value['inst_type_nr']] = $value['inst_type_navn'];
			}
		}
	}
}





// Write content to file
if(count($skoler) > 0)
{
	writeContentToFile(json_encode($skoler), 'skoler.json', 'w');
	writeContentToFile(json_encode($skoletyper), 'skoletyper.json', 'w');
}
?>