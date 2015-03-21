<?php

/*
 * PHPCache
 * 
 * @autor Sebastian Klüh (http://sklueh.de)
 * @license LGPL
 *
 * Example:
 * 
 * $oCache = new PHPCache();
 * 
 * //to clear cache manually.
 * //$oCache->clear('my_cache');
 * 
 * //to clear whole cache directory
 * //$oCache->clear();
 * 
 * //data will be cached for 30 seconds. Second parameter is optional.
 * $mData = $oCache->get('my_cache', 30); 
 * 
 * if(!$mData) 
 * {
 * 	$mData = array(1 => date('Y-m-d H:i:s', time()), 
 * 			       2 => 'Wert 1', 
 * 			       3 => 'Blaaa');
 * 	
 * 	//save data to cache";
 * 	$oCache->set('my_cache', $mData);
 * }
 * 
 * //get cached data
 * var_dump($mData);
 */
class PHPCache 
{   
  private $sDirectory = "cache";
  private $sExtension = "cache";
  private $iExpiration = 900; /* 15 minutes */	
    
  public function PHPCache($sDirectory = "", $iExpiration = "", $sExtension = "")  
  {  
	if(!empty($sDirectory))
	$this->sDirectory = $sDirectory;
		
	if(!file_exists($this->sDirectory))
	mkdir($this->sDirectory, 0777, true);
	
	if(!empty($iExpiration))
	$this->iExpiration = intval($iExpiration);

	if(!empty($sExtension))
	$this->sExtension = $sExtension;
  }
    
  public function set($sKey, $mData)
  {
	  $sCachePath = $this->getPath($sKey);
	  if(file_exists($this->sDirectory))
	  {
		  $rCacheFile = fopen($sCachePath, 'wb');
		  fwrite($rCacheFile, serialize($mData));
		  fclose($rCacheFile);		     
		  @chmod($sCachePath, 0777);
		  return true;
	  }
	  return false;
  }
      
  public function get($sKey, $iExpiration = "")
  {   
	$mCache = false;	    
	            
	if(file_exists($sCachePath = $this->getPath($sKey)))  
	{
		if(filemtime($sCachePath) < (time() - (empty($iExpiration) ? $this->iExpiration : $iExpiration)))
		return !$this->clear($sKey);
		
		$rCacheFile = @fopen($sCachePath, 'r');
		$mCache = unserialize(fread($rCacheFile, filesize($sCachePath)));        	       	
		fclose($rCacheFile);
	}
	
	return $mCache;
  }  
 
  public function clear($sKey = "")  
  {
	if(empty($sKey))
	{
		foreach(glob($this->sDirectory.'/*.'.$this->sExtension) as $sFile)		
		unlink($sFile);
	}   
	else if(file_exists($sCachePath = $this->getPath($sKey)))
	unlink($sCachePath);
	return true;
  }
	
  private function getPath($sKey)
  {
	return $this->sDirectory."/".sha1($sKey).".".$this->sExtension;
  }
}  
