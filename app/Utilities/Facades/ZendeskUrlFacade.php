<?php
namespace App\Utilities\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * Facade to resolve the ZendeskUrl utility
 */
class ZendeskUrlFacade extends Facade
{
    /**
     *  {@inheritdoc}
     */
    protected static function getFacadeAccessor()
    {
        return 'zendesk.url';
    }
}
