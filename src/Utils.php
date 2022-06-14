<?php

namespace Invoiceoffice\RestSdk;

/**
 * @method \Invoiceoffice\RestSdk\Utils\OAuth2   oAuth2()
 * @method \Invoiceoffice\RestSdk\Utils\Webhooks Webhooks()
 */
class Utils
{
    public function __call(string $name, $arguments = null)
    {
        $resource = 'Invoiceoffice\\RestSdk\\Utils\\' . ucfirst($name);

        return new $resource();
    }

    public static function getFactory(): static
    {
        return new static();
    }
}
