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
            <a href="<?php echo $base . 'index.php?option=com_dkqmaker&view=quiz&id=' . $item->id; ?>"><?php echo $item->number; ?></a>
        </td>
        <td>
            <?php echo $item->location; ?>
        </td>
        <td>
            <?php echo $item->address; ?>
        </td>
        <td>
            <?php echo $item->quiz_date; ?>
        </td>
        <td>
            <?php echo $item->quiz_master; ?>
        </td>
        <td>
            <?php echo $item->latitude; ?>
        </td>
        <td>
            <?php echo $item->longitude; ?>
        </td>
        <td>
            <?php echo JHtml::_('jgrid.published', $item->published, $i, 'quizzes.', true, 'cb'); ?>
        </td>
        <td>
            <?php echo $item->version; ?>
        </td>
        <td>
            <?php echo $item->last_update; ?>
        </td>
    </tr>
<?php endforeach; ?>
