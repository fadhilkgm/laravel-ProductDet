<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class ProductController extends Controller
{

    public function index()
    {
        //take the user Id
        $userId = Auth::user()->id;
        //getting the products of that user
        $products = Product::where(['user_id' => $userId])->get();
        //returning the products
        return view('product.list', ['products' => $products])->with('i');
    }

    //creation of products
    public function create()
    {
        //showing the product/add.blade.php
        return view('product.create');
    }
    //storing the products

    public function store(Request $request)
    {
        $userId = Auth::user()->id;

        // Validate the user's input
        $validatedData = $request->validate([
            'title' => 'required|max:255',
            'description' => 'required',
            'status' => 'required',
            'image' => 'required|image|mimes:jpg,png,jpeg,gif|max:2048',
            'expire_at' => 'required|date',
        ]);


        $imageName = time() . '.' . $request->image->extension();
        $request->image->move(public_path('images'), $imageName);

        // Save the image to the server and get the file path


        // Add the user_id and image_path to the validated data
        $validatedData['user_id'] = $userId;
        $validatedData['image'] = $imageName;

        // Create the product
        $product = Product::create($validatedData);

        // Show a success message and redirect to the product index page
        if ($product) {
            $request->session()->flash('success', 'Product successfully added');
        } else {
            $request->session()->flash('error', 'Oops something went wrong, product not saved');
        }
        return redirect('product');
    }

    //show function

    public function show($id)
    {
        //user_id
        $userId = Auth::user()->id;
        //getting the specific product created by the user
        $product = Product::where(['user_id' => $userId, 'id' => $id])->first();
        //checking the product exist or not
        if (!$product) {
            //if not show the not found message
            return redirect('product')->with('error', 'Product not found');
        }
        //return the product/view.blade.php and pass the product 
        return view('product.view', ['product' => $product]);
    }


    //edit function
    public function edit($id)
    {
        //user_id
        $userId = Auth::user()->id;
        //getting the specific product created by the user
        $product = Product::where(['user_id' => $userId, 'id' => $id])->first();
        if ($product) {
            //if product exists the show product/edit.blade.php 
            return view('product.edit', ['product' => $product]);
        } else {
            //if not then show not found
            return redirect('product')->with('error', 'Product not found');
        }
    }
 
    public function update(Request $request, $id)
    {
        $userId = Auth::user()->id;

        $product = Product::where(['user_id' => $userId, 'id' => $id])->first();

        if (!$product) {
            return redirect('product')->with('error', 'Product not found.');
        }

        $validatedData = $request->validate([
            'title' => 'required|max:255',
            'description' => 'required',
            'status' => 'required',
            'image' => 'image|mimes:jpg,png,jpeg,gif|max:5000',
            'expire_at' => 'required|date',
        ]);

        if ($request->hasFile('image')) {
            $imageName = time() . '.' . $request->image->extension();
            $request->image->move(public_path('images'), $imageName);
            $validatedData['image'] = $imageName;
            $fileName = public_path('images/'. $product->image);
            File::delete($fileName);
        }

        $productStatus = $product->update($validatedData);

        if ($productStatus) {
            return redirect('product')->with('success', 'Product successfully updated.');
        } else {
            return redirect('product')->with('error', 'Oops something went wrong. Product not updated');
        }

        return redirect('product')->with('success', 'Product successfully updated.');
    }


    //delete
    public function destroy($id)
    {
        //user_id
        $userId = Auth::user()->id;
        //getting the specific product created by the user
        $product = Product::where(['user_id' => $userId, 'id' => $id])->first();
        $fileName = public_path('images/'.$product->image);
        File::delete($fileName);

        //response status = response message = ' '
        $respStatus = $respMsg = '';
        //if product does not exists the set respStatus to error and response message to not found
        if (!$product) {
            $respStatus = 'error';
            $respMsg = 'Product not found';
        }

        //setting the productDelStatus = taking the product then calling delete function 
        $productDelStatus = $product->delete();
        //setting the respStatus according to the productDelStatus
        if ($productDelStatus) {
            $respStatus = 'success';
            $respMsg = 'Product deleted successfully';
        } else {
            $respStatus = 'error';
            $respMsg = 'Oops something went wrong. Product not deleted successfully';
        }
        //redirect to product route with respStatus and respMsg
        return redirect('product')->with($respStatus, $respMsg);
    }
}
