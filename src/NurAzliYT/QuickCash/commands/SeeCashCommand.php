<?php

namespace NurAzliYT\QuickCash\commands;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\player\Player;
use pocketmine\plugin\PluginOwned;
use pocketmine\plugin\PluginOwnedTrait;
use NurAzliYT\QuickCash\Main;

class SeeCashCommand extends Command implements PluginOwned {
    use PluginOwnedTrait;

    private Main $plugin;
  
    public function __construct(Main $plugin) {
        parent::__construct("seecash", "See the amount of cash a player has", "/seecash [player]", []);
        $this->setPermission("quickcash.command.seecash");
        $this->owningPlugin = $plugin;
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args): bool {
        if (!$this->testPermission($sender)) {
            return false;
        }

        $target = $sender instanceof Player ? $sender : null;
        if (isset($args[0])) {
            $target = $sender->getServer()->getPlayerByPrefix($args[0]);
        }

        if (!$target instanceof Player) {
            $sender->sendMessage("Player not found");
            return false;
        }

        $plugin = $this->owningPlugin;
        $balance = $plugin->getAPI()->getCash($target);
        $sender->sendMessage("{$target->getName()} has $balance " . $plugin->getCurrencyName());
        return true;
    }
}
