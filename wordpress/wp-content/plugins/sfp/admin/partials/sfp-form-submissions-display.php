<?php
/**
 * The view for the admin page used for listing licenses.
 *
 * @package    Wp_License_Manager
 * @subpackage Wp_License_Manager/admin/partials
 */

?>
<div class="wrap">

    <h2>
        <?php _e( 'Form Submissions', $this->plugin_name ); ?>
    </h2>

    <?php if (isset($list_table)): ?>
        <?php $list_table->display(); ?>
    <?php endif; ?>
</div>
