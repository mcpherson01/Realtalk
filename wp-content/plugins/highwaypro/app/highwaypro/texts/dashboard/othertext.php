<?php

namespace HighWayPro\App\HighWayPro\Texts\Dashboard;

use HighWayPro\App\HighWayPro\Texts\TextComponent;
use HighWayPro\Original\Collections\Collection;
use HighWayPro\Original\Environment\Env;

Class OtherText extends TextComponent
{
    const name = 'other';

    protected static function registerTexts()
    {
        return new Collection([
            'loading' => esc_html__('Loading', Env::textDomain()),
            'saving' => esc_html__('Saving', Env::textDomain()),
            'deleting' => esc_html__('Deleting', Env::textDomain()),
            'create' => esc_html__('create', Env::textDomain()),
            'cancel' => esc_html__('cancel', Env::textDomain()),
            'ok'     => esc_html__('ok', Env::textDomain()),
            'goBack' => esc_html__('Back', Env::textDomain()),
            'details' => [
                'success' => esc_html__('Success Details', Env::textDomain()),
                'error' => esc_html__('Error Details', Env::textDomain()),
                'details' => esc_html__('Details', Env::textDomain()),
            ]
        ]);
    }
    
}