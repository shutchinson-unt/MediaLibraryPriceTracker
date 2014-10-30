<?php
/* @var $this SiteController */
/* @var $model LoginForm */
/* @var $form CActiveForm  */

$this->pageTitle=Yii::app()->name;
?>

You're logged in as <strong><?php echo Yii::app()->user->name; ?></strong>
<br />
<br />

<h1 class="media-item-name">Recent Offers</h1>
<ul class="recent-media-items">
    <?php foreach ($recentItems as $recentItem): ?>
        <li>
            <div class="image-container">
                <img src="<?php echo $recentItem->image; ?>" />
            </div>

            <div class="recent-media-item-name"><?php echo trim(implode(' ', array_slice(explode(' ', $recentItem->name), 0, 8))); ?></div>

            <?php foreach ($recentItem->prices as $price): ?>
                <?php if (isset($price->type) && $price->type === 'buy'): ?>
                    <div class="recent-media-item-price"> $<?php echo $price->value; ?></div>
                <?php endif; ?>
            <?php endforeach; ?>

            <a href="<?php echo Yii::app()->createUrl('/mediaitem/view/' . $recentItem->id); ?>">View Prices</a>
        </li>
    <?php endforeach; ?>
</ul>

<div class="about-us">
    <h1 class="media-item-name">What is ePrice?</h1>
    <p>Rhoncus aenean. <em>Conubia</em> mus suscipit in molestie sed vivamus fermentum. Sem quis <em>donec</em> sociis, sagittis. Massa. Ante Auctor integer. Dui luctus. Non urna. Dictum arcu metus ultrices integer ultrices placerat. Iaculis rutrum luctus praesent nonummy et fermentum penatibus. Porttitor ad.</p>
    <p>Mus ligula ultrices iaculis quam sodales urna <em>lacus</em> egestas metus sed sapien tempus lobortis conubia torquent aliquet. Aenean. Morbi eros purus, ullamcorper <em>nunc</em> sociis duis. Massa commodo sollicitudin, ipsum, rhoncus enim, <strong>habitant</strong> elementum venenatis diam scelerisque duis et sociis lectus aliquam cum <em>fermentum</em> venenatis senectus.</p>
    <p>Erat aptent curae;, nibh porta praesent et adipiscing adipiscing dolor sagittis quisque primis. Suscipit Lacus.</p>
</div>
