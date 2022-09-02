<?php


namespace AgSoftware\StorePickup\Api\Data;

interface StorePickupInterface
{

    const TELEPHONE = 'telephone';
    const EXTRA = 'extra';
    const PROVINCIA = 'provincia';
    const DISTRITO = 'distrito';
    const STORE_PICKUP_ID = 'store_pickup_id';
    const EMAIL = 'email';
    const COUNTRY_ID = 'country_id';
    const SCHEDULE = 'schedule';
    const NAME = 'name';
    const ACTIVE = 'active';
    const STREET = 'street';
    const POSTCODE = 'postcode';
    const DESPARTAMENTO = 'departamento';
    const STORES = 'stores';
    const PRICE = 'price';
    const FREE = 'free';


    /**
     * Get free
     * @return string|null
     */
    public function getFree();

    /**
     * Set free
     * @param string $free
     * @return \AgSoftware\StorePickup\Api\Data\StorePickupInterface
     */
    public function setFree($free);
 
    /**
     * Get store_pickup_id
     * @return string|null
     */
    public function getStorePickupId();

    /**
     * Set store_pickup_id
     * @param string $storePickupId
     * @return \AgSoftware\StorePickup\Api\Data\StorePickupInterface
     */
    public function setStorePickupId($storePickupId);
 
     /**
     * Get stores
     * @return string[]|null
     */
    public function getStores();

    /**
     * Set stores
     * @param string[] $stores
     * @return \AgSoftware\StorePickup\Api\Data\StorePickupInterface
     */
    public function setStores($stores);

    /**
     * Get country_id
     * @return string|null
     */
    public function getCountryId();

    /**
     * Set country_id
     * @param string $countryId
     * @return \AgSoftware\StorePickup\Api\Data\StorePickupInterface
     */
    public function setCountryId($countryId);

    /**
     * Get departamento
     * @return string|null
     */
    public function getDepartamento();

    /**
     * Set departamento
     * @param string $departamento
     * @return \AgSoftware\StorePickup\Api\Data\StorePickupInterface
     */
    public function setDepartamento($departamento);

    /**
     * Get provincia
     * @return string|null
     */
    public function getProvincia();

    /**
     * Set provincia
     * @param string $provincia
     * @return \AgSoftware\StorePickup\Api\Data\StorePickupInterface
     */
    public function setProvincia($provincia);

    /**
     * Get distrito
     * @return string|null
     */
    public function getDistrito();

    /**
     * Set distrito
     * @param string $distrito
     * @return \AgSoftware\StorePickup\Api\Data\StorePickupInterface
     */
    public function setDistrito($distrito);

    /**
     * Get street
     * @return string|null
     */
    public function getStreet();

    /**
     * Set street
     * @param string $street
     * @return \AgSoftware\StorePickup\Api\Data\StorePickupInterface
     */
    public function setStreet($street);

    /**
     * Get telephone
     * @return string|null
     */
    public function getTelephone();

    /**
     * Set telephone
     * @param string $telephone
     * @return \AgSoftware\StorePickup\Api\Data\StorePickupInterface
     */
    public function setTelephone($telephone);

    /**
     * Get extra
     * @return string|null
     */
    public function getExtra();

    /**
     * Set extra
     * @param string $extra
     * @return \AgSoftware\StorePickup\Api\Data\StorePickupInterface
     */
    public function setExtra($extra);

    /**
     * Get price
     * @return string|null
     */
    public function getPrice();

    /**
     * Set price
     * @param string $price
     * @return \AgSoftware\StorePickup\Api\Data\StorePickupInterface
     */
    public function setPrice($price);
   
    /**
     * Get postcode
     * @return string|null
     */
    public function getPostcode();

    /**
     * Set postcode
     * @param string $postcode
     * @return \AgSoftware\StorePickup\Api\Data\StorePickupInterface
     */
    public function setPostcode($postcode);

    /**
     * Get email
     * @return string|null
     */
    public function getEmail();

    /**
     * Set email
     * @param string $email
     * @return \AgSoftware\StorePickup\Api\Data\StorePickupInterface
     */
    public function setEmail($email);

    /**
     * Get schedule
     * @return string|null
     */
    public function getSchedule();

    /**
     * Set schedule
     * @param string $schedule
     * @return \AgSoftware\StorePickup\Api\Data\StorePickupInterface
     */
    public function setSchedule($schedule);

    /**
     * Get name
     * @return string|null
     */
    public function getName();

    /**
     * Set name
     * @param string $name
     * @return \AgSoftware\StorePickup\Api\Data\StorePickupInterface
     */
    public function setName($name);

    /**
     * Get active
     * @return string|null
     */
    public function getActive();

    /**
     * Set active
     * @param string $active
     * @return \AgSoftware\StorePickup\Api\Data\StorePickupInterface
     */
    public function setActive($active);
}
