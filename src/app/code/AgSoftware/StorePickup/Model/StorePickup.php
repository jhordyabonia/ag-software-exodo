<?php


namespace AgSoftware\StorePickup\Model;

use AgSoftware\StorePickup\Api\Data\StorePickupInterface;

class StorePickup extends \Magento\Framework\Model\AbstractModel implements StorePickupInterface
{

    protected $_eventPrefix = 'agsoftware_storepickup_store_pickup';

    /**
     * @return void
     */
    protected function _construct()
    {
        $this->_init('AgSoftware\StorePickup\Model\ResourceModel\StorePickup');
    }

    /**
     * Get store_pickup_id
     * @return string
     */
    public function getStorePickupId()
    {
        return $this->getData(self::STORE_PICKUP_ID);
    }

    /**
     * Set store_pickup_id
     * @param string $storePickupId
     * @return \AgSoftware\StorePickup\Api\Data\StorePickupInterface
     */
    public function setStorePickupId($storePickupId)
    {
        return $this->setData(self::STORE_PICKUP_ID, $storePickupId);
    }


    /**
     * Get stores
     * @return string[]|null
     */
    public function getStores()
    {
        $stores = $this->getData(self::STORES);
        if (empty($stores)) {
            return [];
        }
        if ($stores && !is_array($stores)) {
            $stores = explode(',', $stores);
        }
        return $stores;
    }

    /**
     * Set stores
     * @param string[] $stores
     * @return \AgSoftware\StorePickup\Api\Data\StorePickupInterface
     */
    public function setStores($stores)
    {
        return $this->setData(self::STORES, $stores);
    }

    /**
     * Get country_id
     * @return string
     */
    public function getCountryId()
    {
        return $this->getData(self::COUNTRY_ID);
    }

    /**
     * Set country_id
     * @param string $countryId
     * @return \AgSoftware\StorePickup\Api\Data\StorePickupInterface
     */
    public function setCountryId($countryId)
    {
        return $this->setData(self::COUNTRY_ID, $countryId);
    }

    /**
     * Get departamento
     * @return string
     */
    public function getDepartamento()
    {
        return $this->getData(self::DESPARTAMENTO);
    }

    /**
     * Set departamento
     * @param string $departamento
     * @return \AgSoftware\StorePickup\Api\Data\StorePickupInterface
     */
    public function setDepartamento($departamento)
    {
        return $this->setData(self::DESPARTAMENTO, $departamento);
    }

    /**
     * Get distrito
     * @return string
     */
    public function getDistrito()
    {
        return $this->getData(self::DISTRITO);
    }

    /**
     * Set distrito
     * @param string $distrito
     * @return \AgSoftware\StorePickup\Api\Data\StorePickupInterface
     */
    public function setDistrito($distrito)
    {
        return $this->setData(self::DISTRITO, $distrito);
    }

    /**
     * Get provincia
     * @return string
     */
    public function getProvincia()
    {
        return $this->getData(self::PROVINCIA);
    }

    /**
     * Set provincia
     * @param string $provincia
     * @return \AgSoftware\StorePickup\Api\Data\StorePickupInterface
     */
    public function setProvincia($provincia)
    {
        return $this->setData(self::PROVINCIA, $provincia);
    }

    /**
     * Get street
     * @return string
     */
    public function getStreet()
    {
        return $this->getData(self::STREET);
    }

    /**
     * Set street
     * @param string $street
     * @return \AgSoftware\StorePickup\Api\Data\StorePickupInterface
     */
    public function setStreet($street)
    {
        return $this->setData(self::STREET, $street);
    }

    /**
     * Get telephone
     * @return string
     */
    public function getTelephone()
    {
        return $this->getData(self::TELEPHONE);
    }

    /**
     * Set telephone
     * @param string $telephone
     * @return \AgSoftware\StorePickup\Api\Data\StorePickupInterface
     */
    public function setTelephone($telephone)
    {
        return $this->setData(self::TELEPHONE, $telephone);
    }

    /**
     * Get extra
     * @return string
     */
    public function getExtra()
    {
        return $this->getData(self::EXTRA);
    }

    /**
     * Set extra
     * @param string $extra
     * @return \AgSoftware\StorePickup\Api\Data\StorePickupInterface
     */
    public function setExtra($extra)
    {
        return $this->setData(self::EXTRA, $extra);
    }

    /**
     * Get price
     * @return string
     */
    public function getPrice()
    {
        return $this->getData(self::PRICE);
    }

    /**
     * Set price
     * @param string $price
     * @return \AgSoftware\StorePickup\Api\Data\StorePickupInterface
     */
    public function setPrice($price)
    {
        return $this->setData(self::PRICE, $price);
    }

    /**
     * Get postcode
     * @return string
     */
    public function getPostcode()
    {
        return $this->getData(self::POSTCODE);
    }

    /**
     * Set postcode
     * @param string $postcode
     * @return \AgSoftware\StorePickup\Api\Data\StorePickupInterface
     */
    public function setPostcode($postcode)
    {
        return $this->setData(self::POSTCODE, $postcode);
    }

    /**
     * Get email
     * @return string
     */
    public function getEmail()
    {
        return $this->getData(self::EMAIL);
    }

    /**
     * Set email
     * @param string $email
     * @return \AgSoftware\StorePickup\Api\Data\StorePickupInterface
     */
    public function setEmail($email)
    {
        return $this->setData(self::EMAIL, $email);
    }

    /**
     * Get schedule
     * @return string
     */
    public function getSchedule()
    {
        return $this->getData(self::SCHEDULE);
    }

    /**
     * Set schedule
     * @param string $schedule
     * @return \AgSoftware\StorePickup\Api\Data\StorePickupInterface
     */
    public function setSchedule($schedule)
    {
        return $this->setData(self::SCHEDULE, $schedule);
    }

    /**
     * Get name
     * @return string
     */
    public function getName()
    {
        return $this->getData(self::NAME);
    }

    /**
     * Set name
     * @param string $name
     * @return \AgSoftware\StorePickup\Api\Data\StorePickupInterface
     */
    public function setName($name)
    {
        return $this->setData(self::NAME, $name);
    }

    /**
     * Get active
     * @return string
     */
    public function getActive()
    {
        return $this->getData(self::ACTIVE);
    }

    /**
     * Set active
     * @param string $active
     * @return \AgSoftware\StorePickup\Api\Data\StorePickupInterface
     */
    public function setActive($active)
    {
        return $this->setData(self::ACTIVE, $active);
    }

    /**
     * Get free
     * @return string
     */
    public function getFree()
    {
        return $this->getData(self::FREE);
    }

    /**
     * Set free
     * @param string $free
     * @return \AgSoftware\StorePickup\Api\Data\StorePickupInterface
     */
    public function setFree($free)
    {
        return $this->setData(self::FREE, $free);
    }
}
