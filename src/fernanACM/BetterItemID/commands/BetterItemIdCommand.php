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

use pocketmine\item\StringToItemParser;

# Lib - Commando
use CortexPE\Commando\BaseCommand;
# My files
use fernanACM\BetterItemID\ItemID;
use fernanACM\BetterItemID\utils\PluginUtils;
use fernanACM\BetterItemID\commands\subcommands\BlockInfoSubCommand;

class BetterItemIdCommand extends BaseCommand{

    public function __construct(){
        parent::__construct(ItemID::getInstance(), "betteritemid", "BetterItemID by fernanACM", ["itemid", "id"]);
        $this->setPermission("betteritemid.cmd.acm");
    }
    
    /**
     * @return void
     */
    protected function prepare(): void{
        $this->registerSubCommand(new BlockInfoSubCommand);
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
        $item = $sender->getInventory()->getItemInHand();
        $message = ItemID::getMessage($sender, "Messages.Itemid");
        /** @var StringToItemParser $stringToItem */
        $stringToItem = StringToItemParser::getInstance();
        $id = $stringToItem->lookupAliases($item)[0];
        $message = str_replace(["{ID}"], [$id], $message);
        if(ItemID::getInstance()->config->getNested("Settings.Id-no-sound")){
            PluginUtils::PlaySound($sender, ItemID::getInstance()->config->getNested("Settings.Id-sound"), 1, 3);
        }
        $sender->sendMessage($message);
    }
}
