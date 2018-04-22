<?php

class NewsModel
{
    public $id;
    public $srcUrlHash;
    public $srcUrl;
    public $created;
    public $title;
    public $img;
    public $text;
    public $description;

    public function __construct($data)
    {
        foreach ($data as $key => $value) {
            $this->$key = $value;
        }

        $this->srcUrlHash = crc32($this->srcUrl);
    }
}