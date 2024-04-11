<?php

class MenuItemManager {
    private $menuItemModel;
    private $billModel;
    private $billItemModel;

    public function __construct() {
        $this->menuItemModel = new MenuItemModel();
        $this->billModel = new BillModel();
        $this->billItemModel = new BillItemModel();
    }

    public function getMostSoldItems() {
        $items =  $this->menuItemModel->findAllByItemsSold();

        $mostSoldItems = array_slice(
           $items,
            0,
            count($items) < 10 ? count($items): 10
        );

        if (count($items) <= 10) return $mostSoldItems;

        $lastItemIndex = count($items) < 10 ? count($items) - 1 : 9;
        $lastItemItemsSold = $mostSoldItems[$lastItemIndex]['items_sold'];
        $x = $lastItemIndex + 1;

        // this checks for duplicate values like if the 10th and 11th have the same number sold
        while ($x < count($items) - 1) {
            if($items[$x]['items_sold'] === $lastItemItemsSold) {
                array_push($mostSoldItems, $items[$x]);
            } else {
                break;
            }
            $x++;
        }

        return $mostSoldItems;
    }

    public function getMostProfitableItems() {
        $items =  $this->menuItemModel->findAllByMostProfitGenerated();
        $mostProfitableItems = array_slice(
           $items,
            0,
            count($items) < 10 ? count($items) : 10
        );

        if (count($items) <= 10) return $mostProfitableItems;

        $lastItemIndex = count($items) < 10 ? count($items) - 1 : 9;
        $lastItemProfitGenerated = $mostProfitableItems[$lastItemIndex]['profit_generated'];
        $x = $lastItemIndex + 1;

        //  // this checks for duplicate values like if the 10th and 11th have the same number profit generated
        while ($x < count($items) - 1) {
            if($items[$x]['profit_generated'] === $lastItemProfitGenerated) {
                array_push($mostProfitableItems, $items[$x]);
            } else {
                break;
            }
            $x++;
        }

        return $mostProfitableItems;
    }

    public function getItemsSoldWithinPeriod($startDate, $endDate) {
        $this->billModel->set_status("cancelled");
        $bills = $this->billModel->findAllWithinPeriod($startDate, $endDate); 
        $items = [
            "labels" => [],
            "data" => []
        ];


        foreach($bills as $bill) {
            
            $this->billItemModel->set_bill_id($bill['id']);
            foreach($this->billItemModel->findAllForBill() as $billItem) {
                if (!in_array($billItem['name'], $items['labels'])) {
                    array_push($items['labels'], $billItem['name']);
                    array_push($items['data'], $billItem['amount']);


                } else {
                    $index = array_search($billItem['name'], $items['labels']);
                    $items['data'][$index] += $billItem['amount'];
                }
            }
        }

        return $items;
    }

    public function getItemsSoldWithinPeriodLine($startDate, $endDate) {
        $this->billModel->set_status("cancelled");
  
        $bills = $this->billModel->findAllWithinPeriod($startDate, $endDate); 
        $items = [
            "title" => [],
            "data" => []
        ];

        foreach($bills as $bill) {
            $this->billItemModel->set_bill_id($bill['id']);
            foreach($this->billItemModel->findAllForBill() as $billItem) {
                if (!in_array($billItem['name'], $items['title'])) {
                    array_push($items['title'], $billItem['name']);
                    $data = [];
                    $start = new DateTime($startDate);
                    $end = new DateTime($endDate);
            
                    while ($start <= $end) {
                        if($bill['order_date'] == $start->format('Y-m-d')) {
                            array_push($data, $billItem['amount']);
                        } else {
                            array_push($data, 0);
                        }
                        $start->modify('+1 day');
                    }
                    array_push($items['data'], $data);
                } else {
                    $index = array_search($billItem['name'], $items['title']);
                    $start = new DateTime($startDate);
                    $end = new DateTime($endDate);
                    $x = 0;
                    while ($start <= $end) {
                        if($bill['order_date'] == $start->format('Y-m-d')) {
                            $items['data'][$index][$x] += $billItem['amount'];
                        }
                        $x++;
                        $start->modify('+1 day');
                    }
                }
            }
        }

        return $items;

    }

}

