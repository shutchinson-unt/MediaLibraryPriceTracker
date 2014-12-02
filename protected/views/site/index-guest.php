<?php
/* @var $this SiteController */
/* @var $model LoginForm */
/* @var $form CActiveForm  */

$this->pageTitle=Yii::app()->name . ' - Login';
// $this->breadcrumbs=array(
//     'Login',
// );
?>

<div class="home-form-container">
    <div class="form login-form-container">
        <h1 class="media-item-name">Sign In</h1>
        <?php $form=$this->beginWidget('CActiveForm', array(
            'id'=>'login-form',
            'enableClientValidation'=>true,
            'clientOptions'=>array(
                'validateOnSubmit'=>true,
            ),
        )); ?>

            <!-- <p class="note">Fields with <span class="required">*</span> are required.</p> -->

            <div class="row">
                <?php echo $form->labelEx($model,'username'); ?>
                <?php echo $form->textField($model,'username'); ?>
                <?php echo $form->error($model,'username'); ?>
            </div>

            <div class="row">
                <?php echo $form->labelEx($model,'password'); ?>
                <?php echo $form->passwordField($model,'password'); ?>
                <?php echo $form->error($model,'password'); ?>
        <!--         <p class="hint">
                    Hint: You may login with <kbd>demo</kbd>/<kbd>demo</kbd> or <kbd>admin</kbd>/<kbd>admin</kbd>.
                </p> -->
            </div>

            <div class="row rememberMe">
                <?php echo $form->checkBox($model,'rememberMe'); ?>
                <?php echo $form->label($model,'rememberMe'); ?>
                <?php echo $form->error($model,'rememberMe'); ?>
            </div>

            <div class="row buttons">
                <?php echo CHtml::submitButton('Sign In'); ?>
            </div>

        <?php $this->endWidget(); ?>
    </div>

    <div class="register-form-container">
        <h1 class="media-item-name">Sign Up</h1>
        <form class="register-form" method="post" action="<?php echo Yii::app()->createUrl('site/register'); ?>">
            <div class="row">
                <label>Username<br />
                    <input type="text" name="username" maxlength="255">
                </label><br />
            </div>
            <div class="row">
                <label>Password<br />
                    <input type="password" name="password" maxlength="255">
                </label><br />
            </div>
            <div class="row">
                <label>Repeat Password<br />
                    <input type="password" name="repeat_password" maxlength="255">
                </label><br />
            </div>
            <button type="submit">Create</button>
        </form>
    </div>

    <div style="clear: left;"></div>
</div>

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
