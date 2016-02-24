<?php
/**
 * @copyright MagicLogix (c) 2016
 * @author Jonathan McCartney <jmccartney@magiclogix.com>
 */

namespace Application\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

use Zend\Form\Annotation as ZFA;
use Zend\Stdlib\ArraySerializableInterface;

/**
 * An example of how to implement a role aware invoice entity.
 *
 * @ORM\Entity
 * @ORM\Table(name="invoices")
 *
 * @ZFA\Name("invoice")
 */
class Invoice implements ArraySerializableInterface
{
    /**
     * @var int
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     *
     * @ZFA\Filter({"name":"StringTrim"})
     * @ZFA\Required(false)
     * @ZFA\Attributes({"type":"hidden"})
     */
    protected $id = null;

    /**
     * @var \DateTime
     * @ORM\Column(type="datetime")
     *
     * @ZFA\Required(true)
     * @ZFA\Attributes({"type":"date"})
     * @ZFA\Options({"label":"Invoice Date", "format": "Y-m-d"})
     */
    protected $invoicedOn = null;

    /**
     * @var null|string
     * @ORM\Column(type="string", length=20, nullable=true)
     *
     * @ZFA\Filter({"name":"StringTrim"})
     * @ZFA\Required(false)
     * @ZFA\Validator({"name":"StringLength", "options":{"min":0, "max":20}})
     * @ZFA\Options({"label":"Invoice Number"})
     */
    protected $invoiceNumber = null;

    /**
     * @var null|string
     * @ORM\Column(type="string", length=20, nullable=true)
     *
     * @ZFA\Filter({"name":"StringTrim"})
     * @ZFA\Required(false)
     * @ZFA\Validator({"name":"StringLength", "options":{"min":0, "max":20}})
     * @ZFA\Options({"label":"Customer ID"})
     */
    protected $customerId = null;

    /**
     * @var string
     * @ORM\Column(type="text")
     *
     * @ZFA\Filter({"name":"StringTrim"})
     * @ZFA\Required(true)
     * @ZFA\Validator({"name":"StringLength", "options":{"min":1}})
     * @ZFA\Attributes({"type":"textarea"})
     * @ZFA\Options({"label":"Bill To"})
     */
    protected $billTo = null;

    /**
     * @var null|string
     * @ORM\Column(type="text", nullable=true)
     *
     * @ZFA\Filter({"name":"StringTrim"})
     * @ZFA\Required(false)
     * @ZFA\Attributes({"type":"textarea"})
     * @ZFA\Options({"label":"Other Comments or Special Instructions"})
     */
    protected $comments = null;

    /**
     * @var InvoiceLog[]\Doctrine\Common\Collections\Collection
     * @ORM\OneToMany(targetEntity="Application\Entity\InvoiceLog", mappedBy="invoice", cascade={"all"}, orphanRemoval=true)
     *
     * @ZFA\ComposedObject({"target_object": "Application\Entity\InvoiceLog", "should_create_template": true, "is_collection": true, "options":{"allow_add": true, "count":1}})
     * ZFA\Type("Zend\Form\Element\Collection")
     * ZFA\Options({"count": 5, "should_create_template": true})
     */
    protected $logs;

    /**
     * Initialies the roles variable.
     */
    public function __construct()
    {
        $this->logs = new ArrayCollection();
        $this->invoicedOn = new \DateTime();
    }

    public function getTotal()
    {
        $total = 0.0;
        foreach ($this->logs as $log) {
            $total += $log->getTotal();
        }
        return $total;
    }

    public function toArray()
    {
        return [];
    }

    /**
     * @return InvoiceLog[]
     */
    public function getLogs()
    {
        return $this->logs;
    }

    /**
     * @param InvoiceLog[] $logs
     * @return $this
     */
    public function setLogs(array $logs)
    {
        $this->logs = $logs;
        return $this;
    }

    /**
     * @return null|string
     */
    public function getComments()
    {
        return $this->comments;
    }

    /**
     * @param null|string $comments
     * @return $this
     */
    public function setComments($comments)
    {
        $this->comments = $comments;
        return $this;
    }

    /**
     * @return string
     */
    public function getBillTo()
    {
        return $this->billTo;
    }

    /**
     * @param string $billTo
     * @return $this
     */
    public function setBillTo($billTo)
    {
        $this->billTo = $billTo;
        return $this;
    }

    /**
     * @return null|string
     */
    public function getCustomerId()
    {
        return $this->customerId;
    }

    /**
     * @param null|string $customerId
     * @return $this
     */
    public function setCustomerId($customerId)
    {
        $this->customerId = $customerId;
        return $this;
    }

    /**
     * @return null|string
     */
    public function getInvoiceNumber()
    {
        return $this->invoiceNumber;
    }

    /**
     * @param null|string $invoiceNumber
     * @return $this
     */
    public function setInvoiceNumber($invoiceNumber)
    {
        $this->invoiceNumber = $invoiceNumber;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getInvoicedOn()
    {
        return $this->invoicedOn;
    }

    /**
     * @param \DateTime $invoicedOn
     * @return $this
     */
    public function setInvoicedOn(\DateTime $invoicedOn)
    {
        $this->invoicedOn = $invoicedOn;
        return $this;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Exchange internal values from provided array
     *
     * @param  array $array
     * @return void
     */
    public function exchangeArray(array $array)
    {
        $logs = [];
        foreach ($array['logs'] as $log) {
            $logs[] = (new InvoiceLog())
                ->setDescription($log['description'])
                ->setDeveloper($log['developer'])
                ->setHourlyPrice($log['hourlyPrice'])
                ->setHours($log['hours'])
            ;
        }
        $this->setBillTo($array['billTo'])
            ->setComments($array['comments'])
            ->setCustomerId($array['customerId'])
            ->setInvoicedOn(new \DateTime($array['invoicedOn']))
            ->setInvoiceNumber($array['invoiceNumber'])
            ->setLogs($logs)
        ;
    }

    /**
     * Return an array representation of the object
     *
     * @return array
     */
    public function getArrayCopy()
    {
        return get_object_vars($this);
    }
}