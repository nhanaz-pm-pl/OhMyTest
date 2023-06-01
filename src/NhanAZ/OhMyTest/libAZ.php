<?php

declare(strict_types=1);

namespace NhanAZ\OhMyTest;

use pocketmine\block\Block;
use pocketmine\block\BlockTypeIds;
use pocketmine\item\Item;
use pocketmine\item\LegacyStringToItemParser;
use pocketmine\item\LegacyStringToItemParserException;
use pocketmine\item\StringToItemParser;
use pocketmine\math\Facing;
use pocketmine\player\ChunkSelector;
use pocketmine\Server;
use pocketmine\world\format\Chunk;
use pocketmine\world\World;
use pocketmine\lang\KnownTranslationFactory;
use pocketmine\lang\Language;
use pocketmine\lang\Translatable;
use pocketmine\permission\PermissionManager;

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

	public static function dumpPermissions(): void {
		$permissions = PermissionManager::getInstance()->getPermissions();
		$file = fopen(Main::getInstance()->getDataFolder() . "/permissions.md", "w");
		fwrite($file, "| Name | Description | Children | Permissibles |" . "\n");
		fwrite($file, "| :--- | :---------- | :------- | :----------- |" . "\n");
		foreach ($permissions as $permission) {
			$lang = new Language("eng");
			$description = $permission->getDescription();
			$descriptionString = $description instanceof Translatable ? $lang->translate($description) : $description;

			$childrens = $permission->getChildren();
			$children = json_encode($childrens);
			$children = str_replace(",", "<br/>", $children);
			$children = str_replace(["{", "}"], "", $children);
			$children = str_replace('":', " : ", $children);
			$children = str_replace('"', "- ", $children);
			if ($children !== "[]") {
				$children = "<details><summary>Details</summary> " . $children . "</details>";
			}

			$permissibles = $permission->getPermissibles();
			$permissionle = json_encode($permissibles);
			fwrite($file, "| `" . $permission->getName() . "` | " . $descriptionString . " | " . $children . " | " . $permissionle . " |" . "\n");
		}
		fclose($file);
	}

	public static function dumpIdItem(): void {
		$arr = [];
		$file = fopen(Main::getInstance()->getDataFolder() . "/ID Items.md", "w");
		fwrite($file, "| ID:Meta | (TypeId:ComputeStateData)xCount tags:0xNamedTag |" . "\n");
		fwrite($file, "| :------ | :---------------------------------------------- |" . "\n");
		for ($id = -214; $id <= 511; $id++) {
			for ($meta = 0; $meta <= 100; $meta++) {
				$item = $id . ":" . $meta;
				try {
					$item = StringToItemParser::getInstance()->parse($item) ?? LegacyStringToItemParser::getInstance()->parse($item);
				} catch (LegacyStringToItemParserException $e) {
					$item = "Unknown";
				}
				if ($item instanceof Item) {
					$object = $item->getStateId() . $item->getTypeId();
					if (!in_array($object, $arr)) {
						fwrite($file, "| `" . $id . ":" . $meta . "` | " . $item->__toString() . " |" . "\n");
						array_push($arr, $object);
					}
				}
			}
		}
		fclose($file);
	}
}
