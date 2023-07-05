<?php

declare(strict_types=1);

namespace NhanAZ\OhMyTest;

use pocketmine\event\Listener;
use pocketmine\event\player\PlayerJoinEvent;

class EventListener implements Listener {

	public function onJoin(PlayerJoinEvent $event): void {
		$player = $event->getPlayer();
		$item = Main::getInstance()->customItem();
		$player->getInventory()->setItemInHand($item);
		var_dump($player->getInventory()->getItemInHand()->getCustomBlockData());
	}
}
