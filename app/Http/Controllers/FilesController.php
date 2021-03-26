<?php

namespace App\Http\Controllers;

use App\Models\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Response;

class FilesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $files = Storage::disk('files')->get('Webstamps.pdf');

        // $directories = Storage::disk('files')->allDirectories();
        $files = Storage::disk('files')->allFiles();

        return response()->json([
            // 'directories' => $directories,
            'files' => $files,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\File  $file
     * @return \Illuminate\Http\Response
     */
    public function download($filePath)
    {
        return Storage::disk('files')->download(urldecode($filePath));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\File  $file
     * @return \Illuminate\Http\Response
     */
    // public function getSize($filePath)
    public function getSize(Request $request)
    {
        $filePath = $request->filePath;
        return Storage::disk('files')->size(urldecode($filePath));
        // return Storage::disk('files')->size(urldecode('/images/1920x1080.jpg'));

        // return response()->json([
        //     'request->filePath' => $request->filePath
        // ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\File  $file
     * @return \Illuminate\Http\Response
     */
    public function getLastModified(Request $request)
    {
        $filePath = $request->filePath;
        return Storage::disk('files')->lastModified(urldecode($filePath));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $path = $request->path;
        $deleted = Storage::disk('files')->delete($path);

        if ($deleted) {
            return response()->json([
                'success'   => true,
                'message'   => 'Deleted file successfully'
            ], 200);
        } else {
            return response()->json([
                'success'   => false,
                'message'   => 'Delete file error'
            ], 500);
        }
    }
}
