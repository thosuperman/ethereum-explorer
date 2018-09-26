<?php

namespace ThoNguyen;

use Exception;

class EthereumExplorer
{
    private $lastRequest;
    private $ch;

    /**
     * EtherBlockApi constructor.
     * @param string $url
     */
    public function __construct(string $url)
    {
        $this->ch = curl_init();
        curl_setopt($this->ch, CURLOPT_URL, $url);
        curl_setopt($this->ch, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($this->ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($this->ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($this->ch, CURLOPT_SSL_VERIFYHOST, 0);
    }

    /**
     * @param int $seconds
     */
    public function setRequestTimeout(int $seconds)
    {
        curl_setopt($this->ch, CURLOPT_TIMEOUT, $seconds);
    }

    /**
     * @param array $addressList
     * @param int $startBlock
     * @param int $endBlock
     * @param int|null $requestId
     * @return string
     */
    public function getTransactions(array $addressList, int $startBlock = 0, int $endBlock = 0, int $requestId
    = null): string
    {
        return $this->doRequest([
            'method' => 'ico_accountsStatement',
            'params' => [
                [
                    'accounts' => $addressList,
                    'start_block' => $startBlock,
                    'end_block' => $endBlock,
                ]
            ],
        ], $requestId);
    }

    /**
     * @param int|null $requestId
     * @return string
     */
    public function checkStatus(int $requestId = null): string
    {
        return $this->doRequest([
            'method' => 'eth_syncing',
            'params' => [],
        ], $requestId);
    }

    /**
     * @return string
     */
    public function getLastRequest()
    {
        return $this->lastRequest;
    }

    /**
     * @param array $data
     * @param int|null $requestId
     * @return string
     * @throws Exception
     */
    private function doRequest(array $data, int $requestId = 1): string
    {
        $data['jsonrpc'] = '2.0';
        $data['id'] = $requestId;
        $this->lastRequest = json_encode($data);
        curl_setopt($this->ch, CURLOPT_POSTFIELDS, $this->lastRequest);
        $result = curl_exec($this->ch);

        if ($result === false) {
            throw new Exception('Curl error: ' . curl_error($this->ch));
        }

        return $result;
    }

    public function __destruct()
    {
        curl_close($this->ch);
    }
}
