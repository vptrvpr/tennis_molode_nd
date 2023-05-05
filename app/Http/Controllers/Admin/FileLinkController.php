<?php

namespace App\Http\Controllers\Admin;

use App\FileLink;
use App\Helpers\StringHelper;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;

class FileLinkController extends Controller
{
    public function get()
    {
        return FileLink::all();
    }


    public function delete( $id )
    {
        FileLink::where( 'id', $id )->delete();
    }


    public function store( Request $request )
    {
        $requestJSON = json_decode( $request->get( 'json' ) );

        $fileLink       = new FileLink();
        $fileLink->name = $requestJSON->name;

        if( $request->file( 'file' ) ) {
            $file          = $request->file( 'file' );
            $fileExtension = $file->getClientOriginalExtension();
            $rand          = StringHelper::strRandom( 6 );
            $fileName      = "$rand.$fileExtension";
            $file->move( public_path( 'storage/file-links/' ), $fileName );
            $fileLink->file = $fileName;
        }


        $fileLink->save();

    }
}
