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
 * @ORM\Table(name="invoice_logs")
 *
 * @ZFA\Name("invoice_log")
 */
class InvoiceLog implements ArraySerializableInterface
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
     * @var null|string
     * @ORM\Column(type="string", length=20, nullable=true)
     *
     * @ZFA\Filter({"name":"StringTrim"})
     * @ZFA\Required(false)
     * @ZFA\Validator({"name":"StringLength", "options":{"min":0, "max":20}})
     * @ZFA\Options({"label":"Developer"})
     */
    protected $developer = null;

    /**
     * @var string
     * @ORM\Column(type="string", length=20)
     *
     * @ZFA\Filter({"name":"StringTrim"})
     * @ZFA\Required(true)
     * @ZFA\Validator({"name":"StringLength", "options":{"min":1, "max":20}})
     * @ZFA\Options({"label":"Description"})
     */
    protected $description = null;

    /**
     * @var float
     * @ORM\Column(type="decimal")
     *
     * @ZFA\Filter({"name":"StringTrim"})
     * @ZFA\Required(true)
     * @ZFA\Validator({"name":"StringLength", "options":{"min":1}})
     * @ZFA\Attributes({"type":"number", "min": 0.0})
     * @ZFA\Options({"label":"Hourly Price"})
     */
    protected $hourlyPrice = null;

    /**
     * @var float
     * @ORM\Column(type="decimal")
     *
     * @ZFA\Filter({"name":"StringTrim"})
     * @ZFA\Required(true)
     * @ZFA\Validator({"name":"StringLength", "options":{"min":1}})
     * @ZFA\Attributes({"type":"number", "min": 0.0})
     * @ZFA\Options({"label":"Hours"})
     */
    protected $hours = null;

    public function toArray()
    {
        return [];
    }

    public function getTotal()
    {
        return $this->hours * $this->hourlyPrice;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return null|string
     */
    public function getDeveloper()
    {
        return $this->developer;
    }

    /**
     * @param null|string $developer
     * @return $this
     */
    public function setDeveloper($developer)
    {
        $this->developer = $developer;
        return $this;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string $description
     * @return $this
     */
    public function setDescription($description)
    {
        $this->description = $description;
        return $this;
    }

    /**
     * @return float
     */
    public function getHourlyPrice()
    {
        return $this->hourlyPrice;
    }

    /**
     * @param float $hourlyPrice
     * @return $this
     */
    public function setHourlyPrice($hourlyPrice)
    {
        $this->hourlyPrice = $hourlyPrice;
        return $this;
    }

    /**
     * @return float
     */
    public function getHours()
    {
        return $this->hours;
    }

    /**
     * @param float $hours
     * @return $this
     */
    public function setHours($hours)
    {
        $this->hours = $hours;
        return $this;
    }

    /**
     * Exchange internal values from provided array
     *
     * @param  array $array
     * @return void
     */
    public function exchangeArray(array $array)
    {
        print_r($array);
        die('exchange array');
        // TODO: Implement exchangeArray() method.
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