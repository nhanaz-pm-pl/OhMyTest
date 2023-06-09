<?php

declare(strict_types=1);

namespace NhanAZ\OhMyTest;

use pocketmine\player\ChunkSelector;
use pocketmine\Server;
use pocketmine\world\format\Chunk;
use pocketmine\world\World;
use pocketmine\lang\KnownTranslationFactory;

class WorldAZ {

	public static function loadWorlds(): void {
		$array = scandir(Server::getInstance()->getDataPath() . "worlds");
		if (is_array($array)) {
			foreach (array_diff($array, ["..", "."]) as $levelName) {
				Server::getInstance()->getWorldManager()->loadWorld($levelName);
			}
		}
	}

	public static function generateTerrain(): void {
		$worlds = Server::getInstance()->getWorldManager()->getWorlds();
		foreach ($worlds as $world) {
			try {
				$world->getSafeSpawn();
			} catch (\Exception) {
				Main::getInstance()->getServer()->getLogger()->notice(Main::getInstance()->getServer()->getLanguage()->translate(KnownTranslationFactory::pocketmine_level_backgroundGeneration($world->getFolderName())));
				$spawnLocation = $world->getSpawnLocation();
				$centerX = $spawnLocation->getFloorX() >> Chunk::COORD_BIT_SIZE;
				$centerZ = $spawnLocation->getFloorZ() >> Chunk::COORD_BIT_SIZE;
				$selected = iterator_to_array((new ChunkSelector())->selectChunks(8, $centerX, $centerZ), preserve_keys: false);
				$done = 0;
				$total = count($selected);
				foreach ($selected as $index) {
					World::getXZ($index, $chunkX, $chunkZ);
					$world->orderChunkPopulation($chunkX, $chunkZ, null)->onCompletion(
						static function () use ($world, &$done, $total): void {
							$oldProgress = (int) floor(($done / $total) * 100);
							$newProgress = (int) floor((++$done / $total) * 100);
							if (intdiv($oldProgress, 10) !== intdiv($newProgress, 10) || $done === $total || $done === 1) {
								$world->getLogger()->info($world->getServer()->getLanguage()->translate(KnownTranslationFactory::pocketmine_level_spawnTerrainGenerationProgress(strval($done), strval($total), strval($newProgress))));
							}
						},
						static function (): void {
							//NOOP: All worlds have been loaded before
						}
					);
				}
			}
		}
	}
}
