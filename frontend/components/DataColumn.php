<?php

namespace frontend\components;

use yii\helpers\Html;

class DataColumn extends \yii\grid\DataColumn
{
    public $sortLinkOptions = ['class' => 'nav-link'];
    protected function renderHeaderCellContent()
    {
        if ($this->header !== null || $this->label === null && $this->attribute === null) {
            return parent::renderHeaderCellContent();
        }

        $label = $this->getHeaderCellLabel();
        if ($this->encodeLabel) {
            $label = Html::encode($label);
        }

        if (
            $this->attribute !== null && $this->enableSorting &&
            ($sort = $this->grid->dataProvider->getSort()) !== false && $sort->hasAttribute($this->attribute)
        ) {
            $headerClass = 'sorting';
            if (($direction = $sort->getAttributeOrder($this->attribute)) !== null) {
                $headerClass = $direction === SORT_DESC ? 'sorting_desc' : 'sorting_asc';
            }
            $this->headerOptions['class'] = $headerClass;
            return $sort->link($this->attribute, array_merge($this->sortLinkOptions, ['label' => $label]));
        }
        $this->headerOptions['class'] = '';
        return $label;
    }
}