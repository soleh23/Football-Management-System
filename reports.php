<?php

$topScoringPlayers = "SELECT Player.name, Player.surname, count(*) AS goalsNO
					  FROM Player, Stats
					  WHERE Stats.playerID = Player.ID AND Stats.action = '0'
					  GROUP BY Player.name, Player.surname
					  ORDER BY goalsNo DESC";
mysqli_query($connection, $topScoringPlayers);

$topFoulingPlayers = "SELECT Player.name, Player.surname, count(*) AS goalsNO
					  FROM Player, Stats
					  WHERE Stats.playerID = Player.ID AND Stats.action = '1'
					  GROUP BY Player.name, Player.surname
					  ORDER BY goalsNo DESC";
mysqli_query($connection, $topFoulingPlayers);

$mostExpensiveTransfers = "SELECT Player.name, Player.surname, Transfer_Offer.price
						   FROM Transfer_Offer, Player	
						   WHERE Transfer_Offer.status = '3' AND Transfer_Offer.playerID = Player.ID
						   ORDER BY Transfer_Offer.price DESC";
mysqli_query($connection, $mostExpensiveTransfers);
?>