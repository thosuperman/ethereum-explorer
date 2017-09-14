<?php

require __DIR__ . '/../vendor/autoload.php';

use EthereumExplorer\EthereumExplorer;

$ep = new EthereumExplorer('url_of_service');

try {
    echo $ep->checkStatus() . PHP_EOL;
} catch (Exception $exception) {
    echo $exception->getMessage() . PHP_EOL;
}
echo $ep->getLastRequest();
