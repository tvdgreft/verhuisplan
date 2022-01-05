<?php

/**
 * WP Functies
 *
 */
function wp_parse_args($nargs,$default)
{
	$args=$default;
	foreach ($nargs as $arg=>$value)
	{
		$args[$arg] = $value;
	}
	return($args);
}