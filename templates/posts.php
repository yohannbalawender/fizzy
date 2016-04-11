<?php

foreach ($posts->models as $index => $model) {
    $modifDate = $model->get('ModificationDate');
?>
    <div class="post-container">
        <h2><?php echo $model->get('Title'); ?></h2>
        <div class="post-header">
            <?php echo sprintf('Par %s le %s', $model->get('Author'), Fdate::convert($modifDate, 'SQL', 'FR_short')); ?>
        </div>
        <div class="post-content"><?php echo $model->get('Content'); ?></div>
        <!--<div class="post-footer">0 comments</div>-->
    </div>
<?php
}
?>