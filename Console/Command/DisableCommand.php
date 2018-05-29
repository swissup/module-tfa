<?php

namespace Swissup\Tfa\Console\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Magento\User\Model\ResourceModel\User\CollectionFactory;
use Magento\User\Model\ResourceModel\User\Collection;

class DisableCommand extends Command
{
    const ADMIN_EMAIL = 'email';

    /**
     *
     * @var \Magento\User\Model\ResourceModel\User\CollectionFactory
     */
    private $userCollectionFactory;

    /**
     * @var \Swissup\Tfa\Model\TfaFactory
     */
    private $tfaModelFactory;

    /**
     *
     * @param \Magento\User\Model\ResourceModel\User\CollectionFactory $userCollectionFactory
     * @param \Swissup\Tfa\Model\TfaFactory $tfaModelFactory
     */
    public function __construct(
        CollectionFactory $userCollectionFactory,
        \Swissup\Tfa\Model\TfaFactory $tfaModelFactory
    ) {
        parent::__construct();
        $this->userCollectionFactory = $userCollectionFactory;
        $this->tfaModelFactory = $tfaModelFactory;
    }

    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this->setName('swissup:tfa:disable')
            ->setDescription('Disable Two Factor Authentication for admin user')
            ->setDefinition([
                new InputArgument(
                    self::ADMIN_EMAIL,
                    InputArgument::REQUIRED,
                    'Admin User Email'
                )
            ])
            ;
        parent::configure();
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        /** @var Collection $collection */
        $collection = $this->userCollectionFactory->create();
        $email = $input->getArgument(self::ADMIN_EMAIL);
        $collection->addFieldToFilter('email', $email);

        $user = $collection->getFirstItem();

        if (!$user || !$user->getId()) {
            $output->writeln('<error>User ' . $email . ' was not found.</error>');
            return;
        }

        $model = $this->tfaModelFactory->create();
        $model->loadByUserId($user->getUserId());

        if ($model->getId() && $model->getIsActive() == 0) {
            $output->writeln('<info>TFA already disabled for '. $user->getEmail() . '</info>');
            return;
        }

        $model->setIsActive(0);
        try {
            $model->getResource()->save($model);
            $output->writeln('<info>Disabled TFA for '. $user->getEmail() . '</info>');
        } catch (\Exception $e) {
            $output->writeln('<error>' . $e->getMessage() . '</error>');
        }
    }
}
