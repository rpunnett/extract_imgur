extract_imgur
=========

extract_imgur is php class to pull out the actual image URL's from imgur links. It is based the the JS project '[impurge]'.


Usage
----
```php
use  punnettr\ImageHost\Imgur;

$url = 'http://imgur.com/4Bpn7iO'

#Checks if the link is from inmgur, returns true false : TRUE
Imgur::valid($url); 

#Returns the ID of the image : 4Bpn7iO
Imgur::getId($url); 

#Returns the TYPE of the link -> Album, Gallery, Hash, Image : Image
Imgur::getType($url); 

#Returns an array of URLs based on requested type
Type Options:
* original
* imgur_page
* small_square
* large_thumbnail

Imgur::getImage($url,'original');
/*
url		[3]
0   :   http://i.imgur.com/x3Opkpv.jpg
1   :   http://i.imgur.com/oXLVTyT.jpg
2   :	http://i.imgur.com/1cbsAEZ.jpg
---
url [1]
0   :	http://imgur.com/4Bpn7iO
*/
```

Version
----

0.65

Requirements
-----------

extract_imgur has the following requirements:

* [cURL] - Reads interwebs
* [PHP] - Version 5.*


Preferred Installation
--------------

Use packagist.
https://packagist.org/packages/rpunnett/extract_imgur


Normal Installation
--------------
Copy to a project directory and include the namespace 'punnettr\ImageHost\Imgur'

```sh
git clone https://github.com/rpunnett/extract_imgur.git extract_imgur
cd extract_imgur
cp punnettr <include path>
```


License
----

MIT



[robert punnett]:https://github.com/rpunnett
[cURL]:http://curl.haxx.se/
[PHP]:http://php.net/
[impurge]:https://github.com/hortinstein/impurge
