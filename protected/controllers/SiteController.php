<?php

class SiteController extends Controller
{
    /**
     * Declares class-based actions.
     */
    public function actions()
    {
        return array(
            // captcha action renders the CAPTCHA image displayed on the contact page
            'captcha'=>array(
                'class'=>'CCaptchaAction',
                'backColor'=>0xFFFFFF,
            ),
            // page action renders "static" pages stored under 'protected/views/site/pages'
            // They can be accessed via: index.php?r=site/page&view=FileName
            'page'=>array(
                'class'=>'CViewAction',
            ),
        );
    }

    /**
     * This is the default 'index' action that is invoked
     * when an action is not explicitly requested by users.
     */
    public function actionIndex()
    {
        $model=new LoginForm;

        // if it is ajax validation request
        if(isset($_POST['ajax']) && $_POST['ajax']==='login-form')
        {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }

        // collect user input data
        if(isset($_POST['LoginForm']))
        {
            $model->attributes=$_POST['LoginForm'];
            // validate user input and redirect to the previous page if valid
            if($model->validate() && $model->login())
                $this->redirect(Yii::app()->user->returnUrl);
        }

        $recentItems = MediaItem::model()->findAll();
        $recentItems = array_slice(array_reverse($recentItems), 0, 5, true);

        // if user is NOT logged in
        if (!Yii::app()->user->isGuest) {
            // display the login form
            $this->render('index-user', array(
                'model'       => $model,
                'recentItems' => $recentItems,
            ));
        }
        else {
            // display the user's homepage content (e.g. some dashboard or something)
            $this->render('index-guest', array(
                'model'       => $model,
                'recentItems' => $recentItems,
            ));
        }
    }

    public function actionRegister()
    {
        $requestMethod = Yii::app()->getRequest()->getRequestType();

        if ($requestMethod === 'GET') {
            $this->render('register');
            return;
        }

        if (!isset($_POST['username'])
            || !isset($_POST['password'])
            || !isset($_POST['repeat_password'])
        ) {
            $this->redirect(Yii::app()->createUrl('/site/register'));
            return;
        }

        $users = User::model()->findAll();
        foreach ($users as $user) {
            if ($user->username === $_POST['username']) {
                $this->redirect(Yii::app()->createUrl('/site/register'));
                return;
            }
        }

        if ($_POST['password'] !== $_POST['repeat_password']) {
            $this->redirect(Yii::app()->createUrl('/site/register'));
            return;
        }

        $hash = Password::hash($_POST['password'], 12);

        $user = new User;
        $user->username = $_POST['username'];
        $user->password = $hash;

        if ($user->save()) {
            $duration = 3600*24*30; // 30 days
            Yii::app()->user->login(new UserIdentity($user->username, $user->password), $duration);
            $this->redirect(Yii::app()->createUrl('/site/index'));
            return;
        }

        $this->redirect(Yii::app()->createUrl('/site/register'));
    }

    /**
     * This is the action to handle external exceptions.
     */
    public function actionError()
    {
        if($error=Yii::app()->errorHandler->error)
        {
            if(Yii::app()->request->isAjaxRequest)
                echo $error['message'];
            else
                $this->render('error', $error);
        }
    }

    /**
     * Displays the support page
     */
    public function actionSupport()
    {
        $model=new ContactForm;
        if(isset($_POST['ContactForm']))
        {
            $model->attributes=$_POST['ContactForm'];
            if($model->validate())
            {
                $name='=?UTF-8?B?'.base64_encode($model->name).'?=';
                $subject='=?UTF-8?B?'.base64_encode($model->subject).'?=';
                $headers="From: $name <{$model->email}>\r\n".
                    "Reply-To: {$model->email}\r\n".
                    "MIME-Version: 1.0\r\n".
                    "Content-Type: text/plain; charset=UTF-8";

                mail(Yii::app()->params['adminEmail'],$subject,$model->body,$headers);
                Yii::app()->user->setFlash('contact','Thank you for contacting us. We will respond to you as soon as possible.');
                $this->refresh();
            }
        }
        $this->render('support',array('model'=>$model));
    }

    /**
     * Logs out the current user and redirect to homepage.
     */
    public function actionLogout()
    {
        Yii::app()->user->logout();
        $this->redirect(Yii::app()->homeUrl);
    }
}
