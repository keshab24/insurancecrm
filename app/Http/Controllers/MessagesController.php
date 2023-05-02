<?php

namespace App\Http\Controllers;

use App\Models\ContactMessage;
use Illuminate\Http\Request;

class MessagesController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }
    public function index()
    {
        $messages = ContactMessage::all();
        return view('Message.index')->with('messages', $messages);
    }
    public function update(Request $request, $id)
    {
        $message = ContactMessage::findOrFail($id);

        $message->status = $request->status;

        $message->save();

        return redirect()->route('admin.message.show', $message->id);
    }
    public function show($id)
    {
        $message = ContactMessage::findOrFail($id);

        $message->is_seen = true;

        $message->save();

        return view('Message.show', compact('message'));
    }
    public function delete($id)
    {
        $message = ContactMessage::findorfail($id);
        $message->delete();
        return true;
    }
}
