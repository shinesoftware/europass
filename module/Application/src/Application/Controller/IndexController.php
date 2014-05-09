<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application\Controller;

use Europass\Service\EuropassServiceInterface;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;


class IndexController extends AbstractActionController
{
/**
	 * @var \Europass\Service\EuropassServiceInterface
	 */
	protected $europassService;
	
	public function __construct(EuropassServiceInterface $europassService)
	{
		$this->europassService = $europassService;
	}
	
	public function indexAction()
	{
		// Set the locale
		$this->europassService->setLocale('fr');
		$this->europassService->setFormat('json');
		
		$pd = $this->europassService->getPersonaldata();
		$pd->setFirstname('John');
		$pd->setLastname('Doe');
		$pd->setGender('M');
		$pd->setBirthdate(date('1977-m-d'));

		$this->europassService->setPersonaldata($pd);
		
		// get th header of the page
		$header = $this->europassService->getHeader();
		header($header);
		$this->europassService->build();
		die();
	}
}
