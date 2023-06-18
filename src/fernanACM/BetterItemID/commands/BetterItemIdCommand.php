<?php
    
#      _       ____   __  __ 
#     / \     / ___| |  \/  |
#    / _ \   | |     | |\/| |
#   / ___ \  | |___  | |  | |
#  /_/   \_\  \____| |_|  |_|
# The creator of this plugin was fernanACM.
# https://github.com/fernanACM
 
namespace fernanACM\BetterItemID\commands;

use pocketmine\player\Player;

use pocketmine\command\CommandSender;
# Lib - Commando
use CortexPE\Commando\BaseCommand;
# My files
use fernanACM\BetterItemID\ItemID;
use fernanACM\BetterItemID\utils\PluginUtils;

class BetterItemIdCommand extends BaseCommand{

    public function __construct(){
        parent::__construct(ItemID::getInstance(), "betteritemid", "BetterItemID by fernanACM", ["itemid", "id"]);
        $this->setPermission("betteritemid.cmd.acm");
    }
    
    /**
     * @return void
     */
    protected function prepare(): void{
    }

    public function onRun(CommandSender $sender, string $aliasUsed, array $args): void{
        if(!$sender instanceof Player) {
            $sender->sendMessage("Use this command in-game");
            return;
        }
        $item = $sender->getInventory()->getItemInHand();
        $message = ItemID::getMessage($sender, "Messages.Itemid");
        $message = str_replace(["{ID}"], [$item->getName()], $message);
        if(ItemID::getInstance()->config->getNested("Settings.Id-no-sound")){
            PluginUtils::PlaySound($sender, ItemID::getInstance()->config->getNested("Settings.Id-sound"), 1, 3);
        }
        $sender->sendMessage($message);
    }
}
