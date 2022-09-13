<?php

namespace Swissup\Tfa\Console\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Magento\User\Model\ResourceModel\User\CollectionFactory;
use Magento\User\Model\ResourceModel\User\Collection;

class ListCommand extends Command
{
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
        $this->setName('swissup:tfa:list')
            ->setDescription('List Two Factor Authentication status for admin users.')
            ;
        parent::configure();
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $model = $this->tfaModelFactory->create();
        /** @var Collection $collection */
        $collection = $this->userCollectionFactory->create();
        /** @var \Magento\User\Model\User $user */
        foreach ($collection->getItems() as $user) {
            $model->loadByUserId($user->getId());
            $active = $model->getIsActive() == 1 ?
                '<bg=green;options=bold>enabled</>' : '<bg=red;options=bold>disabled</>';
            $output->writeln('<info>TFA already ' . $active . ' for '. $user->getEmail() . '</info>');
        }

        return \Magento\Framework\Console\Cli::RETURN_SUCCESS;
    }
}
