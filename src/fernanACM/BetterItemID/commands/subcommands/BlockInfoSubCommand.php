<?php
    
#      _       ____   __  __ 
#     / \     / ___| |  \/  |
#    / _ \   | |     | |\/| |
#   / ___ \  | |___  | |  | |
#  /_/   \_\  \____| |_|  |_|
# The creator of this plugin was fernanACM.
# https://github.com/fernanACM
 
namespace fernanACM\BetterItemID\commands\subcommands;

use pocketmine\player\Player;

use pocketmine\command\CommandSender;

use pocketmine\utils\TextFormat;
# Lib - Commando
use CortexPE\Commando\BaseSubCommand;
# My files
use fernanACM\BetterItemID\ItemID;
use fernanACM\BetterItemID\utils\BlockInfoUtils;
use fernanACM\BetterItemID\utils\PluginUtils;

class BlockInfoSubCommand extends BaseSubCommand{

    public function __construct(){
        parent::__construct("blockinfo", "BlockInfo by fernanACM", []);
        $this->setPermission("betteritemid.cmd.acm");
    }
    
    /**
     * @return void
     */
    protected function prepare(): void{
    }

    /**
     * @param CommandSender $sender
     * @param string $aliasUsed
     * @param array $args
     * @return void
     */
    public function onRun(CommandSender $sender, string $aliasUsed, array $args): void{
        if(!$sender instanceof Player) {
            $sender->sendMessage("Use this command in-game");
            return;
        }
        $sender->getInventory()->addItem(BlockInfoUtils::getBlockInfo());
        $sender->sendMessage(ItemID::Prefix(). TextFormat::colorize("&aYou received the &eBlockInfo&a in your inventory!"));
        PluginUtils::PlaySound($sender, "random.pop2", 1, 3.5);
    }
}
