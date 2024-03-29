<?php

namespace App;

class Router {
    static $pages = [];
    static function __callStatic($name, $args) {
        if(strtolower($_SERVER["REQUEST_METHOD"]) == $name) {
            self::$pages[] = $args;
        }
    }

    static function start() {
        $currentURL = explode("?", $_SERVER["REQUEST_URI"])[0];
        foreach(self::$pages as $page) {
            $url = $page[0];
            $action = explode("@", $page[1]);
            $permission = isset($page[2]) ? $page[2] : null;

            $regex = preg_replace("/({[^\/]+})/", "([^/]+)");
            $regex = preg_replace("/\//", "\\/");

            if(preg_match("/^{$regex}$/", $currentURL, $actions)) {
                unset($actions[0]);

                if($permission) {
                    if($permission == "guest" && user()) go("/", "비회원만 접근하실 수 있습니다.");
                    if($permission == "user" && !user()) go("/login", "로그인 후 접근하실 수 있습니다.");
                    if($permission == "company" && !company()) go("/", "기업회원만 접근하실 수 있습니다.");
                    if($permission == "admin" && !admin()) go("/", "관리자만 접근하실 수 있습니다.");
                }
            }
        }
    }
}