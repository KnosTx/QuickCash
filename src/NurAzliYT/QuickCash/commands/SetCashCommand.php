<?php

namespace NurAzliYT\QuickCash\commands;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\player\Player;
use pocketmine\plugin\PluginOwned;
use pocketmine\plugin\PluginOwnedTrait;
use NurAzliYT\QuickCash\Main;

class SetCashCommand extends Command implements PluginOwned {
    use PluginOwnedTrait;

    public function __construct(Main $plugin) {
        parent::__construct("setcash", "Set uang untuk pemain", "/setcash <player> <amount>", []);
        $this->setPermission("quickcash.command.setcash");
        $this->owningPlugin = $plugin;
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args): bool {
        if (!$this->testPermission($sender)) {
            return false;
        }

        if (count($args) < 2 || !is_numeric($args[1])) {
            $sender->sendMessage("Usage: /setcash <player> <amount>");
            return false;
        }

        $target = $sender->getServer()->getPlayerByPrefix($args[0]);
        if (!$target instanceof Player) {
            $sender->sendMessage("Player not found");
            return false;
        }

        $amount = (int) $args[1];
        $plugin = $this->owningPlugin;

        if ($amount > $plugin->getMaxBalance()) {
            $sender->sendMessage("Amount exceeds maximum balance of " . $plugin->getMaxBalance());
            return false;
        }

        $plugin->getAPI()->setCash($target, $amount);
        $sender->sendMessage("Set {$target->getName()}'s cash to $amount " . $plugin->getCurrencyName());
        return true;
    }
}
