<?php
require_once __DIR__ . '/../../vendor/autoload.php'; // Autoload files using Composer autoload

use EthereumExplorer\EthereumExplorer;
use PHPUnit\Framework\TestCase;

class EthereumExplorerTest extends TestCase
{

    private $url = '18.221.22.28:8545';


    public function testGetTransactions(){

        $eteriumExplorer = new EthereumExplorer($this->url);

        $addreses = ['0xf2b3f8eb4e663da275b8c57fe45a0e8d489eac2e'];
        $result = $eteriumExplorer->getTransactions($addreses);
        $this->assertJson($result);
        $decodedResult = json_decode($result, true);
        $this->assertArrayHasKey('id', $decodedResult);
        $this->assertArrayHasKey('jsonrpc', $decodedResult);
        $this->assertArrayHasKey('result', $decodedResult);

        $this->assertTrue(is_array($decodedResult['result']));
        $this->assertArrayHasKey('0xf2b3f8eb4e663da275b8c57fe45a0e8d489eac2e', $decodedResult['result']);
        $this->assertTrue(is_array($decodedResult['result']['0xf2b3f8eb4e663da275b8c57fe45a0e8d489eac2e']));
    }

    public function testCheckStatus(){

        $eteriumExplorer = new EthereumExplorer($this->url);
        $requestId = 1;

        $this->assertInternalType('int', $requestId);
        $result = $eteriumExplorer->checkStatus($requestId);
        $this->assertJson($result);
        $decodedResult = json_decode($result, true);

        $this->assertArrayHasKey('id', $decodedResult);
        $this->assertArrayHasKey('jsonrpc', $decodedResult);
        $this->assertArrayHasKey('result', $decodedResult);

        $this->assertTrue(is_array($decodedResult['result']));
    }
}