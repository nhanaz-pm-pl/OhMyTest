| Name | Description | Children | Permissibles |
| ---- | ----------- | -------- | ------------ |
| `pocketmine.group.console` | Grants all console permissions | <details><summary>Details</summary> - pocketmine.group.operator : true<br/>- pocketmine.command.dumpmemory : true</details> | [] |
| `pocketmine.group.operator` | Grants all operator permissions | <details><summary>Details</summary> - pocketmine.group.user : true<br/>- pocketmine.broadcast.admin : true<br/>- pocketmine.command.ban.ip : true<br/>- pocketmine.command.ban.list : true<br/>- pocketmine.command.ban.player : true<br/>- pocketmine.command.clear.other : true<br/>- pocketmine.command.defaultgamemode : true<br/>- pocketmine.command.difficulty : true<br/>- pocketmine.command.effect.other : true<br/>- pocketmine.command.effect.self : true<br/>- pocketmine.command.enchant.other : true<br/>- pocketmine.command.enchant.self : true<br/>- pocketmine.command.gamemode.other : true<br/>- pocketmine.command.gamemode.self : true<br/>- pocketmine.command.gc : true<br/>- pocketmine.command.give.other : true<br/>- pocketmine.command.give.self : true<br/>- pocketmine.command.kick : true<br/>- pocketmine.command.kill.other : true<br/>- pocketmine.command.list : true<br/>- pocketmine.command.op.give : true<br/>- pocketmine.command.op.take : true<br/>- pocketmine.command.particle : true<br/>- pocketmine.command.plugins : true<br/>- pocketmine.command.save.disable : true<br/>- pocketmine.command.save.enable : true<br/>- pocketmine.command.save.perform : true<br/>- pocketmine.command.say : true<br/>- pocketmine.command.seed : true<br/>- pocketmine.command.setworldspawn : true<br/>- pocketmine.command.spawnpoint.other : true<br/>- pocketmine.command.spawnpoint.self : true<br/>- pocketmine.command.status : true<br/>- pocketmine.command.stop : true<br/>- pocketmine.command.teleport.other : true<br/>- pocketmine.command.teleport.self : true<br/>- pocketmine.command.time.add : true<br/>- pocketmine.command.time.query : true<br/>- pocketmine.command.time.set : true<br/>- pocketmine.command.time.start : true<br/>- pocketmine.command.time.stop : true<br/>- pocketmine.command.timings : true<br/>- pocketmine.command.title.other : true<br/>- pocketmine.command.title.self : true<br/>- pocketmine.command.transferserver : true<br/>- pocketmine.command.unban.ip : true<br/>- pocketmine.command.unban.player : true<br/>- pocketmine.command.whitelist.add : true<br/>- pocketmine.command.whitelist.disable : true<br/>- pocketmine.command.whitelist.enable : true<br/>- pocketmine.command.whitelist.list : true<br/>- pocketmine.command.whitelist.reload : true<br/>- pocketmine.command.whitelist.remove : true<br/>- devtools.command.makeplugin : true<br/>- devtools.command.extractplugin : true<br/>- devtools.command.checkperm.other : true<br/>- devtools.command.genplugin : true<br/>- devtools.command.listperms.self : true<br/>- devtools.command.listperms.other : true<br/>- devtools.command.handlers : true<br/>- devtools.command.handlersbyplugin : true</details> | [] |
| `pocketmine.group.user` | Grants all non-sensitive permissions that everyone gets by default | <details><summary>Details</summary> - pocketmine.broadcast.user : true<br/>- pocketmine.command.clear.self : true<br/>- pocketmine.command.help : true<br/>- pocketmine.command.kill.self : true<br/>- pocketmine.command.me : true<br/>- pocketmine.command.tell : true<br/>- pocketmine.command.version : true<br/>- devtools.command.checkperm : true</details> | [] |
| `pocketmine.broadcast.admin` | Allows the user to receive administrative broadcasts | [] | [] |
| `pocketmine.broadcast.user` | Allows the user to receive user broadcasts | [] | [] |
| `pocketmine.command.ban.ip` | Allows the user to ban IP addresses | [] | [] |
| `pocketmine.command.ban.list` | Allows the user to list banned players | [] | [] |
| `pocketmine.command.ban.player` | Allows the user to ban players | [] | [] |
| `pocketmine.command.clear.other` | Allows the user to clear inventory of other players | [] | [] |
| `pocketmine.command.clear.self` | Allows the user to clear their own inventory | [] | [] |
| `pocketmine.command.defaultgamemode` | Allows the user to change the default game mode | [] | [] |
| `pocketmine.command.difficulty` | Allows the user to change the game difficulty | [] | [] |
| `pocketmine.command.dumpmemory` | Allows the user to dump memory contents | [] | [] |
| `pocketmine.command.effect.other` | Allows the user to modify effects of other players | [] | [] |
| `pocketmine.command.effect.self` | Allows the user to modify their own effects | [] | [] |
| `pocketmine.command.enchant.other` | Allows the user to enchant the held items of other players | [] | [] |
| `pocketmine.command.enchant.self` | Allows the user to enchant their own held item | [] | [] |
| `pocketmine.command.gamemode.other` | Allows the user to change the game mode of other players | [] | [] |
| `pocketmine.command.gamemode.self` | Allows the user to change their own game mode | [] | [] |
| `pocketmine.command.gc` | Allows the user to fire garbage collection tasks | [] | [] |
| `pocketmine.command.give.other` | Allows the user to give items to other players | [] | [] |
| `pocketmine.command.give.self` | Allows the user to give items to themselves | [] | [] |
| `pocketmine.command.help` | Allows the user to view the help menu | [] | [] |
| `pocketmine.command.kick` | Allows the user to kick players | [] | [] |
| `pocketmine.command.kill.other` | Allows the user to kill other players | [] | [] |
| `pocketmine.command.kill.self` | Allows the user to commit suicide | [] | [] |
| `pocketmine.command.list` | Allows the user to list all online players | [] | [] |
| `pocketmine.command.me` | Allows the user to perform a chat action | [] | [] |
| `pocketmine.command.op.give` | Allows the user to give a player operator status | [] | [] |
| `pocketmine.command.op.take` | Allows the user to take a player's operator status | [] | [] |
| `pocketmine.command.particle` | Allows the user to create particle effects | [] | [] |
| `pocketmine.command.plugins` | Allows the user to view the list of plugins | [] | [] |
| `pocketmine.command.save.disable` | Allows the user to disable automatic saving | [] | [] |
| `pocketmine.command.save.enable` | Allows the user to enable automatic saving | [] | [] |
| `pocketmine.command.save.perform` | Allows the user to enable automatic saving | [] | [] |
| `pocketmine.command.say` | Allows the user to broadcast announcements to the server | [] | [] |
| `pocketmine.command.seed` | Allows the user to view the seed of the world | [] | [] |
| `pocketmine.command.setworldspawn` | Allows the user to change the world spawn | [] | [] |
| `pocketmine.command.spawnpoint.other` | Allows the user to change the respawn point of other players | [] | [] |
| `pocketmine.command.spawnpoint.self` | Allows the user to change their own respawn point | [] | [] |
| `pocketmine.command.status` | Allows the user to view the server performance | [] | [] |
| `pocketmine.command.stop` | Allows the user to stop the server | [] | [] |
| `pocketmine.command.teleport.other` | Allows the user to teleport other players | [] | [] |
| `pocketmine.command.teleport.self` | Allows the user to teleport themselves | [] | [] |
| `pocketmine.command.tell` | Allows the user to privately message another player | [] | [] |
| `pocketmine.command.time.add` | Allows the user to fast-forward time | [] | [] |
| `pocketmine.command.time.query` | Allows the user to check the time | [] | [] |
| `pocketmine.command.time.set` | Allows the user to change the time | [] | [] |
| `pocketmine.command.time.start` | Allows the user to restart the time | [] | [] |
| `pocketmine.command.time.stop` | Allows the user to stop the time | [] | [] |
| `pocketmine.command.timings` | Allows the user to record timings to analyse server performance | [] | [] |
| `pocketmine.command.title.other` | Allows the user to send a title to the specified player | [] | [] |
| `pocketmine.command.title.self` | Allows the user to send a title to themselves | [] | [] |
| `pocketmine.command.transferserver` | Allows the user to transfer self to another server | [] | [] |
| `pocketmine.command.unban.ip` | Allows the user to unban IP addresses | [] | [] |
| `pocketmine.command.unban.player` | Allows the user to unban players | [] | [] |
| `pocketmine.command.version` | Allows the user to view the version of the server | [] | [] |
| `pocketmine.command.whitelist.add` | Allows the user to add a player to the server whitelist | [] | [] |
| `pocketmine.command.whitelist.disable` | Allows the user to disable the server whitelist | [] | [] |
| `pocketmine.command.whitelist.enable` | Allows the user to enable the server whitelist | [] | [] |
| `pocketmine.command.whitelist.list` | Allows the user to list all players on the server whitelist | [] | [] |
| `pocketmine.command.whitelist.reload` | Allows the user to reload the server whitelist | [] | [] |
| `pocketmine.command.whitelist.remove` | Allows the user to remove a player from the server whitelist | [] | [] |
| `devtools.command.makeplugin` | Allows the creation of Phar plugins | [] | [] |
| `devtools.command.extractplugin` | Allows the extraction of Phar plugins | [] | [] |
| `devtools.command.checkperm.other` | Allows checking others permission value | [] | [] |
| `devtools.command.genplugin` | Allows the user to generate skeleton files for a plugin | [] | [] |
| `devtools.command.listperms.self` | Allows the user to list their own permissions | [] | [] |
| `devtools.command.listperms.other` | Allows the user to list another player's permissions | [] | [] |
| `devtools.command.handlers` | Allows the user to list handlers associated with an event | [] | [] |
| `devtools.command.handlersbyplugin` | Allows the user to list event handlers registered by a given plugin | [] | [] |
| `devtools.command.checkperm` | Allows checking a permission value | [] | [] |
