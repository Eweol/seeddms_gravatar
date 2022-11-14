<?php
$EXT_CONF['gravatar'] = array(
	'title' => 'Gravatar Extension',
	'description' => 'This extension enables profie pictures from gravatar',
	'disable' => false,
	'version' => '1.0.0',
	'releasedate' => '2022-11-14',
	'author' => array('name'=>'Eweol', 'email'=>'eweol@outlook.com', 'company'=>'Unimain'),
	'config' => array(
		'gravatarEnable' => array(
			'title'=>'Enable Gravatar Profile Pictures',
			'type'=>'checkbox',
		)
	),
	'constraints' => array(
		'depends' => array('php' => '5.6.40-', 'seeddms' => '5.1.0-'),
	),
	'icon' => 'icon.svg',
	'changelog' => 'changelog.md',
	'class' => array(
		'file' => 'class.gravatar.php',
		'name' => 'SeedDMS_Gravatar'
	),
);
?>