<?php
namespace Swissup\Tfa\Api\Data;

interface TfaSearchResultsInterface
{
    /**
     * Get list.
     *
     * @return \Swissup\Tfa\Api\Data\TfaInterface[]
     */
    public function getItems();

    /**
     * Set list.
     *
     * @param \Swissup\Tfa\Api\Data\TfaInterface[] $items
     * @return $this
     */
    public function setItems(array $items);
}
