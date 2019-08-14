<?php

/**
 * EaDesgin
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Academic Free License (AFL 3.0)
 * that is bundled with this package in the file LICENSE_AFL.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/afl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@eadesign.ro so we can send you a copy immediately.
 *
 * @category    Eadesigndev_Shipestimation
 * @copyright   Copyright (c) 2008-2015 EaDesign by Eco Active S.R.L.
 * @license     http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
 */
class Eadesigndev_Shipestimation_IndexController extends Mage_Core_Controller_Front_Action
{


    public function indexAction()
    {
    }

    public function quotationAction()
    {

        $shippingblock = $this->getLayout()->createBlock('checkout/cart_shipping');

        $country = $this->getRequest()->getParam('country_id');
        $regionId = $this->getRequest()->getParam('region_id');
        $cityId = $this->getRequest()->getParam('city_id');
        $zipId = $this->getRequest()->getParam('zip');
        $productId = $this->getRequest()->getParam('productId');

        $_product = Mage::getModel('catalog/product')->load($productId);

        $quote = Mage::getModel('sales/quote');

        $shippingAddress = $quote->getShippingAddress();
        $shippingAddress->setCountryId($country);
        $shippingAddress->setRegionId($regionId);
        $shippingAddress->setCity($cityId);
        $shippingAddress->setPostcode($zipId);
        $shippingAddress->setCollectShippingRates(true);


        $quote->addProduct($_product);
        $quote->getShippingAddress()->collectTotals();
        $quote->getShippingAddress()->setCollectShippingRates(true);
        $quote->getShippingAddress()->collectShippingRates();

        $rates = $quote->getShippingAddress()->getGroupedAllShippingRates();


        if(empty($rates)){
             echo  Mage::helper('shipping')->__('There are no rates available');
        }


        foreach ($rates as $code=>$rate) {
            $carierName = '<div class="cariername">'
                . $shippingblock->getCarrierName($code)
                .'</div>';
            echo $carierName;

            foreach($rate as $r){
                $price = Mage::helper('core')->currency($r->getPrice(), true, false);
                $rates  = '<div>'
                    . $r->getMethodTitle()
                    . ' <strong>'
                    . $price
                    .' </strong>';
                echo $rates;
            }

        }
        return;
    }
}
