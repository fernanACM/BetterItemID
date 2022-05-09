<?php

namespace fernanACM\BetterItemID\commands;

use pocketmine\Server;
use pocketmine\player\Player;
use pocketmine\plugin\Plugin;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\plugin\PluginOwned;

use fernanACM\BetterItemID\ItemID;
use fernanACM\BetterItemID\utils\PluginUtils;

class BetterItemIdCommand extends Command implements PluginOwned{
    
    private $plugin;

    public function __construct(ItemID $plugin){
        $this->plugin = $plugin;
        
        parent::__construct("betteritemid", "BetterItemID by fernanACM", "§cUse: /betteritemid | itemid | id", ["itemid", "id"]);
        $this->setPermission("betteritemid.cmd.acm");
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args){
        if(count($args) == 0){
            if($sender instanceof Player) {
                $item = $sender->getInventory()->getItemInHand();
                $message = $this->plugin->getMessage($sender, "Messages.Itemid");
                $message = str_replace('{ID}', $item->getId(), $message);
                $message = str_replace('{META}', $item->getMeta(), $message);
                $message = str_replace('{BLOCK-NAME}', $item->getName(), $message);
                if($this->plugin->config->get("Settings")["Id-no-sound"]){
                   PluginUtils::PlaySound($sender, $this->plugin->config->get("Settings")["Id-sound"], 1, 3);
                }
                $sender->sendMessage($message);
                }else{
                   $sender->sendMessage("Use this command in-game");
            }
        }
        return true;
    }
    
    public function getPlugin(): Plugin{
        return $this->plugin;
    }

    public function getOwningPlugin(): ItemID{
        return $this->plugin;
    }
}
