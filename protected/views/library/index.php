<?php
/* @var $this LibraryController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Libraries',
);

$this->menu=array(
	array('label'=>'Create Library', 'url'=>array('create')),
	array('label'=>'Manage Library', 'url'=>array('admin')),
);
?>

<h1 class="media-item-name">Libraries</h1>

<ul class="library-list">
    <li>
        <div class="media-item-container add-new">
            <?php
                $library = new Library;
            ?>
            <?php $form=$this->beginWidget('CActiveForm', array(
                'id'=>'media-item-form',
                'enableAjaxValidation'=>false,
                'action' => Yii::app()->createUrl('library/create/'),
            )); ?>

                <?php echo $form->hiddenField($library,'user_id',array('size'=>10,'maxlength'=>10, 'value' => 1)); ?>

                <?php echo $form->textField($library,'name',array('value' => '', 'placeholder' => 'Name', 'size'=>60,'maxlength'=>255, 'class' => 'media-item-name-field')); ?>

                <button type="submit" class="media-item-add-button">Add New Library</button>
            <?php $this->endWidget(); ?>
        </div>
    </li>
    <br />
<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
    'enablePagination' => false,
    'summaryText' => '',
)); ?>
</ul>
