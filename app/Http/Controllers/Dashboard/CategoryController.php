<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Notifications\CategoryAdded;
use Illuminate\Support\Facades\Notification;
use App\Models\Notification as NotificationModel;

class CategoryController extends Controller
{

    public function index()
    {
        return view('dashboard.category.index');
    }



    public function deleteSelected(Request $request)
    {
        try {
            $delete_selected_id = explode(",", $request->delete_selected_id);
            // foreach($delete_selected_id as $selected_id) {
            //     $related_table = Product::where('category_id', $selected_id)->pluck('category_id');
            //     if($related_table->count() == 0) {
                    $categories = Category::whereIn('id', $delete_selected_id)->delete();
                    session()->flash('success');
                    return redirect()->back();
                // } else {
                //     session()->flash('canNotDeleted');
                //     return redirect()->back();
                // }
            // }
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }



    public function showNotification($route_id,$notification_id)
    {
        $notification = NotificationModel::findOrFail($notification_id);
        $notification->update(['read_at' => now()]);
        return view('dashboard.category.index');
    }
}
