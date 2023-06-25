<?php
    
#      _       ____   __  __ 
#     / \     / ___| |  \/  |
#    / _ \   | |     | |\/| |
#   / ___ \  | |___  | |  | |
#  /_/   \_\  \____| |_|  |_|
# The creator of this plugin was fernanACM.
# https://github.com/fernanACM
 
namespace fernanACM\BetterItemID;

use pocketmine\Server;
use pocketmine\player\Player;

use pocketmine\plugin\PluginBase;

use pocketmine\utils\Config;
use pocketmine\utils\TextFormat;

use pocketmine\event\Listener;

use pocketmine\event\player\PlayerItemHeldEvent;

use pocketmine\permission\DefaultPermissions;
# Libs
use muqsit\simplepackethandler\SimplePacketHandler;

use DaPigGuy\libPiggyUpdateChecker\libPiggyUpdateChecker;

use CortexPE\Commando\PacketHooker;
use CortexPE\Commando\BaseCommand;
# My files
use fernanACM\BetterItemID\utils\PluginUtils;
use fernanACM\BetterItemID\commands\BetterItemIdCommand;

class ItemID extends PluginBase implements Listener{
    
    /** @var Config $config */
    public Config $config;

    /** @var ItemID $instance */
    private static ItemID $instance;
    # CheckConfig
    public const CONFIG_VERSION = "1.0.0";
    
    /**
     * @return void
     */
    public function onLoad(): void{
        self::$instance = $this;
        $this->loadFiles();
    }

    /**
     * @return void
     */
    public function onEnable(): void{
        $this->loadCheck();
        $this->loadVirions();
        $this->loadCommands();
        $this->loadEvents();
    }

    /**
     * @return void
     */
    private function loadFiles(): void{
        $this->saveResource("config.yml");
	    $this->config = new Config($this->getDataFolder() . "config.yml");
    }

    /**
     * @return void
     */
    private function loadCheck(){
        # CONFIG
        if((!$this->config->exists("config-version")) || ($this->config->get("config-version") != self::CONFIG_VERSION)){
            rename($this->getDataFolder() . "config.yml", $this->getDataFolder() . "config_old.yml");
            $this->saveResource("config.yml");
            $this->getLogger()->critical("Your configuration file is outdated.");
            $this->getLogger()->notice("Your old configuration has been saved as config_old.yml and a new configuration file has been generated. Please update accordingly.");
        }
    }

    /**
     * @return void
     */
    private function loadVirions(): void{
        foreach([
            "SimplePacketHandler" => SimplePacketHandler::class,
            "Commando" => BaseCommand::class,
            "libPiggyUpdateChecker" => libPiggyUpdateChecker::class
            ] as $virion => $class
        ){
            if(!class_exists($class)){
                $this->getLogger()->error($virion . " virion not found. Please download BetterItemID from Poggit-CI or use DEVirion (not recommended).");
                $this->getServer()->getPluginManager()->disablePlugin($this);
                return;
            }
        }
        if(!PacketHooker::isRegistered()){
            PacketHooker::register($this);
        }
        # Update
        libPiggyUpdateChecker::init($this);
    }

    /**
     * @return void
     */
    private function loadCommands(): void{
        Server::getInstance()->getCommandMap()->register("betteritemid", new BetterItemIdCommand);
    }

    /**
     * @return void
     */
    private function loadEvents(): void{
        Server::getInstance()->getPluginManager()->registerEvents($this, $this);
    }
    
    /**
     * @param PlayerItemHeldEvent $event
     * @return void
     */
    public function ItemHeld(PlayerItemHeldEvent $event): void{
        $player = $event->getPlayer();
        if($this->config->getNested("Settings.No-tip-itemid")){
            if($player->hasPermission(DefaultPermissions::ROOT_OPERATOR)){
                $message = $this->getMessage($player, "Messages.Tip-itemid");
                $player->sendTip(str_replace(["{ID}"], [$event->getItem()->getVanillaName()], $message));
            }
        }
    }

    /**
     * @return ItemID
     */
    public static function getInstance(): ItemID{
        return self::$instance;
    }
    
     /**
     * @param Player $player
     * @param string $key
     * @return string
     */
    public static function getMessage(Player $player, string $key): string{
        $messageArray = self::$instance->config->getNested($key, []);
        if(!is_array($messageArray)){
            $messageArray = [$messageArray];
        }
        $message = implode("\n", $messageArray);
        return PluginUtils::codeUtil($player, $message);
    }

    /**
     * @return string
     */
    public static function Prefix(): string{
        return TextFormat::colorize(self::$instance->config->get("Prefix"));
    }
}
