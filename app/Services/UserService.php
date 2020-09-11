<?php

declare(strict_types=1);

namespace App\Services;

use Hyperf\Di\Annotation\Inject;
use Hyperf\Redis\Redis;

class UserService
{
    /**
     * @Inject()
     * @var Redis
     */
    private $redis;

    public function __construct()
    {
        $this->redis->set('user:1', 'hello cache');
    }

    /**
     * @author  shiwen <wshi@suntekcorps.com>
     */
    public function get()
    {
        return $this->redis->get('user:1');
    }
}
