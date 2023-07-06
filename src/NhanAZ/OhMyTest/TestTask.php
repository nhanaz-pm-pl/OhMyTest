<?php

declare(strict_types=1);

namespace NhanAZ\OhMyTest;

use pocketmine\network\mcpe\NetworkBroadcastUtils;
use pocketmine\network\mcpe\protocol\SpawnParticleEffectPacket;
use pocketmine\network\mcpe\protocol\types\DimensionIds;
use pocketmine\plugin\PluginBase;
use pocketmine\scheduler\Task;
use pocketmine\Server;

class TestTask extends Task {

	public function __construct(private PluginBase $plugin) {
	}

	public function onRun(): void {
		$server = Server::getInstance();
		$players = $server->getOnlinePlayers();
		$nhanaz = $server->getPlayerExact("NhanAZ");
		if ($nhanaz !== null) {
			for ($i = 0; $i <= 30; $i++) {
				$x = SpawnParticleEffectPacket::create(DimensionIds::OVERWORLD, -1, $nhanaz->getPosition()->add(rand(05, 5), rand(-5, 5), rand(-5, 5)), "minecraft:cherry_leaves_particle", null);
				$y = SpawnParticleEffectPacket::create(DimensionIds::OVERWORLD, -1, $nhanaz->getPosition()->add(rand(-5, 5), rand(-5, 5), rand(-5, 5)), "minecraft:cherry_leaves_particle", null);
				$z = SpawnParticleEffectPacket::create(DimensionIds::OVERWORLD, -1, $nhanaz->getPosition()->add(rand(-5, 5), rand(-5, 5), rand(-5, 5)), "cminecraft:herry_leaves_particle", null);
				NetworkBroadcastUtils::broadcastPackets($players, [$x, $y, $z]);
			}
		}
	}
}
