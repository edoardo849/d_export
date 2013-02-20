<?php
/**
 * @author edoardo849 <edoardo.s@daviom.com>
 * @copyright Copyright &copy; Daviom 2011-2013
 * Date: 1/22/13 - 4:43 PM
 */
?>
<div class="modal-header">
    <button data-dismiss="modal" class="close" type="button">×</button>
    <h3>Alert modal</h3>
</div>

<div class="modal-body">
    <p>Lorem ipsum dolor sit amet...</p>
    <?php echo $modelName; ?>
    <?php var_dump($parameters); ?>
</div>

<div class="modal-footer">
    <a data-dismiss="modal" class="btn btn-primary" href="#">Confirm</a>
    <a data-dismiss="modal" class="btn" href="#">Cancel</a>
</div>