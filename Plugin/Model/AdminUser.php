<?php

namespace Swissup\Tfa\Plugin\Model;

use PragmaRX\Google2FA\Google2FA;

class AdminUser
{
    /**
     * @var \Swissup\Tfa\Model\TfaFactory
     */
    protected $tfaModelFactory;

    /**
     *
     * @var \PragmaRX\Google2FA\Google2FA
     */
    protected $google2fa;

    /**
     *
     * @var \Magento\Framework\App\Request\Http|\Laminas\Http\Request
     */
    protected $request;

    /**
     *
     * @param \Magento\Framework\App\Request\Http $request
     * @param Google2FA  $google2fa
     * @param \Swissup\Tfa\Model\TfaFactory $tfaModelFactory
     */
    public function __construct(
        \Magento\Framework\App\Request\Http $request,
        Google2FA $google2fa,
        \Swissup\Tfa\Model\TfaFactory $tfaModelFactory
    ) {
        $this->request = $request;
        $this->google2fa = $google2fa;
        $this->tfaModelFactory = $tfaModelFactory;
    }

    /**
     *
     * @param  \Magento\User\Model\User $subject
     * @param bool|array $result
     * @param  string  $password
     * @return array
     */
    public function afterVerifyIdentity(
        \Magento\User\Model\User $subject,
        $result,
        $password
    ) {
        if ($result === false) {
            return $result;
        }
        $model = $this->tfaModelFactory->create();
        $model->loadByUserId($subject->getData('user_id'));

        if ($model->getId() == null) {
            return $result;
        }

        if ($model->getIsActive() != 1) {
            return $result;
        }

        $tfa = $this->request->getPost('tfa');
        $key = $tfa['key'];

        $isValid = $this->google2fa->verifyKey($model->getSecret(), $key);
        if (!$isValid) {
            return false;
        }
        return $result;
    }

    /**
     *
     * @param  \Magento\User\Model\User $user [description]
     * @return void
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function beforeSave(
        \Magento\User\Model\User $user
    ) {
        $data = $user->getData();

        if (!isset($data['tfa'])) {
            return;
        }

        $data = $data['tfa'];

        if (empty($data['key']) || !isset($data['secret'])) {
            return;
        }

        $model = $this->tfaModelFactory->create();
        $model->loadByUserId($user->getData('user_id'));

        $isNew = empty($model->getId());

        $key = $data['key'];
        unset($data['key']);
        $isValid = $this->google2fa->verifyKey($data['secret'], $key);

        if ($isValid !== true) {
            throw new \Magento\Framework\Exception\LocalizedException(
                __('Incorrect Verification Key.')
            );
        }
        $model->addData($data);

        $model->save();

        if (isset($data['is_reset']) && $data['is_reset'] == '') {
            $model->delete();
        }
    }
}
