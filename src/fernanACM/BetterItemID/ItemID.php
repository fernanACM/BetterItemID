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
# LIbs
use muqsit\simplepackethandler\SimplePacketHandler;
use CortexPE\Commando\PacketHooker;
# My files
use fernanACM\BetterItemID\utils\PluginUtils;
use fernanACM\BetterItemID\commands\BetterItemIdCommand;

class ItemID extends PluginBase implements Listener {
    
    public Config $config;
    public static $instance;
        
    public function onEnable(): void{
        self::$instance = $this;
        $this->saveDefaultConfig();
	$this->saveResource("config.yml");
	$this->config = new Config($this->getDataFolder() . "config.yml");
        $this->getServer()->getPluginManager()->registerEvents($this ,$this);
        $this->getServer()->getCommandMap()->register("betteritemid", new BetterItemIdCommand($this, "betteritemid", "BetterItemID by fernanACM", ["itemid", "id"]));
        # Libs - Commando and SimplePacketHandler
        foreach ([
                "Commando" => PacketHooker::class,
                "SimplePacketHandler" => SimplePacketHandler::class
            ] as $virion => $class
        ) {
            if (!class_exists($class)) {
                $this->getLogger()->error($virion . " virion not found. Please download BetterItemID from Poggit-CI or use DEVirion (not recommended).");
                $this->getServer()->getPluginManager()->disablePlugin($this);
                return;
            }
        }
        #Commando
        if (!PacketHooker::isRegistered()) {
            PacketHooker::register($this);
        }
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
    
    public static function getInstance(): ItemID{
        return self::$instance;
    }
}
