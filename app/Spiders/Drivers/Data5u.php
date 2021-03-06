<?php

namespace App\Spiders\Drivers;

use App\Models\Proxy;
use App\Spiders\Spider;

class Data5u extends Spider
{
    public function handle()
    {
        $this->sleep = rand(3, 5);
        $urls = [
            "http://www.data5u.com/free/index.shtml",
            "http://www.data5u.com/free/gngn/index.shtml",
            "http://www.data5u.com/free/gnpt/index.shtml",
            "http://www.data5u.com/free/gwgn/index.shtml",
            "http://www.data5u.com/free/gwpt/index.shtml"
        ];

        $this->queryListProcess($urls, "ul.l2", function ($tr) {
            $ip = $tr->find('li:eq(0)')->text();
            $port = $tr->find('li:eq(1)')->text();
            $temp = $tr->find('li:eq(2)')->text();
            if (strpos($temp, '高匿') !== false) {
                $anonymity = Proxy::ANONYMITY_HIGH_ANONYMOUS;
            } elseif (strpos($temp, '透明') !== false) {
                $anonymity = Proxy::ANONYMITY_TRANSPARENT;
            } else {
                $anonymity = Proxy::ANONYMITY_ANONYMOUS;
            }
            $protocol = $tr->find('li:eq(3)')->text();
            return [$ip, $port, $anonymity, $protocol];
        });
    }
}