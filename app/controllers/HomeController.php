<?php

namespace App\Controllers;

use App\Models\Item;
use Core\BaseController;

class HomeController extends BaseController
{

    public function index()
    {
        $this->render('index');
    }

    public function showProduct()
    {
        $id = $_GET['search'] ?? null;
        
        $data = $this->getData($id, 1);

        $this->render('card', $data);
    }

    public function updatePrice(){
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Получаем данные из тела запроса
            $data = json_decode(file_get_contents('php://input'), true);
            
            $quantity = (int) $data['quantity'];
            $selectedOptions = $data['selectedOptions'];
            $itemId = (int) $data['itemId'];
            
            $data = $this->getData($itemId, $quantity);
            // include __DIR__ . '/../views/fetch/price_container.php';
            ob_start();
            $this->render('fetch/price_container', $data);
            $html = ob_get_clean();

            // Возвращаем HTML клиенту
            header('Content-Type: text/html');
            echo $html;
        }
    }
    public function getData($id, $count_item){
        $data['item'] = Item::find($id);
        $data['count_item'] = $count_item;
        if($count_item > 1000){
            $data['actual_price'] = $data['item']->price - ($data['item']->price * ($data['item']->discount()->from1000 / 100));
            $data['actual_price_options_of'] = $data['item']->price - ($data['item']->price * ($data['item']->discount()->from1000 / 100));
        }
        elseif($count_item > 500){
            $data['actual_price'] = $data['item']->price - ($data['item']->price * ($data['item']->discount()->from500 / 100));
            $data['actual_price_options_of'] = $data['item']->price - ($data['item']->price * ($data['item']->discount()->from500 / 100));
        }
        elseif($count_item > 300){
            $data['actual_price'] = $data['item']->price - ($data['item']->price * ($data['item']->discount()->from300 / 100));
            $data['actual_price_options_of'] = $data['item']->price - ($data['item']->price * ($data['item']->discount()->from300 / 100));
        }
        elseif($count_item > 100){
            $data['actual_price'] = $data['item']->price - ($data['item']->price * ($data['item']->discount()->from100 / 100));
            $data['actual_price_options_of'] = $data['item']->price - ($data['item']->price * ($data['item']->discount()->from100 / 100));
        }
        elseif($count_item > 50){
            $data['actual_price'] = $data['item']->price - ($data['item']->price * ($data['item']->discount()->from50 / 100));
            $data['actual_price_options_of'] = $data['item']->price - ($data['item']->price * ($data['item']->discount()->from50 / 100));
        }
        else{
            $data['actual_price'] = $data['item']->price;
            $data['actual_price_options_of'] = $data['item']->price;
        }
        return $data;
    }
}