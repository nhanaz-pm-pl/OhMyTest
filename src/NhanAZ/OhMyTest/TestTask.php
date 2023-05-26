<?php

declare(strict_types=1);

namespace NhanAZ\OhMyTest;

use pocketmine\plugin\PluginBase;
use pocketmine\scheduler\Task;

class TestTask extends Task {

	public function __construct(private PluginBase $plugin) {
	}

	public function onRun(): void {
	}
}