<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted Access');

$base = JURI::base();
$base=substr($base,0,strlen($base)-strlen("administrator/"));
?>
<?php foreach($this->items as $i => $item): ?>
    <tr class="row<?php echo $i % 2; ?>">
        <td>
            <?php echo JHtml::_('grid.id', $i, $item->id); ?>
        </td>
        <td>
            <?php echo $item->id; ?>
        </td>
        <td>
            <?php echo $item->quiz_number; ?>
        </td>
        <td>
            <?php echo $item->number; ?>
        </td>
        <td>
            <?php echo $item->question; ?>
        </td>
        <td>
            <?php echo $item->answer; ?>
        </td>
	    <td>
	        <?php echo JHtml::_('jgrid.published', $item->published, $i, 'questions.', true, 'cb'); ?>
        </td>
        <td>
            <?php echo $item->version; ?>
        </td>
        <td>
            <?php echo $item->last_update; ?>
        </td>
        <td>
            <a href="<?php echo $base . 'index.php?option=com_dkqmaker&view=question&quiz=' . $item->quiz_number . '&question=' . $item->number; ?>">API</a>
        </td>
    </tr>
<?php endforeach; ?>
