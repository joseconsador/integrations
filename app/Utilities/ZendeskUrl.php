<?php

namespace App\Utilities;

class ZendeskUrl
{
    /**
     * Cleans up the subdomain input by the user
     *
     * @param string $input
     *
     * @return string
     */
    public function cleanSubdomain($input)
    {
        $subdomain = preg_replace(
            ['/\.' . preg_quote(config('app.zendesk_domain')) . '.*/', '/https?:\/\//'],
            ['', ''],
            $input
        );

        $subdomain = strtolower($subdomain);

        return $subdomain;
    }
}
