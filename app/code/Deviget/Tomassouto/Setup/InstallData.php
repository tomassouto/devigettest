<?php
/**
 * Created by: Tomas Souto
 * E-mail: tomas.souto@gmail.com
 * Date: 12/3/18
 * Time: 5:29 PM
 */

namespace Deviget\Tomassouto\Setup;

use Magento\Cms\Api\BlockRepositoryInterface;
use Magento\Cms\Api\Data\BlockInterface;
use Magento\Cms\Api\Data\BlockInterfaceFactory;
use Magento\Framework\Setup\InstallDataInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;

class InstallData implements \Magento\Framework\Setup\InstallDataInterface {
    /**
     *
     * @SuppressWarnings(PHPMD.ExcessiveMethodLength)
     */

    /** @var  BlockRepositoryInterface */
    private $blockRepository;
    /** @var BlockFactory */
    private $blockInterfaceFactory;


    /**
     * InstallData constructor.
     * @param BlockRepositoryInterface $blockRepository
     * @param BlockInterfaceFactory $blockInterfaceFactory
     */
    public function __construct(
        BlockRepositoryInterface $blockRepository,
        BlockInterfaceFactory $blockInterfaceFactory
    ) {
        $this->blockRepository = $blockRepository;
        $this->blockInterfaceFactory = $blockInterfaceFactory;
    }

    public function install(\Magento\Framework\Setup\ModuleDataSetupInterface $setup, \Magento\Framework\Setup\ModuleContextInterface $context) {
        /** @var BlockInterface $cmsBlock */
        $blocksLimit = 10;
        $storeId = 1;
        $blockContent = <<<HTML
            <div class="post-wrapper">
                <h1>Home CMS Block Title</h1>
                <div class="post-author">by <a href="#">Syed Balkhi</a> on August 6, 2013</div>
                <div class="image">
                FEATURED IMAGE
                </div>
                <div class="post-content">
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse mauris tortor, 
                    rhoncus at diam ac, aliquet egestas elit. Integer varius, ipsum et imperdiet scelerisque, 
                    lorem magna feugiat arcu, sed rhoncus velit magna a velit.</p>
                </div>
                <div class="post-data">
                    <div class="post-categories">Categories: <a href="#">Business</a>, <a href="#">Marketing</a></div>
                    <div class="post-actions"><a href="#">Continue Reading »</a></div>
                </div>
            </div> 
HTML;

        for ($i=0; $i <= $blocksLimit; $i++) {
            $cmsBlock = $this->blockInterfaceFactory->create();
            $cmsBlock->setIdentifier('home_cms_block_' . $i);
            $cmsBlock->setTitle('Home CMS Block ' . $i);
            $cmsBlock->setContent($blockContent);
            $cmsBlock->setData('stores', $storeId);
            $this->blockRepository->save($cmsBlock);
        }
    }
}