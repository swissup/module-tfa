<?php
namespace Swissup\Tfa\Api\Data;

interface TfaInterface
{
    const ID = 'id';
    const USER_ID = 'user_id';
    const IS_ACTIVE = 'is_active';
    const SECRET = 'secret';
    const CREATED = 'created';
    const UPDATED = 'updated';

    /**
     * Get id
     *
     * @return int
     */
    public function getId();

    /**
     * Get user_id
     *
     * @return int
     */
    public function getUserId();

    /**
     * Get is_active
     *
     * @return int
     */
    public function getIsActive();

    /**
     * Get secret
     *
     * @return string
     */
    public function getSecret();

    /**
     * Get created
     *
     * @return string
     */
    public function getCreated();

    /**
     * Get updated
     *
     * @return string
     */
    public function getUpdated();


    /**
     * Set id
     *
     * @param int $id
     * @return \Swissup\Tfa\Api\Data\TfaInterface
     */
    public function setId($id);

    /**
     * Set user_id
     *
     * @param int $userId
     * @return \Swissup\Tfa\Api\Data\TfaInterface
     */
    public function setUserId($userId);

    /**
     * Set is_active
     *
     * @param int $isActive
     * @return \Swissup\Tfa\Api\Data\TfaInterface
     */
    public function setIsActive($isActive);

    /**
     * Set secret
     *
     * @param string $secret
     * @return \Swissup\Tfa\Api\Data\TfaInterface
     */
    public function setSecret($secret);

    /**
     * Set created
     *
     * @param string $created
     * @return \Swissup\Tfa\Api\Data\TfaInterface
     */
    public function setCreated($created);

    /**
     * Set updated
     *
     * @param string $updated
     * @return \Swissup\Tfa\Api\Data\TfaInterface
     */
    public function setUpdated($updated);
}
