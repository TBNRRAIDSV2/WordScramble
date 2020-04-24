<?php

declare(strict_types=1);

namespace Dapro718\WordScramble;

use pocketmine\event\Listener;
use pocketmine\event\player\PlayerChatEvent;
use pocketmine\Player;
use pocketmine\Server;
use pocketmine\Server\PluginLogger;
use pocketmine\plugin\Plugin;
use pocketmine\plugin\PluginBase;
use pocketmine\plugin\Plugin;
use pocketmine\utils\Config;
use pocketmine\scheduler\TaskHandler;
use pocketmine\scheduler\Task;
use pocketmine\scheduler\TaskScheduler;
use Dapro718\WordScramble\ScrambleTask;
use onebone\economyapi\EconomyAPI;

class Main extends PluginBase implements Listener {

  public $config;
  public $sTask;
  public $pMoney;
  public $sWord;
  public $cWord;
  
  public function onEnable() {
    $this->getServer()->getPluginManager()->registerEvents(new EventListener($this), $this);
    $this->config = $this->getConfig();
    $interval = $this->config->get("repeat-interval") * 20;
    $this->sTask = $this->getScheduler()->scheduleRepeatingTask(new ScrambleTask($this), $interval);
    $economyapi = $this->getServer()->getPluginManager()->getPlugin("EconomyAPI");
    if($economyapi === null) {
      $this->getServer()->getlogger->error("Depedency 'EconomyAPI' not found. Disabling plugin...");
      $this->getServer()->getPluginManager->disablePlugin("WordScramble");
    }
  }
  
  public function chooseWord() {
    $wordList = $this->config->get("words");
    $wordAmount = count($wordList);
    $random = rand(0 , $wordAmount - 1);
    $word = strtolower($wordList[$random]);
    $correctWord = $word;
    $scrambledWord = str_shuffle($word);
    $this->sendWord($scrambledWord, $correctWord);
  }
  
  public function sendWord($scrambledWord, $correctWord) {
    $min = $this->config->get("min-money");
    $max = $this->config->get("max-money");
    $this->pMoney = rand($min, $max);
    $money = $this->pMoney;
    $this->sWord = $scrambledWord;
    $this->cWord = $correctWord;
    $this->getServer()->broadcastMessage("§2============");
    $this->getServer()->broadcastMessage(" ");
    $this->getServer()->broadcastMessage("§2Word: §e{$scrambledWord}");
    $this->getServer()->broadcastMessage(" ");
    $this->getServer()->broadcastMessage("§2First person to unscramble the word gets §e\${$money}§2!");
    $this->getServer()->broadcastMessage(" ");
    $this->getServer()->broadcastMessage("§2============");
  }
  
  public function closeWord() {
    $this->sWord = "closed902312409";
    $this->cWord = "closed902312409";
  } 
}
