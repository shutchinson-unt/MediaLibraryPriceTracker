<?php
/* @var $this MediaitemController */
/* @var $model MediaItem */

$this->breadcrumbs=array(
	'Media Items'=>array('index'),
	$model->name,
);

$this->menu=array(
	array('label'=>'List MediaItem', 'url'=>array('index')),
	array('label'=>'Create MediaItem', 'url'=>array('create')),
	array('label'=>'Update MediaItem', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete MediaItem', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage MediaItem', 'url'=>array('admin')),
);
?>

<h1>View MediaItem #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'library_id',
		'name',
	),
)); ?>
