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

<h1>Libraries</h1>

<ul>
<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
</ul>
