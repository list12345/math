<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $account Yii2App\Models\Account */
/* @var array $domains */
/* @var array $domain_header */
/* @var $levels array */
/* @var $next_billing_date string */
/* @var $history \Yii2App\Models\AccountHistory */
/* @var $activity_form \Yii2App\Modules\Billing\Modules\Account\Classes\ActivityForm */

?>
<div class="account-info">

    <div class="row">
        <div class="col-md-2">
            <?php
            echo \yii\bootstrap5\Nav::widget([
                'items' => [
                    ['label' => 'Home', 'url' => ['site/index'],],
                    [
                        'label' => 'Dropdown',
                        'items' => [
                            ['label' => 'Level 1 - Dropdown A', 'url' => '#'],
                            ['label' => 'Level 1 - Dropdown B', 'url' => '#'],
                        ],
                    ],
                    ['label' => 'Login', 'url' => ['site/ login'], 'visible' => Yii::$app->user->isGuest],
                    ['label' => 'Login', 'url' => ['site/ login'],],
                    ['label' => 'Login', 'url' => ['site/ login'],],
                    ['label' => 'Login', 'url' => ['site/ login'],],
                    ['label' => 'Login', 'url' => ['site/ login'],],
                ],
                'options' => ['class' => 'nav flex-column', 'style' => ['background-color' => '#ddd',]], // set this to nav-tabs to get tab-styled navigation
            ]);
            ?>
        </div>

        <div class="col-md-10">

        </div>
    </div>
</div>
