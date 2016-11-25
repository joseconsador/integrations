<?php
namespace App\Utilities\Facades;

use Illuminate\Support\Facades\Facade;

class ZendeskApiFacade extends Facade
{
    /**
     * {@inheritdoc}
     */
    protected static function getFacadeAccessor()
    {
        return 'zendesk.api';
    }
}
