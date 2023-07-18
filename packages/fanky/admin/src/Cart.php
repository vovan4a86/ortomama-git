<?php namespace Fanky\Admin;

use Fanky\Admin\Models\Product;
use Session;

class Cart {

    private static $key = 'cart';

    public static function add($item) {
        $cart = self::all();

        $cart[$item['id']] = $item;
        Session::put(self::$key, $cart);
    }

    public static function count() {
        $cart = self::all();

        return count($cart);
    }

    public static function total_items() {
        $cart = self::all();

        $total_items = 0;
        foreach ($cart as $item) {
            $total_items += $item['count'];
        }

        return $total_items;
    }

    public static function remove($id) {
        $cart = self::all();
        unset($cart[$id]);
        Session::put(self::$key, $cart);
    }

    public static function ifInCart($id): bool {
        $cart = self::all();
        return isset($cart[$id]);
    }

    public static function updateCount($id, $count) {
        $cart = self::all();
        if (isset($cart[$id])) {
            $cart[$id]['count'] = $count;
            Session::put(self::$key, $cart);
        }
    }

    public static function purge() {
        Session::put(self::$key, []);
    }

    public static function all(): array {
        $res = Session::get(self::$key, []);
        return is_array($res) ? $res : [];
    }

    public static function sum(): int {
        $cart = self::all();
        $sum = 0;
        foreach ($cart as $item) {
            $sum += $item['count'] * $item['price'];
        }
        return $sum;
    }
}
