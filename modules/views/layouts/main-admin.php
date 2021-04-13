<?php

/* @var $this \yii\web\View */
/* @var $content string */

use app\widgets\Alert;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;
use app\assets\AdminOnlyMainModuleAsset; //main Admin js/css asset
use yii\helpers\Url;

AppAsset::register($this);
AdminOnlyMainModuleAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode("Admin Panel"/*$this->title*/) ?></title>
    <?php $this->head() ?>
	<!-- Favicon -->
	<?php $this->registerLinkTag(['rel' => 'icon', 'type' => 'image/png', 'href' => Url::to(['../images/favicon.ico'])]);?>
	
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
			['label' => 'Кабінет користувача', 'url' => ['/personal-account/index']],
			//['label' => 'Sign up', 'url' => ['/site/signup'] ,'visible' => (Yii::$app->user->isGuest)],
			['label' => 'AdminPanel', 'url' => ['/admin/default/index'] ],
			['label' => 'Реєстрація', 'url' => ['/admin/admin-x/users-registration-requests']],
			['label' => 'Запит на вiдвантаження', 'url' => ['/admin/invoice-load-out/index'] ],  
			['label' => 'Нова накладна', 'url' => ['/admin/invoice-load-in/create'] ], 
			['label' => 'Всі користувачі', 'url' => ['/admin/view-all-users/index'] ],
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
