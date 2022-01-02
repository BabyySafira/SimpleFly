<?php

namespace BabyySafira\SimpleFly;

use pocketmine\Server;
use pocketmine\player\Player;
use pocketmine\plugin\PluginBase;
use pocketmine\event\Listener;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\utils\Config;

class Main extends PluginBase implements Listener {
	
	public function onEnable(): void {
		$this->getLogger()->info("Plugin Loaded");
		$this->getServer()->getPluginManager()->registerEvents($this, $this); 
		$this->saveResource("config.yml");
		$this->config = new Config($this->getDataFolder() . "config.yml", Config::YAML); 
	}
	
	public function onCommand(CommandSender $player, Command $cmd, String $label, Array $args) : bool {
		switch($cmd->getName()){
			case "fly":
			if($player instanceof Player) {
				if($player->hasPermission("fly.cmd")){
					if(!$player->isCreative()){
						$player->sendMessage($player->getAllowFlight() === false ? $this->config()->get("fly-enabled") : $this->config()->get("fly-disabled"));
					    $player->setAllowFlight($player->getAllowFlight() === false ? true : false);
					    $player->setFlying($player->isFlying() === false ? true : false);
					}else{
						$player->sendMessage($this->config->get("only-survival-message"));
					    return false;
					}
				}else{
					$player->sendMessage($this->config->get("no-permission"));
					return false; 
				}
			}else{
				$player->sendMessage($this->config->get("in-game-only"));
			}
		}
		return true; 
	}
}