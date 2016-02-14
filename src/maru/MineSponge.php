<?php 
namespace maru;
use pocketmine\plugin\PluginBase;
use pocketmine\event\Listener;
use pocketmine\event\block\BlockPlaceEvent;
use pocketmine\level\Position;
use pocketmine\block\Block;
use pocketmine\event\block\BlockBreakEvent;
class MineSponge extends PluginBase implements Listener {
	public function onEnable() {
		$this->getServer()->getPluginManager()->registerEvents($this, $this);
	}
	public function onBlockPlace(BlockPlaceEvent $event) {
		$block = $event->getBlock();
		$pos = new Position($block->getX(), $block->getY() + 1, $block->getZ(), $block->getLevel());
		if ($block->getId() !== 19 ) {
			return;
		}
		$block->getLevel()->setBlock($pos, $this->getMineBlock());
	}
	public function onBlockBreak(BlockBreakEvent $event) {
		$block = $event->getBlock();
		if ($block->getLevel()->getBlock(new Position($block->getX(), $block->getY() - 1, $block->getZ(), $block->getLevel()))->getId() !== 19 ) {
			return;
		}
		$block->getLevel()->setBlock(new Position($block->getX(), $block->getY(), $block->getZ(), $block->getLevel()), $this->getMineBlock());
	}
	private function getMineBlock() {
		while (true) {
			if (mt_rand(0, 1)) {
				return Block::get(1);
			} else if (mt_rand(1, 100) <= 20) {
				return Block::get(16);
			} else if (mt_rand(1, 100) <= 10) {
				return Block::get(15);
			} else if (mt_rand(1, 100) <= 8) {
				return Block::get(14);
			} else if (mt_rand(1, 100) <= 5) {
			return Block::get(21);
			} else if (mt_rand(1, 100) <= 5) {
				return Block::get(73);
			} else if (mt_rand(1, 100) <= 1) {
				return Block::get(56);
			} else if (mt_rand(1, 100) <= 1) {
				return Block::get(129);
			}
		}
	}
}
?>