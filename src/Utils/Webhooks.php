<?php

namespace Invoiceoffice\RestSdk\Utils;

class Webhooks
{
    /**
     * Validation of Invoiceoffice Signature.
     *
     * @param string $signature   Invoiceoffice signature
     * @param string $secret      the Secret of your app
     * @param string $requestBody a set of scopes that your app will need access to
     */
    public static function isInvoiceofficeSignatureValid(string $signature, string $secret, string $requestBody): bool
    {
        return $signature === hash('sha256', $secret . $requestBody);
    }
}
