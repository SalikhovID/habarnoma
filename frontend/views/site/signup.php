<?php

/** @var yii\web\View $this */
/** @var yii\bootstrap5\ActiveForm $form */
/** @var \frontend\models\SignupForm $model */

use yii\bootstrap5\Html;
use yii\bootstrap5\ActiveForm;

$this->title = 'Signup';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="box-root padding-top--24 flex-flex flex-direction--column" style="flex-grow: 1; z-index: 9;">
    <div class="box-root padding-top--48 padding-bottom--24 flex-flex flex-justifyContent--center">
        <h1><a href="http://blog.stackfindover.com/" rel="dofollow">Stackfindover</a></h1>
    </div>
    <div class="formbg-outer">
        <div class="formbg">
            <div class="formbg-inner padding-horizontal--48">
                <span class="padding-bottom--15">Sign in to your account</span>
                <?php $form = ActiveForm::begin(['id' => 'form-signup']); ?>
                <div class="row">
                    <div class="col-6">
                        <?= $form->field($model, 'first_name')->textInput(['autofocus' => true]) ?>
                    </div>
                    <div class="col-6">
                        <?= $form->field($model, 'last_name')->textInput(['autofocus' => true]) ?>
                    </div>
                    <div class="col-12">
                        <?= $form->field($model, 'username')->textInput(['autofocus' => true]) ?>
                    </div>
                    <div class="col-6">
                        <?= $form->field($model, 'password')->passwordInput() ?>
                    </div>
                    <div class="col-6">
                        <?= $form->field($model, 'repeat_password')->passwordInput() ?>
                    </div>
                </div>



                <div class="form-group">
                    <?= Html::submitButton('Signup', ['class' => 'btn btn-primary', 'name' => 'signup-button']) ?>
                </div>

                <?php ActiveForm::end(); ?>
            </div>
        </div>
        <div class="footer-link padding-top--24">
            <span>Don't have an account? <a href="/site/login">Login</a></span>
            <div class="listing padding-top--24 padding-bottom--24 flex-flex center-center">
                <span><a href="#">© Stackfindover</a></span>
                <span><a href="#">Contact</a></span>
                <span><a href="#">Privacy & terms</a></span>
            </div>
        </div>
    </div>
</div>
