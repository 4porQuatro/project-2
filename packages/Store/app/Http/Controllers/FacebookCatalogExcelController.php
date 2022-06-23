<?php

namespace Packages\Store\app\Http\Controllers;

use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use Packages\Store\app\Exports\ProductFacebookCatalogExport;


class FacebookCatalogExcelController extends Controller
{
   public function download()
   {
//       return Excel::download(new ProductFacebookCatalogExport(), 'catalog_products.csv');
       return Excel::download(new ProductFacebookCatalogExport(), 'catalog_products.csv', \Maatwebsite\Excel\Excel::CSV);
   }
}
