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

	const GRID = 16; // 16 * 16 Emoji

	public static function getBambooHeight(Block $block): int {
		$originalBlock = $block;
		$height = 0;
		while ($block->getTypeId() === BlockTypeIds::BAMBOO) {
			$height++;
			$block = $block->getSide(Facing::UP);
		}
		$block = $originalBlock;
		while ($block->getTypeId() === BlockTypeIds::BAMBOO) {
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

	public static function dumpGlyph(string $glyph = "E1"): void {
		$filename = basename("glyph_$glyph", ".png");
		$startChar = hexdec(substr($filename, strrpos($filename, "_") + 1) . "00");
		$i = 0;
		$messages = [];
		do {
			$z = ($i - ($i % self::GRID)) / self::GRID;
			$ci = (int) $startChar + $i; // char index
			$char = mb_chr($ci);
			$messages[$z] = array_key_exists($z, $messages) ? $messages[$z] . $char : $char;
		} while (++$i < self::GRID ** 2);
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

	public static function centerText(string $text): string {
		// Tách các dòng văn bản thành mảng dựa trên ký tự xuống dòng \n
		$lines = explode("\n", $text);

		// Tìm chiều dài dòng dài nhất
		$max_length = 0;
		foreach ($lines as $line) {
			$line_length = strlen($line);
			if ($line_length > $max_length) {
				$max_length = $line_length;
			}
		}

		// Căn giữa từng dòng văn bản bằng cách thêm khoảng trắng vào đầu và cuối
		$centered_lines = array();
		foreach ($lines as $line) {
			$line_length = strlen($line);
			$padding_length = ($max_length - $line_length) / 2;
			$padding = str_repeat(" ", (int) $padding_length);
			$centered_line = $padding . $line . $padding;
			$centered_lines[] = $centered_line;
		}

		// Gộp lại các dòng văn bản thành một chuỗi
		$centered_text = implode("\n", $centered_lines);

		return $centered_text;
	}

	/**
	 * Hàm căn giữa chuỗi
	 *
	 * @param string $str Chuỗi cần căn giữa
	 *
	 * @return string
	 */
	public static function centerString($str) {
		$lines = explode("\n", $str);
		$maxLen = 0;
		foreach ($lines as $line) {
			$maxLen = max($maxLen, strlen($line));
		}
		$result = '';
		foreach ($lines as $line) {
			$numSpaces = $maxLen - strlen($line);
			$leftSpaces = floor($numSpaces / 2);
			$rightSpaces = ceil($numSpaces / 2);
			$result .= str_repeat(' ', (int)$leftSpaces) . $line . str_repeat(' ', (int)$rightSpaces) . "\n";
		}
		return $result;
	}
}
