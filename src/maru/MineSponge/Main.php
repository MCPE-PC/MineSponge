<?php 
namespace maru\MineSponge;
use pocketmine\plugin\PluginBase;
use pocketmine\event\Listener;
use pocketmine\event\block\BlockPlaceEvent;
use pocketmine\level\Position;
use pocketmine\block\Block;
use pocketmine\event\block\BlockBreakEvent;
use pocketmine\item\Item;
class Main extends PluginBase implements Listener {
	public function onEnable(): void {
		$this->getServer()->getPluginManager()->registerEvents($this, $this);
	}
	public function onBlockPlace(BlockPlaceEvent $event): void {
		$block = $event->getBlock();
		$pos = new Position($block->getX(), $block->getY() + 1, $block->getZ(), $block->getLevel());
		if ($block->getId() === 19 ) {
			$block->getLevel()->setBlock($pos, $this->getMineBlock());
		}
	}
	public function onBlockBreak(BlockBreakEvent $event): void {
		$player = $event->getPlayer();
		$block = $event->getBlock();
		if ($block->getLevel()->getBlock(new Position($block->getX(), $block->getY() - 1, $block->getZ(), $block->getLevel()))->getId() === 19 ) {
			$event->setCancelled();
			$block->getLevel()->setBlock(new Position($block->getX(), $block->getY(), $block->getZ(), $block->getLevel()), $this->getMineBlock());
			$player->getInventory()->addItem($this->oreTomineral(Item::get($block->getId())));
		}
	}
	private function getMineBlock(): Block {
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
				return Block::get(74);
			} else if (mt_rand(1, 100) <= 1) {
				return Block::get(56);
			} else if (mt_rand(1, 100) <= 1) {
				return Block::get(129);
			}
		}
	}
	private function oreTomineral (Item $item): Item {
		$id = $item->getId();
		$damage = $item->getDamage();
		if ($id == 14) {
			$mineral_id = 266;
		} else if ($id == 15) {
			$mineral_id = 265;
		} else if ($id == 16) {
			$mineral_id = 263;
		} else if ($id == 56) {
			$mineral_id = 264;
		} else if ($id == 129) {
			$mineral_id = 388;
		} else if ($id == 21) {
			return Item::get(351, 4, mt_rand(1, 4));
		} else if ($id == 74) {
			return Item::get(331, 0, mt_rand(1, 4));
		} else if ($id == 1) {
			$mineral_id = 4;
		}
		else {
			$mineral_id = $item->getId();
		}
		return Item::get($mineral_id);
	}
}
