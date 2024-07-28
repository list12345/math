<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var array $menu */

?>
<div class="account-info">

    <div class="row">
        <div class="col-md-2">
            <?php
            echo \yii\bootstrap5\Nav::widget([
                'items' => $menu,

                'options' => [
                    'class' => 'nav flex-column',
                    'style' => ['background-color' => '#ddd',],
                    'linkOptions' => ['class' => 'nav-link'],
                ], // set this to nav-tabs to get tab-styled navigation
            ]);
            ?>
        </div>

        <div class="col-md-10">

        </div>
    </div>
</div>
