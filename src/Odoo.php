<?php

namespace Refact\Odoo;

class Odoo
{
    /**
     * @var string
     */
    private $url;
    /**
     * @var array
     */
    private $auth;

    public function __construct(string $url, array $auth)
    {
        $this->url = $url;
        $this->auth = $auth;
    }

    public function getUrl(): string
    {
        return $this->url;
    }

    private function request(string $service, string $method, array $args)
    {
        $out = file_get_contents($this->url . '/jsonrpc', false, stream_context_create([
            'http' => [
                'header' => "Content-type: application/json\r\n",
                'content' => json_encode([
                    'jsonrpc' => '2.0',
                    'method' => 'call',
                    'params' => [
                        'service' => $service,
                        'method' => $method,
                        'args' => $args,
                    ],
                    'id' => rand(0, 1000000000),
                ]),
            ],
        ]));

        return json_decode($out, true)['result'];
    }

    public function auth(string $user, string $password)
    {
        return $this->request('common', 'login', [$this->auth[0], $user, $password]);
    }

    public function rpc(string $service, string $method, array $args)
    {
        return $this->request($service, $method, array_merge($this->auth, $args));
    }
}
