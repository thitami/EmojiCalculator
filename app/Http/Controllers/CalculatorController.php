<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Moveit\Emoji\EmojiService;

class CalculatorController extends Controller
{
    /**
     * @var EmojiService
     */
    protected $emojiService;

    /**
     * CalculatorController constructor.
     * @param EmojiService $emojiService
     */
    public function __construct(EmojiService $emojiService)
    {
        $this->emojiService = $emojiService;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function homepage()
    {
        $this->emojiService->
    }
}
