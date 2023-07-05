<?php

declare(strict_types=1);

namespace NhanAZ\OhMyTest;

use pocketmine\item\Item;
use pocketmine\item\VanillaItems;
use pocketmine\nbt\tag\CompoundTag;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\SingletonTrait;

class Main extends PluginBase {
	use SingletonTrait;

	protected function onEnable(): void {
		self::setInstance($this);
		$this->getServer()->getPluginManager()->registerEvents(new EventListener(), $this);
	}

	public static function customItem(): Item {
		$item = VanillaItems::APPLE();
		$cbd = new CompoundTag();
		$cbd->setString("id", "id-value");
		$item->setCustomBlockData($cbd);
		return $item;
	}
}
