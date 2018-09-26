<?php

require __DIR__ . '/../vendor/autoload.php';

use ThoNguyen\EthereumExplorer;

$ep = new EthereumExplorer('127.0.0.1', '8545');

try {
    echo $ep->web3_clientVersion() . PHP_EOL;
} catch (Exception $exception) {
    echo $exception->getMessage() . PHP_EOL;
}

