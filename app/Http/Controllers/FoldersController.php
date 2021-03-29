<?php

namespace App\Http\Controllers;

use App\Models\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Response;

class FoldersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $directories = Storage::disk('files')->allDirectories();

        return response()->json([
            'directories' => $directories
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
        $path = $request->path;
        $created = Storage::disk('files')->makeDirectory($path);

        if ($created) {
            return response()->json([
                'success'   => true,
                'message'   => 'Created folder successfully'
            ]);
        } else {
            return response()->json([
                'success'   => false,
                'message'   => 'Create folder error'
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\File  $file
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $files = Storage::disk('files')->allFiles($directory);

        return response()->json([
            'directory' => $files
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $newName)
    {
        // $path = $request->path;
        $path = $request->path;
        $newPath = dirname($path) . "/" . $newName;
        // rename("/images/old folder name", "/images/new folder name");
        // $renamed = Storage::disk('files')->rename('/abc/old folder name', '/abc/new folder name');
        $renamed = Storage::disk('files')->rename($path, $newPath);

        if ($renamed) {
            return response()->json([
                'success'   => true,
                'message'   => 'Renamed folder successfully'
            ], 200);
        } else {
            return response()->json([
                'success'   => false,
                'message'   => 'Rename folder error'
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // public function destroy($folderName)
    public function destroy(Request $request)
    {
        $path = $request->path;
        $deleted = Storage::disk('files')->deleteDirectory($path);

        if ($deleted) {
            return response()->json([
                'success'   => true,
                'message'   => 'Deleted folder successfully'
            ], 200);
        } else {
            return response()->json([
                'success'   => false,
                'message'   => 'Delete folder error'
            ], 500);
        }
    }
}
