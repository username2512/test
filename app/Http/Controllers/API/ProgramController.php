<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProgramController extends Controller
{
    //
        Public function index()
    {
        $data = Program::latest()->get();
        Return response()->json([ProgramResource::collection($data), ‘Programs fetched.’]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    Public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            ‘name’ => ‘required|string|max:255’,
            ‘desc’ => ‘required’
        ]);

        If($validator->fails()){
            Return response()->json($validator->errors());       
        }

        $program = Program::create([
            ‘name’ => $request->name,
            ‘desc’ => $request->desc
         ]);
        
        Return response()->json([‘Program created successfully.’, new ProgramResource($program)]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    Public function show($id)
    {
        $program = Program::find($id);
        If (is_null($program)) {
            Return response()->json(‘Data not found’, 404); 
        }
        Return response()->json([new ProgramResource($program)]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    Public function update(Request $request, Program $program)
    {
        $validator = Validator::make($request->all(),[
            ‘name’ => ‘required|string|max:255’,
            ‘desc’ => ‘required’
        ]);

        If($validator->fails()){
            Return response()->json($validator->errors());       
        }

        $program->name = $request->name;
        $program->desc = $request->desc;
        $program->save();
        
        Return response()->json([‘Program updated successfully.’, new ProgramResource($program)]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    Public function destroy(Program $program)
    {
        $program->delete();

        Return response()->json(‘Program deleted successfully’);
    }
}


