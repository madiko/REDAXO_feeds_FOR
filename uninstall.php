<?php 

// delete ForeignKey
rex_sql_table::get(rex::getTable('feeds_stream'))
->removeForeignKey('rex_feeds_item_ibfk_1')
->ensure();  

# delete media effect
$sql = rex_sql::factory();
$sql->setTable(rex::getTablePrefix().'media_manager_type');
$sql->setWhere(['name'=>'feeds_thumb']);
$sql->delete();

$sql->setTable(rex::getTablePrefix().'media_manager_type_effect');
$sql->setWhere(['createuser'=>'feeds']);
$sql->delete();

// delete tables
$sql->setQuery(sprintf('DROP TABLE IF EXISTS `%s`;', rex::getTable('feeds_item')));
$sql->setQuery(sprintf('DROP TABLE IF EXISTS `%s`;', rex::getTable('feeds_stream')));
