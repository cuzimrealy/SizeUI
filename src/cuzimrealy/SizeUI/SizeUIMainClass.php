<?php

/*
Plugin distributed under the MIT license.
Plugin developed by pavoe (GitHub: pavoe), All Rights Reserved.
Copyright (c) 2022 pavoe All Rights Reserved.
*/

namespace cuzimrealy\SizeUI;

use pocketmine\plugin\PluginBase;
use pocketmine\event\Listener;
use pocketmine\player\Player;
use pocketmine\Server;
use pocketmine\command\CommandSender;
use pocketmine\command\Command;
use pocketmine\utils\Config;
use pocketmine\utils\TextFormat as M;

class SizeUIMainClass extends PluginBase implements Listener {

	public $prefix = M::GREEN."[".M::GOLD."Size".M::AQUA."UI".M::GREEN."]" ;

	public function onEnable(): void{
		@mkdir($this->getDataFolder());
		$this->saveResource("config.yml");
		$this->getServer()->getPluginManager()->registerEvents($this, $this);
		$this->getLogger()->info("Plugin SizeUI Enabled!");
	}

	public function onDisable(): bool{
		$this->getLogger()->info("Plugin SizeUI Disabled!");
	}

	public function onCommand(CommandSender $sender, Command $command, string $label, array $args) : bool{
		switch($command->getName()){
			case "size":
			if($sender instanceof Player)       {
				           $this->openMyForm($sender);
					 } else {
						     $sender->sendMessage("Use this command in-game");
						      return true;
					 }
			break;
		}
	    return true;
	}

	public function openMyForm(Player $player){
		$api = $this->getServer()->getPluginManager()->getPlugin("FormAPI");
		$form = $api->createSimpleForm(function (Player $player, int $data = null){
		$config = new Config($this->getDataFolder() . "config.yml", Config::YAML);
			    $result = $data;
			    if($result === null){
				      return;
				}
				switch($result){
					case "0";
					         $SmallSize = $config->get("Small-Size");
					         $player->setScale("$SmallSize");
				             $player->sendMessage($this->prefix . M::GREEN."Your Size has Changed to".M::AQUA." Small!");
					         return;
				    break;

					case "1";
					         $player->setScale("1.0");
				             $player->sendMessage($this->prefix . M::GREEN."Your Size has been set to ".M::WHITE."Default!");
					         return;
				    break;

					case "2";
					         $BigSize = $config->get("Big-Size");
					         $player->setScale("$BigSize");
				             $player->sendMessage($this->prefix . M::GREEN."Your Size has Changed to".M::YELLOW." Big!");
					         return;
				    break;
					}



			});
			$form->setTitle(M::GOLD."Size".M::AQUA."UI");
			$form->setContent(M::GREEN."Change your size!:");
			$form->addButton(M::WHITE."Small");
			$form->addButton(M::WHITE."Default");
			$form->addButton(M::WHITE
." Big");

			$form->sendToPlayer($player);
			return $form;
		}
}

?>
