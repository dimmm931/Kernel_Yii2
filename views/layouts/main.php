<?php

/* @var $this \yii\web\View */
/* @var $content string */

use app\widgets\Alert;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;
use yii\helpers\Url;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
    <head>
        <meta charset="<?= Yii::$app->charset ?>">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <?= Html::csrfMetaTags() ?>
        <title><?= Html::encode($this->title) ?></title>
        <?php $this->head() ?>
        <!-- Favicon -->
        <?php $this->registerLinkTag(['rel' => 'icon', 'type' => 'image/png', 'href' => Url::to(['images/favicon.ico'])]);?>	
    </head>
    <body>
    <?php $this->beginBody() ?>

        <div class="wrap">
        <?php
        NavBar::begin([
            'brandLabel' => Yii::$app->name, //Html::img('@web/images/kernel.jpg', ['alt'=>Yii::$app->name]), 
            'brandUrl' => Yii::$app->homeUrl,
            'options' => [
                'class' => 'navbar-inverse navbar-fixed-top',
            ],
        ]);
        echo Nav::widget([
            'options' => ['class' => 'navbar-nav navbar-right'],
            'items' => [
                //['label' => 'Home', 'url' => ['/site/index']],
                ['label' => 'Про нас', 'url' => ['/site/about']],
                //['label' => 'Contact', 'url' => ['/site/contact']],
			    ['label' => 'Мій кабінет', 'url' => ['/personal-account/index'] ,'visible' => (!Yii::$app->user->isGuest)],
			    ['label' => 'Реєстрація', 'url' => ['/site/signup'] ,'visible' => (Yii::$app->user->isGuest)],
			    ['label' => 'AdminPanel', 'url' => ['/admin/default/index'], 'visible' => (!Yii::$app->user->isGuest)],
			    ['label' => 'Вiдвантажити', 'url' => ['/invoice-load-out/load-out'], 'visible' => (!Yii::$app->user->isGuest)],
			    ['label' => 'Переоформити', 'url' => ['/transfer-rights/transfer-right'], 'visible' => (!Yii::$app->user->isGuest)],
			    ['label' => 'Повiдомлення', 'url' => ['/messages/show-messages'], 'visible' => (!Yii::$app->user->isGuest)], 
			    ['label' => 'Історія', 'url' => ['/transactions/mytransations'], 'visible' => (!Yii::$app->user->isGuest)],
			
                Yii::$app->user->isGuest ? (
                    ['label' => 'Login', 'url' => ['/site/login']]
                ) : (
                    '<li>'
                    . Html::beginForm(['/site/logout'], 'post')
                    . Html::submitButton(
                        'Logout (' . Yii::$app->user->identity->username . ')',
                        ['class' => 'btn btn-link logout']
                    )
                    . Html::endForm()
                    . '</li>'
                )
            ],
        ]);
    NavBar::end();
    ?>

    <div class="container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= Alert::widget() ?>
        <?= $content ?>
    </div>
</div>

<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; Kernel <?= date('Y') ?></p>
        <p class="pull-right"></p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
