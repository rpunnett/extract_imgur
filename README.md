extract_imgur
=========

extract_imgur is php class to pull out the actual image URL's from imgur links. It is based the the JS project '[impurge]'.


Usage
----
Example URL: http://imgur.com/4Bpn7iO
```php

#Checks if the link is from inmgur, returns true false : TRUE
Imgur::valid($url); 

#Returns the ID of the image : 4Bpn7iO
Imgur::getId($url); 

#Returns the TYPE of the link -> Album, Gallery, Hash, Image
Imgur::getType($url); 

#Returns either the image URL, or an array of URLS depending on TYPE
Imgur::getImage($url,'original');
/*
url		[3]
0   :   http://i.imgur.com/x3Opkpv.jpg
1   :   http://i.imgur.com/oXLVTyT.jpg
2   :	http://i.imgur.com/1cbsAEZ.jpg
---
url :	http://imgur.com/4Bpn7iO
*/
```

Version
----

0.25

Requirements
-----------

extract_imgur has the following requirements:

* [Guzzle] - A PHP Client for consuming web services
* [cURL] - Reads interwebs
* [PHP] - Version 5.*


Preferred Installation
--------------

Use packagist.
https://packagist.org/packages/rpunnett/extract_imgur


Normal Installation
--------------
Copy to a project directory and include the class.

```sh
git clone https://github.com/rpunnett/extract_imgur.git extract_imgur
cd extract_imgur
cp Imgur.php <include path>
```

To Do
----

* Remove most static classes
* Improve error handling
* Add callback capability 



License
----

MIT



[robert punnett]:https://github.com/rpunnett
[guzzle]:http://guzzle.readthedocs.org/en/latest/
[cURL]:http://curl.haxx.se/
[PHP]:http://php.net/
[impurge]:https://github.com/hortinstein/impurge
