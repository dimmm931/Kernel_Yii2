<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Invoice Load Ins';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="invoice-load-in-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create new invoice ', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            //'user_kontagent_id',
			['attribute' =>'user_kontagent_id', 'label'=>'User', 'value' => 'users.email'],
            //'product_nomenklatura_id',
			['attribute' =>'product_nomenklatura_id', 'label'=>'Product', 'value' => 'products.pr_name_name'], 
            'date',
            'unix',
            //'invoice_id',
            //'elevator_id',
            //'carrier',
            //'driver',
            //'truck',
            //'truck_weight_netto',
            //'truck_weight_bruto',
            //'product_wight',
            //'trash_content',
            //'humidity',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
