<li>
    <a href="<?php echo Yii::app()->createUrl('library/view/' . $data->id); ?>">
        <div class="library-title"><?php echo $data->name; ?></div>
        <div class="library-item-count"><?php echo count($data->mediaItems); ?> Items</div>
    </a>
</li>
