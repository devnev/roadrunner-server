<?php
/**
 * @var Goridge\RelayInterface $relay
 */

use Spiral\Goridge;
use Spiral\RoadRunner;

require __DIR__ . "/vendor/autoload.php";

$relay = Goridge\Relay::create('tcp://127.0.0.1:9999');
$rr = new RoadRunner\Worker($relay);

while ($in = $rr->waitPayload()) {
    try {
        $rr->respond(new RoadRunner\Payload((string)$in->body));
    } catch (\Throwable $e) {
        $rr->error((string)$e);
    }
}
