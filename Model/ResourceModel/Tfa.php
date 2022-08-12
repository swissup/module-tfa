<?php
namespace Swissup\Tfa\Model\ResourceModel;

/**
 * Tfa Tfa mysql resource
 */
class Tfa extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{

    /**
     * Core Date
     *
     * @var \Magento\Framework\Stdlib\DateTime\DateTime
     */
    protected $coreDate;

    /**
     * Construct
     *
     * @param \Magento\Framework\Model\ResourceModel\Db\Context $context
     * @param \Magento\Framework\Stdlib\DateTime\DateTime $coreDate
     * @param string|null $connectionName
     */
    public function __construct(
        \Magento\Framework\Model\ResourceModel\Db\Context $context,
        \Magento\Framework\Stdlib\DateTime\DateTime $coreDate,
        $connectionName = null
    ) {
        $this->coreDate = $coreDate;
        parent::__construct($context, $connectionName);
    }

    /**
     * Initialize resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('swissup_tfa', 'id');
    }

    /**
     * Load  by user id
     *
     * @param \Swissup\Tfa\Model\Tfa $model
     * @param int  $userId
     * @return $this
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function loadByUserId(\Swissup\Tfa\Model\Tfa $model, $userId)
    {
        $connection = $this->getConnection();
        $bind = ['user_id' => $userId];
        $select = $connection->select()->from(
            $this->getMainTable(),
            [$this->getIdFieldName()]
        )->order(
            $this->getIdFieldName() . ' DESC'
        )->where(
            'user_id = :user_id'
        );

        $id = $connection->fetchOne($select, $bind);
        if ($id) {
            $this->load($model, $id);
        } else {
            $model->setData($bind);
        }

        return $this;
    }

    /**
     * Process post data before saving
     *
     * @param \Magento\Framework\Model\AbstractModel $object
     * @return $this
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    protected function _beforeSave(\Magento\Framework\Model\AbstractModel $object)
    {
        parent::_beforeSave($object);

        if ($object->isObjectNew() && !$object->hasData('created')) {
            $object->setData('created', $this->coreDate->gmtDate());
        }

        $object->setData('updated', $this->coreDate->gmtDate());

        return $this;
    }
}
