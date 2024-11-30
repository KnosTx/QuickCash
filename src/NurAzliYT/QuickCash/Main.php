<?php

namespace NurAzliYT\QuickCash;

use pocketmine\plugin\PluginBase;
use pocketmine\plugin\PluginDescription;
use pocketmine\plugin\PluginLoader;
use pocketmine\plugin\ResourceProvider;
use pocketmine\scheduler\TaskScheduler;
use pocketmine\Server;
use pocketmine\utils\Config;
use NurAzliYT\QuickCash\api\QuickCashAPI;
use NurAzliYT\QuickCash\commands\{SetCashCommand, SeeCashCommand, AddCashCommand, RemoveCashCommand, PayCommand};

class Main extends PluginBase{

    private Config $config;
    private PluginLogger $logger;
	private TaskScheduler $scheduler;

    public function __construct(
		private PluginLoader $loader,
		private Server $server,
		private PluginDescription $description,
		private string $dataFolder,
		private string $file,
		private ResourceProvider $resourceProvider
	){
		$this->dataFolder = rtrim($dataFolder, "/" . DIRECTORY_SEPARATOR) . "/";
		//TODO: this is accessed externally via reflection, not unused
		$this->file = rtrim($file, "/" . DIRECTORY_SEPARATOR) . "/";
		$this->resourceFolder = Path::join($this->file, "resources") . "/";

		$this->configFile = Path::join($this->dataFolder, "config.yml");

		$prefix = $this->description->getPrefix();
		$this->logger = new PluginLogger($server->getLogger(), $prefix !== "" ? $prefix : $this->getName());
		$this->scheduler = new TaskScheduler($this->getFullName());

		$this->onLoad();

		$this->registerYamlCommands();
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
