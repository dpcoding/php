<?php
	function write2DArray($filename, $array2d, $delimiter)
	{
		@$fp = fopen($filename, 'w');

		if (!$fp)
			throw new Exception("Can't open file $filename. $php_errormsg.");
		
		for ($row = 0; $row < count($array2d); $row++)
		{
			$record = "";
			for ($column = 0; $column < count ($array2d[0]) - 1; $column++)
			{
				$record = $record . $array2d[$row][$column] . $delimiter;
			}
			if ($row < count($array2d) - 1)
				$record = $record . $array2d[$row][$column] . "\n";
			else
				$record = $record . $array2d[$row][$column];
			if (fwrite($fp, $record) === false)
				throw new Exception("Can't write record to the file $filename. $record");
		}
		
		if (!fclose($fp))
			throw new Exception ("Can't close file $filename");
	}
	
	function get2DArray($filename, $delimiter)
	{
		$array2D = array();
		@$fp = fopen($filename, 'r');

		if (!$fp)
			throw new Exception("Can't open file $filename. $php_errormsg.");
		
		$i = 0;
		while(!feof($fp))
		{
			if (($record = fgetcsv($fp, 200, $delimiter)) !== false)
			{
				$array2D[$i] = $record;
				$i++;
			}
			else
				throw new Exception("Can't read record from the file $filename. $i");
		}
		
		if (!fclose($fp))
			throw new Exception ("Can't close file $filename");
		
		return $array2D;
	}
	
	function get2DAssocArray($filename, $delimiter, $keys)
	{
		$array2D = array();
		@$fp = fopen($filename, 'r');

		if (!$fp)
			throw new Exception("Can't open file $filename. $php_errormsg.");
		
		$i = 0;
		while(!feof($fp))
		{
			if (($record = fgetcsv($fp, 200, $delimiter)) !== false)
			{
				for ($k = 0; $k < count($keys); $k++)
				{
					// if every record doesn't have the same number of fields
					if (isset($record[$k]) && trim($record[$k]) != "")
					{
						$array2D[$i][$keys[$k]] = $record[$k];
					}
				}
				$i++;
			}
			else
				throw new Exception("Can't read record from the file $filename");
		}
		
		if (!fclose($fp))
			throw new Exception ("Can't close file $filename");
		
		return $array2D;
	}
	
?>