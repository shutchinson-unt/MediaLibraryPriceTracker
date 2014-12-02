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
<p>There are many sites that buy used textbooks. They all may offer the same book but then prices will most likely differ. So, it is best to look around for the best price to make sure you getting the best deals when buying your books.</p>
<p>ePrice makes this proess of locating and buying a book easy by quickly searching all of those sites for you. Our sites technology submits the ISBN to each of the sites, just like you would. It then displays the prices from all of those sites so you can see the range of offers and decide who you want to buy from or sell it to.</p>
</div>
