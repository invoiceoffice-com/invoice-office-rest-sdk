<?php

namespace Invoiceoffice\RestSdk\Resources;

/**
 * @see https://developers.invoiceoffice.com/docs/contacts-overview
 */
class Contacts extends Resource
{
    public string $resource = 'contacts';

    /**
     * Update an existing contact by email.
     *
     * @param string $email      the contact's email address
     * @param array  $properties the contact properties to update
     *
     * @return \Invoiceoffice\RestSdk\Http\Response
     *
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Invoiceoffice\RestSdk\Exceptions\BadRequest
     * @throws \Invoiceoffice\RestSdk\Exceptions\InvoiceofficeException
     *
     * @see https://developers.invoiceoffice.com/docs/methods/contacts/update_contact-by-email
     */
    public function updateByEmail(string $email, array $properties)
    {
        return $this->client->request('post', "/contacts/v1/contact/email/{$email}/profile", ['json' => ['properties' => $properties]]);
    }

    /**
     * Create or update a contact.
     *
     * @param string $email      the contact's email address
     * @param array  $properties the contact properties
     *
     * @return \Invoiceoffice\RestSdk\Http\Response
     *
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Invoiceoffice\RestSdk\Exceptions\BadRequest
     * @throws \Invoiceoffice\RestSdk\Exceptions\InvoiceofficeException
     *
     * @see https://developers.invoiceoffice.com/docs/methods/contacts/create_or_update
     */
    public function createOrUpdate(string $email, array $properties = [])
    {
        return $this->client->request('post', "/contacts/v1/contact/createOrUpdate/email/{$email}", ['json' => ['properties' => $properties]]);
    }

    /**
     * For a given portal, return all contacts that have been recently created.
     * A paginated list of contacts will be returned to you, with a maximum of 100 contacts per page, as specified by
     * the "count" parameter. The endpoint only scrolls back in time 30 days.
     *
     * @param array $params Array of optional parameters ['count', 'timeOffset', 'vidOffset', 'property',
     *                      'propertyMode', 'formSubmissionMode', 'showListMemberships']
     *
     * @return \Invoiceoffice\RestSdk\Http\Response
     *
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Invoiceoffice\RestSdk\Exceptions\BadRequest
     * @throws \Invoiceoffice\RestSdk\Exceptions\InvoiceofficeException
     *
     * @see https://developers.invoiceoffice.com/docs/methods/contacts/get_recently_updated_contacts
     */
    public function recentNew(array $params = [])
    {
        return $this->client->request('get', '/contacts/v1/lists/all/contacts/recent', [], build_query_string($params));
    }

    /**
     * Get a contact by email address.
     *
     * @param array $params Array of optional parameters ['property', 'propertyMode', 'formSubmissionMode', 'showListMemberships']
     *
     * @return \Invoiceoffice\RestSdk\Http\Response
     *
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Invoiceoffice\RestSdk\Exceptions\BadRequest
     * @throws \Invoiceoffice\RestSdk\Exceptions\InvoiceofficeException
     *
     * @see https://developers.invoiceoffice.com/docs/methods/contacts/get_contact_by_email
     */
    public function getByEmail(string $email, array $params = [])
    {
        return $this->client->request('get', "/contacts/v1/contact/email/{$email}/profile", [], build_query_string($params));
    }

    /**
     * Get a contact by its user token.
     *
     * @param array $params Array of optional parameters ['property', 'propertyMode', 'formSubmissionMode', 'showListMemberships']
     *
     * @return \Invoiceoffice\RestSdk\Http\Response
     *
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Invoiceoffice\RestSdk\Exceptions\BadRequest
     * @throws \Invoiceoffice\RestSdk\Exceptions\InvoiceofficeException
     *
     * @see https://developers.invoiceoffice.com/docs/methods/contacts/get_contact_by_utk
     */
    public function getByToken(string $utk, array $params = [])
    {
        return $this->client->request('get', "/contacts/v1/contact/utk/{$utk}/profile", [], build_query_string($params));
    }

    /**
     * For a given portal, return contacts and some data associated with
     * those contacts by the contact's email address or name.
     *
     * Please note that you should expect this method to only return a small
     * subset of data about the contact. One piece of data that the method will
     * return is the contact ID (vid) that you can then use to look up much
     * more data about that particular contact by its ID.
     *
     * @see https://developers.invoiceoffice.com/docs/methods/contacts/search_contacts
     *
     * @param string $query  Search query
     * @param array  $params Array of optional parameters ['count', 'offset']
     *
     * @return \Invoiceoffice\RestSdk\Http\Response
     *
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Invoiceoffice\RestSdk\Exceptions\BadRequest
     * @throws \Invoiceoffice\RestSdk\Exceptions\InvoiceofficeException
     */
    public function search(string $query, array $params = [])
    {
        $params['q'] = $query;

        return $this->client->request('get', '/contacts/v1/search/query', [], build_query_string($params));
    }
}
