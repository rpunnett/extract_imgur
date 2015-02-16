<?php

namespace spec\Imgur;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ImgurSpec extends ObjectBehavior
{

    private $imgurImage = 'http://imgur.com/4Bpn7iO';
    private $imgurAlbum = 'https://imgur.com/a/PBvK0';
    private $imgurGallery = 'https://imgur.com/gallery/PZglF';
    private $badLink = 'http://www.youtube.com/imgur/3846';

    /**
    * Creates
    **/
    function it_is_initializable()
    {
        $this->shouldHaveType('Imgur\Imgur');
    }
	
    /**
    * Imgur Link Validation
    **/

	function it_returns_true_for_imgur_link()
    {
        $this->valid($this->imgurImage)->shouldReturn(true);
    }
	
	function it_returns_false_for_nonimgur_link()
    {
        $this->valid($this->badLink)->shouldReturn(false);
    }

    /**
    * Imgur Type Validation
    **/
    function it_returns_image_for_image_type()
    {
        $this->getType($this->imgurImage)->shouldReturn('image');
    }

    function it_returns_album_for_image_type()
    {
        $this->getType($this->imgurAlbum)->shouldReturn('album');
    }

    function it_returns_gallery_for_image_type()
    {
        $this->getType($this->imgurGallery)->shouldReturn('album');
    }

    function it_returns_false_for_image_type()
    {
        $this->getType($this->badLink)->shouldReturn(false);
    }


    /**
    * Imgur ID Validation
    **/
    function it_returns_4Bpn7iO_for_image_id()
    {
        $this->getID($this->imgurImage)->shouldReturn('4Bpn7iO');
    }

  
    function it_returns_false_for_image_id()
    {
        $this->getID($this->badLink)->shouldReturn(false);
    }
    


    /**
    * Imgur Get Image(s)
    **/
    function it_returns_single_array_for_image_array()
    {
        $this->getImage($this->imgurImage)->shouldHaveCount(1);
    }

    function it_returns_multiple_array_for_image_array()
    {
        $this->getImage($this->imgurGallery)->shouldHaveCount(20);
    }

    function it_returns_false_for_image_array()
    {
        $this->getImage($this->badLink)->shouldReturn(false);
    }

}
