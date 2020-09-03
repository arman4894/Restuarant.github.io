<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Food;
use App\Category;

class FoodController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $foods = Food::latest()->paginate(5);
        return view('food.index',compact('foods'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('food.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'=>'required',
            'description' =>'required',
            'price'=>'required|integer',
            'category'=>'required',
            'image'=>'required|mimes:png,jpeg,jpg'

        ]);
        $image = $request->file('image');
        $name = time().','.$image->getClientOriginalExtension();
        $destinationPath = public_path('/images');
        $image->move($destinationPath,$name);
        Food::create([
            'name' =>$request->get('name'),
            'description' =>$request->get('description'),
            'price' =>$request->get('price'),
            'category_id' =>$request->get('category'),
            'image' =>$name
        ]);
        return redirect()->back()->with('success','Food created');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $food = Food::find($id);
        return view('food.detail',compact('food'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $food = Food::find($id);
        return view('food.edit',compact('food'));
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
        $request->validate([
            'name'=>'required',
            'description' =>'required',
            'price'=>'required|integer',
            'category'=>'required',
            'image'=>'mimes:png,jpeg,jpg'

        ]);
        $food = Food::find($id);
        $name = $food->image;
        if($request->hasFile('image'))
        {
        $image = $request->file('image');
        $name = time().','.$image->getClientOriginalExtension();
        $destinationPath = public_path('/images');
        $image->move($destinationPath,$name);
        }
        $food->name = $request->get('name');
        $food->description = $request->get('description');
        $food->price = $request->get('price');
        $food->name = $request->get('name');
        $food->category_id = $request->get('category');
        $food->image = $name;
        $food->save();
        return redirect()->route('food.index')->with('success','Food updated');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Food::find($id)->delete();
        return redirect()->back()->with('success','Food Deleted');

    }
    public function listFood()
    {
         $categories = Category::with('food')->get();
         return view('food.list',compact('categories'));
    }
    public function view($id)
    {

    }
}
