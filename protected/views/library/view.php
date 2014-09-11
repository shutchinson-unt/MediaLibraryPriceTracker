<?php
/* @var $this LibraryController */
/* @var $model Library */

$this->breadcrumbs=array(
    'Libraries'=>array('index'),
    $model->name,
);

$this->menu=array(
    array('label'=>'List Library', 'url'=>array('index')),
    array('label'=>'Create Library', 'url'=>array('create')),
    array('label'=>'Update Library', 'url'=>array('update', 'id'=>$model->id)),
    array('label'=>'Delete Library', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
    array('label'=>'Manage Library', 'url'=>array('admin')),
);
?>

<h1><?php echo $model->name; ?></h1>

<ul class="media-item-list">
    <li>
        <div class="media-item-container">
            <?php echo CHtml::link('Add New Media', array('mediaitem/create/' . $model->id), array('style' => 'background: #00e0f9')); ?>
        </div>
    </li>
<?php foreach ($model->mediaItems as $mediaItem): ?>
    <li>
        <div class="media-item-container">
            <a href="#"><?php echo $mediaItem->name; ?></a>
            <?php foreach ($mediaItem->prices as $price): ?>
                <?php if (isset($price->type)): ?>
                    <?php if ($price->type === 'buy'): ?>
                        <div class="buy-price">$<?php echo $price->value; ?></div>
                    <?php elseif ($price->type === 'sell'): ?>
                        <div class="sell-price">$<?php echo $price->value; ?></div>
                    <?php endif; ?>
                <?php endif; ?>
            <?php endforeach; ?>
        </div>
    </li>
<?php endforeach; ?>
</ul>
