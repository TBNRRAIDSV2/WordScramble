<?php

declare(strict_types=1);

namespace Dapro718\WordScramble;

use pocketmine\event\Listener;
use pocketmine\event\player\PlayerChatEvent;
use pocketmine\Player;
use pocketmine\Server;
use pocketmine\plugin\PluginBase;
use pocketmine\plugin\Plugin;
use pocketmine\utils\Config;
use pocketmine\scheduler\TaskHandler;
use pocketmine\scheduler\Task;
use pocketmine\scheduler\TaskScheduler;
use Dapro718\WordScramble\ScrambleTask;
use onebone\economyapi\EconomyAPI;
use Dapro718\WordScramble\Main;

class EventListener implements Listener {
  
  public $plugin;

  public function __construct(Main $plugin) {
    $this->plugin = $plugin;
  }
  
  public function onChat(PlayerChatEvent $event) {
    $this->plugin->getServer()->broadcastMessage("Chat Event Activated");
    $scrambledWord = $this->plugin->sWord;
    $correctWord = $this->plugin->cWord;
    $this->plugin->getServer()->broadcastMessage("Scrambled is: $scrambledWord");
    $this->plugin->getServer()->broadcastMessage("Correct is: $correctWord");
    $player = $event->getPlayer();
    $money = $this->plugin->pMoney;
    $message = strtolower($event->getMessage());
    $this->plugin->getServer()->broadcastMessage("Players message is: $message");
    if($event->getPlayer() instanceof Player) {
      $this->plugin->getServer()->broadcastMessage("Player is $player and is an instance of Player");
      if($correctWord !== "closed902312409") {
        $this->plugin->getServer()->broadcastMessage("Word is open");
        if($message === $scrambledWord) {
          $this->plugin->getServer()->broadcastMessage("message is correct, things should happen");
          EconomyAPI::getInstance()->addMoney($player, $money);
          $this->plugin->getServer()->broadcastMessage("§e{$player} §2has unscrambled §e{$correctWord} §2from §2{$scrambledWord} and got §e\${$money}§2!");
          $this->plugin->closeWord();
        }
      } else {
        return TRUE;
      }
    }
  }
}
