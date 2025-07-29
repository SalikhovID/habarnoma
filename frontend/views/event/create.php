<?php

use yii\base\Model;
use frontend\models\EventForm;
use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\EventForm */

$this->title = 'Create Event';
$this->params['breadcrumbs'][] = ['label' => 'Events', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

function checkBoxInput(Model $model, $attribute, $list = [], $label = '&nbsp', $square = false, $space = null): string
{
    $class_name = basename(str_replace('\\', '/', get_class($model)));
    $result = '<div class="form-group"><div class="mb-3 field-groupform-price required">
                            <label class="form-label">'. $label .'</label>
                            <div class="selectgroup w-100 ' . ($square ? 'selectgroup-pills' : '') . '">';
    $counter = 0;
    foreach ($list as $key => $value) {
        $counter++;

        $result .= '<label class="selectgroup-item">';
        $result .= '<input type="radio" name="'.$class_name.'['.$attribute.']" value="'.$key.'" class="selectgroup-input" ' . ($model->$attribute == $key ? 'checked' : '') . '>';
        $result .= '<span class="selectgroup-button">'.$value.'</span>';
        $result .= '</label>';
        if(!is_null($value) && $counter == $space) {
            $counter = 0;
            $result .= '</div><div class="selectgroup w-100 selectgroup-pills">';
        }
    }

    $result .= '</div></div></div>';
    return $result;
}

function checkBoxInputMultiple(Model $model, $attribute, $list = [], $label = '&nbsp', $square = false, $space=null): string
{
    $class_name = basename(str_replace('\\', '/', get_class($model)));
    $result = '<div class="form-group"><div class="mb-3 field-groupform-price required">
                            <label class="form-label">'. $label .'</label>
                            <div class="selectgroup w-100 ' . ($square ? 'selectgroup-pills' : '') . '">';
    $counter = 0;
    foreach ($list as $key => $value) {
        $counter++;
        $result .= '<label class="selectgroup-item">';
        $result .= '<input type="checkbox" name="'.$class_name.'['.$attribute.'][]" value="'.$key.'" class="selectgroup-input" ' . (in_array($key, $model->$attribute ?? []) ? 'checked' : '') . '>';
        $result .= '<span class="selectgroup-button">'.$value.'</span>';
        $result .= '</label>';
        if(!is_null($value) && $counter == $space) {
            $counter = 0;
            $result .= '</div><div class="selectgroup w-100 ' . ($square ? 'selectgroup-pills' : '') . '">';
        }
    }


    $result .= '</div></div></div>';
    return $result;
}
?>
<div class="card">
    <div class="card-body">
        <div class="event-create">

            <h1><?= Html::encode($this->title) ?></h1>

            <div class="event-form">

                <?php $form = ActiveForm::begin([
                    'id' => 'event-form',
                    'options' => ['class' => 'form-horizontal'],
                ]); ?>

                <div class="row">
                    <div class="col-md-12">

                        <div class="row">
                            <div class="col-8">
                                <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label class="form-label">Color Input</label>
                                    <div class="row gutters-xs">
                                        <div class="col-auto">
                                            <label class="colorinput">
                                                <input name="EventForm[color]" type="radio" value="#000000" class="colorinput-input" <?= $model->color === '#000000' ? 'checked' : '' ?>>
                                                <span class="colorinput-color bg-black"></span>
                                            </label>
                                        </div>
                                        <div class="col-auto">
                                            <label class="colorinput">
                                                <input name="EventForm[color]" type="radio" value="#0d6efd" class="colorinput-input" <?= $model->color === '#0d6efd' ? 'checked' : '' ?>>
                                                <span class="colorinput-color bg-primary"></span>
                                            </label>
                                        </div>
                                        <div class="col-auto">
                                            <label class="colorinput">
                                                <input name="EventForm[color]" type="radio" value="#6c757d" class="colorinput-input" <?= $model->color === '#6c757d' ? 'checked' : '' ?>>
                                                <span class="colorinput-color bg-secondary"></span>
                                            </label>
                                        </div>
                                        <div class="col-auto">
                                            <label class="colorinput">
                                                <input name="EventForm[color]" type="radio" value="#0dcaf0" class="colorinput-input" <?= $model->color === '#0dcaf0' ? 'checked' : '' ?>>
                                                <span class="colorinput-color bg-info"></span>
                                            </label>
                                        </div>
                                        <div class="col-auto">
                                            <label class="colorinput">
                                                <input name="EventForm[color]" type="radio" value="#198754" class="colorinput-input" <?= $model->color === '#198754' ? 'checked' : '' ?>>
                                                <span class="colorinput-color bg-success"></span>
                                            </label>
                                        </div>
                                        <div class="col-auto">
                                            <label class="colorinput">
                                                <input name="EventForm[color]" type="radio" value="#dc3545" class="colorinput-input" <?= $model->color === '#dc3545' ? 'checked' : '' ?>>
                                                <span class="colorinput-color bg-danger"></span>
                                            </label>
                                        </div>
                                        <div class="col-auto">
                                            <label class="colorinput">
                                                <input name="EventForm[color]" type="radio" value="#ffc107" class="colorinput-input" <?= $model->color === '#ffc107' ? 'checked' : '' ?>>
                                                <span class="colorinput-color bg-warning"></span>
                                            </label>
                                        </div>
                                        <div class="col-auto">
                                            <label class="colorinput">
                                                <input name="EventForm[color]" type="radio" value="#ff69b4" class="colorinput-input" <?= $model->color === '#ff69b4' ? 'checked' : '' ?>>
                                                <span class="colorinput-color" style="background-color: #ff69b4;"></span>
                                            </label>
                                        </div>
                                        <div class="col-auto">
                                            <label class="colorinput">
                                                <input name="EventForm[color]" type="radio" value="#9c27b0" class="colorinput-input" <?= $model->color === '#9c27b0' ? 'checked' : '' ?>>
                                                <span class="colorinput-color" style="background-color: #9c27b0;"></span>
                                            </label>
                                        </div>
                                        <div class="col-auto">
                                            <label class="colorinput">
                                                <input name="EventForm[color]" type="radio" value="#ff9800" class="colorinput-input" <?= $model->color === '#ff9800' ? 'checked' : '' ?>>
                                                <span class="colorinput-color" style="background-color: #ff9800;"></span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <?= $form->field($model, 'description')->textarea(['rows' => 4]) ?>
                            </div>
                            <div class="col-md-6">
                                <?= $form->field($model, 'start_date')->input('date') ?>
                            </div>
                            <div class="col-md-6">
                                <?= $form->field($model, 'end_date')->input('date') ?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <?=checkBoxInput($model, 'repeat_type', [
                                    'daily' => 'Daily',
                                    'weekly' => 'Weekly',
                                    'monthly' => 'Monthly'
                                ], 'Report type')?>
                            </div>
                            <div class="col-6">
                                <!-- Daily repeat options -->
                                <div id="daily-options" class="repeat-options" style="display: none;">
                                    <div class="form-group">
                                        <?= $form->field($model, 'repeat_interval')->textInput([
                                            'type' => 'number',
                                            'min' => 1,
                                            'placeholder' => 'Enter number of days'
                                        ]) ?>
                                    </div>
                                </div>

                                <!-- Weekly repeat options -->
                                <div id="weekly-options" class="repeat-options" style="display: none;">
                                    <?=checkBoxInputMultiple($model, 'repeat_days_week',
                                        EventForm::getDaysOfWeekOptions(),
                                        'Report Days Week', false, 1
                                    )?>
                                </div>

                                <!-- Monthly repeat options -->
                                <div id="monthly-options" class="repeat-options" style="display: none;">
                                    <?=checkBoxInputMultiple($model, 'repeat_days_month',
                                        EventForm::getDaysOfMonthOptions(),
                                        'Report Days Month', true, 7
                                    )?>
                                </div>
                            </div>
                        </div>


<!--                            'id' => 'repeat-type-dropdown'-->



                        <!-- Event Times -->
                        <div class="form-group">
                            <?= Html::activeLabel($model, 'event_times', ['class' => 'control-label']) ?>
                            <div id="event-times-container">
                                <?php if (!empty($model->event_times)): ?>
                                    <?php foreach ($model->event_times as $index => $time): ?>
                                        <div class="event-time-row" style="margin-bottom: 10px;">
                                            <?= Html::dropDownList("EventForm[event_times][]", $time, EventForm::getTimeOptions(), [
                                                'class' => 'form-control',
                                                'style' => 'width: 120px; display: inline-block; margin-right: 10px;'
                                            ]) ?>
                                            <button type="button" class="btn btn-danger btn-sm remove-time">Remove</button>
                                        </div>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <div class="event-time-row" style="margin-bottom: 10px;">
                                        <?= Html::dropDownList("EventForm[event_times][]", '', EventForm::getTimeOptions(), [
                                            'class' => 'form-control',
                                            'style' => 'width: 120px; display: inline-block; margin-right: 10px;',
                                            'prompt' => 'Select time'
                                        ]) ?>
                                        <button type="button" class="btn btn-danger btn-sm remove-time">Remove</button>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <button type="button" id="add-time" class="btn btn-success btn-sm" style="margin-top: 10px;">Add Time</button>
                            <?= Html::error($model, 'event_times', ['class' => 'help-block']) ?>
                        </div>

                        <div class="form-group">
                            <?= Html::submitButton('Create Event', ['class' => 'btn btn-success btn-lg']) ?>
                            <?= Html::a('Cancel', ['index'], ['class' => 'btn btn-default btn-lg']) ?>
                        </div>

                    </div>
                </div>

                <?php ActiveForm::end(); ?>

            </div>

        </div>
    </div>
</div>
<?php
$timeOptions = json_encode(EventForm::getTimeOptions());
$this->registerJs("
    var timeOptions = {$timeOptions};
    
    // Define function in global scope
    function toggleRepeatOptions(type) {
        // Hide all repeat options
        $('.repeat-options').hide();
        
        // Show the selected option
        
        if (type === 'weekly') {
            $('#weekly-options').show();
        } else if (type === 'monthly') {
            $('#monthly-options').show();
        }else if(type === 'daily'){
            $('#daily-options').show();
        }
    }
    
    // Initialize on page load
    $(document).ready(function() {
        var currentType = $('[name=\"EventForm[repeat_type]\"]:checked').val();
        console.log(currentType);
        toggleRepeatOptions(currentType);
        
        // Bind change event to dropdown
        $('[name=\"EventForm[repeat_type]\"]').change(function() {
            toggleRepeatOptions($(this).val());
        });
        
        // Add time functionality
        $('#add-time').click(function() {
            var html = '<div class=\"event-time-row\" style=\"margin-bottom: 10px;\">';
            html += '<select name=\"EventForm[event_times][]\" class=\"form-control\" style=\"width: 120px; display: inline-block; margin-right: 10px;\">';
            html += '<option value=\"\">Select time</option>';
            $.each(timeOptions, function(value, text) {
                html += '<option value=\"' + value + '\">' + text + '</option>';
            });
            html += '</select>';
            html += '<button type=\"button\" class=\"btn btn-danger btn-sm remove-time\">Remove</button>';
            html += '</div>';
            
            $('#event-times-container').append(html);
        });
        
        // Remove time functionality
        $(document).on('click', '.remove-time', function() {
            if ($('.event-time-row').length > 1) {
                $(this).closest('.event-time-row').remove();
            } else {
                alert('At least one time is required.');
            }
        });
    });
", \yii\web\View::POS_END);
?>