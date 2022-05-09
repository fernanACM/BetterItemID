<?php
    
namespace fernanACM\BetterItemID;

use pocketmine\Server;
use pocketmine\player\Player;

use pocketmine\plugin\PluginBase;
use pocketmine\event\Listener;

use pocketmine\item\Item;

use pocketmine\event\player\PlayerItemHeldEvent;

use pocketmine\permission\DefaultPermissions;

use pocketmine\utils\Config;

use fernanACM\BetterItemID\utils\PluginUtils;
use fernanACM\BetterItemID\commands\BetterItemIdCommand;

class ItemID extends PluginBase implements Listener {
    
    public Config $config;
        
	public function onEnable(): void{
        $this->saveDefaultConfig();
		$this->saveResource("config.yml");
		$this->config = new Config($this->getDataFolder() . "config.yml");
        $this->getServer()->getPluginManager()->registerEvents($this ,$this);
        $this->getServer()->getCommandMap()->register("betteritemid", new BetterItemIdCommand($this));
    }
        
    public function ItemHeld(PlayerItemHeldEvent $event){
        if($this->config->get("Settings")["No-tip-itemid"]){
            $player = $event->getPlayer();
            if($player->hasPermission(DefaultPermissions::ROOT_OPERATOR)){
                $message = $this->getMessage($player, "Messages.Tip-itemid");
                $player->sendTip(str_replace(["{ID}", "{META}"], [$event->getItem()->getId(), $event->getItem()->getMeta()], $message));
            }
        }
    }
    
    public function getMessage(Player $player, string $key){
        return PluginUtils::codeUtil($player, $this->config->getNested($key, $key));
    }
}
