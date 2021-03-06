<?php

namespace Evolution7\Behat\MinkPageObjectExtension\Context;

use Behat\MinkExtension\Context\MinkContext,
    Behat\MinkExtension\Element\TraversableElement\DocumentElement;
use SensioLabs\Behat\PageObjectExtension\PageObject\Page,
    SensioLabs\Behat\PageObjectExtension\Context\PageFactory,
    SensioLabs\Behat\PageObjectExtension\Context\PageObjectAwareInterface;

/**
 * PageOjbect version of MinkContext
 *
 * Essentially we take PageObjectContext from the Behat Page Object Extension,
 * and make it extend MinkContext rather than BehatContext.
 * We then override some methods used by MinkContext so we can reference
 * pages and elements by names instead of URLs and selectors.
 */
class MinkPageObjectContext extends MinkContext implements PageObjectAwareInterface
{

    /**
     * Opens specified page, based on page object name.
     * Sets page object within context.
     */
    public function visit($page)
    {
        $page = $this->getPage($page);
        if ($page instanceof Page) {
           $this->getSession()->setPage($page);
           $page->open();
        } else {
           parent::visit($page);
        }
    }

    /**
     * @var PageFactory $pageFactory
     */
    private $pageFactory = null;

    /**
     * @param string $name
     *
     * @return Page
     *
     * @throws \RuntimeException
     */
    public function getPage($name)
    {
        if (null === $this->pageFactory) {
            throw new \RuntimeException('To create pages you need to pass a factory with setPageFactory()');
        }

        return $this->pageFactory->createPage($name);
    }

    /**
     * @param string $name
     *
     * @return Element
     *
     * @throws \RuntimeException
     */
    public function getElement($name)
    {
        if (null === $this->pageFactory) {
            throw new \RuntimeException('To create elements you need to pass a factory with setPageFactory()');
        }

        return $this->pageFactory->createElement($name);
    }

    /**
     * @param PageFactory $pageFactory
     */
    public function setPageFactory(PageFactory $pageFactory)
    {
        $this->pageFactory = $pageFactory;
    }

}
