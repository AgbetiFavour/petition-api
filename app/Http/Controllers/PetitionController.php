<?php

namespace App\Http\Controllers;

use App\Http\Resources\PetitionCollection;
use App\Http\Resources\PetitionResource;
use App\Models\Petition;
use Illuminate\Http\Client\Request as ClientRequest;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class PetitionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index($id = "")
    {
        // return new PetitionCollection(Petition::all());
        if ($id != "") {
            $single = Petition::where('id', $id)->first();
            return response()->json($single, Response::HTTP_OK);
        } else {
            return response()->json(new PetitionCollection(Petition::all()), Response::HTTP_OK);
        }
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return PetitionResource
     */
    public function store(Request $request)
    {
        $petition = Petition::create($request->only([
            'title', 'description', 'category', 'author', 'signees'
        ]));

        return new PetitionResource($petition);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Petition  $petition
     * * @param  \Illuminate\Http\Request  $request
     * @return PetitionResource
     */


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Petition  $petition
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if ($request->title != "") {
            Petition::where('id', $id)->update([
                "title" => $request->title,
                "description" => $request->description, "category" => $request->category
            ]);
        }
        $single = Petition::where('id', $id)->first();
        return response()->json($single, Response::HTTP_OK);
    }


    public function delete($id)
    {
        $single = Petition::where('id', $id)->get();
        if (count($single) > 0) {
            Petition::where('id', $id)->delete();
            return response()->json(["message" => "Petition delete successful"], Response::HTTP_OK);
        } else {
            return response()->json(["message" => "Petition with this id does not exist"], Response::HTTP_OK);
        }
    }
}
