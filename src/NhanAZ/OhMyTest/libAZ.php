<?php

declare(strict_types=1);

namespace NhanAZ\OhMyTest;

use pocketmine\block\Block;
use pocketmine\block\BlockTypeIds;
use pocketmine\math\Facing;
use pocketmine\Server;

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
}