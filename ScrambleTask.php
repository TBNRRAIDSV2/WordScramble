<?php

declare(strict_types=1);

namespace Dapro718\WordScramble;

use pocketmine\scheduler\Task;
use pocketmine\scheduler\TaskHandler;
use Dapro718\WordScramble\Main;

class ScrambleTask extends Task {

  public $plugin;
  
  public function __construct(Main $plugin) {
   $this->plugin = $plugin;
  }
  
  public function onRun(int $currentTick) {
    $this->plugin->chooseWord();
  }
}
