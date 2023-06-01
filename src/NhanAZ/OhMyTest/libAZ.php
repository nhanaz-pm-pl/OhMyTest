<?php

declare(strict_types=1);

namespace NhanAZ\OhMyTest;

use pocketmine\block\Block;
use pocketmine\block\BlockTypeIds;
use pocketmine\math\Facing;
use pocketmine\player\ChunkSelector;
use pocketmine\Server;
use pocketmine\world\format\Chunk;
use pocketmine\world\World;
use pocketmine\lang\KnownTranslationFactory;

class libAZ {

	public static function getBambooHeight(Block $block): int {
		$originalBlock = $block;
		$height = 0;
		for (; $block->getTypeId() === BlockTypeIds::BAMBOO;) {
			$height++;
			$block = $block->getSide(Facing::UP);
		}
		$block = $originalBlock;
		for (; $block->getTypeId() === BlockTypeIds::BAMBOO;) {
			$height++;
			$block = $block->getSide(Facing::DOWN);
		}
		return $height - 1;
	}

	public static function loadWorlds(): void {
		$array = scandir(Server::getInstance()->getDataPath() . "worlds");
		if (is_array($array)) {
			foreach (array_diff($array, ["..", "."]) as $levelName) {
				Server::getInstance()->getWorldManager()->loadWorld($levelName);
			}
		}
	}

	const GRID = 16; // 16 * 16 Emoji

	public static function dumpGlyph(string $glyph = "E1"): void {
		$filename = basename("glyph_$glyph", ".png");
		$startChar = hexdec(substr($filename, strrpos($filename, "_") + 1) . "00");
		$messages = array_fill(0, self::GRID * self::GRID, "");
		for ($i = 0; $i < self::GRID * self::GRID; $i++) {
			$z = ($i - ($i % self::GRID)) / self::GRID;
			$ci = (int) $startChar + $i; // char index
			$messages[$z] .= mb_chr($ci);
		}
		foreach ($messages as $row) {
			echo $row;
		}
	}

	public static function generateTerrain(): void {
		$worlds = Server::getInstance()->getWorldManager()->getWorlds();
		foreach ($worlds as $world) {
			try {
				$world->getSafeSpawn();
			} catch (\Exception) {
				$spawnLocation = $world->getSpawnLocation();
				$centerX = $spawnLocation->getFloorX() >> Chunk::COORD_BIT_SIZE;
				$centerZ = $spawnLocation->getFloorZ() >> Chunk::COORD_BIT_SIZE;
				$selected = iterator_to_array((new ChunkSelector())->selectChunks(8, $centerX, $centerZ));
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

	public static function centerString($str) {
		$lines = explode("\n", $str);
		$maxLen = max(array_map('strlen', $lines));
		$result = '';
		foreach ($lines as $line) {
			$numSpaces = $maxLen - strlen($line);
			$result .= str_repeat(' ', (int)($numSpaces / 2)) . $line . str_repeat(' ', (int)($numSpaces / 2)) . "\n";
		}
		return $result;
	}
}
