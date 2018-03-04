<?php
	function imgresize($filename, $newfilename, $max) 
	{

		$ext = array_pop(explode(".", $filename));
		if($ext == "png")
			$image = imagecreatefrompng($filename);
		else if($ext == "jpeg")
			$image = imagecreatefromjpeg($filename);
		else if($ext == "gif")
			$image = imagecreatefromgif($filename);
		
		$exif = exif_read_data($filename);

	    if (!empty($exif['Orientation']))
	    {
	        switch ($exif['Orientation'])
	        {
	            case 3:
	                $image = imagerotate($image, 180, 0);
	                break;

	            case 6:
	                $image = imagerotate($image, -90, 0);
	                break;

	            case 8:
	                $image = imagerotate($image, 90, 0);
	                break;
	        }
	    }

		// Get new dimensions
		$owidth = imagesx($image);
		$oheight = imagesy($image);

		$width = $max;
		$height = $max;
		if($owidth > $oheight)
			$height = $max * $oheight / $owidth;
		else
			$width = $max * $owidth / $oheight;
		// Resample
		$image_p = imagecreatetruecolor($width, $height);

		imagecopyresampled($image_p, $image, 0, 0, 0, 0, $width, $height, $owidth, $oheight);

		if($ext == "png")
			imagepng($image_p, $newfilename);
		else if($ext == "jpeg")
			imagejpeg($image_p, $newfilename);
		else if($ext == "gif")
			imagegif($image_p, $newfilename);
	}
?>