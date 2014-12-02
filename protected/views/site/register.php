<?php
$this->pageTitle=Yii::app()->name . ' - Register';
?>

<h1 class="media-item-name">Register</h1>
<form class="register-form" method="post">
    <label>Username
        <input type="text" name="username" maxlength="255" class="register-form-input">
    </label>
    <label>Password
        <input type="password" name="password" maxlength="255" class="register-form-input">
    </label>
    <label>Repeat Password
        <input type="password" name="repeat_password" maxlength="255">
    </label>
    <button type="submit">Create</button>
</form>
