<?php

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2022 Eweol<eweol@outlook.com>
 *  (c) 2013 Uwe Steinmann <uwe@steinmann.cx>
 *  All rights reserved
 *
 *  This script is part of the SeedDMS project. The SeedDMS project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 2 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/

/**
 * Gravatar extension
 *
 * @author  Eweol <eweol@outlook.com>
 * @package SeedDMS
 * @subpackage  Gravatar
 */
class SeedDMS_Gravatar extends SeedDMS_ExtBase
{

	/**
	 * Initialization
	 *
	 * Use this method to do some initialization like setting up the hooks
	 * You have access to the following global variables:
	 * $GLOBALS['settings'] : current global configuration
	 * $GLOBALS['settings']['_extensions']['example'] : configuration of this extension
	 * $GLOBALS['LANG'] : the language array with translations for all languages
	 * $GLOBALS['SEEDDMS_HOOKS'] : all hooks added so far
	 */
	function init()
	{
		$GLOBALS['SEEDDMS_HOOKS']['controller']['login'][] = new SeedDMS_User_Gravatar;
	}

	function main()
	{
	}
}

/**
 * Gravatar extension
 *
 * @author  Eweol <eweol@outlook.com>
 * @package SeedDMS
 * @subpackage  Gravatar
 */
class SeedDMS_User_Gravatar
{
	/**
	 * Hook after Login into SeedDMS
	 */
	function postLogin($login,$user)
	{
		$extSettings =  $login->getParam('settings')->_extensions;
		$gravatarSettings = $extSettings['gravatar'];

		if (!isset($gravatarSettings['gravatarEnable'])) {
			return;
		}
		if ($gravatarSettings['gravatarEnable'] !== "1") {
			return;
		}
		
		$image = file_get_contents(self::get_gravatar($user->getEmail(),150));
		file_put_contents("profile.jpg", $image);
		$user->setImage("profile.jpg","image/jpeg");

		if(!unlink('profile.jpg'))
		{
			error_log("[Warning] could not remove profile picture");
		}
	}

	/**
	 * Get either a Gravatar URL or complete image tag for a specified email address.
	 *
	 * @param string $email The email address
	 * @param string $s Size in pixels, defaults to 80px [ 1 - 2048 ]
	 * @param string $d Default imageset to use [ 404 | mp | identicon | monsterid | wavatar ]
	 * @param string $r Maximum rating (inclusive) [ g | pg | r | x ]
	 * @param boole $img True to return a complete IMG tag False for just the URL
	 * @param array $atts Optional, additional key/value attributes to include in the IMG tag
	 * @return String containing either just a URL or a complete image tag
	 * @source https://gravatar.com/site/implement/images/php/
	 */
	function get_gravatar( $email, $s = 80, $d = 'mp', $r = 'g', $img = false, $atts = array() ) {
		$url = 'https://www.gravatar.com/avatar/';
		$url .= md5( strtolower( trim( $email ) ) );
		$url .= "?s=$s&d=$d&r=$r";
		if ( $img ) {
			$url = '<img src="' . $url . '"';
			foreach ( $atts as $key => $val )
				$url .= ' ' . $key . '="' . $val . '"';
			$url .= ' />';
		}
		return $url;
	}
}