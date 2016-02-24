<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application\Controller;

use Application\Entity\Invoice;
use Application\Pdf\InvoicePdf;
use Doctrine\ORM\EntityManager;
use Zend\Form\Annotation\AnnotationBuilder;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class InvoiceController extends AbstractActionController
{
    /** @var EntityManager */
    protected $em;

    public function indexAction()
    {
        $form = (new AnnotationBuilder())->createForm(Invoice::class);
        return new ViewModel([
            'form'  => $form
        ]);
    }
}
