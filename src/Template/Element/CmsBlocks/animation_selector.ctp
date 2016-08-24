<?php
use Cake\Core\Configure;

$animationOptions = Configure::read('Cms.BlockAnimations');
$animation = '';
$animateOnce = true;
$animationSpeed = '';
$animationDelay = '';

if(isset($widget->viewVars['block']->block_data['animation'])) {
    $animation = $widget->viewVars['block']->block_data['animation'];
}
if(isset($widget->viewVars['block']->block_data['animate_once'])) {
    $animateOnce = $widget->viewVars['block']->block_data['animate_once'];
}
if(isset($widget->viewVars['block']->block_data['animation_speed'])) {
    $animationSpeed = $widget->viewVars['block']->block_data['animation_speed'];
}
if(isset($widget->viewVars['block']->block_data['animation_delay'])) {
    $animationDelay = $widget->viewVars['block']->block_data['animation_delay'];
}

if($animationOptions != false) {
    echo $this->Form->input('block_data.animation', [
        'label' => __d('cms', 'animations'),
        'type' => 'select',
        'value' => $animation,
        'options' => $animationOptions,
    ]);

    echo $this->Form->input('block_data.animate_once', [
        'label' => __d('cms', 'animate_once'),
        'type' => 'checkbox',
        'checked' => $animateOnce
    ]);
    echo $this->Form->input('block_data.animation_speed', [
        'label' => __d('cms', 'animation_speed'),
        'type' => 'select',
        'value' => $animationSpeed,
        'options' => [
            '' => 'Normal',
            'slow' => 'Slow',
            'slower' => 'Slower',
            'slowest' => 'Slowest',
        ],
    ]);
    echo $this->Form->input('block_data.animation_delay', [
        'label' => __d('cms', 'animation_delay'),
        'type' => 'select',
        'value' => $animationDelay,
        'options' => [
            '' => 'None',
            'delay-250' => '250 ms',
            'delay-500' => '500 ms',
            'delay-750' => '750 ms',
            'delay-1000' => '1000 ms',
            'delay-1250' => '1250 ms',
            'delay-1500' => '1500 ms',
            'delay-1750' => '1750 ms',
            'delay-2000' => '2000 ms',
            'delay-2250' => '2250 ms',
            'delay-2500' => '2500 ms',
            'delay-2750' => '2750 ms',
            'delay-3000' => '3000 ms',
        ],
    ]);
}
