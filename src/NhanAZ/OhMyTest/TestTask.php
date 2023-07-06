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
			$packet = SpawnParticleEffectPacket::create(DimensionIds::OVERWORLD, -1, $nhanaz->getPosition()->add(0.5, 0, 0.5), "minecraft:crop_growth_area_emitter", null);
			NetworkBroadcastUtils::broadcastPackets($players, [$packet]);
		}
	}
}
