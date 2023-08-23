<?php

use Illuminate\Support\Facades\DB;

Route::get('/', function () {
  $visited = DB::select('select * from user where id = ?', [1]);

  return view('travel_list', ['visited' => $visited] );
});
