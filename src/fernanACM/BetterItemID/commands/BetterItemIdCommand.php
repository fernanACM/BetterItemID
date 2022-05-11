<?php

namespace fernanACM\BetterItemID\commands;

use pocketmine\Server;
use pocketmine\player\Player;
use pocketmine\plugin\Plugin;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
# Lib - Commando
use CortexPE\Commando\BaseCommand;
# My files
use fernanACM\BetterItemID\ItemID;
use fernanACM\BetterItemID\utils\PluginUtils;

class BetterItemIdCommand extends BaseCommand{
    
    protected function prepare(): void{
        $this->setPermission("betteritemid.cmd.acm");
    }

    public function onRun(CommandSender $sender, string $aliasUsed, array $args): void{
        if (!$sender instanceof Player) {
              $sender->sendMessage("Use this command in-game");
               return;
        }
        $item = $sender->getInventory()->getItemInHand();
        $message = ItemID::getInstance()->getMessage($sender, "Messages.Itemid");
        $message = str_replace('{ID}', $item->getId(), $message);
        $message = str_replace('{META}', $item->getMeta(), $message);
        $message = str_replace('{BLOCK-NAME}', $item->getName(), $message);
        if(ItemID::getInstance()->config->get("Settings")["Id-no-sound"]){
            PluginUtils::PlaySound($sender, ItemID::getInstance()->config->get("Settings")["Id-sound"], 1, 3);
        }
        $sender->sendMessage($message);
    }
}
