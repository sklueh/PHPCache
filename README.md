# PHPCache
A simple class for file-based caching

**Example:**
```php
$oCache = new PHPCache();

//clear cache manually
//$oCache->clear('my_cache');

//to clear whole cache directory.
//$oCache->clear();

//data will be cached for 30 seconds. Second parameter is optional.
$mData = $oCache->get('my_cache', 30);

if(!$mData)
{
    //get your data from database, function or something else
    $mData = array(1 => date('Y-m-d H:i:s', time()),
		           2 => 'Wert 1',
		           3 => 'Blaaa');
	
    //save data in the cache;
    $oCache->set('my_cache', $mData);
}
	
//view cached data
var_dump($mData);
```

For more information visit the following link:

http://sklueh.de/
