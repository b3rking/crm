<?php
//$data = json_decode(file_get_contents('php://input'), true);
require_once("../../model/connection.php");
require_once("../../model/contract.class.php");

$contract = new Contract();

$invoice = $contract->getInvoiceToSendToObr($_GET['id'])->fetch();
$items_res = array();
foreach ($contract->getInvoiceItems($_GET['id']) as $value) {

    if ($value->quantite > 1) {



        $contract->validFacture($_GET['id']);
        $price = $value->montant;
        $exchange_rate = $value->exchange_rate;
        $monnaie = $value->monnaie;
        $exchange_currency = $value->exchange_currency;
        $tva = $value->montant_tvci + $value->montant_tva;

        if ($monnaie == 'USD' && $exchange_currency == 'USD') {

            $price_nvat = $tva * $value->quantite;
            $price = round($value->montant);
            $vat = $price_nvat * (18 / 100);
            $item_price_wvat = $price_nvat + $vat;

            $items_res[] = [
                "item_designation" => $value->description,
                "item_quantity" => $value->quantite,
                "item_ott_tax" => round($value->ott),
                "item_price" => round($price),
                "item_price_nvat" => round($price),
                "vat" => round($price_nvat),
                "item_price_wvat" => round($price + $price_nvat),
                "item_total_amount" => round($value->montant_total + $value->ott),
            ];
        
        } else if ($monnaie == 'USD' && $price <= 100000) {
            
            $price_nvat = ($tva * $value->quantite) * $exchange_rate;
            $price = $value->montant * $exchange_rate;
            $vat = ($price_nvat * (18 / 100));
            $item_price_wvat = ($price_nvat + $vat);
            $montant_total = $value->montant_total * $exchange_rate;

            $items_res[] = [
                "item_designation" => $value->description,
                "item_quantity" => $value->quantite,
                "item_ott_tax" => round($value->ott),
                "item_price" => round($price),
                "item_price_nvat" => round($price),
                "vat" => round($price_nvat),
                "item_price_wvat" => round($price + $price_nvat),
                "item_total_amount" => round($montant_total + $value->ott),
            ];

        } else {


            $htva = round($value->montant * $value->quantite);
            $tva = round($value->montant_tvci + $value->montant_tva);
            $tvac = round($value->montant_total_avant_reduction);
            $total = $tvac + $value->ott;

            if ($value->rediction > 0) {
                $multiplier = 1 - ($value->rediction / 100);
                $htva = round($htva * $multiplier);
                $tva = round($tva * $multiplier);
                $ntvac = round($tvac * $multiplier);

                $amount_to_reduce_on_total = $tvac - $ntvac;

                $tvac = $ntvac;

                $total = round($total - $amount_to_reduce_on_total);
            }

            $items_res[] = [
                "item_designation" => $value->description,
                "item_quantity" => $value->quantite,
                "item_ott_tax" => round($value->ott),
                "item_price" => $htva,
                "item_price_nvat" => $htva,
                "vat" => $tva,
                "item_price_wvat" => $tvac,
                "item_total_amount" => $total,
            ];
        }



    } else {
        


        $contract->validFacture($_GET['id']);
        $price = $value->montant;
        $exchange_rate = $value->exchange_rate;
        $monnaie = $value->monnaie;
        $exchange_currency = $value->exchange_currency;
        $tva = $value->montant_tvci + $value->montant_tva;

        if ($monnaie == 'USD' && $exchange_currency == 'USD') {

            $price_nvat = $tva * $value->quantite;
            $price = round($value->montant);
            $vat = $price_nvat * (18 / 100);
            $item_price_wvat = $price_nvat + $vat;

            $items_res[] = [
                "item_designation" => $value->description,
                "item_quantity" => $value->quantite,
                "item_ott_tax" => round($value->ott),
                "item_price" => round($price),
                "item_price_nvat" => round($price),
                "vat" => round($price_nvat),
                "item_price_wvat" => round($price + $price_nvat),
                "item_total_amount" => round($value->montant_total + $value->ott),
            ];
        
        } else if ($monnaie == 'USD' && $price <= 100000) {
            
            $price_nvat = ($tva * $value->quantite) * $exchange_rate;
            $price = $value->montant * $exchange_rate;
            $vat = ($price_nvat * (18 / 100));
            $item_price_wvat = ($price_nvat + $vat);
            $montant_total = $value->montant_total * $exchange_rate;

            $items_res[] = [
                "item_designation" => $value->description,
                "item_quantity" => $value->quantite,
                "item_ott_tax" => round($value->ott),
                "item_price" => round($price),
                "item_price_nvat" => round($price),
                "vat" => round($price_nvat),
                "item_price_wvat" => round($price + $price_nvat),
                "item_total_amount" => round($montant_total + $value->ott),
            ];

        } else {

            $price_nvat = $tva * $value->quantite;
            $price = $value->montant;
            $vat = $price_nvat * (18 / 100);
            $item_price_wvat = $price_nvat + $vat;

            $items_res[] = [
                "item_designation" => $value->description,
                "item_quantity" => $value->quantite,
                "item_ott_tax" => round($value->ott),
                "item_price" => round($price),
                "item_price_nvat" => round($price),
                "vat" => round($price_nvat),
                "item_price_wvat" => round($price + $price_nvat),
                "item_total_amount" => round($value->montant_total + $value->ott),
            ];
        }


    }
}


$data = [
    "invoice_number" => $invoice['numero'],
    "invoice_date" => $invoice['date_creation'],
    "invoice_type" => "FN",
    "tp_type" => "2",
    "tp_name" => "SPIDERNET S.A",
    "tp_TIN" => "4000000408",
    "tp_trade_number" => "67249",
    "tp_postal_number" => "1638",
    "tp_phone_number" => "76004400",
    "tp_address_province" => "Bujumbura",
    "tp_address_commune" => "MUKAZA",
    "tp_address_quartier" => "ASIATIQUE",
    "tp_address_avenue" => "kirundu",
    "tp_address_number" => "6",
    "vat_taxpayer" => "1",
    "ct_taxpayer" => "0",
    "tl_taxpayer" => "0",
    "tp_fiscal_center" => "19747",
    "tp_activity_sector" => "TELECOMMUNICATION",
    "tp_legal_form" => "SA",
    "payment_type" => "4",
    "invoice_currency" => $value->monnaie,
    "customer_name" => $invoice['nom_client'],
    "customer_TIN" => $invoice['nif'],
    "customer_address" => $invoice['adresse'],
    "vat_customer_payer" => $invoice['assujettiTVA'] == 'oui' ? "1" : "0",
    "cancelled_invoice_ref" => "",
    "invoice_ref" => "",
    "invoice_signature" => $invoice['invoice_signature'],
    "invoice_signature_date" => $invoice['date_creation'],
    "invoice_items" => $items_res,
];

echo json_encode($data);