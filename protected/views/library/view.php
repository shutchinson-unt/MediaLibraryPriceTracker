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
            <div class="form">
                <?php $form=$this->beginWidget('CActiveForm', array(
                    'id'=>'media-item-form',
                    'enableAjaxValidation'=>false,
                    'action' => Yii::app()->createUrl('mediaitem/create/' . $model->id),
                )); ?>

                    <?php echo $form->hiddenField($model,'library_id',array('size'=>10,'maxlength'=>10, 'value' => $model->id)); ?>

                    <?php echo $form->textField($model,'name',array('value' => '', 'placeholder' => 'ISBN', 'size'=>60,'maxlength'=>255, 'class' => 'media-item-name-field')); ?>

                    <button type="submit" class="media-item-add-button">Add New Media</button>
                <?php $this->endWidget(); ?>
            </div>
        </div>
    </li>

<?php foreach (array_reverse($model->mediaItems) as $mediaItem): ?>
    <li>
        <div class="media-item-container">
            <div class="media-item-image-container">
                <img class="media-item-image" src="<?php echo $mediaItem->image; ?>" />
            </div>

            <div class="media-item-info">
                <h2><?php echo $mediaItem->name; ?></h2>
                <p><strong>Author:</strong> J.K. Rowling</p>
                <p><strong>ISBN:</strong> 1442219440</p>
                <p><strong>Description:</strong> Volutpat volutpat nostra torquent vehicula inceptos fermentum</p>
            </div>

            <div class="media-item-price-container">
                <?php foreach ($mediaItem->prices as $price): ?>
                    <?php if (isset($price->type) && $price->type === 'buy'): ?>
                        <div class="media-item-price">$<?php echo $price->value; ?></div>
                    <?php endif; ?>
                <?php endforeach; ?>
                <a href="<?php echo Yii::app()->createUrl('/mediaitem/view/' . $mediaItem->id); ?>">View Prices</a>
            </div>
        </div>
    </li>
<?php endforeach; ?>
</ul>
