<?php
namespace Swissup\Tfa\Model\ResourceModel;

/**
 * Tfa Tfa mysql resource
 */
class Tfa extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
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
}
