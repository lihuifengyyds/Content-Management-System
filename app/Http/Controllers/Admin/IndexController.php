<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use PharIo\Version\Version;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class IndexController extends Controller
{
    public function index(Request $request)
    {
        $data = [
            'server_version' => $request->server('SERVER_SOFTWARE'),
            'laravel_version' => app()->version(),
            'mysql_version' => $this->getMySQLVer(), 
            'server_time' => date('Y-m-d H:i:s', time()),
            'upload_max_filesize' => ini_get('file_uploads') ? 
            ini_get('upload_max_filesize') : '已禁用',
            'max_execution_time' => ini_get('max_execution_time') . '秒'
        ];
        return view('admin.index', $data);
    }
    private function getMySQLVer()
    {
        $res = DB::select('SELECT VERSION() AS ver'); 
        return $res[0]->ver ?? '未知';   
    }
}
