<?php
$urls = [
    'http://www.example.com/',
    'http://www.example.com',
    'http://www.example.com/test/.jpg',
    'http://www.example.com/test/.',
    'https://anonymous:dCU7egW1A1L0a6pxU3qu9@www.example.com:8080/path/to/directory/file.jpeg?param1=foo&param2=bar&param3[1]=abc&param3[2]=def#anchor',
    'ftp://anonymous@ftp.example.com/pub/test.jpg',
    'file:///home/user/.config/test.config',
    'chrome://settings/passwords',
    'postgres://user:password@localhost:5000/db'
];

foreach ($urls as $url) {
    echo $url, PHP_EOL;
    var_export(parse_url($url));
    echo PHP_EOL, PHP_EOL;
}