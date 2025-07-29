<?php

namespace frontend\components;

class Gridview extends \yii\grid\GridView
{
    public $options = ['class' => 'col-md-12'];

    public $pager = [
        'pageCssClass' => ['class' => 'page-item'],
        'linkOptions' => ['class' => 'page-link'],
        'disabledListItemSubTagOptions' => ['class' => 'page-link'],
        'prevPageCssClass' => 'page-item',
        'nextPageCssClass' => 'page-item',
        'disabledPageCssClass' => 'disabled',
        'nextPageLabel' => 'Next',
        'prevPageLabel' => 'Previous',
    ];

    public $headerButtons = '';

    public $headerRowOptions = ['class' => 'sort'];

    public $tableOptions = ['class' => 'table table-striped table-hover dataTable'];

    public $dataColumnClass = DataColumn::class;

    public function init()
    {
        $header = '';
        if ($this->headerButtons){
            $header = <<<HTML
            <div class="card-header">
                <div class="row">
                    <div class="col-sm-12 col-md-6">{$this->headerButtons}</div>
                    <div class="col-sm-12 col-md-6"></div>
                </div>
            </div>
            HTML;
        }
        $this->layout = <<<HTML
        <div class="card">
            {$header}
            <div class="card-body">
                <div class="table-responsive">
                    <div class="dataTables_wrapper container-fluid dt-bootstrap4">
                        <div class="row">
                            <div class="col-sm-12 col-md-6"></div>
                            <div class="col-sm-12 col-md-6"></div>
                        </div>
                        <div class="row"><div class="col-sm-12">{items}</div></div>
                        <div class="row">
                            <div class="col-sm-12 col-md-5">{summary}</div>
                            <div class="col-sm-12 col-md-7"><div class="dataTables_paginate paging_simple_numbers">{pager}</div></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        HTML;

        parent::init();
    }

}