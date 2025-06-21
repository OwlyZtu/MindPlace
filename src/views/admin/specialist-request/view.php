<?php

/** @var yii\web\View $this */
/** @var app\models\User $doctor */

use yii\bootstrap5\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;

$this->title = Yii::t('admin', 'Profile') . ' ' . $doctor->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('admin', 'Specialists requests'), 'url' => ['/admin/specialist-request']];  
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-view">
    <div class="body-content container-fluid row row-gap-2 justify-content-center mx-auto row">
        <div class="gradient-text-alt mt-4">
            <div class="specialists-header text-center">
                <h1><?= Html::encode($this->title) ?></h1>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="card shadow-sm p-3 mb-4 bg-body-tertiary-cstm rounded-4">
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-md-8">
                                <div class="row mb-3">
                                    <h2><?= Html::encode($doctor->name) ?></h2>
                                </div>
                                <div class="row">
                                    <h3><?= Yii::t('admin', 'Main info') ?></h3>
                                    <table class="table table-striped">
                                        <tr>
                                            <th><?= Yii::t('admin', 'Email') ?>:</th>
                                            <td><?= Html::encode($doctor->email) ?></td>
                                        </tr>
                                        <tr>
                                            <th><?= Yii::t('admin', 'Contact number') ?>:</th>
                                            <td><?= Html::encode($doctor->contact_number) ?></td>
                                        </tr>
                                        <tr>
                                            <th><?= Yii::t('admin', 'Date of birth') ?>:</th>
                                            <td>
                                                <?= Html::encode($doctor->date_of_birth) ?>
                                                (<?= Html::encode($doctor->age) ?> <?= Yii::t('admin', 'years old') ?>)
                                            </td>
                                        </tr>
                                        <tr>
                                            <th><?= Yii::t('admin', 'City') ?>:</th>
                                            <td><?= Html::encode($doctor->getOptionLabel('city', 'city')) ?></td>
                                        </tr>
                                        <tr>
                                            <th><?= Yii::t('admin', 'Gender') ?>:</th>
                                            <td><?= Html::encode($doctor->getOptionLabel('gender', 'gender')) ?></td>
                                        </tr>
                                        <tr>
                                            <th><?= Yii::t('admin', 'Languages') ?>:</th>
                                            <td>

                                                <?= Html::encode(implode(', ', $doctor->getOptionLabels('language', 'language'))) ?>
                                            </td>
                                        </tr>
                                    </table>
                                </div>

                            </div>
                            <div class="col-md-4">
                                <img src="<?= Html::encode($doctor->photo_url) ?>" class="img-fluid rounded" alt="avatar">
                            </div>
                        </div>
                        <div>
                            <p class="d-inline-flex gap-1">
                                <button class="btn btn-primary" type="button" data-bs-toggle="collapse" data-bs-target="#collapseData" aria-expanded="false" aria-controls="collapseData">
                                    <?= Yii::t('admin', 'More info') ?>
                                </button>
                            </p>
                            <div class="collapse" id="collapseData">
                                <div class="card card-body row">
                                    <div class="col-md-12">
                                        <h3><?= Yii::t('admin', 'Professional info') ?></h3>
                                        <table class="table table-striped">
                                            <tr>
                                                <th><?= Yii::t('admin', 'Specialization') ?>:</th>
                                                <td><?= Html::encode(implode(', ', $doctor->getOptionLabels('specialization', 'specialization'))) ?></td>
                                            </tr>
                                            <tr>
                                                <th><?= Yii::t('admin', 'Therapy types') ?>:</th>
                                                <td><?= Html::encode(implode(', ', $doctor->getOptionLabels('therapy_types', 'therapy_types'))) ?></td>
                                            </tr>
                                            <tr>
                                                <th><?= Yii::t('admin', 'Themes') ?>:</th>
                                                <td><?= Html::encode(implode(', ', $doctor->getOptionLabels('theme', 'theme'))) ?></td>
                                            </tr>
                                            <tr>
                                                <th><?= Yii::t('admin', 'Approaches') ?>:</th>
                                                <td><?= Html::encode(implode(', ', $doctor->getOptionLabels('approach_type', 'approach_type'))) ?></td>
                                            </tr>
                                            <tr>
                                                <th><?= Yii::t('admin', 'Format') ?>:</th>
                                                <td><?= Html::encode(implode(', ', $doctor->getOptionLabels('format', 'format'))) ?></td>
                                            </tr>
                                            <tr>
                                                <th><?= Yii::t('admin', 'LGBT') ?>:</th>
                                                <td><?= $doctor->lgbt ? Yii::t('admin', 'Yes') : Yii::t('admin', 'No') ?></td>
                                            </tr>
                                            <tr>
                                                <th><?= Yii::t('admin', 'Military') ?>:</th>
                                                <td><?= $doctor->military ? Yii::t('admin', 'Yes') : Yii::t('admin', 'No') ?></td>
                                            </tr>
                                        </table>
                                    </div>
                                    <div class="col-md-12">
                                        <h3><?= Yii::t('admin', 'Education and certificates') ?></h3>
                                        <table class="table table-striped">
                                            <tr>
                                                <th><?= Yii::t('admin', 'Education') ?>:</th>
                                                <td><?= Html::encode($doctor->education_name) ?></td>
                                            </tr>
                                            <tr>
                                                <th><?= Yii::t('admin', 'Education file') ?>:</th>
                                                <td>
                                                    <?php if ($doctor->education_file): ?>
                                                        <a href="<?= Url::to(['download-education', 'id' => $doctor->id]) ?>" class="btn btn-outline-primary">
                                                            <?= Yii::t('admin', 'Download document') ?>
                                                        </a>
                                                    <?php else: ?>
                                                        <?= Yii::t('admin', 'Not loaded') ?>
                                                    <?php endif; ?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th><?= Yii::t('admin', 'Additional certificates') ?>:</th>
                                                <td>
                                                    <?php if ($doctor->additional_certification): ?>
                                                        <?= Html::encode($doctor->additional_certification) ?>
                                                    <?php else: ?>
                                                        <?= Yii::t('admin', 'Not specified') ?>
                                                    <?php endif; ?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th><?= Yii::t('admin', 'Additional certificates file') ?>:</th>
                                                <td>
                                                    <?php if ($doctor->additional_certification_file): ?>
                                                        <a href="<?= Url::to(['download-additional-certification', 'id' => $doctor->id]) ?>" class="btn btn-outline-primary">
                                                            <?= Yii::t('admin', 'Download document') ?>
                                                        </a>
                                                    <?php else: ?>
                                                        <?= Yii::t('admin', 'Not loaded') ?>
                                                    <?php endif; ?>
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                    <div class="col-md-12">
                                        <h3><?= Yii::t('admin', 'Experience') ?>:</h3>
                                        <p><?= $doctor->experience ?></p>

                                        <h3><?= Yii::t('admin', 'Social media') ?>:</h3>
                                        <p><?= $doctor->social_media ?></p>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <div class="card mt-4 p-3 bg-body-tertiary-cstm rounded-4">
        <h3><?= Yii::t('admin', 'Moderation') ?></h3>
        <?php $form = ActiveForm::begin(); ?>
        <?= $form->field($application, 'comment')->textarea(['id' => 'comment'])->label(Yii::t('admin', 'Admin comment')) ?>

        <?php if ($application->status === 'pending'): ?>
            <div class="alert alert-warning" role="alert">
                <?= Yii::t('admin', 'Pending application') ?>
            </div>
            <div class="form-group">
                <?= Html::submitButton(Yii::t('admin', 'Approve application'), [
                    'class' => 'btn btn-success',
                    'name' => 'action',
                    'value' => 'approve',
                    'formaction' => Url::to(['approve', 'id' => $application->id]),
                    'formmethod' => 'post',
                ]) ?>
                <?= Html::submitButton(Yii::t('admin', 'Reject application'), [
                    'class' => 'btn btn-danger',
                    'name' => 'action',
                    'value' => 'reject',
                    'formaction' => Url::to(['reject', 'id' => $application->id]),
                    'formmethod' => 'post',
                ]) ?>
                <?= Html::submitButton(Yii::t('admin', 'Block application'), [
                    'class' => 'btn btn-warning',
                    'name' => 'action',
                    'value' => 'block',
                    'formaction' => Url::to(['block', 'id' => $application->id]),
                    'formmethod' => 'post',
                ]) ?>
            </div>
        <?php elseif ($application->status === 'approved'): ?>
            <div class="alert alert-success" role="alert">
                <?= Yii::t('admin', 'Approved application') ?>
            </div>
            <div class="form-group">
                <?= Html::submitButton(Yii::t('admin', 'Block application'), [
                    'class' => 'btn btn-warning',
                    'name' => 'action',
                    'value' => 'block',
                    'formaction' => Url::to(['block', 'id' => $application->id]),
                    'formmethod' => 'post',
                ]) ?>
            </div>
        <?php elseif ($application->status === 'rejected'): ?>
            <div class="alert alert-danger" role="alert">
                <?= Yii::t('admin', 'Rejected application') ?>
            </div>
            <div class="form-group">
                <?= Html::submitButton(Yii::t('admin', 'Approve application'), [
                    'class' => 'btn btn-success',
                    'name' => 'action',
                    'value' => 'approve',
                    'formaction' => Url::to(['approve', 'id' => $application->id]),
                    'formmethod' => 'post',
                ]) ?>
                <?= Html::submitButton(Yii::t('admin', 'Reject application'), [
                    'class' => 'btn btn-danger',
                    'name' => 'action',
                    'value' => 'reject',
                    'formaction' => Url::to(['reject', 'id' => $application->id]),
                    'formmethod' => 'post',
                ]) ?>
                <?= Html::submitButton(Yii::t('admin', 'Block application'), [
                    'class' => 'btn btn-warning',
                    'name' => 'action',
                    'value' => 'block',
                    'formaction' => Url::to(['block', 'id' => $application->id]),
                    'formmethod' => 'post',
                ]) ?>
            </div>
        <?php elseif ($application->status === 'blocked'): ?>
            <div class="alert alert-danger" role="alert">
                <?= Yii::t('admin', 'Blocked application') ?>
            </div>
            <div class="form-group">
                <?= Html::submitButton(Yii::t('admin', 'Unblock application'), [
                    'class' => 'btn btn-warning',
                    'name' => 'action',
                    'value' => 'block',
                    'formaction' => Url::to(['unblock', 'id' => $application->id]),
                    'formmethod' => 'post',
                ]) ?>
            </div>
        <?php endif; ?>

        <?php ActiveForm::end(); ?>

    </div>
</div>


<script>
    tinymce.init({
        selector: 'textarea#comment',
        menubar: false,
        plugins: 'link lists code',
        toolbar: 'undo redo | bold italic underline | bullist numlist | link'
    });
</script>