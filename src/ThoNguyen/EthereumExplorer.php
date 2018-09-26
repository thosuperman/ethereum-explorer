<?php

namespace ThoNguyen;

class EthereumExplorer extends JsonRpc
{
    /**
     * @param $method
     * @param array $params
     * @return mixed
     * @throws RPCException
     */
    private function ether_request($method, $params = array())
    {
        try {
            $ret = $this->request($method, $params);
            return $ret->result;
        } catch (RPCException $e) {
            throw $e;
        }
    }

    /**
     * @param $input
     * @return bool|float|int|string
     */
    private function decode_hex($input)
    {
        if (substr($input, 0, 2) == '0x')
            $input = substr($input, 2);

        if (preg_match('/[a-f0-9]+/', $input))
            return hexdec($input);

        return $input;
    }

    /**
     * @return mixed
     * @throws RPCException
     */
    function web3_clientVersion()
    {
        return $this->ether_request(__FUNCTION__);
    }

    /**
     * @param $input
     * @return mixed
     * @throws RPCException
     */
    function web3_sha3($input)
    {
        return $this->ether_request(__FUNCTION__, array($input));
    }

    /**
     * @return mixed
     * @throws RPCException
     */
    function net_version()
    {
        return $this->ether_request(__FUNCTION__);
    }

    /**
     * @return mixed
     * @throws RPCException
     */
    function net_listening()
    {
        return $this->ether_request(__FUNCTION__);
    }

    /**
     * @return mixed
     * @throws RPCException
     */
    function net_peerCount()
    {
        return $this->ether_request(__FUNCTION__);
    }

    /**
     * @return mixed
     * @throws RPCException
     */
    function eth_protocolVersion()
    {
        return $this->ether_request(__FUNCTION__);
    }

    /**
     * @return mixed
     * @throws RPCException
     */
    function eth_coinbase()
    {
        return $this->ether_request(__FUNCTION__);
    }

    /**
     * @return mixed
     * @throws RPCException
     */
    function eth_mining()
    {
        return $this->ether_request(__FUNCTION__);
    }

    /**
     * @return mixed
     * @throws RPCException
     */
    function eth_hashrate()
    {
        return $this->ether_request(__FUNCTION__);
    }

    /**
     * @return mixed
     * @throws RPCException
     */
    function eth_gasPrice()
    {
        return $this->ether_request(__FUNCTION__);
    }

    /**
     * @return mixed
     * @throws RPCException
     */
    function eth_accounts()
    {
        return $this->ether_request(__FUNCTION__);
    }

    /**
     * @param bool $decode_hex
     * @return bool|float|int|mixed|string
     * @throws RPCException
     */
    function eth_blockNumber($decode_hex = FALSE)
    {
        $block = $this->ether_request(__FUNCTION__);

        if ($decode_hex)
            $block = $this->decode_hex($block);

        return $block;
    }

    /**
     * @param $address
     * @param string $block
     * @param bool $decode_hex
     * @return bool|float|int|mixed|string
     * @throws RPCException
     */
    function eth_getBalance($address, $block = 'latest', $decode_hex = FALSE)
    {
        $balance = $this->ether_request(__FUNCTION__, array($address, $block));

        if ($decode_hex)
            $balance = $this->decode_hex($balance);

        return $balance;
    }

    /**
     * @param $address
     * @param $at
     * @param string $block
     * @return mixed
     * @throws RPCException
     */
    function eth_getStorageAt($address, $at, $block = 'latest')
    {
        return $this->ether_request(__FUNCTION__, array($address, $at, $block));
    }

    /**
     * @param $address
     * @param string $block
     * @param bool $decode_hex
     * @return bool|float|int|mixed|string
     * @throws RPCException
     */
    function eth_getTransactionCount($address, $block = 'latest', $decode_hex = FALSE)
    {
        $count = $this->ether_request(__FUNCTION__, array($address, $block));

        if ($decode_hex)
            $count = $this->decode_hex($count);

        return $count;
    }

    /**
     * @param $tx_hash
     * @return mixed
     * @throws RPCException
     */
    function eth_getBlockTransactionCountByHash($tx_hash)
    {
        return $this->ether_request(__FUNCTION__, array($tx_hash));
    }

    /**
     * @param string $tx
     * @return mixed
     * @throws RPCException
     */
    function eth_getBlockTransactionCountByNumber($tx = 'latest')
    {
        return $this->ether_request(__FUNCTION__, array($tx));
    }

    /**
     * @param $block_hash
     * @return mixed
     * @throws RPCException
     */
    function eth_getUncleCountByBlockHash($block_hash)
    {
        return $this->ether_request(__FUNCTION__, array($block_hash));
    }

    /**
     * @param string $block
     * @return mixed
     * @throws RPCException
     */
    function eth_getUncleCountByBlockNumber($block = 'latest')
    {
        return $this->ether_request(__FUNCTION__, array($block));
    }

    /**
     * @param $address
     * @param string $block
     * @return mixed
     * @throws RPCException
     */
    function eth_getCode($address, $block = 'latest')
    {
        return $this->ether_request(__FUNCTION__, array($address, $block));
    }

    /**
     * @param $address
     * @param $input
     * @return mixed
     * @throws RPCException
     */
    function eth_sign($address, $input)
    {
        return $this->ether_request(__FUNCTION__, array($address, $input));
    }

    /**
     * @param $transaction
     * @return mixed
     * @throws RPCException
     */
    function eth_sendTransaction($transaction)
    {
        if (!is_a($transaction, 'Ethereum_Transaction')) {
            throw new RPCException('Transaction object expected');
        } else {
            return $this->ether_request(__FUNCTION__, $transaction->toArray());
        }
    }

    /**
     * @param $message
     * @param $block
     * @return mixed
     * @throws RPCException
     */
    function eth_call($message, $block)
    {
        if (!is_a($message, 'Ethereum_Message')) {
            throw new RPCException('Message object expected');
        } else {
            return $this->ether_request(__FUNCTION__, $message->toArray());
        }
    }

    /**
     * @param $message
     * @param $block
     * @return mixed
     * @throws RPCException
     */
    function eth_estimateGas($message, $block)
    {
        if (!is_a($message, 'Ethereum_Message')) {
            throw new ErrorException('Message object expected');
        } else {
            return $this->ether_request(__FUNCTION__, $message->toArray());
        }
    }

    /**
     * @param $hash
     * @param bool $full_tx
     * @return mixed
     * @throws RPCException
     */
    function eth_getBlockByHash($hash, $full_tx = TRUE)
    {
        return $this->ether_request(__FUNCTION__, array($hash, $full_tx));
    }

    /**
     * @param string $block
     * @param bool $full_tx
     * @return mixed
     * @throws RPCException
     */
    function eth_getBlockByNumber($block = 'latest', $full_tx = TRUE)
    {
        return $this->ether_request(__FUNCTION__, array($block, $full_tx));
    }

    /**
     * @param $hash
     * @return mixed
     * @throws RPCException
     */
    function eth_getTransactionByHash($hash)
    {
        return $this->ether_request(__FUNCTION__, array($hash));
    }

    /**
     * @param $hash
     * @param $index
     * @return mixed
     * @throws RPCException
     */
    function eth_getTransactionByBlockHashAndIndex($hash, $index)
    {
        return $this->ether_request(__FUNCTION__, array($hash, $index));
    }

    /**
     * @param $block
     * @param $index
     * @return mixed
     * @throws RPCException
     */
    function eth_getTransactionByBlockNumberAndIndex($block, $index)
    {
        return $this->ether_request(__FUNCTION__, array($block, $index));
    }

    /**
     * @param $tx_hash
     * @return mixed
     * @throws RPCException
     */
    function eth_getTransactionReceipt($tx_hash)
    {
        return $this->ether_request(__FUNCTION__, array($tx_hash));
    }

    /**
     * @param $hash
     * @param $index
     * @return mixed
     * @throws RPCException
     */
    function eth_getUncleByBlockHashAndIndex($hash, $index)
    {
        return $this->ether_request(__FUNCTION__, array($hash, $index));
    }

    /**
     * @param $block
     * @param $index
     * @return mixed
     * @throws RPCException
     */
    function eth_getUncleByBlockNumberAndIndex($block, $index)
    {
        return $this->ether_request(__FUNCTION__, array($block, $index));
    }

    /**
     * @return mixed
     * @throws RPCException
     */
    function eth_getCompilers()
    {
        return $this->ether_request(__FUNCTION__);
    }

    function eth_compileSolidity($code)
    {
        return $this->ether_request(__FUNCTION__, array($code));
    }

    function eth_compileLLL($code)
    {
        return $this->ether_request(__FUNCTION__, array($code));
    }

    function eth_compileSerpent($code)
    {
        return $this->ether_request(__FUNCTION__, array($code));
    }

    function eth_newFilter($filter, $decode_hex = FALSE)
    {
        if (!is_a($filter, 'Ethereum_Filter')) {
            throw new ErrorException('Expected a Filter object');
        } else {
            $id = $this->ether_request(__FUNCTION__, $filter->toArray());

            if ($decode_hex)
                $id = $this->decode_hex($id);

            return $id;
        }
    }

    function eth_newBlockFilter($decode_hex = FALSE)
    {
        $id = $this->ether_request(__FUNCTION__);

        if ($decode_hex)
            $id = $this->decode_hex($id);

        return $id;
    }

    function eth_newPendingTransactionFilter($decode_hex = FALSE)
    {
        $id = $this->ether_request(__FUNCTION__);

        if ($decode_hex)
            $id = $this->decode_hex($id);

        return $id;
    }

    function eth_uninstallFilter($id)
    {
        return $this->ether_request(__FUNCTION__, array($id));
    }

    function eth_getFilterChanges($id)
    {
        return $this->ether_request(__FUNCTION__, array($id));
    }

    function eth_getFilterLogs($id)
    {
        return $this->ether_request(__FUNCTION__, array($id));
    }

    function eth_getLogs($filter)
    {
        if (!is_a($filter, 'Ethereum_Filter')) {
            throw new ErrorException('Expected a Filter object');
        } else {
            return $this->ether_request(__FUNCTION__, $filter->toArray());
        }
    }

    function eth_getWork()
    {
        return $this->ether_request(__FUNCTION__);
    }

    function eth_submitWork($nonce, $pow_hash, $mix_digest)
    {
        return $this->ether_request(__FUNCTION__, array($nonce, $pow_hash, $mix_digest));
    }

    function db_putString($db, $key, $value)
    {
        return $this->ether_request(__FUNCTION__, array($db, $key, $value));
    }

    function db_getString($db, $key)
    {
        return $this->ether_request(__FUNCTION__, array($db, $key));
    }

    function db_putHex($db, $key, $value)
    {
        return $this->ether_request(__FUNCTION__, array($db, $key, $value));
    }

    function db_getHex($db, $key)
    {
        return $this->ether_request(__FUNCTION__, array($db, $key));
    }

    function shh_version()
    {
        return $this->ether_request(__FUNCTION__);
    }

    function shh_post($post)
    {
        if (!is_a($post, 'Whisper_Post')) {
            throw new ErrorException('Expected a Whisper post');
        } else {
            return $this->ether_request(__FUNCTION__, $post->toArray());
        }
    }

    function shh_newIdentinty()
    {
        return $this->ether_request(__FUNCTION__);
    }

    function shh_hasIdentity($id)
    {
        return $this->ether_request(__FUNCTION__);
    }

    function shh_newFilter($to = NULL, $topics = array())
    {
        return $this->ether_request(__FUNCTION__, array(array('to' => $to, 'topics' => $topics)));
    }

    function shh_uninstallFilter($id)
    {
        return $this->ether_request(__FUNCTION__, array($id));
    }

    function shh_getFilterChanges($id)
    {
        return $this->ether_request(__FUNCTION__, array($id));
    }

    function shh_getMessages($id)
    {
        return $this->ether_request(__FUNCTION__, array($id));
    }
}

/**
 *    Ethereum transaction object
 */
class Ethereum_Transaction
{
    private $to, $from, $gas, $gasPrice, $value, $data, $nonce;

    /**
     * Ethereum_Transaction constructor.
     * @param $from
     * @param $to
     * @param $gas
     * @param $gasPrice
     * @param $value
     * @param string $data
     * @param null $nonce
     */
    function __construct($from, $to, $gas, $gasPrice, $value, $data = '', $nonce = NULL)
    {
        $this->from = $from;
        $this->to = $to;
        $this->gas = $gas;
        $this->gasPrice = $gasPrice;
        $this->value = $value;
        $this->data = $data;
        $this->nonce = $nonce;
    }

    /**
     * @return array
     */
    function toArray()
    {
        return array(
            array
            (
                'from' => $this->from,
                'to' => $this->to,
                'gas' => $this->gas,
                'gasPrice' => $this->gasPrice,
                'value' => $this->value,
                'data' => $this->data,
                'nonce' => $this->nonce
            )
        );
    }
}

/**
 *    Ethereum message -- Same as a transaction, except using this won't
 *  post the transaction to the blockchain.
 */
class Ethereum_Message extends Ethereum_Transaction
{
}

/**
 *    Ethereum transaction filter object
 */
class Ethereum_Filter
{
    private $fromBlock, $toBlock, $address, $topics;

    function __construct($fromBlock, $toBlock, $address, $topics)
    {
        $this->fromBlock = $fromBlock;
        $this->toBlock = $toBlock;
        $this->address = $address;
        $this->topics = $topics;
    }

    function toArray()
    {
        return array(
            array
            (
                'fromBlock' => $this->fromBlock,
                'toBlock' => $this->toBlock,
                'address' => $this->address,
                'topics' => $this->topics
            )
        );
    }
}

/**
 *    Ethereum whisper post object
 */
class Whisper_Post
{
    private $from, $to, $topics, $payload, $priority, $ttl;

    function __construct($from, $to, $topics, $payload, $priority, $ttl)
    {
        $this->from = $from;
        $this->to = $to;
        $this->topics = $topics;
        $this->payload = $payload;
        $this->priority = $priority;
        $this->ttl = $ttl;
    }

    function toArray()
    {
        return array(
            array
            (
                'from' => $this->from,
                'to' => $this->to,
                'topics' => $this->topics,
                'payload' => $this->payload,
                'priority' => $this->priority,
                'ttl' => $this->ttl
            )
        );
    }
}
