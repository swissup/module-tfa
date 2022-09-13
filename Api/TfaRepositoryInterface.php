<?php
namespace Swissup\Tfa\Api;

/**
 * Tfa CRUD interface.
 * @api
 */

interface TfaRepositoryInterface
{

    /**
     * Save tfa.
     *
     * @throws \Magento\Framework\Exception\LocalizedException
     *
     * @param \Swissup\Tfa\Api\Data\TfaInterface $tfa The tfa
     * @return \Swissup\Tfa\Api\Data\TfaInterface
     */
    public function save(Data\TfaInterface $tfa);

    /**
     * Retrieve tfa by tfa id
     *
     * @throws \Magento\Framework\Exception\LocalizedException
     *
     * @param int $id tfa id.
     * @return \Swissup\Tfa\Api\Data\TfaInterface
     */
    public function getById($id);

    /**
     * Retrieve tfas matching the specified criteria.
     *
     * @throws \Magento\Framework\Exception\LocalizedException
     *
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria The search criteria
     * @return \Swissup\Tfa\Api\Data\TfaSearchResultsInterface
     */
    public function getList(\Magento\Framework\Api\SearchCriteriaInterface $searchCriteria);

    /**
     * Delete tfa.
     *
     * @throws \Magento\Framework\Exception\LocalizedException
     *
     * @param \Swissup\Tfa\Api\Data\TfaInterface $tfa The tfa
     * @return bool true on success
     */
    public function delete(Data\TfaInterface $tfa);

    /**
     * Delete tfa by ID.
     *
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @throws \Magento\Framework\Exception\LocalizedException
     *
     * @param int $id The tfa Id
     * @return bool true on success
     */
    public function deleteById(int $id);
}
