<?php

declare(strict_types=1);

namespace NhanAZ\OhMyTest;

use pocketmine\block\Block;
use pocketmine\block\BlockTypeIds;
use pocketmine\math\Facing;

class BambooAZ {

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
}
