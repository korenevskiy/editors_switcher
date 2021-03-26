<?php
defined('_JEXEC') or die;

JHtml::_('behavior.framework');

//onchange
$js = 'onchange="';
if ($confirmation)
{
	$this->loadLanguage('plg_editors_switcher', JPATH_PLUGINS . '/editors/switcher');
	$js .= 'if(this.options.selectedIndex != ' . $index . ' && confirm(\''
			. JText::_('PLG_EDITORS_SWITCHER_CONFIRM_MESSAGE_TITLE', true)
			. '\r\n' . JText::_('PLG_EDITORS_SWITCHER_CONFIRM_MESSAGE_BODY', true) . '\')'
			. '){';
	$js .= 'jQuery(\'#editorswitcher-currentvalue\').value = this.options.selectedIndex;';
}

$domain = JURI::getInstance()->getHost();
$days   = intval($params->get('cookie_days', 365));
$js     .= "Cookie.write('$this->cookiename', this.value, {duration:'$days', domain:'$domain'});";
$js     .= "Cookie.write('$this->cookiename', this.value, {duration:$days});window.location.reload();";

if ($confirmation)
{
	$js .= '} else {var curSelected = \'#jswitcheditor_chzn_o_\'+jswitcherEditors[document.id(\'editorswitcher-currentvalue\').value];
					if(jQuery(curSelected))jQuery(curSelected).trigger(\'mouseup\');}';
}
$js .= '"';
?>
<div id="switcherSelector" class="btn-toolbar">
	<input type="hidden" id="editorswitcher-currentvalue" value="<?php echo $current; ?>" />
		<?php echo JHtml::_('select.genericlist', $editors, 'switcheditor' . ''
				, 'class="btn" ' . $js, 'value', 'text', $current, 'jswitcheditor'); ?>
</div>
<?php
// Write html and move and init list index
$array = json_encode($array);
$js    = "var jswitcherEditors = $array;window.addEvent('domready', function(){var btnwrap = $$('#editor-xtd-buttons .btn-toolbar');if(btnwrap.length > 0)"
		. " document.id('switcherSelector').inject(btnwrap[0]);	setTimeout(function(){var curSelected = '#jswitcheditor_chzn_o_'+$index;if(jQuery(curSelected)) jQuery(curSelected).trigger('mouseup');}, 1000);});";
JFactory::getDocument()->addScriptDeclaration($js);
?>
