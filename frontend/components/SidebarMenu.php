<?php

namespace frontend\components;

use yii\bootstrap5\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\Menu;

class SidebarMenu extends Menu
{
    public $options = ['class' => 'nav nav-secondary'];
    public $itemOptions = ['class' => 'nav-item'];
    public $linkTemplate = '';

    protected function renderItems($items, $subItems = false)
    {

        $n = count($items);
        $lines = [];
        foreach ($items as $i => $item) {

            $options = array_merge($this->itemOptions, ArrayHelper::getValue($item, 'options', []));
            $tag = ArrayHelper::remove($options, 'tag', 'li');
            $class = [];

            // Check if item or any of its children are active
            if ($this->isItemOrChildActive($item)) {
                if($subItems){
                    $class[] = $this->activeCssClass;
                }else{
                    $class[] = 'collapsed submenu';
                }
                $item['active'] = true; // Mark parent as active if any child is active
            } else {
                // Only add "collapsed" class if the item is not active
                $class[] = 'collapsed';
            }

            if ($i === 0 && $this->firstItemCssClass !== null) {
                $class[] = $this->firstItemCssClass;
            }
            if ($i === $n - 1 && $this->lastItemCssClass !== null) {
                $class[] = $this->lastItemCssClass;
            }
            Html::addCssClass($options, $class);

            $icon = isset($item['icon']) ? '<i class="'. ($item['icon-group'] ?? 'fas') .' '. $item['icon'] .'"></i>' : '';
            if (!empty($item['items'])) {
                $item['url'] = "#item_{$i}";
                $this->linkTemplate = '<a data-bs-toggle="collapse" href="{url}">'.$icon.'<p>{label}</p><span class="caret"></span></a>';
            } else {
                $this->linkTemplate = '<a href="{url}">'.$icon.'<p>{label}</p></a>';
                if($subItems){
                    $this->linkTemplate = '<a href="{url}"><span class="sub-item">{label}</span></a>';
                }
            }
            $menu = $this->renderItem($item);
            if (!empty($item['items'])) {

                $template = "<div class='collapse ".($item['active'] ? 'show' : '') ."' id='item_{$i}'><ul class='nav nav-collapse'>\n{items}\n</ul></div>";
                $submenuTemplate = ArrayHelper::getValue($item, 'submenuTemplate', $template);
                $menu .= strtr($submenuTemplate, [
                    '{items}' => $this->renderItems($item['items'], true),
                ]);

            }
            $lines[] = Html::tag($tag, $menu, $options);
        }

        return implode("\n", $lines);
    }

    protected function isItemOrChildActive($item)
    {
        // If the item itself is active
        if (isset($item['active']) && $item['active']) {
            return true;
        }

        // Check if any child item is active
        if (!empty($item['items'])) {
            foreach ($item['items'] as &$child) {
                if ($this->isItemOrChildActive($child)) {
                    $child['active'] = true; // Mark child as active
                    return true;
                }
            }
        }

        return false;
    }
}