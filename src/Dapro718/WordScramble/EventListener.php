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
    $scrambledWord = $this->plugin->sWord;
    $correctWord = $this->plugin->cWord;
    $player = $event->getPlayer();
    $displayname = $event->getPlayer()->getName();
    $money = $this->plugin->pMoney;
    $message = strtolower($event->getMessage());
    if($event->getPlayer() instanceof Player) {
      if(!$player->hasPermission("wordscramble.deny")) {
        if($correctWord !== "closed902312409") {
          if($message === $correctWord) {
            if($player->hasPermission("wordscramble.bonus")) {
              EconomyAPI::getInstance()->addMoney($player, $money * 2);
              $this->plugin->getServer()->broadcastMessage("§e{$displayname} §2has unscrambled §e{$correctWord} §2from §2{$scrambledWord} and got §e\${$money}§2!");
              $this->plugin->closeWord();
            } else {
            EconomyAPI::getInstance()->addMoney($player, $money * 2);
            $this->plugin->getServer()->broadcastMessage("§e{$displayname} §2has unscrambled §e{$correctWord} §2from §2{$scrambledWord} and got §e\${$money}§2!");
            $this->plugin->closeWord();
            }
          }
        } else {
          return TRUE;
        }
      } else {
        // do nothing
      }
    }
  }
}
