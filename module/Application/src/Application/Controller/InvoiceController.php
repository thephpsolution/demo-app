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
        $form->populateValues((new Invoice())->getArrayCopy());
        return new ViewModel([
            'form'  => $form
        ]);
    }

    public function createAction()
    {
        $form = (new AnnotationBuilder())->createForm(Invoice::class);

        $request = $this->getRequest();
        if ($request->isPost()) {
            $invoice = new Invoice();
            $form->setData($request->getPost());

            if ($form->isValid()) {
                $invoice->exchangeArray($form->getData());
                $pdf = new InvoicePdf();
                $pdf->bind($invoice)->flatten()->send("invoice.pdf");

                return $this->redirect()->toRoute('home');
            } else {
                // Flash back with form errors
            }
        }
        return $this->redirect()->toRoute('home');
    }

    public function em()
    {
        return $this->em ?: $this->getServiceLocator()->get('DoctrineORMEntityManager');
    }

    public function getMockData()
    {
        return array(
            'invoicedOn' => '2012-05-05',
            'invoiceNumber' => '123',
            'customerId' => '123',
            'billTo' => '321 sdf',
            'logs' =>
                array (
                    0 =>
                        array (
                            'id' => '',
                            'developer' => 'sdf',
                            'description' => 'sdfg',
                            'hourlyPrice' => '1',
                            'hours' => '1',
                        ),
                    1 =>
                        array (
                            'id' => '',
                            'developer' => 'sdf',
                            'description' => 'sdfg',
                            'hourlyPrice' => '1',
                            'hours' => '1',
                        ),
                    2 =>
                        array (
                            'id' => '',
                            'developer' => 'dsfg',
                            'description' => 'dfg',
                            'hourlyPrice' => '1',
                            'hours' => '1',
                        ),
                    3 =>
                        array (
                            'id' => '',
                            'developer' => 'dfrg',
                            'description' => 'dfg',
                            'hourlyPrice' => '1',
                            'hours' => '1',
                        ),
                    4 =>
                        array (
                            'id' => '',
                            'developer' => 'dfg',
                            'description' => 'sdfg',
                            'hourlyPrice' => '1',
                            'hours' => '1',
                        ),
                ),
            'comments' => 'dfgdfg',
        );
    }
}
