<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Statamic\View\View;

class GalleryController extends Controller
{
    public function showGallery(Request $request)
    {
        // Return the gallery view after User is logged in
        return (new View)
            ->template('gallery')
            ->layout('layout');
    }
}
