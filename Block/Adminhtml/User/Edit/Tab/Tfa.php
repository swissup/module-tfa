<?php
namespace Swissup\Tfa\Block\Adminhtml\User\Edit\Tab;

use PragmaRX\Google2FAQRCode\Google2FA;

class Tfa extends \Magento\Backend\Block\Widget\Form implements \Magento\Backend\Block\Widget\Tab\TabInterface
{
    /**
     * @var \Magento\Framework\Registry
     */
    private $coreRegistry;

    /**
     * @var \Magento\Framework\Data\FormFactory
     */
    protected $formFactory;

    /**
     * @var \Swissup\Tfa\Model\TfaFactory
     */
    protected $tfaModelFactory;

     /**
      *
      * @var \PragmaRX\Google2FAQRCode\Google2FA
      */
    protected $google2fa;

    /**
     * @param \Magento\Backend\Block\Template\Context $context
     * @param \Magento\Framework\Registry $registry
     * @param \Magento\Framework\Data\FormFactory $formFactory
     * @param \Swissup\Tfa\Model\TfaFactory $tfaModelFactory
     * @param Google2FA $google2fa
     * @param array $data
     */
    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Framework\Registry $registry,
        \Magento\Framework\Data\FormFactory $formFactory,
        \Swissup\Tfa\Model\TfaFactory $tfaModelFactory,
        Google2FA $google2fa,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->coreRegistry = $registry;
        $this->formFactory = $formFactory;
        $this->tfaModelFactory = $tfaModelFactory;
        $this->google2fa = $google2fa;
    }

    /**
     * Prepare form fields
     *
     * @SuppressWarnings(PHPMD.ExcessiveMethodLength)
     * @return \Magento\Backend\Block\Widget\Form
     */
    protected function _prepareForm()
    {
        /** @var \Magento\User\Model\User $user */
        $user = $this->coreRegistry->registry('permissions_user');
        /** @var \Magento\Framework\Data\Form $form */
        $form = $this->formFactory->create();
        $form->setHtmlIdPrefix('tfa_')
            ->setFieldNameSuffix('tfa');

        $tfaModel = $this->tfaModelFactory->create();
        $tfaModel->loadByUserId($user->getId());

        $data = $tfaModel->getData();
        $isNew = $tfaModel->getId() == null;

        $fieldset = $form->addFieldset('twofactorauthentication_fieldset', [
            'legend' => __($isNew ?  'Add' : 'Edit') . ' ' . __('Two Factor Authentication')
        ]);

        if ($isNew) {
            $data['is_active'] = 1;
        }

        $fieldset->addField(
            'is_active',
            'select',
            [
                'name' => 'is_active',
                'label' => __('Is Active'),
                'id' => 'is_active',
                'title' => __('Status'),
                'class' => 'input-select',
                'options' => ['1' => __('Active'), '0' => __('Inactive')]
            ]
        );
        $secret = $isNew ? $this->google2fa->generateSecretKey(32) : $data['secret'];
        $data['secret'] =  $secret;
        $uri = \Laminas\Uri\UriFactory::factory($this->getBaseUrl());
        $hostname = $uri->getHost();

        $qrImage = $this->google2fa->getQRCodeInline(
            $hostname,
            $user->getData('username'),
            $secret
        );

        $label = "$hostname ({$user->getData('username')})";
        $data['label'] =  $label;

        $el = $fieldset->addField(
            'label',
            'label',
            ['label' => __('Label'), 'title' => __('Label'), 'name' => 'label']
        );

        $_label = __('Verification Key');
        $el->setAfterElementHtml(
            "<br/>$qrImage
            <script type=\"text/javascript\">
                setInterval(function () {
                    var el = $('tfa_key').up('.field').select('label').first();
                    var second = 30 - Math.floor(new Date().getTime() / 1000.0) % 30;
                    el.update('$_label (' + second + ' sec)');
                }, 1000);
            </script>"
        );

        $fieldset->addField(
            'secret',
            'hidden',
            [
                'name'  => 'secret',
                'label' => __('Secret'),
                'id'    => 'secret',
                'title' => __('Secret'),
                // 'required' => true,
            ]
        );

        $fieldset->addField(
            'key',
            'text',
            [
                'name'  => 'key',
                'label' => __('Verification Key'),
                'id'    => 'key',
                'title' => __('Verification Key'),
                // 'required' => true,
                'note'  => __('Enter here your Verification Key from  your  Google Authenticator extension label')
            ]
        );

        if (!$isNew) {
            $fieldset->addField(
                'is_reset',
                'checkbox',
                [
                    'name'  => 'is_reset',
                    'label' => __('Reset Secret'),
                    'title' => __('Reset Secret'),
                ]
            );
        }

        $form->setValues($data);

        $this->setForm($form);

        return parent::_prepareForm();
    }

    /**
     * Tab settings
     *
     * @return \Magento\Framework\Phrase
     */
    public function getTabLabel()
    {
        return __('Two Factor Authentication');
    }

    /**
     * @return \Magento\Framework\Phrase
     */
    public function getTabTitle()
    {
        return __('Two Factor Authentication');
    }

    /**
     * @return bool
     */
    public function canShowTab()
    {
        return true;
    }

    /**
     * @return bool
     */
    public function isHidden()
    {
        return false;
    }
}
