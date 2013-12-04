<?php

use Behat\Mink\Session;
use SensioLabs\Behat\PageObjectExtension\Context\PageFactoryInterface;
use SensioLabs\Behat\PageObjectExtension\PageObject\Page as PageObjectPage;

class Page extends PageObjectPage
{
  
  protected $elements = array();

  /**
   * @param Session              $session
   * @param PageFactoryInterface $pageFactory
   * @param array                $parameters
   */
  public function __construct(Session $session, PageFactoryInterface $pageFactory, array $parameters = array())
  {
    if (array_key_exists('base_url', $parameters)) {
      $username = getenv('VAGRANT_DNSMASQ_USERNAME');
      $parameters['base_url'] = str_replace('<USERNAME>', $username, $parameters['base_url']);
    }
    parent::__construct($session, $pageFactory, $parameters);
  }

  /**
   * Finds link with specified locator.
   *
   * @param string $locator link id, title, text or image alt
   *
   * @return NodeElement|null
   */
  public function findLink($locator)
  {
    $locator = array_key_exists($locator, $this->elements) ? $this->elements[$locator] : $locator;
    return parent::findLink($locator);
  }

  /**
   * Finds button (input[type=submit|image|button], button) with specified locator.
   *
   * @param string $locator button id, value or alt
   *
   * @return NodeElement|null
   */
  public function findButton($locator)
  {
    $locator = array_key_exists($locator, $this->elements) ? $this->elements[$locator] : $locator;
    return parent::findButton($locator);
  }

  /**
   * Finds field (input, textarea, select) with specified locator.
   *
   * @param string $locator input id, name or label
   *
   * @return NodeElement|null
   */
  public function findField($locator)
  {
    $locator = array_key_exists($locator, $this->elements) ? $this->elements[$locator] : $locator;
    return parent::findField($locator);
  }

}
