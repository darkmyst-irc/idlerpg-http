# Darkmyst IdleRPG Web Frontend

The original IdleRPG sources (see http://idlerpg.net) unfortunately use several PHP shorttags and many application entry points due the age of the original IdleRPG. In an effort to tackle the future, Darkmyst have tried to make a version of the IdleRPG web frontend that has the same functionality as the old frontend, but uses no short-tags, does not mix HTML and PHP code outside of views, and uses object hydration to make IdleRPG's data more accessible everywhere within the application.

The sources you see here are a first sloppy attempt at that - please feel free to fork the source as necessary and adjust it to something less catastrophic.

# Prerequities

You'll need a map file. You can use the original IdleRPG map (see http://idlerpg.net/worldmap.php) or create one from scratch. _Note that the labels on the map will need to be roughly in the same place unless you also change the source of your IdleRPG bot - the IdleRPG bot will generate quests that refer to the places on the map._

This frontend requires PHP GD as it relies on being able to generate PNGs for world maps.

# Installation instructions

1. Clone into a web directory on your server.
2. `cp config.ini.dist config.ini`
3. Adjust contents of `config.ini`
4. That's probably it. Enjoy!

# Live example

You can find a live example of this code at https://idlerpg.darkmyst.org/.

# Help

Please join `#dataclaw` on `irc.darkmyst.org` if you want assistance with this code in particular - `#dataclaw` is primarily an OOC channel for roleplayers, but the person who hacked this source code together hangs out there as well and if online at all is very happy to help you out. :o)

# Our networks are in competition with each other, can I still use this without making you angry?

Yep! That's why we put this onto GitHub. It's genuinely just meant to be a slight improvement over the original code. It's not like the idea is ours, or anything like that. This is just our way of saying thanks for IdleRPG.
