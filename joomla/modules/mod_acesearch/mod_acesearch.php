<?php
/**
* @version		1.7.0
* @package		AceSearch
* @subpackage	AceSearch
* @copyright	2009-2011 JoomAce LLC, www.joomace.net
* @license		GNU/GPL http://www.gnu.org/copyleft/gpl.html
*/

//No Permision
defined( '_JEXEC' ) or die( 'Restricted access' );

$lang = JFactory::getLanguage();
$lang->load('com_acesearch', JPATH_SITE);

$loader = JPATH_ADMINISTRATOR.'/components/com_acesearch/library/loader.php';
if (!file_exists($loader)) {
    return;
}

require_once($loader);

$AcesearchConfig = AcesearchFactory::getConfig();

$document =& JFactory::getDocument();
$document->addStyleSheet(JURI::root().'components/com_acesearch/assets/css/acesearch.css');
if ($params->get('enable_complete', '1') == '1') {
	$document->addScript(JURI::root().'components/com_acesearch/assets/js/autocompleter.js');
}

$text = $advanced = $order = $focus  = $section = $hidden = $Itemid = $flter  = $hidden  = $advanced_fields = '';

$f = $params->get('text', 'search...');

$query = JRequest::getString('query');
if (!empty($query)) {
	$text = $query; 
	$focus = '';
}
elseif(!empty($f)) {
	$text = $f;
	$focus = 'onblur="if(this.value==\'\') this.value=\''.$text.'\';" onfocus="if(this.value==\''.$text.'\') this.value=\'\';"';
}

$box_class = $params->get('box_class', 'acesearch_input_module_simple');
if (!empty($box_class)) {
	$box_class = 'class="'.$box_class.'"';
}

$output = '<input type="text" name="query" value="'.$text.'" id="qr" '.$box_class.' '.$focus.' style="margin-right:5px;" />';

$group_id = $params->get('filter', '');

if (!empty($group_id)) {
	$flter = '&filter='.$group_id;
	$hidden = '<input type="hidden" name="filter" value="'.$group_id.'"/>';

    $extensions = AcesearchFactory::getCache()->getFilterExtensions($group_id);
	if (!empty($extensions) && is_array($extensions) && count($extensions) == 1) {
		JRequest::setVar('ext', $extensions[0]->extension, 'post');
	}
}

if ($params->get('show_advanced_search_link', '0') == '1') {
	$link = 'index.php?option=com_acesearch&view=advancedsearch'. $flter . AcesearchUtility::getItemid($group_id, true);
	$advanced = '<a style="font-size:12px;float:left;padding-left:5px;line-height:2.5em;"  href='. JRoute::_($link).' title="'.JText::_('COM_ACESEARCH_SEARCH_ADVANCED_SEARCH').'">'.JText::_('COM_ACESEARCH_SEARCH_ADVANCED_SEARCH').'</a>';
}

if ($params->get('show_order', '0') == '1') {
	$order = '<div class="advancedsearch_div">';
    $order .= '<span class="acesearch_span_label_module">';
    $order .= JText::_('COM_ACESEARCH_FIELDS_ORDER');
    $order .= '</span>';
    $order .= '<span class="acesearch_span_field_module">';
    $order .= AcesearchHTML::_renderFieldOrder('', 'class="acesearch_selectbox_module"');
    $order .= '</span>';
    $order .= '</div>';
}

if ($params->get('show_sections', '0') == '1') {
	$lists = AcesearchHTML::getExtensionList('0', '-1', '_module', '', $group_id);

	if ($lists['extension'] != '1') {
		$section = $lists['extension'];

		if ($params->get('show_sections_label', '1') == '1') {
			$section = '<div class="advancedsearch_div">';
			$section .= '<span class="acesearch_span_label_module">';
            $section .= JText::_('MOD_ACESEARCH_SEARCH_SECTION');
            $section .= '</span>';
            $section .= '<span class="acesearch_span_field_module">';
            $section .= $lists['extension'];
            $section .= '</span>';
            $section .= '</div>';
		}
	}
}

$prm_itemid = $params->get('set_itemid', '');
if (!empty($prm_itemid)) {
	$Itemid = $prm_itemid;
}
else {
	$ace_itemid = AcesearchUtility::getItemid($group_id);
	
	if (!empty($ace_itemid)) {
		$Itemid = str_replace('&Itemid=', '', $ace_itemid);
	}
}

if (!empty($Itemid)) {
	$hidden .= '<input type="hidden" name="mod_itemid" value="'.$Itemid.'"/>';
}

$ace_lang = JRequest::getWord('lang');
if (!empty($ace_lang)) {
	$hidden .= '<input type="hidden" name="lang" value="'.$ace_lang.'"/>';
}

if ($params->get('show_extra_fields', '1') == '1') {
	$advanced_fields = '<div id="custom_fields_module"></div>';
}

if ($params->get('layout', '0') == '0') {
	$section .= $advanced_fields.'<div class="acesearch_clear"></div>';
}
else {
	$advanced .= $advanced_fields;
}

require(JModuleHelper::getLayoutPath('mod_acesearch'));