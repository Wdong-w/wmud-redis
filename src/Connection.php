<?php

namespace Wmud\Redis;

use Redis;
use RedisException;

class Connection
{
    /**
     * @param array $config
     * @return Redis
     * @throws RedisException
     */
    public function connect(array $config = []): Redis
    {
        $host = $config['host'] ?? '127.0.0.1';
        $port = (int)($config['port'] ?? 6379);
        $db = (int)($config['db'] ?? 0);
        $auth = $config['auth'] ?? null;
        $timeout = $config['timeout'] ?? 0.0;
        $redis = new Redis();
        if (!$redis->connect($host, $port, $timeout)) {
            throw new RedisException('Redis connection failed.');
        }
        if ($auth) {
            $redis->auth($auth);
        }
        if ($db) {
            $redis->select($db);
        }
        return $redis;
    }
}