<?php

namespace App\Controllers;

use App\Models\Currency;
use Doctrine\DBAL\DriverManager;
use Sabre\Xml\Service;

class CurrencyController
{

    public function index()
    {
        $currencyQuery = query()
            ->select('*')
            ->from('currency')
            ->execute()
            ->fetchAllAssociative();

        $currencies = [];

        foreach ($currencyQuery as $currency) {
            $currencies [] = new Currency (
                (string)$currency['name'],
                (float)$currency['rate']
        );
        }

        return require_once __DIR__ . '/../Views/CurrencyView.php';
    }

    public function store()
    {
        $xml = file_get_contents('https://www.bank.lv/vk/ecb.xml');
        $service = new Service();
        $service->elementMap = [
            'Currency' => 'Sabre\Xml\Deserializer\keyValue',
        ];
        $result = $service->parse($xml);

        $data = [];

        foreach ($result[1]['value'] as $row) {
            $data[] = [
                $row['value'][0]['value'],
                $row['value'][1]['value']
            ];
        }

        foreach ($data as $currency) {

            $checking = query()
                ->select('*')
                ->from('currency')
                ->where('name = :name')
                ->setParameter('name', $currency[0])
                ->execute()
                ->fetchAssociative();

        }
        if (empty($table)) {
            query()
                ->insert('currency')
                ->values([
                    'name' => ':name',
                    'rate' => ':rate'
                ])
                ->setParameter('name', $currency[0])
                ->setParameter('rate', $currency[1])
                ->execute();

        } else {
            query()
                ->update('currency')
                ->set('name', ':name')
                ->set('rate', ':rate')
                ->setParameters([
                    'name' => $currency[0],
                    'rate' => $currency[1],
                ])
                ->where('name = :name')
                ->setParameter('name', $currency[0])
                ->execute();
        }


        header('Location: /');
    }

}