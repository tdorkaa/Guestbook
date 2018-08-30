<?php

use Dotenv\Dotenv;

$dotenvFile = 'test.env';
$dotenv = new Dotenv(__DIR__ . '/../config', $dotenvFile);
$dotenv->load();