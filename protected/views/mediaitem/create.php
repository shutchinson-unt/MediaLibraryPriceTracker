<?php
/* @var $this MediaitemController */
/* @var $model MediaItem */

$this->breadcrumbs=array(
	'Media Items'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List MediaItem', 'url'=>array('index')),
	array('label'=>'Manage MediaItem', 'url'=>array('admin')),
);
?>

<h1>Create MediaItem</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>