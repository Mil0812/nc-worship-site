<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\Database\Eloquent\Collection;

class CommentsSection extends Component
{
    public Collection $comments;
    public $component;

    public function __construct(Collection $comments, $component)
    {
        $this->comments = $comments;
        $this->component = $component;
    }

    public function render(): object
    {
        return view('components.comments-section');
    }
}
