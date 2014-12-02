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
    <p>Rhoncus aenean. <em>Conubia</em> mus suscipit in molestie sed vivamus fermentum. Sem quis <em>donec</em> sociis, sagittis. Massa. Ante Auctor integer. Dui luctus. Non urna. Dictum arcu metus ultrices integer ultrices placerat. Iaculis rutrum luctus praesent nonummy et fermentum penatibus. Porttitor ad.</p>
    <p>Mus ligula ultrices iaculis quam sodales urna <em>lacus</em> egestas metus sed sapien tempus lobortis conubia torquent aliquet. Aenean. Morbi eros purus, ullamcorper <em>nunc</em> sociis duis. Massa commodo sollicitudin, ipsum, rhoncus enim, <strong>habitant</strong> elementum venenatis diam scelerisque duis et sociis lectus aliquam cum <em>fermentum</em> venenatis senectus.</p>
    <p>Erat aptent curae;, nibh porta praesent et adipiscing adipiscing dolor sagittis quisque primis. Suscipit Lacus.</p>
</div>
