<?php

/** @var yii\web\View $this */
/** @var string $content */

use app\assets\AppAsset;
use app\widgets\Alert;
use yii\bootstrap5\Breadcrumbs;
use yii\bootstrap5\Html;
use yii\bootstrap5\Nav;
use yii\bootstrap5\NavBar;

AppAsset::register($this);

$this->registerCsrfMetaTags();
$this->registerMetaTag(['charset' => Yii::$app->charset], 'charset');
$this->registerMetaTag(['name' => 'viewport', 'content' => 'width=device-width, initial-scale=1, shrink-to-fit=no']);
$this->registerMetaTag(['name' => 'description', 'content' => $this->params['meta_description'] ?? '']);
$this->registerMetaTag(['name' => 'keywords', 'content' => $this->params['meta_keywords'] ?? '']);
$this->registerLinkTag(['rel' => 'icon', 'type' => 'image/x-icon', 'href' => Yii::getAlias('@web/favicon.ico')]);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>" class="h-100">

<head>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
</head>

<body class="d-flex flex-column h-100">
    <?php $this->beginBody() ?>

    <header id="header">
        <?php
        NavBar::begin([
            'brandLabel' => Yii::$app->name,
            'brandUrl' => Yii::$app->homeUrl,
            'options' => ['class' => 'navbar-expand-md navbar-dark bg-dark fixed-top']
        ]);

        $links = [
            'options' => ['class' => 'navbar-nav'],
            'items' => [],
        ];

        if (!Yii::$app->user->isGuest) {
            $user = Yii::$app->user->identity;

            if ($user->isAdmin()) {
                addTab($links, 'Користувачі', ['/user']);
                addTab($links, 'Проєкти', ['/project']);
            }

            if ($user->isManager()) {
                addTab($links, 'Проєкти', ['/project']);
                addTab($links, 'Завдання', ['/task']);
                addTab($links, 'Проблеми', ['/issue']);
            }

            if ($user->isProgrammer()) {
                addTab($links, 'Завдання', ['/task']);
                addTab($links, 'Проблеми', ['/issue']);
                addTab($links, 'Звіт', ['/timetracker/report']);
            }
        }

        if (!Yii::$app->user->isGuest) {
            $links['items'][] = [
                'label' => 'Вийти (' . Yii::$app->user->identity->username . ')',
                'url' => ['/site/logout'],
                'linkOptions' => ['data-method' => 'post']
            ];
        } else {
            addTab($links, 'Проблеми', ['/issue']);
            addTab($links, 'Увійти', ['/site/login']);
        }

        echo Nav::widget($links);
        NavBar::end();
        ?>
    </header>

    <main id="main" class="flex-shrink-0" role="main">
        <div class="container">
            <?php if (!empty($this->params['breadcrumbs'])): ?>
                <?= Breadcrumbs::widget([
                    'homeLink' => ['label' => 'Головна', 'url' => Yii::$app->homeUrl],
                    'links' => $this->params['breadcrumbs'],
                ]) ?>
            <?php endif ?>
            <?= Alert::widget() ?>
            <?= $content ?>
        </div>
    </main>

    <footer id="footer" class="mt-auto py-3 bg-light">
        <div class="container">
            <div class="row text-muted">
                <div class="col-md-6 text-center text-md-start">&copy; Dmytro Zamkovyi <?= date('Y') ?></div>
                <div class="col-md-6 text-center text-md-end"><?= Yii::powered() ?></div>
            </div>
        </div>
    </footer>

    <?php $this->endBody() ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js" integrity="sha384-j1CDi7MgGQ12Z7Qab0qlWQ/Qqz24Gc6BM0thvEMVjHnfYGF0rmFCozFSxQBxwHKO" crossorigin="anonymous"></script>
</body>

</html>
<?php $this->endPage() ?>

<?php
function addTab(&$links, $label, $url)
{
    foreach ($links['items'] as $item) {
        if ($item['label'] === $label && $item['url'] === $url) {
            return; // вже є — не додаємо
        }
    }
    $links['items'][] = ['label' => $label, 'url' => $url];
} ?>