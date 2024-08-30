<?php

namespace NurAzliYT\QuickCash\api;

use pocketmine\player\Player;

class QuickCashAPI {

    private $balances = [];

    public function getCash(Player $player): int{
      return $this->balances[
