<?php

namespace NurAzliYT\QuickCash\api;

use pocketmine\player\Player;

class QuickCashAPI {

    private const CASH_TAG = "quickcash_balance";

    /**
     * Get the cash balance of a player.
     *
     * @param Player $player
     * @return int
     */
    public function getCash(Player $player): int {
        // Check if the player has the cash attribute
        $balance = $player->getAttributeMap()->getAttribute(self::CASH_TAG);
        return $balance !== null ? (int) $balance->getValue() : 0;
    }

    /**
     * Set the cash balance of a player.
     *
     * @param Player $player
     * @param int $amount
     */
    public function setCash(Player $player, int $amount): void {
        $attribute = $player->getAttributeMap()->getAttribute(self::CASH_TAG);
        if ($attribute === null) {
            $attribute = $player->getAttributeMap()->createAttribute(self::CASH_TAG, $amount);
        } else {
            $attribute->setValue($amount);
        }
    }

    /**
     * Add cash to a player's balance.
     *
     * @param Player $player
     * @param int $amount
     */
    public function addCash(Player $player, int $amount): void {
        $currentBalance = $this->getCash($player);
        $this->setCash($player, $currentBalance + $amount);
    }

    /**
     * Remove cash from a player's balance.
     *
     * @param Player $player
     * @param int $amount
     */
    public function removeCash(Player $player, int $amount): void {
        $currentBalance = $this->getCash($player);
        $this->setCash($player, max(0, $currentBalance - $amount));
    }

    /**
     * Reset a player's cash balance to zero.
     *
     * @param Player $player
     */
    public function resetCash(Player $player): void {
        $this->setCash($player, 0);
    }
}
