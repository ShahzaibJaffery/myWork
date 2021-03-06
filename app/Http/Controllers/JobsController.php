<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Job;
use App\Category;
use Session;
class JobsController extends Controller
{
    public function index(){
    	return view('admin.jobs.index',['title' => 'Jobs'])->with('jobs',Job::all())->with('categories',Category::all());
    }

    public function create(){
    	return view('admin.jobs.create',['title' => 'Create Job'])->with('categories', Category::all());
    }

    public function store(Request $request)
    {
        $this->validate($request,[
            'title' => 'required',
            'featured' => 'required|image',
            'description' => 'required',
            'category_id' =>'required'
        ]);

        $featured = $request->featured;
        $featured_new_name = time().$featured->getClientOriginalName();
        $featured->move('uploads/jobs', $featured_new_name);
        $job=Job::create([
            'title' => $request->title,
            'featured' => 'uploads/jobs/' . $featured_new_name,
            'description' => $request->description,
            'category_id' => $request->category_id
        ]);
        Session::flash('success','job is created succesfully');
        return redirect()->back();
    } 
    public function edit($id)
    {
        $job=Job::find($id);
        return view('admin.jobs.edit',['title' => 'Update Job'])->with('job',$job)->with('categories', Category::all());

    }
    public function update($id , Request $request)
    {
        $job=job::find($id);
        if($request->featured)
        {
        $featured=$request->featured;
        $new_featured= time().$featured->getClientOriginalName();
        $featured->move('uploads/jobs',$new_featured);
         $job->featured=$new_featured;
        }
        $job->title=$request->title;
        
        $job->description=$request->description;
        $job->category_id= $request->category_id;
        $job->save();
        Session::flash('success','job is created succesfully');
         return redirect()->back();
    }

    public function singleCategoryJobs($id){
        $jobs = Job::where('category_id',$id)->with('category')->get();
        return view('admin.jobs.singleCategoryJobs',['title' => 'Jobs'])->with('jobs',$jobs);
    }
}
