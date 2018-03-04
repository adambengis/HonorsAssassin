	<?php 
		function randStr($length) 
		{
		    return bin2hex(random_bytes($length));
		}
	?>