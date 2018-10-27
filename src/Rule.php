<?php

namespace RulesUI\Rule;

use pocketmine\plugin\PluginBase;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\event\Listener;
use jojoe77777\FormAPI;
use pocketmine\event\player\PlayerInteractEvent;
use pocketmine\utils\Config;
use pocketmine\event\player\PlayerCommandPreprocessEvent;
use pocketmine\event\server\ServerCommandEvent;
use pocketmine\Player;
use pocketmine\Server;
use RulesUI\Main;

class Rule extends PluginBase implements Listener{
    
    public function onEnable(){
        $this->getLogger()->info("§aStarting Test plugin...");
        $this->getServer()->getPluginManager()->registerEvents($this, $this);
    }

    public function checkDepends(){
        $this->formapi = $this->getServer()->getPluginManager()->getPlugin("FormAPI");
        if(is_null($this->formapi)){
            $this->getLogger()->error("§4Please install FormAPI Plugin, disabling Test plugin...");
            $this->getPluginLoader()->disablePlugin($this);
        }
    }

    public function onCommand(CommandSender $sender, Command $cmd, string $label, array $args):bool{
        if($cmd->getName() == "test"){
        if(!($sender instanceof Player)){
                $sender->sendMessage("§cPlease use this command from In-game!", false);
                return true;
        }
        $api = $this->getServer()->getPluginManager()->getPlugin("FormAPI");
        $form = $api->createSimpleForm(function (Player $sender, $data){
            $result = $data;
            if ($result == null) {
            }
            switch ($result) {
                    case 0:
                    $sender->sendMessage("exit");
                        break;
                    case 1:
                    $this->getServer()->getCommandMap()->dispatch($player, "lobby");
                        break;
                    case 2:
                    $this->getServer()->getCommandMap()->dispatch($player, "kill");
                        break;
            }
        });
        $form->setContent("test content title");
        $form->addButton("§cExit", 0);
        $form->addButton("lobby", 1);
        $form->addButton("kill", 2);
        $form->sendToPlayer($sender);
        }
        return true;
    }

    public function onDisable(){
        $this->getLogger()->info("§cDisabling Test plugin...");
    }
}

