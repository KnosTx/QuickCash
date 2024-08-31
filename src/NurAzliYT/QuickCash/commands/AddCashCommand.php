<?php

namespace NurAzliYT\QuickCash\commands;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\player\Player;
use pocketmine\plugin\PluginOwned;
use pocketmine\plugin\PluginOwnedTrait;
use NurAzliYT\QuickCash\Main;

class AddCashCommand extends Command implements PluginOwned {
    use PluginOwnedTrait;

    private Main $plugin;

    public function __construct(Main $plugin) {
        parent::__construct("addcash", "Add cash to a player's account", "/addcash <player> <amount>", []);
        $this->setPermission("quickcash.command.addcash");
        $this->owningPlugin = $plugin;
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args): bool {
        if (!$this->testPermission($sender)) {
            return false;
        }

        if (count($args) < 2 || !is_numeric($args[1])) {
            $sender->sendMessage("Usage: /addcash <player> <amount>");
            return false;
        }

        $target = $sender->getServer()->getPlayerByPrefix($args[0]);
        if (!$target instanceof Player) {
            $sender->sendMessage("Player not found");
            return false;
        }

        $amount = (int) $args[1];
        $plugin = $this->owningPlugin;
        $plugin->getAPI()->addCash($target, $amount);
        $sender->sendMessage("Added $amount " . $plugin->getCurrencyName() . " to {$target->getName()}'s account");
        return true;
    }
}
