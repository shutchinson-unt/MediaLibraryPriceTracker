<?php
/* @var $this MediaitemController */
/* @var $model MediaItem */

$this->breadcrumbs=array(
	'Media Items'=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List MediaItem', 'url'=>array('index')),
	array('label'=>'Create MediaItem', 'url'=>array('create')),
	array('label'=>'View MediaItem', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage MediaItem', 'url'=>array('admin')),
);
?>

<h1>Update MediaItem <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>