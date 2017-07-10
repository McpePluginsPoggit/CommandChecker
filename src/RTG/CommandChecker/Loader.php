<?php

/* 
 * Copyright (C) 2017 RTG
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

namespace RTG\CommandChecker;

use pocketmine\plugin\PluginBase;
use pocketmine\event\Listener;
use pocketmine\utils\Config;
use pocketmine\utils\TextFormat as TF;

class Loader extends PluginBase implements Listener {
    
    public $cfg;
    
    public function onEnable() {
        
        if (!is_dir($this->getDataFolder())) {
            mkdir($this->getDataFolder());
        }
        $this->saveDefaultConfig();
        $this->getServer()->getPluginManager()->registerEvents($this, $this);
        $this->cfg = $this->getConfig()->getAll();
        
    }
    
    public function commandCheck(\pocketmine\event\player\PlayerCommandPreprocessEvent $e) {
        
        $msg = $e->getMessage();
        $exp = explode(" ", $msg);
        $n = $e->getPlayer()->getName();
        
        if (in_array($exp[0], $this->cfg['banned-commands'])) {
            
            if (!in_array(strtolower($n), $this->cfg['allowed-players'])) {
                $e->setCancelled();
                $e->getPlayer()->sendMessage(TF::RED . $this->cfg['no-perm-message']);
            }
            
        }
        
    }
    
    public function onDisable() {
        parent::onDisable();
    }
     
}