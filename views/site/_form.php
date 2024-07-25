<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\forms\UserForm;

/* @var $this yii\web\View */
/* @var $model UserForm */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php echo $form->errorSummary($model); ?>

    <?php echo $form->field($model, 'username')->textInput(['maxlength' => true]); ?>
    <?php echo $form->field($model, 'email')->textInput(['maxlength' => true]); ?>

    <?php echo $form->field($model, 'firstname')->textInput(['maxlength' => true]); ?>
    <?php echo $form->field($model, 'lastname')->textInput(['maxlength' => true]); ?>

    <?php
    if ($model->getScenario() != 'update') {
        echo $form->field($model, 'password')->passwordInput();
        echo $form->field($model, 'password1')->passwordInput();
    }
    ?>
    <div class="form-group">
        <?php
        echo Html::submitButton(
        '<span class="glyphicon glyphicon-ok"></span> Save',
        ['class' => 'btn btn-primary']
    );
        echo Html::a(
            '<span class="glyphicon glyphicon-remove"></span> Cancel',
            ['index'],
            ['class' => 'btn btn-default m-l-5']
        );
        ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
