<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;

$this->title = 'Головна';
?>
<div class="site-index">
    <?php if (Yii::$app->user->isGuest): ?>
        <div class="body-content">
            <div class="row">
                <div class="col-lg-12">
                    <p><h4><a href="/site/register">Зареєструйся</a> або <a href="/site/login">увійди</a>.</h4></p>
                </div>
            </div>
        </div>
    <?php else: ?>

        <div class="row">
            <div class="col-lg-12">
                <?php $form = ActiveForm::begin(['id' => 'post-form']); ?>

                <?= $form->field($model, 'message')->textarea(['rows' => 8])->label('Про що зараз думаєш?')->textarea([
                        'style' => 'resize: none; min-height: 150px',
                ]) ?>

                <div class="form-group">
                    <?= Html::submitButton('Зберегти', ['class' => 'btn btn-primary', 'name' => 'post-button']) ?>
                </div>

                <?php ActiveForm::end(); ?>
            </div>
        </div>

        <div class="body-content">
            <?php foreach ($posts as $post): ?>
                <div class="post">
                    <?= $post['message'] ?>
                    <hr>
                        <div class="post-info">
                            <div class="date"><?= $post['date'] ?></div>
                            <div class="btn-del">
                                <?php $url = Url::toRoute(['site/delete', 'post_id' => $post['post_id']]); ?>
                                <a href="<?= $url ?>" class="btn btn-danger">Видалити</a>
                            </div>
                        </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>
