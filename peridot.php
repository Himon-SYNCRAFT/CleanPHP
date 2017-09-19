<?php

use Evenement\EventEmitterInterface;
use Peridot\Plugin\Watcher\WatcherPlugin;
use Peridot\Plugin\Prophecy\ProphecyPlugin;
use Peridot\Plugin\Watcher\WatcherInterface;
use Peridot\Reporter\CodeCoverage\CodeCoverageReporter;
use Peridot\Reporter\CodeCoverageReporters;

return function(EventEmitterInterface $emitter) {
	$coverage = new CodeCoverageReporters($emitter);
	$coverage->register();

	$emitter->on('code-coverage.start', function(CodeCoverageReporter $reporter) {
		$reporter->addDirectoryToWhiteList(__DIR__ . '/src');
	});

    $watcher = new WatcherPlugin($emitter);
	$watcher->setEvents([WatcherInterface::ALL_EVENT]);
	$watcher->track(__DIR__ . '/src');

	new ProphecyPlugin($emitter);
};
