<?php

namespace App\Http\Controllers;

use App\Http\Requests\CsvImportRequest;
use App\Model\Client;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class FileController extends Controller
{
    public function parseImport(CsvImportRequest $request)
    {
        $path = $request->file('file')->getRealPath();
        $data = array_map('str_getcsv', file($path));

        $i_success = 0;
        $i_failure = 0;
        foreach ($data as $client)
        {
            $first_name = $client[0];
            $email= $client[1];

            if ( preg_match("/^[a-zA-Z0-9_-]/", $first_name) && preg_match("/^[a-zA-Z0-9._-]+@[a-zA-Z0-9-]+\.[a-zA-Z.]{2,5}$/", $email) )
            {
                try{
                    $res = Client::create([
                        'first_name' => $first_name,
                        'email' => $email,
                    ]);
                    $i_success++;
                }catch (\Exception $e){
                    $i_failure++;
                }
            }
            else {
                $i_failure++;
                continue;
            }
        }

        $result = [];
        if ($i_success){
            $result['success'] = 'You add ' . $i_success . ' new clients';
        }
        if ($i_failure) {
            $result['failure'] = 'SERVER ignored ' . $i_failure . ' BAD clients';
        }

        return response($result, Response::HTTP_CREATED);
    }
}
