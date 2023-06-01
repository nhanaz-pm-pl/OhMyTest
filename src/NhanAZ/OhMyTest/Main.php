<?php

declare(strict_types=1);

namespace NhanAZ\OhMyTest;

use pocketmine\block\Block;
use pocketmine\block\VanillaBlocks;
use pocketmine\event\block\BlockBreakEvent;
use pocketmine\event\block\BlockPlaceEvent;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerChatEvent;
use pocketmine\event\player\PlayerInteractEvent;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\event\player\PlayerMoveEvent;
use pocketmine\event\server\DataPacketReceiveEvent;
use pocketmine\item\enchantment\EnchantmentInstance;
use pocketmine\item\enchantment\VanillaEnchantments;
use pocketmine\nbt\tag\CompoundTag;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\SingletonTrait;

class Main extends PluginBase implements Listener {
	use SingletonTrait;

	protected function onEnable(): void {
		self::setInstance($this);
		$this->getServer()->getPluginManager()->registerEvents($this, $this);
		$this->getScheduler()->scheduleRepeatingTask(new TestTask($this), 20);
		libAZ::loadWorlds();
		libAZ::generateTerrain();
		libAZ::dumpPermissions();
		libAZ::dumpIdItem();
	}

	public function onJoin(PlayerJoinEvent $event): void {
	}

	public function onBreak(BlockBreakEvent $event): void {
	}

	public function onMove(PlayerMoveEvent $event) {
	}


	public function onPlace(BlockPlaceEvent $event): void {
		$blocks = $event->getTransaction()->getBlocks();
		foreach ($blocks as [$x, $y, $z, $block]) {
			if (!$block instanceof Block) return;
			// Play with block
		}
	}

	public function onInteract(PlayerInteractEvent $event): void {
	}

	public function onPacket(DataPacketReceiveEvent $event): void {
	}

	public function onChat(PlayerChatEvent $event): void {
		$player = $event->getPlayer();
		$msg = explode(" ", $event->getMessage());
		$commands = [
			"tp" => function ($player, $world) {
				$player->teleport($world->getSafeSpawn());
				$player->sendMessage("Đã dịch chuyển đến thế giới: " . $world->getName());
			},
			"nbt" => function ($player) {
				var_dump($player->getInventory()->getItemInHand()->getCustomBlockData()->getString("blockdata"));
			},
			"setnbt" => function ($player, $key, $value) {
				$nbt = new CompoundTag();
				$nbt->setString($key, $value);
				$item = $player->getInventory()->getItemInHand();
				$item->setCustomBlockData($nbt);
				$player->getInventory()->setItemInHand($item);
			},
			"egd" => function ($player) {
				$item = VanillaBlocks::OAK_LOG()->asItem();
				$item->addEnchantment(new EnchantmentInstance(VanillaEnchantments::UNBREAKING(), 3));
				$item->setCustomName("§cCustommm Names Nhân AZ");
				$item->setLore(["§bLoreeee"]);
				$item->setCount(30);
				$player->getInventory()->addItem($item);
			},
			"vd" => function ($player) {
				var_dump($player->getInventory()->getItemInHand()->jsonSerialize());
			},
			"ws" => function ($player) {
				$worlds = $this->getServer()->getWorldManager()->getWorlds();
				$out = [];
				foreach ($worlds as $world) {
					array_push($out, $world->getDisplayName());
				}
				$player->sendMessage(implode(", ", $out));
			},
		];
		if (isset($commands[$msg[0]])) {
			$commands[$msg[0]]($player, ...array_slice($msg, 1));
		}
	}
}
