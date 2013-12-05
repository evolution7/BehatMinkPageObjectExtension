<?php

namespace Evolution7\Behat\MinkPageObjectExtension\PageObject;

use Behat\Mink\Session;
use SensioLabs\Behat\PageObjectExtension\Context\PageFactoryInterface;
use SensioLabs\Behat\PageObjectExtension\PageObject\Page as PageObjectPage;

class Page extends PageObjectPage
{
  
  protected $aliases = array();

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
   * Replace alias with value.
   * If no matching alias found, value passed is returned.
   *
   * @param string $alias
   * @return string $value
   */
  public function parseAlias($alias)
  {
    if (array_key_exists($alias, $this->aliases)) {
      return $this->aliases[$alias];
    } else {
      return $alias;
    }
  }

  /**
   * Finds element by it's id.
   *
   * @param string $id element id
   *
   * @return NodeElement|null
   */
  public function findById($id)
  {
    return parent::findById($this->parseAlias($id));
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
    return parent::findLink($this->parseAlias($locator));
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
    return parent::findButton($this->parseAlias($locator));
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
    return parent::findField($this->parseAlias($locator));
  }

}
