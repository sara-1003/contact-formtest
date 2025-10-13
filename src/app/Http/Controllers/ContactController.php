<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contact;
use App\Models\Category;
use App\Http\Requests\ContactRequest;

class ContactController extends Controller
{
    public function index()
    {
        $categories = Category::all();

        return view("index",compact('categories'));
    }

    public function confirm(ContactRequest $request)
    {
        $contact=$request->only(["first_name","last_name","gender","email","tel1","tel2","tel3","address","building","category_id","detail"]);
        
        $contact['tel'] = $contact['tel1'] . '-' . $contact['tel2'] . '-' . $contact['tel3'];
        
        $genderLabels = [
            1 => '男性',
            2 => '女性',
            3 => 'その他'
        ];
        $contact['gender_label'] = $genderLabels[$contact['gender']];

        $category=Category::find($contact['category_id']);
        $contact['category_name']=$category->content;

        return view("confirm",compact("contact"));
    }

    public function store(Request $request)
    {
        $contact=$request->only(["first_name","last_name","gender","email","tel","address","building","category_id","detail"]);
        Contact::create($contact);

        return view("thanks");

    }
}
