<?php

namespace NurAzliYT\QuickCash\api;

use pocketmine\player\Player;
use NurAzliYT\QuickCash\Main;

class QuickCashAPI {

    private Main $plugin;

    public function __construct(Main $plugin) {
        $this->plugin = $plugin;
    }

    public function getCash(Player $player): int {
        return $player->getPersistentData()->getInt("quickcash.balance", $this->plugin->getDefaultBalance());
    }

    public function setCash(Player $player, int $amount): void {
        $player->getPersistentData()->setInt("quickcash.balance", min($amount, $this->plugin->getMaxBalance()));
    }

    public function addCash(Player $player, int $amount): void {
        $currentCash = $this->getCash($player);
        $this->setCash($player, $currentCash + $amount);
    }

    public function removeCash(Player $player, int $amount): void {
        $currentCash = $this->getCash($player);
        $this->setCash($player, max($currentCash - $amount, 0));
    }

    public function resetCash(Player $player): void {
        $this->setCash($player, 0);
    }
}
