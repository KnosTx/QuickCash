<?php
/**
 * This Plugin Created By NurAzliYT
 * Plagiarism of Other People's Work is Prohibited
 * Except Asking Permission From The Creator
 */
namespace NurAzliYT\QuickCash;

use pocketmine\plugin\PluginBase;
use pocketmine\command\Command;
use pocketmine\command\PluginCommand;
use pocketmine\utils\Config;
use NurAzliYT\QuickCash\data\PlayerData;
use NurAzliYT\QuickCash\command\MyMoneyCommand;
use NurAzliYT\QuickCash\command\MyDebtCommand;
use NurAzliYT\QuickCash\command\TakeDebtCommand;
use NurAzliYT\QuickCash\command\ReturnDebtCommand;
use NurAzliYT\QuickCash\command\MoneySaveCommand;
use NurAzliYT\QuickCash\command\MoneyLoadCommand;
use NurAzliYT\QuickCash\command\SetMoneyCommand;
use NurAzliYT\QuickCash\command\GiveMoneyCommand;
use NurAzliYT\QuickCash\command\TakeMoneyCommand;
use NurAzliYT\QuickCash\command\SeeMoneyCommand;

class Main extends PluginBase {

    private PlayerData $playerData;

    public function onEnable(): void {
        $this->saveDefaultConfig();
        $this->playerData = new PlayerData($this->getDataFolder());

        $this->registerCommands();
    }

    private function registerCommands(): void {
        $commandMap = $this->getServer()->getCommandMap();
        
        $commands = [
            new MyMoneyCommand($this),
            new MyDebtCommand($this),
            new TakeDebtCommand($this),
            new ReturnDebtCommand($this),
            new MoneySaveCommand($this),
            new MoneyLoadCommand($this),
            new SetMoneyCommand($this),
            new GiveMoneyCommand($this),
            new TakeMoneyCommand($this),
            new SeeMoneyCommand($this)
        ];

        foreach ($commands as $command) {
            $commandMap->register($command->getName(), $command);
        }
    }

    public function getPlayerData(): PlayerData {
        return $this->playerData;
    }
}
