<?php

namespace App\Http\Controllers;


use Illuminate\Contracts\Foundation\Application as ApplicationContract;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use OpenAI\Laravel\Facades\OpenAI;

class TestingController extends Controller
{
    public function index():View
    {

        $messages=collect(session('messages',[]))
        ->reject(fn($messages)
        =>$messages['role']=='system');
        return view('chat.index',[
            'messages'=>$messages
        ]);
    }

    public function store(Request $request): Application|Redirector|RedirectResponse|ApplicationContract
    {
        $messages = $request->session()->get('messages', [
            ['role' => 'system', 'content' => 'You are LaravelGPT - A ChatGPT clone. Answer as concisely as possible.']
        ]);

        $messages[] = ['role' => 'user', 'content' => $request->input('message')];
        $response = OpenAI::chat()->create([
            'model' => 'gpt-3.5-turbo',
            'messages' => $messages
        ]);
        $messages[] = ['role' => 'assistant', 'content' => $response->choices[0]->message->content];
        $request->session()->put('messages', $messages);

        return back();
    }

    public function destroy(Request $request): Application|Redirector|RedirectResponse|ApplicationContract
    {
        $request->session()->forget('messages');

        return back();
    }
}
