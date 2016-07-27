<?php
/**
 * 	BookaTable Component Administrator Bookings View
 *
 * 	@package    	com_bookatable
 * 	@subpackage 	components
 * 	@link
 * 	@license			GNU/GPL
 */
// No direct access
defined('_JEXEC') or die('Restricted access');
JHtml::_('behavior.tooltip');
JHTML::_('script','system/multiselect.js',false,true);


$listOrder = $this->escape($this->state->get('list.ordering'));
$listDirn = $this->escape($this->state->get('list.direction'));
?>

<form
    action="<?php echo JRoute::_('index.php?option=com_bookatable&view=bookings'); ?>"
    method="post" name="adminForm" id="adminForm">

<?php if (!empty($this->sidebar)): ?>
        <div id="j-sidebar-container" class="span2">
        <?php echo $this->sidebar; ?>
        </div>
        <div id="j-main-container" class="span10">
<?php else : ?>
            <div id="j-main-container">
        <?php endif; ?>


            <div id="filter-bar" class="btn-toolbar">
                <div class="btn-group pull-right hidden-phone">
                    <label for="limit" class="element-invisible"><?php echo JText::_('JFIELD_PLG_SEARCH_SEARCHLIMIT_DESC'); ?>
                    </label>
<?php echo $this->pagination->getLimitBox(); ?>
                </div>
                <div class="filter-search btn-group pull-left">
                    <input type="text" name="filter_search"
                           placeholder="<?php echo JText::_('JSEARCH_FILTER_LABEL'); ?>"
                           id="filter_search"
                           value="<?php echo $this->escape($this->state->get('filter.search')); ?>"
                           title="<?php echo JText::_('JSEARCH_FILTER'); ?>" />
                </div>
                <div class="btn-group pull-left">
                    <button class="btn tip hasTooltip" type="submit"
                            title="<?php echo JText::_('JSEARCH_FILTER_SUBMIT'); ?>">
                        <i class="icon-search"></i>
                    </button>
                    <button class="btn tip hasTooltip" type="button"
                            onclick="document.id('filter_search').value = '';this.form.submit();"
                            title="<?php echo JText::_('JSEARCH_FILTER_CLEAR'); ?>">
                        <i class="icon-remove"></i>
                    </button>

                </div>
            </div>
            <div class="clearfix"></div>
<?php if (count($this->items)) : ?>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th width="20"><input type="checkbox" name="checkall-toggle"
                                                  value="" title="<?php echo JText::_('JGLOBAL_CHECK_ALL'); ?>"
                                                  onclick="Joomla.checkAll(this)" />
                            </th>
                            <th><?php echo JHtml::_('grid.sort', 'date', 'a.date', $listDirn, $listOrder); ?>
                            </th>
                            <th><?php echo JHtml::_('grid.sort', 'table', 't.name', $listDirn, $listOrder); ?>
                            </th>
                            <th><?php echo JHtml::_('grid.sort', 'user', 'u.username', $listDirn, $listOrder); ?>
                            </th>
                            <th><?php echo JHtml::_('grid.sort', 'evening', 'a.evening', $listDirn, $listOrder); ?>
                            </th>
                            <th><?php echo JHtml::_('grid.sort', 'units', 'a.units', $listDirn, $listOrder); ?>
                            </th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <td colspan="6"><?php echo $this->pagination->getListFooter(); ?>
                            </td>
                        </tr>
                    </tfoot>

                    <tbody>
    <?php foreach ($this->items as $i => $item): ?>
                            <tr>
                                <td><?php echo JHtml::_('grid.id', $i, $item->id); ?>
                                </td>
                                <td><a href="<?php echo JRoute::_('index.php?option=com_bookatable&task=booking.edit&id=' . $item->id); ?>" title="<?php echo JText::_('JACTION_EDIT'); ?>">
                                        <?php echo JHTML::_('date', $item->date, JTEXT::_('Y/m/d')); ?></a>
                                </td>
                                <td><?php echo $item->table; ?>
                                </td>
                                <td><?php echo $item->user; ?>
                                </td>
                                <td><?php echo ($item->evening == 1 ? JText::_('evening') : JText::_('mourning')); ?>
                                </td>
                                <td><?php echo ($item->units == 1 ? JText::_('entire') : JText::_('half')); ?>
                                </td>

                            </tr>
    <?php endforeach; ?>

                    </tbody>

                </table>
<?php endif; ?>
            <div>
                <input type="hidden" name="task" value="" />
                <input type="hidden" name="boxchecked" value="0" />
                <input type="hidden" name="filter_order" value="<?php echo $listOrder; ?>" />
                <input type="hidden" name="filter_order_Dir" value="<?php echo $listDirn; ?>" />
<?php echo JHtml::_('form.token'); ?>
            </div>

            </form>

