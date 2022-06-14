<?php

namespace spec\Invoiceoffice\RestSdk;

use PhpSpec\ObjectBehavior;

class FactorySpec extends ObjectBehavior
{
    public function let()
    {
        $this->beConstructedThrough('create', ['demo']);
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType('Invoiceoffice\RestSdk\Factory');
    }

    public function it_creates_a_blogs_api_class()
    {
        $this->blogs()->shouldHaveType('Invoiceoffice\RestSdk\Resources\Blogs');
    }

    public function it_creates_a_blogAuthors_api_class()
    {
        $this->blogAuthors()->shouldHaveType('Invoiceoffice\RestSdk\Resources\BlogAuthors');
    }

    public function it_creates_a_blogPosts_api_class()
    {
        $this->blogPosts()->shouldHaveType('Invoiceoffice\RestSdk\Resources\BlogPosts');
    }

    public function it_creates_a_blogTopics_api_class()
    {
        $this->blogTopics()->shouldHaveType('Invoiceoffice\RestSdk\Resources\BlogTopics');
    }

    public function it_creates_a_contacts_api_class()
    {
        $this->contacts()->shouldHaveType('Invoiceoffice\RestSdk\Resources\Contacts');
    }

    public function it_creates_a_contactLists_api_class()
    {
        $this->contactLists()->shouldHaveType('Invoiceoffice\RestSdk\Resources\ContactLists');
    }

    public function it_creates_a_contactProperties_api_class()
    {
        $this->contactProperties()->shouldHaveType('Invoiceoffice\RestSdk\Resources\ContactProperties');
    }

    public function it_creates_a_email_api_class()
    {
        $this->emailSubscription()->shouldHaveType('Invoiceoffice\RestSdk\Resources\EmailSubscription');
    }

    public function it_creates_a_emailEvents_api_class()
    {
        $this->emailEvents()->shouldHaveType('Invoiceoffice\RestSdk\Resources\EmailEvents');
    }

    public function it_creates_a_files_api_class()
    {
        $this->files()->shouldHaveType('Invoiceoffice\RestSdk\Resources\Files');
    }

    public function it_creates_a_forms_api_class()
    {
        $this->forms()->shouldHaveType('Invoiceoffice\RestSdk\Resources\Forms');
    }

    public function it_creates_a_keywords_api_class()
    {
        $this->keywords()->shouldHaveType('Invoiceoffice\RestSdk\Resources\Keywords');
    }

    public function it_creates_a_pages_api_class()
    {
        $this->pages()->shouldHaveType('Invoiceoffice\RestSdk\Resources\Pages');
    }

    public function it_creates_a_socialMedia_api_class()
    {
        $this->socialMedia()->shouldHaveType('Invoiceoffice\RestSdk\Resources\SocialMedia');
    }

    public function it_creates_a_workflows_api_class()
    {
        $this->workflows()->shouldHaveType('Invoiceoffice\RestSdk\Resources\Workflows');
    }

    public function it_creates_an_events_api_class()
    {
        $this->events()->shouldHaveType('Invoiceoffice\RestSdk\Resources\Events');
    }

    public function it_creates_a_company_properties_api_class()
    {
        $this->companyProperties()->shouldHaveType('Invoiceoffice\RestSdk\Resources\CompanyProperties');
    }
}
