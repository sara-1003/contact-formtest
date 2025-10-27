<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contact;
use App\Models\Category;
use Illuminate\Support\Facades\Response;

class AdminController extends Controller
{
    public function index()
    {
        $contacts = Contact::with('category')->paginate(7);
        $contacts->withPath('/admin');
        $categories = Category::all();

        return view('admin',compact('contacts','categories'));
    }

    public function search(Request $request)
    {
        $contacts=Contact::with('category')
        ->CategorySearch($request->category_id)
        ->KeywordSearch($request->keyword)
        ->GenderSearch($request->gender)
        ->DateSearch($request->date)
        ->paginate(7)
        ->appends($request->all());

        $contacts->withPath('/admin/search');

        $categories = Category::all();


        return view("admin",compact('contacts','categories'));
    }

    public function destroy(Request $request)
    {
        Contact::find($request->id)->delete();
        return redirect('/admin');
    }

    public function export(Request $request)
    {
        $keyword = $request->input('keyword');
        $gender = $request->input('gender');
        $category_id = $request->input('category_id');

        $contacts = Contact::query();
        
        if ($keyword) {
            $contacts->where(function($q) use ($keyword){
                $q->where('first_name', 'like', "%{$keyword}%")
                ->orWhere('last_name', 'like', "%{$keyword}%")
                ->orWhere('email', 'like', "%{$keyword}%");
        });
    }

        if ($gender) {
            $contacts->where('gender', $gender);
    }

        if ($category_id) {
            $contacts->where('category_id', $category_id);
    }

        $contacts = $contacts->get();

        $csvHeader = ['お名前', '性別', 'メールアドレス', 'お問い合わせの種類', '内容'];
        $csvData = [];
        foreach ($contacts as $contact) {
        $csvData[] = [
            $contact->first_name . ' ' . $contact->last_name,
            $contact->gender == 1 ? '男性' : ($contact->gender == 2 ? '女性' : 'その他'),
            $contact->email,
            $contact->category->content,
            $contact->detail,
        ];
    }
        $callback = function() use ($csvHeader, $csvData) {
        $file = fopen('php://output', 'w');
        fputcsv($file, $csvHeader);
        foreach ($csvData as $row) {
            fputcsv($file, $row);
        }
        fclose($file);
    };

    return Response::stream($callback, 200, [
        "Content-Type" => "text/csv",
        "Content-Disposition" => "attachment; filename=contacts.csv",
    ]);
}
}
