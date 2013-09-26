<?php

	function echo2DArray($array)
	{
		echo "<p>There are " . count($array) . " rows in the 2D array<br />";
		echo "Each record has " . count($array[0]) . " fields</p>";
		foreach ($array as $indexR=>$record)
		{
			echo "$indexR&nbsp;&nbsp;&nbsp;";
			foreach ($record as $indexF=>$field)
				echo "$indexF: $field&nbsp;&nbsp;&nbsp;";
			echo "<br />";
		}
	}

	function search_2d_array($array, $key, $value) {
		for ($i = 0; $i < count($array); $i++)
		{
			if (isset($array[$i][$key])) {
				if ($array[$i][$key] == $value) {
					return $i;
				}
			}	
		}
		return false;
    };
	
	function usortByKey(&$array, $key, $asc=SORT_ASC) {
		$sort_flags = array(SORT_ASC, SORT_DESC);
		if(!in_array($asc, $sort_flags)) 
			throw new InvalidArgumentException('sort flag only accepts SORT_ASC or SORT_DESC');
		$cmp = function(array $a, array $b) use ($key, $asc, $sort_flags) {
			if(!isset($a[$key]) || !isset($b[$key])) {
				throw new Exception('attempting to sort on non-existent keys');
			}
			if($a[$key] == $b[$key]) return 0;
			return ($asc==SORT_ASC xor $a[$key] < $b[$key]) ? 1 : -1; 
		};
		usort($array, $cmp);
	};
	
	function usortByArrayKey(&$array, $key, $asc=SORT_ASC) {
		$sort_flags = array(SORT_ASC, SORT_DESC);
		if(!in_array($asc, $sort_flags)) 
			throw new InvalidArgumentException('sort flag only accepts SORT_ASC or SORT_DESC');
		$cmp = function(array $a, array $b) use ($key, $asc, $sort_flags) {
			if(!is_array($key)) { //just one key and sort direction
				if(!isset($a[$key]) || !isset($b[$key])) {
					throw new Exception('attempting to sort on non-existent keys');
				}
				if($a[$key] == $b[$key]) return 0;
				return ($asc==SORT_ASC xor $a[$key] < $b[$key]) ? 1 : -1;
			} 
			else 
			{ //using multiple keys for sort and sub-sort
				foreach($key as $sub_key => $sub_asc) {
					//array can come as 'sort_key'=>SORT_ASC|SORT_DESC or just 'sort_key', so need to detect which
					if(!in_array($sub_asc, $sort_flags)) { $sub_key = $sub_asc; $sub_asc = $asc; }
					//just like above, except 'continue' in place of return 0
					if(!isset($a[$sub_key]) || !isset($b[$sub_key])) {
						throw new Exception('attempting to sort on non-existent keys');
					}
					if($a[$sub_key] == $b[$sub_key]) continue;
					return ($sub_asc==SORT_ASC xor $a[$sub_key] < $b[$sub_key]) ? 1 : -1;
				}
            return 0;
			}
		};
		usort($array, $cmp);
	};
?>