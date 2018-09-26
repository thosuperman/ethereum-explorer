<?php

namespace ThoNguyen;

use Exception;

class JsonRpc
{
    protected $host, $port, $version;
    protected $id = 0;

    /**
     * JsonRpc constructor.
     * @param $host
     * @param $port
     * @param string $version
     */
    function __construct($host, $port, $version = "2.0")
    {
        $this->host = $host;
        $this->port = $port;
        $this->version = $version;
    }

    /**
     * @param $method
     * @param array $params
     * @return mixed
     * @throws RPCException
     */
    function request($method, $params = array())
    {
        $data = array();
        $data['jsonrpc'] = $this->version;
        $data['id'] = $this->id++;
        $data['method'] = $method;
        $data['params'] = $params;

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $this->host);
        curl_setopt($ch, CURLOPT_PORT, $this->port);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
        curl_setopt($ch, CURLOPT_POST, TRUE);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

        $ret = curl_exec($ch);

        if ($ret !== FALSE) {
            $formatted = $this->format_response($ret);

            if (isset($formatted->error)) {
                throw new RPCException($formatted->error->message, $formatted->error->code);
            } else {
                return $formatted;
            }
        } else {
            throw new RPCException("Server did not respond");
        }
    }

    /**
     * @param $response
     * @return mixed
     */
    function format_response($response)
    {
        return @json_decode($response);
    }
}

/**
 * Class RPCException
 * @package ThoNguyen
 */
class RPCException extends Exception
{
    public function __construct($message, $code = 0, Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

    public function __toString()
    {
        return __CLASS__ . ": " . (($this->code > 0) ? "[{$this->code}]:" : "") . " {$this->message}\n";
    }
}
