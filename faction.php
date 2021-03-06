<?php

require_once 'config.php'; 

$factionID = filter_input(INPUT_GET, 'factionID', FILTER_VALIDATE_INT);

$tpl->factionName = Db::qColumn("SELECT `itemName` FROM  `invUniqueNames` WHERE  `itemID` = ?", array($factionID));
$tpl->corps = Db::q("
    SELECT a.corporationID, b.factionID, c.itemName AS corpName, d.itemName AS facName, count(*) AS num
    FROM `lpStore` a 
    INNER JOIN crpNPCCorporations b ON (b.corporationID = a.corporationID) 
    INNER JOIN invUniqueNames c ON (a.corporationID = c.itemID AND c.groupID = 2)
    INNER JOIN invUniqueNames d ON (b.factionID = d.itemID)
    WHERE b.factionID = ?
    GROUP BY a.corporationID 
    ORDER BY c.itemName ASC", array($factionID));

$tpl->display('faction.html');