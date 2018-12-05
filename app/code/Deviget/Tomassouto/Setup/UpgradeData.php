<?php
/**
 * Created by: Tomas Souto
 * E-mail: tomas.souto@gmail.com
 * Date: 12/3/18
 * Time: 6:15 PM
 */

namespace Deviget\Tomassouto\Setup;

use Magento\Cms\Api\BlockRepositoryInterface;
use Magento\Cms\Api\Data\BlockInterface;
use Magento\Cms\Api\Data\BlockInterfaceFactory;
use Magento\Framework\Setup\InstallDataInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Cms\Model\Page;
use Magento\Cms\Model\PageFactory;

class UpgradeData implements \Magento\Framework\Setup\UpgradeDataInterface {

    /**
     *
     * @SuppressWarnings(PHPMD.ExcessiveMethodLength)
     */

    /** @var  BlockRepositoryInterface */
    private $blockRepository;
    /** @var BlockFactory */
    private $blockInterfaceFactory;
    /**
     * Page factory
     *
     * @var PageFactory
     */
    private $pageFactory;

    const HOME_PAGE_ID = 2;


    /**
     * InstallData constructor.
     * @param BlockRepositoryInterface $blockRepository
     * @param BlockInterfaceFactory $blockInterfaceFactory
     */
    public function __construct(
        BlockRepositoryInterface $blockRepository,
        BlockInterfaceFactory $blockInterfaceFactory,
        PageFactory $pageFactory
    ) {
        $this->blockRepository = $blockRepository;
        $this->blockInterfaceFactory = $blockInterfaceFactory;
        $this->pageFactory = $pageFactory;
    }

    /**
     * Create page
     *
     * @return Page
     */
    private function createPage()
    {
        return $this->pageFactory->create();
    }

    /**
     *
     * @SuppressWarnings(PHPMD.ExcessiveMethodLength)
     */
    public function upgrade(\Magento\Framework\Setup\ModuleDataSetupInterface $setup, \Magento\Framework\Setup\ModuleContextInterface $context) {
        $setup->startSetup();

        if (version_compare($context->getVersion(), '0.1.1', '<=')) {
            $storeId = 1;
            $blockContent = <<<HTML
            <div class="follow-wrapper">
                <h1>Follow Me</h1>
                <ul>
                <li class="twitter"><a href="#">Twitter</a></li>
                <li class="facebook"><a href="#">Facebook</a></li>
                <li class="pinterest"><a href="#">Pinterest</a></li>
                <li class="gplus"><a href="#">gplus</a></li>
                <li class="rss"><a href="#">rss</a></li>
                </ul>
            </div>
HTML;

            $cmsBlock = $this->blockInterfaceFactory->create();
            $cmsBlock->setIdentifier('home_follow_me');
            $cmsBlock->setTitle('Follow Me');
            $cmsBlock->setContent($blockContent);
            $cmsBlock->setData('stores', $storeId);
            $this->blockRepository->save($cmsBlock);
        }

        elseif (version_compare($context->getVersion(), '0.1.8', '<=')) {

            $homePage = $this->createPage()->load(self::HOME_PAGE_ID);
            $homePageId = $homePage->getId();

            if ($homePageId) {
                $homePage->setPageLayout('2columns-right');
                $homePage->setContent('<div></div>');
                $homePage->save();
            }

        }

        if (version_compare($context->getVersion(), '0.1.9', '<=')) {
            $storeId = 1;
            $blockContent = <<<HTML
            <div class="profile-wrapper">
                <div class="profile-image">Profile Photo</div>
                <div class="profile-text">
                    <h1>Tomas Souto</h1>
                    <p>My name is Tomas, I’m from Argentina and I’m a web developer specialized on Drupal 
                    and Magento front-end (Certified). I have 15+ years of experience as web developer, 8+ years 
                    of experience working with Drupal, worked on 40+ Drupal sites and 100+ custom modules/extensions 
                    for all possible applications, from simple forms to big pages using Solr (for search), 
                    APIs integration (Facebook, Google, Yelp, etc). Worked on modules for statistics, reports, 
                    CMR and a lot of other applications.</p>
                    <a href="#">Read More »</a>
                </div>
            </div>
HTML;

            $cmsBlock = $this->blockInterfaceFactory->create();
            $cmsBlock->setIdentifier('profile_sidebar');
            $cmsBlock->setTitle('Profile Sidebar');
            $cmsBlock->setContent($blockContent);
            $cmsBlock->setData('stores', $storeId);
            $this->blockRepository->save($cmsBlock);
        }

        $setup->endSetup();
    }
}