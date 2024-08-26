<?php

namespace Nrdev\FmcDeployments\Step\Build;

use Magento\MagentoCloud\Filesystem\FileSystemException;
use Magento\MagentoCloud\Step\StepException;
use Magento\MagentoCloud\Step\StepInterface;

class CompileDi implements StepInterface
{
    public function execute()
    {
        try {
            $this->logger->info('Output the di compilation issues');
            #Do some actions
            $this->writer->update(['MAGE_MODE' => 'production']);
        } catch (FileSystemException $exception) {
            throw new StepException($exception->getMessage(), $exception->getCode(), $exception);
        }
    }

}
