<?php

namespace Swissup\Tfa\Plugin\Model;

class Tfa
{
    /**
     * Core Date
     *
     * @var \Magento\Framework\Stdlib\DateTime\DateTime
     */
    private $coreDate;

    /**
     * Construct
     *
     * @param \Magento\Framework\Stdlib\DateTime\DateTime $coreDate
     */
    public function __construct(
        \Magento\Framework\Stdlib\DateTime\DateTime $coreDate
    ) {
        $this->coreDate = $coreDate;
    }

    /**
     *
     * @param \Swissup\Tfa\Model\Tfa $subject
     * @return void
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function afterBeforeSave(
        \Swissup\Tfa\Model\Tfa $subject
    ) {
        $object = $subject;
        if ($object->isObjectNew() && !$object->hasData('created')) {
            $object->setData('created', $this->coreDate->gmtDate());
        }

        $object->setData('updated', $this->coreDate->gmtDate());
    }
}
