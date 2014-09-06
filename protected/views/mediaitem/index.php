<?php
/* @var $this MediaitemController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Media Items',
);

$this->menu=array(
	array('label'=>'Create MediaItem', 'url'=>array('create')),
	array('label'=>'Manage MediaItem', 'url'=>array('admin')),
);
?>

<h1>Media Items</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
