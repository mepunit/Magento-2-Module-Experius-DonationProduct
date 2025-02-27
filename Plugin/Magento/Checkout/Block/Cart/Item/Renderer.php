<?php
/**
 * A Magento 2 module named Experius/DonationProduct
 * Copyright (C) 2017 Derrick Heesbeen
 *
 * This file is part of Experius/DonationProduct.
 *
 * Experius/DonationProduct is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program. If not, see <http://www.gnu.org/licenses/>.
 */

namespace ShivankitTech\SubsMod\Plugin\Magento\Checkout\Block\Cart\Item;

use ShivankitTech\SubsMod\Helper\Data;

/**
 * Class Renderer
 * @package ShivankitTech\SubsMod\Plugin\Magento\Checkout\Block\Cart\Item
 */
class Renderer
{

    /**
     * @var Data
     */
    protected $donationProductHelper;

    /**
     * Renderer constructor.
     * @param Data $donationProductHelper
     */
    public function __construct(
        Data $donationProductHelper
    ) {
    
        $this->donationProductHelper = $donationProductHelper;
    }

    /**
     * @param \Magento\Checkout\Block\Cart\Item\Renderer $subject
     * @param $result
     * @return array
     */
    public function afterGetProductOptions(
        \Magento\Checkout\Block\Cart\Item\Renderer $subject,
        $result
    ) {
        $item = $subject->getItem();
        $product = $item->getProduct();
        $typeId = $product->getTypeId();
        if ($typeId == \ShivankitTech\SubsMod\Model\Product\Type\Subscription::TYPE_CODE) {
            $itemOption = $item->getOptionByCode(Data::DONATION_OPTION_CODE);
            $options = [];
            $showOptionsInCart = false;
            if ($itemOption && $showOptionsInCart) {
                $options = $this->donationProductHelper->optionsJsonToMagentoOptionsArray(
                    $itemOption->getValue(),
                    $product
                );
            }

            return array_merge($options, $result);
        }

        return $result;
    }
}
