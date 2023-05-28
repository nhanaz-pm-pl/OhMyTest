<?php

declare(strict_types=1);

namespace NhanAZ\OhMyTest;

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
use pocketmine\world\World;
use libpmquery\PMQuery;
use libpmquery\PmQueryException;
use raklib\server\Server;

class Main extends PluginBase implements Listener {

	protected function onEnable(): void {
		$this->getServer()->getPluginManager()->registerEvents($this, $this);
		$this->getScheduler()->scheduleRepeatingTask(new TestTask($this), 20);
		libAZ::loadWorlds();
		libAZ::generateTerrain();
	}

	public function onJoin(PlayerJoinEvent $event): void {
	}

	public function onBreak(BlockBreakEvent $event): void {
	}

	public function onMove(PlayerMoveEvent $event) {
	}


	public function onPlace(BlockPlaceEvent $event): void {
	}

	public function onInteract(PlayerInteractEvent $event): void {
	}

	public function onPacket(DataPacketReceiveEvent $event): void {
	}

	public function onChat(PlayerChatEvent $event): void {
		$player = $event->getPlayer();
		$world = $player->getWorld();
		$msg = explode(" ", $event->getMessage());
		if ($msg[0] == "tp") {
			// $world = $this->getServer()->getWorldManager()->getWorldByName($msg[1]);
			$world = $this->getServer()->getWorldManager()->getWorldByName("Dream Archipelago");
			if ($world instanceof World) {
				$player->teleport($world->getSafeSpawn());
				// $player->sendMessage("Đã dịch chuyển đến thế giới: " . $msg[1]);
			}
		}
		if ($msg[0] == "nbt") {
			var_dump($player->getInventory()->getItemInHand()->getCustomBlockData()->getString("blockdata"));
		}

		if ($msg[0] == "setnbt") {
			$nbt = new CompoundTag();
			$nbt->setString(strval($msg[1]), strval($msg[2]));
			$item = $player->getInventory()->getItemInHand();
			$item->setCustomBlockData($nbt);
			$player->getInventory()->setItemInHand($item);
		}

		if ($msg[0] == "egd") {
			$item = VanillaBlocks::OAK_LOG()->asItem();
			$item->addEnchantment(new EnchantmentInstance(VanillaEnchantments::UNBREAKING(), 3));
			$item->setCustomName("§cCustommm Names Nhân AZ");
			$item->setLore(["§bLoreeee"]);
			$item->setCount(30);
			$player->getInventory()->addItem($item);
		}

		if ($msg[0] == "vd") {
			var_dump($player->getInventory()->getItemInHand()->jsonSerialize());
		}

		if ($msg[0] == "ws") {
			$worlds = $this->getServer()->getWorldManager()->getWorlds();
			$out = [];
			foreach ($worlds as $world) {
				array_push($out, $world->getDisplayName());
			}
			$player->sendMessage(implode(", ", $out));
		}
	}
}