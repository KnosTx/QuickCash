<?php

namespace NurAzliYT\QuickCash\commands;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\player\Player;
use pocketmine\plugin\PluginOwned;
use pocketmine\plugin\PluginOwnedTrait;
use NurAzliYT\QuickCash\Main;

class PayCommand extends Command implements PluginOwned {
    use PluginOwnedTrait;

    private Main $plugin;

    public function __construct(Main $plugin) {
        parent::__construct("pay", "Pay another player a certain amount of cash", "/pay <player> <amount>", []);
        $this->setPermission("quickcash.command.pay");
        $this->owningPlugin = $plugin;
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args): bool {
        if (!$this->testPermission($sender)) {
            return false;
        }

        if (count($args) < 2 || !is_numeric($args[1])) {
            $sender->sendMessage("Usage: /pay <player> <amount>");
            return false;
        }

        if (!$sender instanceof Player) {
            $sender->sendMessage("This command can only be used in-game.");
            return false;
        }

        $target = $sender->getServer()->getPlayerByPrefix($args[0]);
        if (!$target instanceof Player) {
            $sender->sendMessage("Player not found");
            return false;
        }

        $amount = (int) $args[1];
        $plugin = $this->owningPlugin;

        if ($plugin->getAPI()->getCash($sender) < $amount) {
            $sender->sendMessage("You do not have enough " . $plugin->getCurrencyName() . " to complete this transaction.");
            return false;
        }

        $plugin->getAPI()->removeCash($sender, $amount);
        $plugin->getAPI()->addCash($target, $amount);

        $sender->sendMessage("Paid $amount " . $plugin->getCurrencyName() . " to {$target->getName()}.");
        $target->sendMessage("You received $amount " . $plugin->getCurrencyName() . " from {$sender->getName()}.");
        return true;
    }
}
