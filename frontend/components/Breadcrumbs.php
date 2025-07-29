<?php

namespace frontend\components;

use Yii;
use yii\helpers\Html;

class Breadcrumbs extends \yii\bootstrap5\Breadcrumbs
{
    public $tag = 'ul';
    public $options = ['class' => 'breadcrumbs mb-3'];
    public $navOptions = ['class' => 'page-header'];
    public $itemTemplate = "<li class='nav-item'>{link}</li>\n<li class='separator'><i class='icon-arrow-right'></i></li>\n";
    public $activeItemTemplate = "<li class='nav-item'>{link}</li>\n";
    public $homeLink = [
        'label' => '<i class="icon-home"></i>',
        'url' => ['/'],
        'encode' => false,
        'template' => "<li class='nav-home'>{link}</li>\n<li class='separator'><i class='icon-arrow-right'></i></li>\n",
    ];
    public $heading = 'Habarnoma'; // Custom heading

    public function run(): string
    {
        if (empty($this->links)) {
            return '';
        }

        // Normalize links
        $links = [];
        foreach ($this->links as $key => $value) {
            if (is_array($value)) {
                $links[] = $value;
            } else {
                $links[] = ['label' => $value, 'url' => is_string($key) ? $key : null];
            }
        }
        $this->links = $links;
        unset($links);

        if ($this->homeLink === []) {
            $this->homeLink = null;
        }

        if (!isset($this->options['id'])) {
            $this->options['id'] = "{$this->getId()}-breadcrumb";
        }
        \yii\bootstrap5\Html::addCssClass($this->options, ['widget' => 'breadcrumb']);

        // parent method not return result
        ob_start();
        self::prepare();
        $content = ob_get_clean();

        return Html::tag('div', $content, $this->navOptions);
    }

    public function prepare(): void
    {
        if (empty($this->links)) {
            return;
        }
        $links = [];
        if ($this->homeLink === null) {
            $links[] = $this->renderItem([
                'label' => Yii::t('yii', 'Home'),
                'url' => Yii::$app->homeUrl,
            ], $this->itemTemplate);
        } elseif ($this->homeLink !== false) {
            $links[] = $this->renderItem($this->homeLink, $this->itemTemplate);
        }
        foreach ($this->links as $link) {
            if (!is_array($link)) {
                $link = ['label' => $link];
            }
            $links[] = $this->renderItem($link, isset($link['url']) ? $this->itemTemplate : $this->activeItemTemplate);
        }
        echo "<h3 class='fw-bold mb-3'>{$this->heading}</h3>";
        echo Html::tag($this->tag, implode('', $links), $this->options);
    }
}