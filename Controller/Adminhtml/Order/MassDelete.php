<?php
/**
 * Copyright © 2015 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Ibnab\DeleteOrders\Controller\Adminhtml\Order;
//use Magento\Framework\Model\Resource\Db\Collection\AbstractCollection;
use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use Magento\Backend\App\Action\Context;
use Magento\Sales\Model\ResourceModel\Order\CollectionFactory;
use Magento\Ui\Component\MassAction\Filter;
use Magento\Framework\App\ResourceConnection;
class MassDelete extends \Magento\Sales\Controller\Adminhtml\Order\AbstractMassAction
{
  public $_resource;

  public function __construct(Context $context,
  ResourceConnection $resource,
  Filter $filter, CollectionFactory $collectionFactory)
    {
        
    $this->_resource = $resource;
    parent::__construct($context , $filter);
    $this->collectionFactory = $collectionFactory;
 
  }
    /**
     * Cancel selected orders
     *
     * @param AbstractCollection $collection
     * @return \Magento\Backend\Model\View\Result\Redirect
     */
    protected function massAction(AbstractCollection $collection)
    {
        $countCancelOrder = 0;
        $connection = $this->_resource->getConnection(\Magento\Framework\App\ResourceConnection::DEFAULT_CONNECTION);
        $showTables = $connection->fetchCol('show tables');
//start get table name
        
        $tblSalesOrder = $connection->getTableName('sales_order');
        $tblSalesCreditmemoComment = $connection->getTableName('sales_creditmemo_comment');
        $tblSalesCreditmemoItem = $connection->getTableName('sales_creditmemo_item');
        $tblSalesCreditmemo = $connection->getTableName('sales_creditmemo');
        $tblSalesCreditmemoGrid = $connection->getTableName('sales_creditmemo_grid');
        $tblSalesInvoiceComment = $connection->getTableName('sales_invoice_comment');
        $tblSalesInvoiceItem = $connection->getTableName('sales_invoice_item');
        $tblSalesInvoice = $connection->getTableName('sales_invoice');
        $tblSalesInvoiceGrid = $connection->getTableName('sales_invoice_grid');
        $tblQuoteAddressItem = $connection->getTableName('quote_address_item');
        $tblQuoteItemOption = $connection->getTableName('quote_item_option');
        $tblQuote = $connection->getTableName('quote');
        $tblQuoteAddress = $connection->getTableName('quote_address');
        $tblQuoteItem = $connection->getTableName('quote_item');
        $tblQuotePayment = $connection->getTableName('quote_payment');
        $tblQuoteShippingRate = $connection->getTableName('quote_shipping_rate');
        $tblQuoteIDMask = $connection->getTableName('quote_id_mask');
        $tblSalesShipmentComment = $connection->getTableName('sales_shipment_comment');
        $tblSalesShipmentItem = $connection->getTableName('sales_shipment_item');
        $tblSalesShipmentTrack = $connection->getTableName('sales_shipment_track');
        $tblSalesShipment = $connection->getTableName('sales_shipment');
        $tblSalesShipmentGrid = $connection->getTableName('sales_shipment_grid');
        $tblSalesOrderAddress = $connection->getTableName('sales_order_address');
        $tblSalesOrderItem = $connection->getTableName('sales_order_item');
        $tblSalesOrderPayment = $connection->getTableName('sales_order_payment');
        $tblSalesOrderStatusHistory = $connection->getTableName('sales_order_status_history');
        $tblSalesOrderGrid = $connection->getTableName('sales_order_grid');
        $tblLogQuote = $connection->getTableName('log_quote');
        $showTablesLog = $connection->fetchCol('SHOW TABLES LIKE ?', '%'.$tblLogQuote);
        $tblSalesOrderTax = $connection->getTableName('sales_order_tax');       
        foreach ($collection->getItems() as $order) {

                $orderId = $order->getId();
                if ($order->getIncrementId()) {
                    $incId = $order->getIncrementId();
                    if (in_array($tblSalesOrder, $showTables)) {
                        $result1 = $connection->fetchAll('SELECT quote_id FROM `'.$tblSalesOrder.'` WHERE entity_id='.$orderId);
                        $quoteId = (int) $result1[0]['quote_id'];
                    }
                    $connection->rawQuery('SET FOREIGN_KEY_CHECKS=1');
                    if (in_array($tblSalesCreditmemoComment, $showTables)) {
                        $connection->rawQuery('DELETE FROM `'.$tblSalesCreditmemoComment.'` WHERE parent_id IN (SELECT entity_id FROM `'.$tblSalesCreditmemo.'` WHERE order_id='.$orderId.')');
                    }
                    if (in_array('sales__creditmemo_item', $showTables)) {
                        $connection->rawQuery('DELETE FROM `'.$tblSalesCreditmemoItem.'` WHERE parent_id IN (SELECT entity_id FROM `'.$tblSalesCreditmemo.'` WHERE order_id='.$orderId.')');
                    }
                    if (in_array($tblSalesCreditmemo, $showTables)) {
                        $connection->rawQuery('DELETE FROM `'.$tblSalesCreditmemo.'` WHERE order_id='.$orderId);
                    }
                    if (in_array($tblSalesCreditmemoGrid, $showTables)) {
                        $connection->rawQuery('DELETE FROM `'.$tblSalesCreditmemoGrid.'` WHERE order_id='.$orderId);
                    }
                    if (in_array($tblSalesInvoiceComment, $showTables)) {
                        $connection->rawQuery('DELETE FROM `'.$tblSalesInvoiceComment.'` WHERE parent_id IN (SELECT entity_id FROM `'.$tblSalesInvoice.'` WHERE order_id='.$orderId.')');
                    }
                    if (in_array($tblSalesInvoiceItem, $showTables)) {
                        $connection->rawQuery('DELETE FROM `'.$tblSalesInvoiceItem.'` WHERE parent_id IN (SELECT entity_id FROM `'.$tblSalesInvoice.'` WHERE order_id='.$orderId.')');
                    }
                    if (in_array($tblSalesInvoice, $showTables)) {
                        $connection->rawQuery('DELETE FROM `'.$tblSalesInvoice.'` WHERE order_id='.$orderId);
                    }
                    if (in_array($tblSalesInvoiceGrid, $showTables)) {
                        $connection->rawQuery('DELETE FROM `'.$tblSalesInvoiceGrid.'` WHERE order_id='.$orderId);
                    }
                    if ($quoteId) {
                        if (in_array($tblQuoteAddressItem, $showTables)) {
                            $connection->rawQuery('DELETE FROM `'.$tblQuoteAddressItem.'` WHERE parent_item_id IN (SELECT address_id FROM `'.$tblQuoteAddress.'` WHERE quote_id='.$quoteId.')');
                        }
                        if (in_array($tblQuoteShippingRate, $showTables)) {
                            $connection->rawQuery('DELETE FROM `'.$tblQuoteShippingRate.'` WHERE address_id IN (SELECT address_id FROM `'.$tblQuoteAddress.'` WHERE quote_id='.$quoteId.')');
                        }
                       if (in_array($tblQuoteIDMask, $showTables)) {
                           $connection->rawQuery('DELETE FROM `'.$tblQuoteIDMask.'` where quote_id='.$quoteId);
                        }
                        if (in_array($tblQuoteItemOption, $showTables)) {
                            $connection->rawQuery('DELETE FROM `'.$tblQuoteItemOption.'` WHERE item_id IN (SELECT item_id FROM `'.$tblQuoteItem.'` WHERE quote_id='.$quoteId.')');
                        }
                        if (in_array($tblQuote, $showTables)) {
                            $connection->rawQuery('DELETE FROM `'.$tblQuote.'` WHERE entity_id='.$quoteId);
                        }
                        if (in_array($tblQuoteAddress, $showTables)) {
                            $connection->rawQuery('DELETE FROM `'.$tblQuoteAddress.'` WHERE quote_id='.$quoteId);
                        }
                        if (in_array($tblQuoteItem, $showTables)) {
                            $connection->rawQuery('DELETE FROM `'.$tblQuoteItem.'` WHERE quote_id='.$quoteId);
                        }
                        if (in_array('sales__quotePayment', $showTables)) {
                            $connection->rawQuery('DELETE FROM `'.$tblQuotePayment.'` WHERE quote_id='.$quoteId);
                        }
                    }
                    if (in_array($tblSalesShipmentComment, $showTables)) {
                        $connection->rawQuery('DELETE FROM `'.$tblSalesShipmentComment.'` WHERE parent_id IN (SELECT entity_id FROM `'.$tblSalesShipment.'` WHERE order_id='.$orderId.')');
                    }
                    if (in_array($tblSalesShipmentItem, $showTables)) {
                        $connection->rawQuery('DELETE FROM `'.$tblSalesShipmentItem.'` WHERE parent_id IN (SELECT entity_id FROM `'.$tblSalesShipment.'` WHERE order_id='.$orderId.')');
                    }
                    if (in_array($tblSalesShipmentTrack, $showTables)) {
                        $connection->rawQuery('DELETE FROM `'.$tblSalesShipmentTrack.'` WHERE order_id IN (SELECT entity_id FROM `'.$tblSalesShipment.'` WHERE parent_id='.$orderId.')');
                    }
                    if (in_array($tblSalesShipment, $showTables)) {
                        $connection->rawQuery('DELETE FROM `'.$tblSalesShipment.'` WHERE order_id='.$orderId);
                    }
                    if (in_array($tblSalesShipmentGrid, $showTables)) {
                        $connection->rawQuery('DELETE FROM `'.$tblSalesShipmentGrid.'` WHERE order_id='.$orderId);
                    }
                    if (in_array($tblSalesOrder, $showTables)) {
                        $connection->rawQuery('DELETE FROM `'.$tblSalesOrder.'` WHERE entity_id='.$orderId);
                    }
                    if (in_array($tblSalesOrderAddress, $showTables)) {
                        $connection->rawQuery('DELETE FROM `'.$tblSalesOrderAddress.'` WHERE parent_id='.$orderId);
                    }
                    if (in_array($tblSalesOrderItem, $showTables)) {
                        $connection->rawQuery('DELETE FROM `'.$tblSalesOrderItem.'` WHERE order_id='.$orderId);
                    }
                    if (in_array($tblSalesOrderPayment, $showTables)) {
                        $connection->rawQuery('DELETE FROM `'.$tblSalesOrderPayment.'` WHERE parent_id='.$orderId);
                    }
                    if (in_array($tblSalesOrderStatusHistory, $showTables)) {
                        $connection->rawQuery('DELETE FROM `'.$tblSalesOrderStatusHistory.'` WHERE parent_id='.$orderId);
                    }
                    if ($incId && in_array($tblSalesOrderGrid, $showTables)) {
                        $connection->rawQuery('DELETE FROM `'.$tblSalesOrderGrid.'` WHERE increment_id='.$incId);
                    }
                    if (in_array($tblSalesOrderTax, $showTables)) {
                        $connection->rawQuery('DELETE FROM `'.$tblSalesOrderTax.'` WHERE order_id='.$orderId);
                    }
                    if ($quoteId && $showTablesLog) {
                        $connection->rawQuery('DELETE FROM `'.$tblLogQuote.'` WHERE quote_id='.$quoteId);
                    }
                    $connection->rawQuery('SET FOREIGN_KEY_CHECKS=1');
                }

            $countCancelOrder++;
        }
        $countNonCancelOrder = $collection->count() - $countCancelOrder;

        if ($countNonCancelOrder && $countCancelOrder) {
            $this->messageManager->addError(__('%1 order(s) cannot be deleted.', $countNonCancelOrder));
        } elseif ($countNonCancelOrder) {
            $this->messageManager->addError(__('You cannot delete the order(s).'));
        }

        if ($countCancelOrder) {
            $this->messageManager->addSuccess(__('We deleted %1 order(s).', $countCancelOrder));
        }
        $resultRedirect = $this->resultRedirectFactory->create();
        $resultRedirect->setPath('sales/*/');
        return $resultRedirect;
    }
}
