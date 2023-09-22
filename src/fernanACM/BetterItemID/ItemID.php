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
use pocketmine\event\player\PlayerInteractEvent;

use pocketmine\permission\DefaultPermissions;

use pocketmine\item\StringToItemParser;
# Libs
use muqsit\simplepackethandler\SimplePacketHandler;

use DaPigGuy\libPiggyUpdateChecker\libPiggyUpdateChecker;

use CortexPE\Commando\PacketHooker;
use CortexPE\Commando\BaseCommand;
# My files
use fernanACM\BetterItemID\utils\PluginUtils;
use fernanACM\BetterItemID\commands\BetterItemIdCommand;
use fernanACM\BetterItemID\utils\BlockInfoUtils;

class ItemID extends PluginBase implements Listener{
    
    /** @var Config $config */
    public Config $config;

    /** @var array $cooldown */
    private static array $cooldown = [];

    /** @var ItemID $instance */
    private static ItemID $instance;
    # CheckConfig
    public const CONFIG_VERSION = "2.0.0";
    
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
    public function onItemHeld(PlayerItemHeldEvent $event): void{
        $player = $event->getPlayer();
        if($this->config->getNested("Settings.No-tip-itemid")){
            if($player->hasPermission(DefaultPermissions::ROOT_OPERATOR)){
                $message = self::getMessage($player, "Messages.Tip-itemid");
                /** @var StringToItemParser $stringToItem */
                $stringToItem = StringToItemParser::getInstance();
                $id = $stringToItem->lookupAliases($event->getItem())[0];
                $player->sendActionBarMessage(str_replace(["{ID}"], [$id], $message));
            }
        }
    }

    /**
     * @param PlayerInteractEvent $event
     * @return void
     */
    public function onInteractBlock(PlayerInteractEvent $event): void{
        $player = $event->getPlayer();
        $action = $event->getAction();
        $block = $event->getBlock();
        if($player->getInventory()->getItemInHand()->equals(BlockInfoUtils::getBlockInfo()) && 
            $action === PlayerInteractEvent::RIGHT_CLICK_BLOCK){
            if((self::$cooldown[$player->getName()] ?? .0) < microtime(true)){
                self::$cooldown[$player->getName()] = microtime(true) + 0.2;
            }else return;
            $message = self::getMessage($player, "Messages.block-info");
            /** @var StringToItemParser $stringToItem */
            $stringToItem = StringToItemParser::getInstance();
            $id = $stringToItem->lookupBlockAliases($block)[0];
            if($player->hasPermission("betteritemid.use.acm")){
                if(ItemID::getInstance()->config->getNested("Settings.Id-no-sound")){
                    PluginUtils::PlaySound($player, ItemID::getInstance()->config->getNested("Settings.Id-sound"), 1, 3);
                }
                $player->sendMessage(self::Prefix(). str_replace(["{ID}"], [$id], $message));
            }
        }
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
     * @return ItemID
     */
    public static function getInstance(): ItemID{
        return self::$instance;
    }

    /**
     * @return string
     */
    public static function Prefix(): string{
        return TextFormat::colorize(self::$instance->config->get("Prefix"));
    }
}
