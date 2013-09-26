<?php

  $FLYER_FILE = "flyer.txt";
  $MILEAGE_FILE = "mileage.txt";
  $DATA_FOLDER = "flyers";
  $ID_INDEX = 0;
  $EMAIL_INDEX = 1;
  $PASSWORD_INDEX = 2;
  $MILEAGE_INDEX = 1;

  function readFlyerFile($filename)
  {
    global $DATA_FOLDER;
    
    $filename = "$DATA_FOLDER/$filename";
    $dataAll = array();
    @$fp = fopen($filename, 'rb');

    if (!$fp)
      throw new Exception("Can't open file $filename. $php_errormsg.");
    
    $i = 0;
    while(!feof($fp))
    {
      if (($data = fgetcsv($fp, 200, "\t")) !== false)
      {
        $dataAll[$i] = $data;
        $i++;
      }
      else
        throw new Exception("Can't read record from the file $filename");
    }
    
    if (!fclose($fp))
      throw new Exception ("Can't close file $filename");
    
    return $dataAll;
  }
  
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
  
  function getFlyerInfo($email)
  {
    global $FLYER_FILE;
    try
    {
      $flyers = readFlyerFile($FLYER_FILE);
      foreach ($flyers as $flyer)
      {
        if (trim($flyer[1]) == trim($email))
          return $flyer; 
      }
      return false;
      
    }
    catch (Exception $e)
    {
      echo "Exception: " . $e->getMessage() . " occurred in " . $e->getFile() . " at line " . $e->getLine() . "." ; 
      return false;
    }
  }
  
  function getFlyerInfoById($id)
  {
    global $FLYER_FILE;
    try
    {
      $flyers = readFlyerFile($FLYER_FILE);
      foreach ($flyers as $flyer)
      {
        if (trim($flyer[0]) == $id)
          return $flyer; 
      }
      return false;
      
    }
    catch (Exception $e)
    {
      echo "Exception: " . $e->getMessage() . " occurred in " . $e->getFile() . " at line " . $e->getLine() . "." ; 
      return false;
    }
  }
  
  function getFlyerMileageInfoById($id)
  {
    global $MILEAGE_FILE;
    try
    {
      $flyers = readFlyerFile($MILEAGE_FILE);
      foreach ($flyers as $flyer)
      {
        if (trim($flyer[0]) == $id)
          return $flyer; 
      }
      return false;
      
    }
    catch (Exception $e)
    {
      echo "Exception: " . $e->getMessage() . " occurred in " . $e->getFile() . " at line " . $e->getLine() . "." ; 
      return false;
    }
  }
  
  function getFlyerMileageById($id)
  {
    global $MILEAGE_INDEX;
    $flyer = getFlyerMileageInfoById($id);
    if ($flyer === false)
      return 0;
    else
      return $flyer[$MILEAGE_INDEX];
  }
  
  function writeFlyerFile($filename, $dataAll)
  {
    global $DATA_FOLDER;
    
    $filename = "$DATA_FOLDER/$filename";
    // open file for writing only - create a new file
    @ $fp = fopen($filename, 'wb');
    if (!$fp)
    {
      throw new Exception("Can't open file $filename. $php_errormsg.");
    }
    
    $i = 1;
    $rows = count($dataAll);
    foreach ($dataAll as $data)
    {
      $output = "";
      foreach ($data as $element)
        $output = $output . $element . "\t";
      // remove the last tab
      $output = substr($output, 0, strlen($output) - 1);
      // add the record delimiter at the end of all records but the last one
      if ($i < $rows)
        $output = $output . "\n";
      
      if (fwrite($fp, $output, strlen($output)) === false)
        throw new Exception("Can't write record to file. $output");
        
      $i++;
    }
    
    @ fclose($fp);
  }
  
  function writeNewFlyer($email, $password)
  {
    global $FLYER_FILE;
    
    try
    {
      $flyers = readFlyerFile($FLYER_FILE);
      $id = rand();
      $flyer = array($id, $email, $password, "", "", "", "", "", "", "");
      $flyers[] = $flyer;
      writeFlyerFile($FLYER_FILE, $flyers);
      return $flyer;
    }
    
    catch (Exception $e)
    {
      echo "Exception: " . $e->getMessage() . " occurred in " . $e->getFile() . " at line " . $e->getLine() . "." ; 
      return false;
    }
  }
  
  function writeExistingFlyer(&$flyer)
  {
    global $FLYER_FILE;
    global $EMAIL_INDEX;
    global $PASSWORD_INDEX;
    
    try
    {
      $flyers = readFlyerFile($FLYER_FILE);
      $i = 0;
      $done = false;
      while ($i < count($flyers) && !$done)
      {
        // check the ids
        if ($flyers[$i][0] == $flyer[0])
        {
          // update the email and password - those aren't in the form
          $flyer[$EMAIL_INDEX] = $flyers[$i][$EMAIL_INDEX];
          $flyer[$PASSWORD_INDEX] = $flyers[$i][$PASSWORD_INDEX];
          $flyers[$i] = $flyer;
          $done = true;
        }
        else
          $i++;
      }

      writeFlyerFile($FLYER_FILE, $flyers);
      return $flyer;
    }
    
    catch (Exception $e)
    {
      echo "Exception: " . $e->getMessage() . " occurred in " . $e->getFile() . " at line " . $e->getLine() . "." ; 
      return false;
    }
  }
  
  /* testing
  $flyer = getFlyerInfo("goodm@lanecc.edu");
  if ($flyer === false)
  {
    echo "oops!";
  }
  else
    echo $flyer[0];
  
  
  writeNewFlyer("test@testing.com", "testing");
  
  $flyer = array(2, "", "", "minnie", "mouse", "alksdjf", "asdf", "adf", "asdf", "asdf");
  writeExistingFlyer($flyer);
  
  echo getFlyerMileageById(1);
  
  */
  

  
?>