# BetterItemID
[![](https://poggit.pmmp.io/shield.state/BetterItemID)](https://poggit.pmmp.io/p/BetterItemID)

[![](https://poggit.pmmp.io/shield.api/BetterItemID)](https://poggit.pmmp.io/p/BetterItemID)

**The best ItemID for PocketMine-MP 5.0 servers. Special use for builders.**

![icon-betteritemid](https://user-images.githubusercontent.com/83558341/167280782-a099e1f2-189f-4698-bf13-aaeb271c5375.png) 

This plugin adds options to see the ID of the blocks in the game, you can customize their texts and sounds very easily through 'config.yml'. Page for the sounds of the game [sounds](https://www.digminecraft.com/lists/sound_list_pe.php)

<a href="https://discord.gg/YyE9XFckqb"><img src="https://img.shields.io/discord/837701868649709568?label=discord&color=7289DA&logo=discord" alt="Discord" /></a>

### 💡 Implementations
[x] BlockInfo
[X] Sounds
[X] Message customization
[X] Commands
---

### 💾 Config
```yaml
   #   ____           _     _                   ___   _                        ___   ____  
   #  | __ )    ___  | |_  | |_    ___   _ __  |_ _| | |_    ___   _ __ ___   |_ _| |  _ \ 
   #  |  _ \   / _ \ | __| | __|  / _ \ | '__|  | |  | __|  / _ \ | '_ ` _ \   | |  | | | |
   #  | |_) | |  __/ | |_  | |_  |  __/ | |     | |  | |_  |  __/ | | | | | |  | |  | |_| |
   #  |____/   \___|  \__|  \__|  \___| |_|    |___|  \__|  \___| |_| |_| |_| |___| |____/ 
   #         by fernanACM

   # The best ItemID for PocketMine-MP 5.0 servers. Special use for builders.
   # This plugin adds options to see the ID of the blocks in the game, you can 
   # customize their texts and sounds very easily through 'config.yml'. 
   # Page for the sounds of the game: https://www.digminecraft.com/lists/sound_list_pe.php

   # DO NOT TOUCH!
   config-version: "2.0.0"
   # =======(SETTINGS)=======
   Settings:
    # Use "true" or "false" to enable/disable tip-id
    No-tip-itemid: true
    # Use "true" or "false" to enable/disable the sound when executing the command.
    Id-no-sound: true
    # I put the name of the sound you like: example:
    # Id-sound: "cauldron.adddye"
    Id-sound: "random.burp"

   # =======(MESSAGES)=======
   Messages:
    # Tip ID message
    Tip-itemid: "&l&b»&r&f[&eITEM&f] §a{ID}&l&b«"
    # Use '{LINE}' like 'enter' and use '{NAME}' to see the player's name.
    Itemid:
      - "§e=======(§bBetterItemID§e)======="
      - "§cHELLO: §f{NAME}"
      - "§aID: §b{ID}"
      - "§e=========================="
    # Block info message
    block-info: "&e{ID}"
  ```

### 🕹 Commands
| Command | Description |
|---------|-------------|
| ```/betteritemid``` | To see the ID of the item in hand |
| ```/betteritemid blockinfo``` | Use blockinfo |

### 🔒 Permissions
| Permission | Description |
|---------|-------------|
| ```betteritemid.cmd.acm``` | Executing the command |
| ```betteritemid.use.acm``` | Use blockinfo |

### 📢 Report bug
* If you find any bugs in this plugin, please let me know via: [issues](https://github.com/fernanACM/BetterItemId/issues)

### 📞 Contact 

| Redes | Tag | Link |
|-------|-------------|------|
| YouTube | fernanACM | [YouTube](https://www.youtube.com/channel/UC-M5iTrCItYQBg5GMuX5ySw) | 
| Discord | fernanACM#5078 | [Discord](https://discord.gg/YyE9XFckqb) |
| GitHub | fernanACM | [GitHub](https://github.com/fernanACM)
| Poggit | fernanACM | [Poggit](https://poggit.pmmp.io/ci/fernanACM)
****

### ✔ Credits
| Authors | Github | Lib |
|---------|--------|-----|
| CortexPE | [CortexPE](https://github.com/CortexPE) | [Commando](https://github.com/CortexPE/Commando/tree/master/) |
| Muqsit | [Muqsit](https://github.com/Muqsit) | [SimplePacketHandler](https://github.com/Muqsit/SimplePacketHandler) |
| DaPigGuy | [DaPigGuy](https://github.com/DaPigGuy) | [libPiggyUpdateChecker](https://github.com/DaPigGuy/libPiggyUpdateChecker) |
