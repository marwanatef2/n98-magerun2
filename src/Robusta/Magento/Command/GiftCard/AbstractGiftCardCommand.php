<?php

namespace Robusta\Magento\Command\GiftCard;

use Magento\GiftCardAccount\Model\Giftcardaccount;
use Robusta\Magento\Command\AbstractMagentoCommand;

/**
 * Class AbstractGiftCardCommand
 * @package Robusta\Magento\Command\GiftCard
 */
abstract class AbstractGiftCardCommand extends AbstractMagentoCommand
{
    /**
     * @return bool
     */
    public function isEnabled()
    {
        return $this->getApplication()->isMagentoEnterprise();
    }

    /**
     * Get the gift card model, optionally loading from an ID
     * @param  string|null $code
     * @return Giftcardaccount
     */
    public function getGiftcard($code = null)
    {
        $giftcard = $this->getObjectManager()->get(Giftcardaccount::class);
        if ($code !== null) {
            $giftcard->loadByCode($code);
        }
        return $giftcard;
    }

    /**
     * Required to avoid "Area code not set" exceptions from Mage framework
     */
    public function setAdminArea()
    {
        $appState = $this->getObjectManager()->get(\Magento\Framework\App\State::class);
        $appState->setAreaCode('adminhtml');
    }
}
