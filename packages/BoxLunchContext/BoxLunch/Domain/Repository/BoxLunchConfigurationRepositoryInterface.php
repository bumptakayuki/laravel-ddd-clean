<?php
namespace Packages\BoxLunchContext\BoxLunch\Domain\Repository;

use Packages\BoxLunchContext\BoxLunch\Domain\BoxLunchConfiguration;
use Packages\BoxLunchContext\BoxLunch\Domain\ValueObject\ConfigurationId;

interface BoxLunchConfigurationRepositoryInterface
{
    /**
     * Box Lunch構成を保存する
     * 
     * @param BoxLunchConfiguration $configuration
     * @return void
     */
    public function save(BoxLunchConfiguration $configuration): void;
    
    /**
     * 構成IDでBox Lunch構成を取得する
     * 
     * @param ConfigurationId $configurationId
     * @return BoxLunchConfiguration|null
     */
    public function findById(ConfigurationId $configurationId): ?BoxLunchConfiguration;
}

