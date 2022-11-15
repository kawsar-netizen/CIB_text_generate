<?php
 function dateFormatcorr($date)
    {
	
		$temp_dt = explode("-", $date);
		
		$fix_dt=$temp_dt[0].$temp_dt[1].$temp_dt[2];
		return $fix_dt;
	}

 echo dateFormatcorr('08-02-1986');
 
?>