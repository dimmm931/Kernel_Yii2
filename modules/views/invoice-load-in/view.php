<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\models\InvoiceLoadIn */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Invoice Load Ins', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="invoice-load-in-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'user_kontagent_id',
            'product_nomenklatura_id',
            'date',
            'unix',
            'invoice_id',
            'elevator_id',
            'carrier',
            'driver',
            'truck',
            'truck_weight_netto',
            'truck_weight_bruto',
            'product_wight',
            'trash_content',
            'humidity',
        ],
    ]) ?>

</div>
