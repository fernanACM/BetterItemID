<?php
    
#      _       ____   __  __ 
#     / \     / ___| |  \/  |
#    / _ \   | |     | |\/| |
#   / ___ \  | |___  | |  | |
#  /_/   \_\  \____| |_|  |_|
# The creator of this plugin was fernanACM.
# https://github.com/fernanACM

declare(strict_types=1);

namespace fernanACM\BetterItemID\utils;

use pocketmine\utils\TextFormat;

use pocketmine\item\Item;
use pocketmine\item\VanillaItems;
use pocketmine\item\enchantment\EnchantmentInstance;
use pocketmine\item\enchantment\VanillaEnchantments;

use pocketmine\nbt\tag\CompoundTag;

class BlockInfoUtils{

    public const TAG_BLOCK_INFO = "BlockInfoACM";
    public const TAG_BETTER_ITEM_ID = "BetterItemId";

    /**
     * @return Item
     */
    public static function getBlockInfo(): Item{
        $blockInfo = VanillaItems::BLAZE_ROD();
        $blockInfo->setNamedTag(CompoundTag::create()->setString(self::TAG_BETTER_ITEM_ID, self::TAG_BLOCK_INFO));
        $blockInfo->setCustomName(TextFormat::colorize("&r&l&eBlockInfo"));
        $blockInfo->setLore([
            TextFormat::colorize("&r&7Use right click on a block to get its ID"),
            TextFormat::colorize("&r&7By: BetterItemId")
        ]);
        $blockInfo->addEnchantment(new EnchantmentInstance(VanillaEnchantments::UNBREAKING(), 1));
        return $blockInfo;
    }
}