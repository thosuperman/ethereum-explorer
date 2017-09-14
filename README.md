# etherscan

<p>This lib is created for connecting to EthereumExplorer api using php.</p>

<h2>USAGE</h2>
```
$ep = new EthereumExplorer('url_of_service');

try {
    echo $ep->checkStatus() . PHP_EOL;
} catch (Exception $exception) {
    echo $exception->getMessage() . PHP_EOL;
}
```
