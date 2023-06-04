<?php

declare(strict_types=1);

namespace NhanAZ\OhMyTest;

use pocketmine\plugin\PluginBase;
use pocketmine\scheduler\Task;
use pocketmine\Server;

class TestTask extends Task {

	public function __construct(private PluginBase $plugin) {
	}

	public function onRun(): void {
		$server = Server::getInstance();
		$tick = $this->getHandler()->getNextRun();
		$server->broadcastMessage("[OhMyTest] I've run on tick " . $tick);
		if ($tick > 120) {
			$server->broadcastMessage("[OhMyTest] Task canceled");
			$this->getHandler()->cancel();
		}
	}
}
