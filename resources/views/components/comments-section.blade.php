<!-- The biggest battle is the war against ignorance. - Mustafa Kemal Atatürk -->
<div class="song__comments mt-[var(--spacing-lg)] max-w-[800px] mx-auto">
    <h2 class="text-[var(--font-size-lg)] font-[var(--font-weight-bold)] mb-[var(--spacing-md)]">
        {{ __('messages.comments') }}
    </h2>
    @if (Auth::check())
        <div
            class="mb-[var(--spacing-sm)] p-[var(--spacing-xs)] bg-[var(--color-background-alt)] rounded-[var(--radius-sm)]">
            <textarea wire:model="newComment"
                      class="w-full p-[var(--spacing-xs)] border border-[var(--color-border)] rounded-none text-[var(--font-size-md)] bg-transparent focus:outline-none focus:border-[var(--color-border)]"
                      placeholder="{{ __('messages.write_comment_placeholder') }}" rows="3"></textarea>
            <button wire:click="addComment"
                    class="mt-[var(--spacing-xs)] bg-[var(--color-primary-light)] text-[var(--color-text-primary)] hover:opacity-90 rounded-[var(--radius-sm)] py-[var(--spacing-xs)] px-[var(--spacing-sm)] transition-opacity duration-200">
                {{ __('messages.add_comment') }}
            </button>
        </div>
    @else
        <p class="text-[var(--color-text-secondary)]">
            {{ __('messages.log_in_to_comment') }}
        </p>
    @endif

    @foreach ($comments as $comment)
        <div
            class="comment mb-[var(--spacing-md)] p-[var(--spacing-xs)] bg-[var(--color-background-alt)] rounded-[var(--radius-sm)]">
            <div class="comment__header flex justify-between items-center">
                <span class="text-[var(--font-size-md)] font-[var(--font-weight-semibold)]">
                    {{ $comment->user->name }}
                </span>
                <span class="text-[var(--font-size-sm)]">
                    {{ $comment->created_at->diffForHumans() }}
                </span>
            </div>

            @if ($component->editingCommentId === $comment->id)
                <textarea wire:model="editedContent"
                          class="w-full p-[var(--spacing-xs)] border border-[var(--color-border)] rounded-none text-[var(--font-size-md)] bg-transparent focus:outline-none focus:border-[var(--color-border)] mt-2"
                          rows="3"></textarea>
                <div class="mt-2">
                    <button wire:click="updateComment"
                            class="bg-[var(--color-primary-light)] text-[var(--color-text-primary)] hover:opacity-90 rounded-[var(--radius-sm)] py-[var(--spacing-xs)] px-[var(--spacing-sm)] mr-2 transition-opacity duration-200">
                        {{ __('messages.save_comments') }}
                    </button>
                    <button wire:click="cancelEdit"
                            class="bg-[var(--color-text-secondary)] text-[var(--color-secondary-dark)] hover:opacity-90 rounded-[var(--radius-sm)] py-[var(--spacing-xs)] px-[var(--spacing-sm)] transition-opacity duration-200">
                        {{ __('messages.cancel') }}
                    </button>
                </div>
            @else
                <p class="text-[var(--font-size-md)] mt-2">{{ $comment->content }}</p>
                <div class="mt-2 flex gap-2">
                    @if (Auth::check() && $comment->user_id === Auth::id())
                        <button wire:click="editComment('{{ $comment->id }}')"
                                class="text-[var(--color-primary)] hover:text-[var(--color-primary-dark)]">
                            {{ __('messages.edit') }}
                        </button>
                        <button wire:click="confirmDelete('{{ $comment->id }}')"
                                class="text-[var(--color-error)] hover:text-[var(--color-error-dark)]">
                            {{ __('messages.delete') }}
                        </button>
                    @endif
                    @if (Auth::check())
                        <button wire:click="startReply('{{ $comment->id }}')"
                                class="text-[var(--color-primary)] hover:text-[var(--color-primary-dark)]">
                            {{ __('messages.reply') }}
                        </button>
                    @endif
                </div>
            @endif

            @if ($component->replyingToCommentId === $comment->id)
                <div class="mt-4 ml-8">
                    <textarea wire:model="replyContent"
                              class="w-full p-[var(--spacing-xs)] border border-[var(--color-border)] rounded-none text-[var(--font-size-md)] bg-transparent focus:outline-none focus:border-[var(--color-border)]"
                              placeholder="{{ __('messages.write_reply_placeholder') }}" rows="2"></textarea>
                    <div class="mt-2">
                        <button wire:click="addReply"
                                class="bg-[var(--color-primary)] text-[var(--color-text-light)] hover:bg-[var(--color-primary-dark)] rounded-[var(--radius-sm)] py-[var(--spacing-xs)] px-[var(--spacing-sm)] mr-2 transition-[var(--transition-normal)]">
                            {{ __('messages.post_reply') }}
                        </button>
                        <button wire:click="cancelReply"
                                class="bg-[var(--color-text-secondary)] text-[var(--color-secondary-dark)] hover:opacity-90 rounded-[var(--radius-sm)] py-[var(--spacing-xs)] px-[var(--spacing-sm)] transition-opacity duration-200">
                            {{ __('messages.cancel') }}
                        </button>
                    </div>
                </div>
            @endif

            @foreach ($comment->replies as $reply)
                <div
                    class="reply ml-8 mt-4 p-[var(--spacing-xs)] bg-[var(--color-background-alt)] rounded-[var(--radius-sm)]">
                    <div class="reply__header flex justify-between items-center">
                        <span class="text-[var(--font-size-md)] font-[var(--font-weight-semibold)]">
                            {{ $reply->user->name }}
                        </span>
                        <span class="text-[var(--font-size-sm)]">
                            {{ $reply->created_at->diffForHumans() }}
                        </span>
                    </div>
                    @if ($component->editingCommentId === $reply->id)
                        <textarea wire:model="editedContent"
                                  class="w-full p-[var(--spacing-xs)] border border-[var(--color-border)] rounded-none text-[var(--font-size-md)] bg-transparent focus:outline-none focus:border-[var(--color-border)] mt-2"
                                  rows="2"></textarea>
                        <div class="mt-2">
                            <button wire:click="updateComment"
                                    class="bg-[var(--color-primary-light)] text-[var(--color-text-primary)] hover:opacity-90 rounded-[var(--radius-sm)] py-[var(--spacing-xs)] px-[var(--spacing-sm)] mr-2 transition-opacity duration-200">
                                {{ __('messages.save_comments') }}
                            </button>
                            <button wire:click="cancelEdit"
                                    class="bg-[var(--color-text-secondary)] text-[var(--color-secondary-dark)] hover:opacity-90 rounded-[var(--radius-sm)] py-[var(--spacing-xs)] px-[var(--spacing-sm)] transition-opacity duration-200">
                                {{ __('messages.cancel') }}
                            </button>
                        </div>
                    @else
                        <p class="text-[var(--font-size-md)] mt-2">{{ $reply->content }}</p>
                        @if (Auth::check() && $reply->user_id === Auth::id())
                            <div class="mt-2">
                                <button wire:click="editComment('{{ $reply->id }}')"
                                        class="text-[var(--color-primary)] hover:text-[var(--color-primary-dark)] mr-2">
                                    {{ __('messages.edit') }}
                                </button>
                                <button wire:click="confirmDelete('{{ $reply->id }}')"
                                        class="text-[var(--color-error)] hover:text-[var(--color-error)]">
                                    {{ __('messages.delete') }}
                                </button>
                            </div>
                        @endif
                    @endif
                </div>
            @endforeach
        </div>
    @endforeach
</div>
