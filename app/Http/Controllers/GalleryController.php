<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;

class GalleryController extends Controller

/**
* @OA\Get(
*     path="/api/gallery",
*     tags={"Gallery"},
*     summary="Fetch gallery posts",
*     description="Menampilkan daftar postingan dengan gambar",
*     operationId="getGallery",
*     @OA\Response(
*         response=200,
*         description="Berhasil menampilkan data",
*         @OA\JsonContent(
*             type="array",
*             @OA\Items(
*                 @OA\Property(property="id", type="integer", example=1),
*                 @OA\Property(property="title", type="string", example="Judul Postingan"),
*                 @OA\Property(property="picture", type="string", example="url_gambar.jpg")
*             )
*         )
*     )
* )
*/


{
    /**
     * Menampilkan data gallery dalam format JSON.
     */
    public function apiIndex()
    {
        $galleries = Post::where('picture', '!=', '')
            ->whereNotNull('picture')
            ->orderBy('created_at', 'desc')
            ->paginate(30);

        return response()->json($galleries, 200);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = array(
            'id' => "posts",
            'menu' => 'Gallery',
            'galleries' => Post::where('picture', '!=',
            '')-> whereNotNull('picture')->orderBy('created_at', 'desc')->paginate(30)
        );
        return view('gallery.index')->with($data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('gallery.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required|max:255',
            'description' => 'required',
            'picture' => 'image|nullable|max:1999'
        ]);
    
        if ($request->hasFile('picture')) {
            $filenameWithExt = $request->file('picture')->getClientOriginalName();
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            $extension = $request->file('picture')->getClientOriginalExtension();
            $basename = uniqid() . time();
            $smallFilename = "small_{$basename}.{$extension}";
            $mediumFilename = "medium_{$basename}.{$extension}";
            $largeFilename = "large_{$basename}.{$extension}";
            $filenameSimpan = "{$basename}.{$extension}";
            $path = $request->file('picture')->storeAs('posts_image', $filenameSimpan);
        } else {
            $filenameSimpan = 'noimage.png';
        }
    
        $post = new Post;
        $post->picture = $filenameSimpan;
        $post->title = $request->input('title');
        $post->description = $request->input('description');
        $post->save();
    
        return redirect('gallery')->with('success', 'Berhasil menambahkan data baru');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $gallery = Post::findOrFail($id);
        return view('gallery.edit', compact('gallery'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
    $request->validate([
        'title' => 'required|string|max:255',
        'description' => 'required|string',
        'picture' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
    ]);
    
    $gallery = Post::findOrFail($id);
    $gallery->title = $request->title;
    $gallery->description = $request->description;
    
    if ($request->hasFile('picture')) {
        $filenameWithExt = $request->file('picture')->getClientOriginalName();
        $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
        $extension = $request->file('picture')->getClientOriginalExtension();
        $basename = uniqid() . time();
        $smallFilename = "small_{$basename}.{$extension}";
        $mediumFilename = "medium_{$basename}.{$extension}";
        $largeFilename = "large_{$basename}.{$extension}";
        $filenameSimpan = "{$basename}.{$extension}";

        $request->file('picture')->storeAs('posts_image', $filenameSimpan);

        $gallery->picture = $filenameSimpan;
    }

    $gallery->save();

    return redirect()->route('gallery.index')->with('success', 'Gallery updated successfully');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $gallery = Post::findOrFail($id);
        $gallery->delete();
        return redirect()->route('gallery.index')->with('success', 'Gallery deleted successfully');
    }
}

