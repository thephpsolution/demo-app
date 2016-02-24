<?php
/**
 * @copyright MagicLogix (c) 2016
 * @author Jonathan McCartney <jmccartney@magiclogix.com>
 */

namespace Application\Pdf;


use Application\Entity\Invoice;
use mikehaertl\pdftk\Pdf;

class InvoicePdf extends Pdf
{
    /**
     * @param null|string|Pdf|array $pdf a pdf filename or Pdf instance or an array of filenames/instances indexed by a handle.
     * The array values can also be arrays of the form array($filename, $password) if some
     * files are password protected.
     * @param array $options Options to pass to set on the Command instance, e.g. the pdftk binary path
     */
    public function __construct($pdf = '')
    {
        parent::__construct('module/Application/resources/invoice-and-receipt-template.pdf', []);
    }

    /**
     * @param Invoice $invoice
     * @return $this
     */
    public function bind(Invoice $invoice)
    {
        $data = [];
        $logs = $invoice->getLogs();
        for ($i = 1; $i <= 5; $i++) {
            $log = isset($logs[$i - 1]) ? $logs[$i - 1] : null;
            $data = array_merge($data, [
                "developer_$i"      => $log ? $log->getDeveloper() : '',
                "description_$i"    => $log ? $log->getDescription() : '',
                "hourly_rate_$i"    => $log ? $log->getHourlyPrice() : '',
                "hours_$i"          => $log ? $log->getHours() : '',
                "total_price_$i"    => $log ? $log->getTotal() : '',
            ]);
        }

        $this->fillForm(array_merge($data, [
            'date'              => $invoice->getInvoicedOn()->format('Y-m-d'),
            'invoice_number'    => $invoice->getInvoiceNumber(),
            'customer_id'       => $invoice->getCustomerId(),
            'total'             => $invoice->getTotal(),
            'bill_to'           => $invoice->getBillTo(),
            'comments'          => $invoice->getComments(),
        ]));
        $this->needAppearances();
        return $this;
    }
}