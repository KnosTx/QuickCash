<?php

namespace NurAzliYT\QuickCash;

use pocketmine\plugin\PluginBase;
use pocketmine\utils\Config;
use NurAzliYT\QuickCash\api\QuickCashAPI;
use NurAzliYT\QuickCash\commands\{SetCashCommand, SeeCashCommand, AddCashCommand, RemoveCashCommand, PayCommand};

class Main extends PluginBase{

    private Config $config;

    public function __construct(){
        parent::__construct();
    }

    public function onEnable() : void{
        $this->saveDefaultConfig();
        $this->config = $this->getConfig();

        $this->getServer()->getCommandMap()->registerAll(null, [
            new SetCashCommand($this),
            new SeeCashCommand($this),
            new AddCashCommand($this),
            new RemoveCashCommand($this),
            new PayCommand($this)
        ]);
    }

    public function getConfigValue(string $key, $default = null){
        return $this->config->get($key, $default);
    }

    public function getCurrencyName() : string{
        return $this->getConfigValue("currency-name", "Cash");
    }

    public function getDefaultBalance() : int{
        return $this->getConfigValue("default-balance", 1000);
    }

    public function getMaxBalance() : int{
        return $this->getConfigValue("max-balance", 1000000);
    }

    public function getAPI() : QuickCashAPI{
        return new QuickCashAPI($this);
    }
}
