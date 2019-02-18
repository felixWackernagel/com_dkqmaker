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
            <?php echo $item->number; ?>
        </td>
        <td>
            <?php echo $item->quiz_number; ?>
        </td>
        <td>
            <?php echo $item->title; ?>
        </td>
        <td>
            <?php echo $item->content; ?>
        </td>
        <td>
            <?php echo $item->image; ?>
        </td>
        <td>
            <?php echo $item->online_date; ?>
        </td>
        <td>
            <?php echo $item->offline_date; ?>
        </td>
        <td>
            <?php echo $item->version; ?>
        </td>
        <td>
            <?php echo $item->last_update; ?>
        </td>
    </tr>
<?php endforeach; ?>
