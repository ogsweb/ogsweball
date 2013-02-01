<?php
/**
 * Mobile Joomla!
 * http://www.mobilejoomla.com
 *
 * @version		1.2.2
 * @license		GNU/GPL v2 - http://www.gnu.org/licenses/gpl-2.0.html
 * @copyright	(C) 2008-2012 Kuneri Ltd.
 * @date		December 2012
 */
defined('_JEXEC') or die('Restricted access');

/** @var $links array */

$parts = array();
foreach($links as $link)
{
	if($link['url'])
		$parts[] = '<a href="'.$link['url'].'">'.$link['text'].'</a>';
	else
		$parts[] = $link['text'];
}

echo implode(' | ', $parts);
