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

<h1 class="media-item-name"><?php echo $model->name; ?></h1>

<ul class="media-item-list">
    <li>
        <div class="media-item-container add-new">
            <?php echo CHtml::link('Add New Media', array('mediaitem/create/' . $model->id), array('style' => 'width: 96%;')); ?>
        </div>
    </li>
<?php foreach ($model->mediaItems as $mediaItem): ?>
    <li>
        <div class="media-item-container">
            <div class="media-item-image-container">
                <div class="media-item-image"></div>
            </div>

            <div class="media-item-info">
                <h2><?php echo $mediaItem->name; ?></h2>
                <p><strong>Author:</strong> J.K. Rowling</p>
                <p><strong>ISBN:</strong> 1442219440</p>
                <p><strong>Description:</strong> Volutpat volutpat nostra torquent vehicula inceptos fermentum</p>
            </div>

            <div class="media-item-price-container">
                <div class="media-item-price">$1234</div>
                <a href="<?php echo Yii::app()->createUrl('/mediaitem/view/' . $mediaItem->id); ?>">View Prices</a>
            </div>
        </div>
    </li>
<?php endforeach; ?>
</ul>
