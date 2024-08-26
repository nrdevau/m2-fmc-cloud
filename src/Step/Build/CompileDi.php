<?php

namespace Nrdev\FmcDeployments\Step\Build;

use Magento\MagentoCloud\App\Error;
use Magento\MagentoCloud\Config\ConfigException;
use Magento\MagentoCloud\Step\StepException;
use Magento\MagentoCloud\Step\StepInterface;
use Magento\MagentoCloud\Shell\MagentoShell;
use Magento\MagentoCloud\Shell\ShellException;
use Magento\MagentoCloud\Shell\ShellFactory;
use Psr\Log\LoggerInterface;
use Magento\MagentoCloud\Config\Stage\BuildInterface;

class CompileDi implements StepInterface
{

    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * @var MagentoShell
     */
    private $magentoShell;

    /**
     * @var BuildInterface
     */
    private $stageConfig;

    /**
     * @param LoggerInterface $logger
     * @param ShellFactory $shellFactory
     * @param BuildInterface $stageConfig
     */
    public function __construct(
        LoggerInterface $logger,
        ShellFactory $shellFactory,
        BuildInterface $stageConfig
    ) {
        $this->logger = $logger;
        $this->magentoShell = $shellFactory->createMagento();
        $this->stageConfig = $stageConfig;
    }

    public function execute()
    {
        try {
            $this->logger->info('Output the di compilation issues');
            $this->logger->notice('Running DI compilation');
            $this->magentoShell->execute(
                'setup:di:compile',
                [
                    '-vvv'
                ]
            );
            $this->logger->notice('End of running DI compilation');
        } catch (ConfigException $e) {
            throw new StepException($e->getMessage(), $e->getCode(), $e);
        } catch (ShellException $e) {
            throw new StepException($e->getMessage(), Error::BUILD_DI_COMPILATION_FAILED, $e);
        }
    }

}
