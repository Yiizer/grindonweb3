<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Category;

use App\Models\Order;

use App\Models\Product;

use Barryvdh\DomPDF\Facade\Pdf;

class AdminController extends Controller
{
    public function view_category()
    {
        $data = Category::all();
        return view('admin.category',compact('data'));
    }

    public function add_category(Request $request)
    {
        $category = new Category;

        $category->category_name = $request->category;

        $category->save();

        toastr()->timeOut(10000)->closeButton()->addSuccess('Category Added Succesfully');

        return redirect()->back();
    }

    public function delete_category($id)
    {
        $data = Category::find($id);

        $data->delete();

        toastr()->timeOut(10000)->closeButton()->addSuccess('Category Deleted Succesfully');

        return redirect()->back();
    }

    public function edit_category($id)
    {
        $data = Category::find($id);

        return view('admin.edit_category',compact('data'));
    }

    public function update_category(Request $request,$id)
    {
        $data = Category::find($id);

        $data->category_name= $request->category;

        $data->save();

        toastr()->timeOut(10000)->closeButton()->addSuccess('Category Updated Succesfully');

        return redirect('/view_category');
    }

    public function add_product()
    {
        $category = Category::all();

        return view('admin.add_product',compact('category'));
    }

    public function upload_product(Request $request)
    {
        $data = new Product;

        $data->title = $request->title;

        $data->description = $request->description;

        $data->price = $request->price;

        $data->quantity = $request->qty;

        $data->category = $request->category;

        $image = $request->image;

        if($image)
        {
            $imagename = time().'.'.$image->getClientOriginalExtension();

            $request->image->move('products',$imagename);

            $data->image = $imagename;
        }

        $data->save();

        toastr()->timeOut(10000)->closeButton()->addSuccess('Product Added Succesfully');

        return redirect()->back();
    }
    
    public function view_product()
    {
        $product = Product::paginate(3);

        return view('admin.view_product',compact('product'));
    }

    public function delete_product($id)
{
    $data = Product::find($id);

    if ($data) {
        // Check if images exist and handle deletion
        $images = json_decode($data->images); // If you store multiple images as JSON
        if ($images && is_array($images)) {
            foreach ($images as $image) {
                $image_path = public_path('products/' . $image);

                if (is_file($image_path)) {
                    unlink($image_path);
                } else {
                    \Log::error("File not found or not valid: " . $image_path);
                }
            }
        } elseif (!empty($data->image)) {
            // Fallback for single image handling (if `image` is not JSON)
            $image_path = public_path('products/' . $data->image);

            if (is_file($image_path)) {
                unlink($image_path);
            } else {
                \Log::error("File not found or not valid: " . $image_path);
            }
        }

        // Delete the product record from the database
        $data->delete();

        toastr()->timeOut(10000)->closeButton()->addSuccess('Product Deleted Successfully');
    } else {
        toastr()->error('Product not found!');
    }

    return redirect()->back();
}

    public function product_search(Request $request)
    {
        $search = $request->search;

        $product = Product::where('title','LIKE','%'.$search.'%')->orWhere('category','LIKE','%'.$search.'%')->paginate(3);

        return view('admin.view_product',compact('product'));
    }
    public function update_product($id)
    {
        $data = Product::find($id);
     
        $category = Category::all();

    
        return view('admin.update_page', compact('data','category'));
    }

    public function edit_product(Request $request, $id)
    {
        $data = Product::find($id);
        
        $data->title = $request->title;

        $data->description = $request->description;

        $data->price = $request->price;

        $data->quantity = $request->quantity;

        $data->category = $request->category;

        $image= $request->image;

        if($image)
        {
        $imagename= time().'.'.$image->getClientOriginalExtension();

        $request->image->move('products',$imagename);

        $data->image = $imagename;


        }
            $data->save();

            toastr()->timeOut(10000)->closeButton()->addSuccess('Product Updated Succesfully');
                 
            return redirect('/view_product');
            

    }

    public function view_orders()
{
    // Fetch all orders along with the associated product (with size, color, and quantity)
    $data = Order::where('status', '!=', 'Delivered')->get();

    // Pass data to the view
    return view('admin.order', compact('data'));
}

    public function on_the_way($id)
    {
        $data = Order::find($id);

        $data->status = 'On the Way';

        $data->save();

        return redirect('/view_orders');

    }

    public function delivered($id)
    {
        // Find the order by its ID
        $data = Order::find($id);
    
        if ($data) {
            // Update the status to 'Delivered'
            $data->status = 'Delivered';
            $data->save();
        }
    
        // Redirect to the orders view
        return redirect('/view_orders')->with('success', 'Order marked as delivered!');
    }
    
    public function print_pdf($id)
    {
        $data = Order::find($id);
    
        
        $pdf = Pdf::loadView('admin.invoice', compact('data'));
    
        return $pdf->download('invoice.pdf');
    }

    public function messages()
    {
        $messages = \App\Models\Contact::orderBy('created_at', 'desc')->paginate(10);

        return view('admin.messages', compact('messages'));
    }

        public function completed_orders()
    {
        // Fetch completed orders from the database
        $data = Order::where('status', 'Delivered')->get();

        // Pass data to the view
        return view('admin.completed_orders', compact('data'));
    }

}