<?php
/**
 *  @package AkeebaSubs
 *  @copyright Copyright (c)2010-2012 Nicholas K. Dionysopoulos
 *  @license GNU General Public License version 3, or later
 */

defined('_JEXEC') or die();

FOFTemplateUtils::addCSS('media://com_akeebasubs/css/backend.css?'.AKEEBASUBS_VERSIONHASH);
FOFTemplateUtils::addJS('media://com_akeebasubs/js/akeebajq.js?'.AKEEBASUBS_VERSIONHASH);
FOFTemplateUtils::addJS('media://com_akeebasubs/js/backend.js?'.AKEEBASUBS_VERSIONHASH);
JHtml::_('behavior.tooltip');

$this->loadHelper('select');
$this->loadHelper('format');
$this->loadHelper('cparams');

?>

<form action="index.php" method="post" name="adminForm" id="adminForm">
<input type="hidden" name="option" value="com_akeebasubs" />
<input type="hidden" name="view" value="levels" />
<input type="hidden" id="task" name="task" value="browse" />
<input type="hidden" name="hidemainmenu" id="hidemainmenu" value="0" />
<input type="hidden" name="boxchecked" id="boxchecked" value="0" />
<input type="hidden" name="filter_order" id="filter_order" value="<?php echo $this->lists->order ?>" />
<input type="hidden" name="filter_order_Dir" id="filter_order_Dir" value="<?php echo $this->lists->order_Dir ?>" />
<input type="hidden" name="<?php echo JFactory::getSession()->getToken();?>" value="1" />

<table class="adminlist">
	<thead>
		<tr>
			<th>
				<?php echo JHTML::_('grid.sort', 'Num', 'akeebasubs_level_id', $this->lists->order_Dir, $this->lists->order) ?>
			</th>
			<th></th>
			<th>
				<?php echo JHTML::_('grid.sort', 'COM_AKEEBASUBS_LEVELS_FIELD_TITLE', 'title', $this->lists->order_Dir, $this->lists->order) ?>
			</th>
			<th width="8%">
				<?php echo JHTML::_('grid.sort', 'COM_AKEEBASUBS_LEVELS_FIELD_LEVELGROUP', 'akeebasubs_levelgroup_id', $this->lists->order_Dir, $this->lists->order) ?>
			</th>
			<th width="8%">
				<?php echo JHTML::_('grid.sort', 'COM_AKEEBASUBS_LEVELS_FIELD_DURATION', 'duration', $this->lists->order_Dir, $this->lists->order) ?>
			</th>
			<th width="5%">
				<?php echo JHTML::_('grid.sort', 'COM_AKEEBASUBS_LEVELS_FIELD_RECURRING', 'recurring', $this->lists->order_Dir, $this->lists->order) ?>
			</th>
			<th width="10%">
				<?php echo JHTML::_('grid.sort', 'COM_AKEEBASUBS_LEVELS_FIELD_PRICE', 'price', $this->lists->order_Dir, $this->lists->order) ?>
			</th>
			<th width="8%">
				<?php echo JHTML::_('grid.sort', 'JFIELD_ORDERING_LABEL', 'ordering', $this->lists->order_Dir, $this->lists->order); ?>
				<?php echo JHTML::_('grid.order', $this->items); ?>
			</th>
			<th width="8%">
				<?php echo JHTML::_('grid.sort', 'JPUBLISHED', 'enabled', $this->lists->order_Dir, $this->lists->order); ?>
			</th>			
		</tr>
		<tr>
			<td></td>
			<td>
				<input type="checkbox" name="toggle" value="" onclick="Joomla.checkAll(this);" />
			</td>
			<td>
				<input type="text" name="search" id="search"
					value="<?php echo $this->escape($this->getModel()->getState('search',''));?>"
					class="text_area" onchange="document.adminForm.submit();" />
				<button onclick="this.form.submit();">
					<?php echo JText::_('JSEARCH_FILTER'); ?>
				</button>
				<button onclick="document.adminForm.search.value='';this.form.submit();">
					<?php echo JText::_('JSEARCH_RESET'); ?>
				</button>
			</td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td>
				<?php echo AkeebasubsHelperSelect::published($this->getModel()->getState('enabled',''), 'enabled', array('onchange'=>'this.form.submit();')) ?>
			</td>
		</tr>
	</thead>
	<tfoot>
		<tr>
			<td colspan="20">
				<?php if($this->pagination->total > 0) echo $this->pagination->getListFooter() ?>	
			</td>
		</tr>
	</tfoot>
	<tbody>
		<?php if($count = count($this->items)): ?>
		<?php $i = -1; $m = 0; ?>
		<?php foreach ($this->items as $item) : ?>
		<?php
			$i++; $m = 1-$m;
			$checkedOut = ($item->locked_by != 0);
			$ordering = $this->lists->order == 'ordering';
			$item->published = $item->enabled;
		?>
		<tr class="<?php echo 'row'.$m; ?>">
			<td align="center">
				<?php echo $item->akeebasubs_level_id; ?>
			</td>
			<td>
				<?php echo JHTML::_('grid.id', $i, $item->akeebasubs_level_id, $checkedOut); ?>
			</td>
			<td align="left">
				<span class="editlinktip hasTip" title="<?php echo JText::_('COM_AKEEBASUBS_LEVEL_EDITLEVEL_TOOLTIP')?> <?php echo $this->escape($item->title); ?>::<?php echo $this->escape(substr(strip_tags($item->description), 0, 300)).'...'; ?>">
					<img src="<?php echo JURI::base(); ?>../<?php echo trim(AkeebasubsHelperCparams::getParam('imagedir', 'images/'),'/') ?>/<?php echo $item->image;?>" width="32" height="32" class="sublevelpic" />
					<a href="index.php?option=com_akeebasubs&view=level&id=<?php echo $item->akeebasubs_level_id ?>" class="subslevel">
						<strong><?php echo $this->escape($item->title) ?></strong>
					</a>
				</span>
			</td>
			<td>
				<?php echo AkeebasubsHelperFormat::formatLevelgroup($item->akeebasubs_levelgroup_id) ?>
			</td>
			<td>
				<?php echo $this->escape($item->duration) ?>
			</td>
			<td align="center">
				<?php
				if($item->recurring) {
					echo JHtml::_('image', 'admin/tick.png', null, null, true);
				} else {
					echo JHtml::_('image', 'admin/publish_x.png', null, null, true);
				}
				?>
			</td>
			<td align="right">
				<?php if(AkeebasubsHelperCparams::getParam('currencypos','before') == 'before'): ?>
				<?php echo AkeebasubsHelperCparams::getParam('currencysymbol','€')?>
				<?php endif; ?>
				<?php echo sprintf('%02.02f', (float)$item->price) ?>
				<?php if(AkeebasubsHelperCparams::getParam('currencypos','before') == 'after'): ?>
				<?php echo AkeebasubsHelperCparams::getParam('currencysymbol','€')?>
				<?php endif; ?>
			</td>
			<td class="order" align="center">
				<span><?php echo $this->pagination->orderUpIcon( $i, true, 'orderup', 'Move Up', $ordering ); ?></span>
				<span><?php echo $this->pagination->orderDownIcon( $i, $count, true, 'orderdown', 'Move Down', $ordering ); ?></span>
				<?php $disabled = $ordering ?  '' : 'disabled="disabled"'; ?>
				<input type="text" name="order[]" size="5" value="<?php echo $item->ordering;?>" <?php echo $disabled ?> class="text_area" style="text-align: center" />
			</td>
			<td align="center">
				<?php echo JHTML::_('grid.published', $item, $i); ?>
			</td>
		</tr>
		<?php endforeach ?>
		<?php else: ?>
		<tr>
			<td colspan="20">
				<?php echo  JText::_('COM_AKEEBASUBS_COMMON_NORECORDS') ?>
			</td>
		</tr>
		<?php endif; ?>
	</tbody>
</table>
</form>
