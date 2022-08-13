<?php
   
Namespace App\Http\Controllers\API;
   
Use Illuminate\Http\Request;
Use App\Http\Controllers\API\BaseController as BaseController;
Use Validator;
Use App\Models\program;
Use App\Http\Resources\ProgramResource;
   
Class BlogController extends BaseController
{

    Public function index()
    {
        $blogs = Blog::all();
        Return $this->sendResponse(ProgramResource::collection($blogs), 'Posts fetched.');
    }

    
    Public function store(Request $request)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'title' => 'required',
            'desc' => 'required'
        ]);
        If($validator->fails()){
            Return $this->sendError($validator->errors());       
        }
        $program = program::create($input);
        Return $this->sendResponse(new ProgramResource($program), 'Post created.');
    }

   
    Public function show($id)
    {
        $program = Blog::find($id);
        If (is_null($program)) {
            Return $this->sendError('Post does not exist.');
        }
        Return $this->sendResponse(new ProgramResource($program), 'Post fetched.');
    }
    

    Public function update(Request $request, Program $program)
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'title' => 'required',
            'desc' => 'required'
        ]);

        If($validator->fails()){
            Return $this->sendError($validator->errors());       
        }

        $program->title = $input['title'];
        $program->desc = $input['description'];
        $program->save();
        
        Return $this->sendResponse(new ProgramResource($program), 'Post updated.');
    }
   
    Public function destroy(Program $program)
    {
        $program->delete();
        Return $this->sendResponse([], 'Post deleted.');
    }
}
