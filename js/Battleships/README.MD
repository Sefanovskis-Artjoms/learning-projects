# Battleship assistant

This project helps to play the battleship game by showing the heatmap with indexes that indicates on what cells is the biggest probability that there can be a ship. Also app automatically marks cells around the ship as killzone, where you cant place shots by the rules of the game making it more visible on what cells there is reason to shoot.

## About project realization

I have used MVC acrhitecture with variable state in model that contains all necesary app data and is the only access point to any used data.

For the correct processing of the ships was created ship class that defines ship behaviour. Ship objects are stored in the ship array in state -> shipRecord. If two ships are merged then they are deleted and new ship is created in its place conatining cells of previous ships and cell that was in between them. Also if hit is removed from the middle of the ship then current ship is deleted and two ships are created in its place.

There are also variables to keep track if ship can be palced or expanded(made longer/ added another hit to it). First variable is in the state -> shipRecord named possibleHitsLeft that contains initial value of all ship length in summ and updated when ever new hit is added or removed, that ensures that there never will be more ships than possible. And also there is variable named knownShipInstances in state that keeps track of how many ships of each length are present on the field to not allow player to place more ships of each length than there possibly can be, for example there are allowed only one battleship(4 tiles long ship) or there can exist 3 cruiser long ships(3 tiles) on the condition that there isnt a battleship, because there can be two cruisers and one of these ships can be expanded. But if there are already one battleship and two cruisers then you will not be able to make cruiser from destroyer(2 tiles) because there will already reached limit of cruisers.

Every time new hit is added or removed, surrounding cell for every ship is also updated.

Colors for heatmap are updated on every change in the grid. It works by finding biggest and smalest value in the grid, assigning respectively the strongest and weakest color tone and colors for every index in between are calculated as interpolation between those two colors
