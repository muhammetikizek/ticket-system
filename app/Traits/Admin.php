<?php

namespace App\Traits;

trait Admin {

    protected function adminView($view, $data = [])
    {
        return view('admin.'.$view, $data);
    }
}
