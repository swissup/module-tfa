<?php
namespace Swissup\Tfa\Model;

use Swissup\Tfa\Api\Data\TfaInterface;
use Magento\Framework\DataObject\IdentityInterface;

class Tfa extends \Magento\Framework\Model\AbstractModel implements TfaInterface, IdentityInterface
{
    /**
     * cache tag
     */
    const CACHE_TAG = 'tfa_tfa';

    /**
     * @var string
     */
    protected $_cacheTag = 'tfa_tfa';

    /**
     * Prefix of model events names
     *
     * @var string
     */
    protected $_eventPrefix = 'tfa_tfa';

    /**
     * Initialize resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init(\Swissup\Tfa\Model\ResourceModel\Tfa::class);
    }

    /**
     * Return unique ID(s) for each object in system
     *
     * @return array
     */
    public function getIdentities()
    {
        return [self::CACHE_TAG . '_' . $this->getId()];
    }

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->getData(self::ID);
    }

    /**
     * Get user_id
     *
     * @return int
     */
    public function getUserId()
    {
        return $this->getData(self::USER_ID);
    }

    /**
     * Get is_active
     *
     * @return int
     */
    public function getIsActive()
    {
        return $this->getData(self::IS_ACTIVE);
    }

    /**
     * Get secret
     *
     * @return string
     */
    public function getSecret()
    {
        return $this->getData(self::SECRET);
    }

    /**
     * Get created
     *
     * @return string
     */
    public function getCreated()
    {
        return $this->getData(self::CREATED);
    }

    /**
     * Get updated
     *
     * @return string
     */
    public function getUpdated()
    {
        return $this->getData(self::UPDATED);
    }

    /**
     * Set id
     *
     * @param int $id
     * @return \Swissup\Tfa\Api\Data\TfaInterface
     */
    public function setId($id)
    {
        return $this->setData(self::ID, $id);
    }

    /**
     * Set user_id
     *
     * @param int $userId
     * @return \Swissup\Tfa\Api\Data\TfaInterface
     */
    public function setUserId($userId)
    {
        return $this->setData(self::USER_ID, $userId);
    }

    /**
     * Set is_active
     *
     * @param int $isActive
     * @return \Swissup\Tfa\Api\Data\TfaInterface
     */
    public function setIsActive($isActive)
    {
        return $this->setData(self::IS_ACTIVE, $isActive);
    }

    /**
     * Set secret
     *
     * @param string $secret
     * @return \Swissup\Tfa\Api\Data\TfaInterface
     */
    public function setSecret($secret)
    {
        return $this->setData(self::SECRET, $secret);
    }

    /**
     * Set created
     *
     * @param string $created
     * @return \Swissup\Tfa\Api\Data\TfaInterface
     */
    public function setCreated($created)
    {
        return $this->setData(self::CREATED, $created);
    }

    /**
     * Set updated
     *
     * @param string $updated
     * @return \Swissup\Tfa\Api\Data\TfaInterface
     */
    public function setUpdated($updated)
    {
        return $this->setData(self::UPDATED, $updated);
    }

    /**
     * Load by user id
     *
     * @param   int user id
     * @return  $this
     */
    public function loadByUserId($userId)
    {
        $this->getResourceModel()->loadByUserId($this, $userId);
        return $this;
    }

    /**
     * @return ResourceModel\Tfa
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    private function getResourceModel()
    {
         if (empty($this->_resourceName) && empty($this->_resource)) {
            throw new \Magento\Framework\Exception\LocalizedException(
                new \Magento\Framework\Phrase('The resource isn\'t set.')
            );
        }

        /** @var \Swissup\Tfa\Model\ResourceModel\Tfa  $resource */
        $resource = $this->_resource ?: \Magento\Framework\App\ObjectManager::getInstance()->get($this->_resourceName);
        return $resource;
    }

    // public function getNewSecret($password)
    // {
    //     // \Zend_Debug::dump(md5($password + md5(time())));
    //     return md5(hash('sha256', $password + md5(time())));
    // }
}
