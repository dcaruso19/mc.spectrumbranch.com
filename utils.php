<?php
	function check_transparent($im) {
		$width = imagesx($im); // Get the width of the image
		$height = imagesy($im); // Get the height of the image
		// We run the image pixel by pixel and as soon as we find a transparent pixel we stop and return true.
		for($i = 0; $i < $width; $i++) {
			for($j = 0; $j < $height; $j++) {
				$rgba = imagecolorat($im, $i, $j);
				if(($rgba & 0x7F000000) >> 24) {
					return true;
				}
			}
		}
		// If we dont find any pixel the function will return false.
		return false;
	}
?>