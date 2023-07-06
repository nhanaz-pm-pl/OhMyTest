<?php

declare(strict_types=1);

namespace NhanAZ\OhMyTest;

use NhanAZ\libBedrock\tools\GenStringToIdMeta;
use pocketmine\block\Block;
use pocketmine\block\VanillaBlocks;
use pocketmine\event\block\BlockBreakEvent;
use pocketmine\event\block\BlockPlaceEvent;
use pocketmine\event\entity\EntityDamageByEntityEvent;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerChatEvent;
use pocketmine\event\player\PlayerInteractEvent;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\event\player\PlayerMoveEvent;
use pocketmine\event\server\DataPacketReceiveEvent;
use pocketmine\item\enchantment\EnchantmentInstance;
use pocketmine\item\enchantment\VanillaEnchantments;
use pocketmine\nbt\tag\CompoundTag;
use pocketmine\network\mcpe\NetworkBroadcastUtils;
use pocketmine\network\mcpe\protocol\LevelEventPacket;
use pocketmine\network\mcpe\protocol\types\LevelEvent;
use pocketmine\player\Player;
use pocketmine\plugin\PluginBase;
use pocketmine\Server;
use pocketmine\utils\SingletonTrait;
use pocketmine\world\World;

class Main extends PluginBase implements Listener {
	use SingletonTrait;

	protected function onEnable(): void {
		self::setInstance($this);
		$this->getServer()->getPluginManager()->registerEvents($this, $this);
		$this->getScheduler()->scheduleRepeatingTask(new TestTask($this), 20);
		WorldAZ::loadWorlds();
		WorldAZ::generateTerrain();

		DumpAZ::Glyph();
		DumpAZ::Permissions();
		# DumpAZ::IdItem();
	}

	/**
	 * @handleCancelled TRUE
	 */
	public function onDamage(EntityDamageByEntityEvent $event): void {
		$entity = $event->getEntity();
		$damager = $event->getDamager();
		if (
			$damager instanceof Player &&
			$entity instanceof Player &&
			$event->isCancelled()
		) {
			$damager->sendMessage("Mở Form");
		}
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
				$world = $this->getServer()->getWorldManager()->getWorldByName($world);
				if (!$world instanceof World) {
					$player->sendMessage($world . "is NULL!");
					return;
				}
				$player->teleport($world->getSafeSpawn());
				$player->sendMessage("Đã dịch chuyển đến thế giới: " . $world->getDisplayName());
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
			"fly" => function (Player $player) {
				$player->setFlying(true);
				$player->setAllowFlight(true);
			},
			"pause" => function (Player $player) {
				$pk = LevelEventPacket::create(1, LevelEvent::PAUSE_GAME, $player->getPosition());
				NetworkBroadcastUtils::broadcastPackets($this->getServer()->getOnlinePlayers(), [$pk]);
				$player->sendMessage("Paused!");
			},
			"resume" => function (Player $player) {
				$pk = LevelEventPacket::create(0, LevelEvent::PAUSE_GAME, $player->getPosition());
				NetworkBroadcastUtils::broadcastPackets($this->getServer()->getOnlinePlayers(), [$pk]);
				$player->sendMessage("Resumed!");
			}
		];
		if (isset($commands[$msg[0]])) {
			$commands[$msg[0]]($player, ...array_slice($msg, 1));
		}
	}
}
