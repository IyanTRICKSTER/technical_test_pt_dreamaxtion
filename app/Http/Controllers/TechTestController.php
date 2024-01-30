<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class TechTestController extends Controller
{


    public function sortingNumber()
    {

        $arr = [9, 3, 7, 8, 2, 6, 1, 4, 10, 2, 2, 3];

        for ($i = 0; $i < count($arr) - 1; $i++) {
            for ($j = 0; $j < count($arr) - 1; $j++) {
                if ($arr[$j] > $arr[$j + 1]) {
                    $temp = $arr[$j];
                    $arr[$j] = $arr[$j + 1];
                    $arr[$j + 1] = $temp;


                }
            }
        }

        return $arr;
    }



    public function countLetter()
    {

        $letters = 'aaabbcccddeddbzaa';

        $res = [];

        $letters = str_split($letters);

        for ($i = 0; $i < count($letters); $i++) {
            if (key_exists($letters[$i], $res)) {
                $res[$letters[$i]] += 1;
            } else {
                $res[$letters[$i]] = 1;
            }
        }


        $keys = array_keys($res);
        $out = "";
        for ($i = 0; $i < count($res); $i++) {
            if ($res[$keys[$i]] == 1) {
                $out .= $keys[$i];

            } else {

                $out .= $keys[$i] . $res[$keys[$i]];
            }
        }

        return $out;

    }

    public function hargaBarang($productType, $quantity)
    {

        //ITEM A => if jumlah beli > 50 => diskon 5%  AND beli di senin OR kamis tambahan diskon 10%

        //ITEM B => if jumlah beli > 100 => diskon 10% AND beli di jumat tambah diskon 5%

        try {
            $productTypes = [
                'A' => 99900,
                'B' => 49900,
            ];
    
            $grossPrice = $productTypes[$productType] * $quantity;

    
            if ($productType == 'A') {
                $discount = 1;
                if ($quantity > 50) {
                    $discount = 50;
    
                    if (Carbon::now()->isoFormat('dddd') == 'Monday' || Carbon::now()->isoFormat('dddd') == 'Thursday') {
                        $discount += 10;
                    }
                }
    
    
                return $grossPrice * ($discount / 100);
    
            } else if ($productType == 'B') {
    
                $discount = 1;
                if ($quantity > 100) {
                    $discount = 10;
    
                    if (Carbon::now()->isoFormat('dddd') == 'Friday') {
                        $discount += 5;
                    }
                }
    
                return $grossPrice * ($discount / 100);
    
            } else {
                return 'Tidak ada barang dengan tipe ' . $productType;
            }

        } catch (\Throwable $th) {

            return 'Terjadi kesalahan ' . $th->getMessage();
        }

    }

    public function runTest()
    {
        return response()->json([
            'data' => [
                'total_kemunculan_huruf' => $this->countLetter(),
                'angke_berurut' => $this->sortingNumber(),
                'output_harga_arang' => $this->hargaBarang('B', 50),
            ]
        ]);
    }

}
