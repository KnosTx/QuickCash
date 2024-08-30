<?php

namespace NurAzliYT\QuickCash;

use pocketmine\plugin\PluginBase;
use NurAzliYT\QuickCash\api\QuickCashAPI;
use NurAzliYT\QuickCash\commands\{SetCashCommand, SeeCashCommand, AddCashCommand, RemoveCashCommand, PayCommand, ResetCashCommand, TopCashCommand};

class Main extends PluginBase {

    private static $qcAPI;

    public function onEnable(): void {
        self::$qcAPI = new QuickCashAPI();

        $this->getServer()->getCommandMap()->registerAll("quickcash", [
            new SetCashCommand(),
            new SeeCashCommand(),
            new AddCashCommand(),
            new RemoveCashCommand(),
            new PayCommand(),
            new ResetCashCommand(),
            new TopCashCommand(),
        ]);
    }

    public static function getAPI(): QuickCashAPI {
        return self::$qcAPI;
    }
}
