<?php

namespace App;

use App\Models\Comment;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;

trait HasComments
{
    public string $newComment = '';
    public ?string $editingCommentId = null;
    public string $editedContent = '';
    public ?string $replyingToCommentId = null;
    public string $replyContent = '';

    public function confirmDelete(string $commentId): void
    {
        $this->dispatch('confirmCommentDeletion', commentId: $commentId);
    }

    public function addComment(): void
    {
        $user = Auth::user();
        if (!$user) {
            $this->dispatch('showError', message: __('messages.log_in_to_comment'));
            return;
        }

        $this->validate([
            'newComment' => 'required|string|max:1000',
        ]);

        Comment::create([
            'user_id' => $user->id,
            'commentable_id' => $this->getCommentableId(),
            'commentable_type' => $this->getCommentableType(),
            'content' => $this->newComment,
            'parent_id' => null,
        ]);

        $this->newComment = '';
        $this->dispatch('showSuccess', message: __('messages.comment_added_successfully'));
    }

    public function editComment(string $commentId): void
    {
        $comment = Comment::find($commentId);
        if ($comment && $comment->user_id === Auth::id()) {
            $this->editingCommentId = $commentId;
            $this->editedContent = $comment->content;
        }
    }

    public function updateComment(): void
    {
        $comment = Comment::find($this->editingCommentId);
        if ($comment && $comment->user_id === Auth::id()) {
            $this->validate([
                'editedContent' => 'required|string|max:1000',
            ]);

            $comment->update(['content' => $this->editedContent]);
            $this->editingCommentId = null;
            $this->editedContent = '';
            $this->dispatch('showSuccess', message: __('messages.comment_updated_successfully'));
        }
    }

    public function cancelEdit(): void
    {
        $this->editingCommentId = null;
        $this->editedContent = '';
    }

    public function startReply(string $commentId): void
    {
        $this->replyingToCommentId = $commentId;
        $this->replyContent = '';
    }

    public function cancelReply(): void
    {
        $this->replyingToCommentId = null;
        $this->replyContent = '';
    }

    public function addReply(): void
    {
        $user = Auth::user();
        if (!$user) {
            $this->dispatch('showError', message: __('messages.log_in_to_reply'));
            return;
        }

        $this->validate([
            'replyContent' => 'required|string|max:1000',
        ]);

        Comment::create([
            'user_id' => $user->id,
            'commentable_id' => $this->getCommentableId(),
            'commentable_type' => $this->getCommentableType(),
            'content' => $this->replyContent,
            'parent_id' => $this->replyingToCommentId,
        ]);

        $this->replyContent = '';
        $this->replyingToCommentId = null;
        $this->dispatch('showSuccess', message: __('messages.reply_added_successfully'));
    }

    public function deleteComment(string $commentId): void
    {
        $comment = Comment::find($commentId);

        if (!$comment || $comment->user_id !== Auth::id()) {
            $this->dispatch('showError', message: __('messages.unauthorized_action'));
            return;
        }

        if ($comment->parent_id === null) {
            Comment::where('parent_id', $comment->id)->delete();
        }

        $comment->delete();

        $this->dispatch('showSuccess', message: __('messages.comment_deleted_successfully'));
    }

    abstract protected function getCommentableId(): string;
    abstract protected function getCommentableType(): string;

    protected function getCommentsForRender(): Collection
    {
        return Comment::where('commentable_id', $this->getCommentableId())
            ->where('commentable_type', $this->getCommentableType())
            ->whereNull('parent_id')
            ->with('user', 'replies.user')
            ->orderBy('created_at', 'desc')
            ->get();
    }
}
