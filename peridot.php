<?php

use Evenement\EventEmitterInterface;
use Peridot\Plugin\Watcher\WatcherPlugin;
use Peridot\Plugin\Prophecy\ProphecyPlugin;
use Peridot\Plugin\Watcher\WatcherInterface;

return function(EventEmitterInterface $emitter) {
    $watcher = new WatcherPlugin($emitter);
	$watcher->setEvents([WatcherInterface::ALL_EVENT]);
	$watcher->track(__DIR__ . '/src');

	new ProphecyPlugin($emitter);
};
