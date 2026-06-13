<?php

namespace App\Http\Controllers;

use App\Models\ChatMessage;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class ChatController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request): View
    {
        $user = Auth::user();
        $contacts = $this->resolveContacts($user);
        $selectedContact = $this->resolveSelectedContact($user, $contacts, $request->query('user'));
        [$messages] = $this->resolveConversation($user, $selectedContact);

        return view('chat.index', compact('contacts', 'selectedContact', 'messages', 'user'));
    }

    public function data(Request $request): JsonResponse
    {
        $user = Auth::user();
        $contacts = $this->resolveContacts($user);
        $selectedContact = $this->resolveSelectedContact($user, $contacts, $request->query('user'));
        [$messages, $unreadCount] = $this->resolveConversation($user, $selectedContact);

        return response()->json([
            'contacts' => $contacts->map(function ($contact) use ($user) {
                return [
                    'id' => $contact->id,
                    'name' => $contact->center_id ?: $contact->email,
                    'email' => $contact->email,
                    'avatar_url' => $contact->avatar_url,
                    'initials' => $contact->initials,
                    'unread_count' => ChatMessage::where('sender_id', $contact->id)
                        ->where('recipient_id', $user->id)
                        ->whereNull('read_at')
                        ->count(),
                ];
            })->values(),
            'selected_contact' => $selectedContact ? [
                'id' => $selectedContact->id,
                'name' => $selectedContact->center_id ?: $selectedContact->email,
                'email' => $selectedContact->email,
                'avatar_url' => $selectedContact->avatar_url,
                'initials' => $selectedContact->initials,
            ] : null,
            'messages' => $messages->map(function ($message) use ($user) {
                return [
                    'id' => $message->id,
                    'mine' => $message->sender_id === $user->id,
                    'sender_name' => $message->sender->center_id ?: $message->sender->email,
                    'sender_avatar_url' => $message->sender->avatar_url,
                    'sender_initials' => $message->sender->initials,
                    'message' => $message->message,
                    'created_at' => optional($message->created_at)->format('d M Y H:i'),
                ];
            })->values(),
            'chat_unread_count' => ChatMessage::where('recipient_id', $user->id)
                ->whereNull('read_at')
                ->count(),
            'conversation_unread_marked' => $unreadCount,
        ]);
    }

    public function store(Request $request): RedirectResponse|JsonResponse
    {
        $user = Auth::user();
        $validated = $request->validate([
            'recipient_id' => ['required', 'integer', 'exists:users,id'],
            'message' => ['required', 'string', 'max:5000'],
        ]);

        $recipient = User::findOrFail($validated['recipient_id']);
        $this->ensureAllowedRecipient($user, $recipient);

        $message = ChatMessage::create([
            'sender_id' => $user->id,
            'recipient_id' => $recipient->id,
            'message' => $validated['message'],
        ]);

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => [
                    'id' => $message->id,
                    'mine' => true,
                    'sender_name' => $user->center_id ?: $user->email,
                    'sender_avatar_url' => $user->avatar_url,
                    'sender_initials' => $user->initials,
                    'message' => $message->message,
                    'created_at' => optional($message->created_at)->format('d M Y H:i'),
                ],
            ]);
        }

        return redirect()
            ->route('chat.index', ['user' => $recipient->id])
            ->with('success', 'Ujumbe umetumwa kikamilifu.');
    }

    protected function resolveContacts(User $user)
    {
        if ($user->role === 'admin') {
            return User::query()
                ->where('id', '!=', $user->id)
                ->where('role', '!=', 'admin')
                ->orderBy('center_id')
                ->orderBy('email')
                ->get();
        }

        return User::query()
            ->where('role', 'admin')
            ->orderBy('center_id')
            ->orderBy('email')
            ->get();
    }

    protected function resolveSelectedContact(User $user, $contacts, $selectedId): ?User
    {
        if ($contacts->isEmpty()) {
            return null;
        }

        if ($selectedId) {
            $selected = $contacts->firstWhere('id', (int) $selectedId);

            if ($selected) {
                return $selected;
            }
        }

        return $contacts->first();
    }

    protected function ensureAllowedRecipient(User $user, User $recipient): void
    {
        if ($user->role === 'admin') {
            if ($recipient->id === $user->id || $recipient->role === 'admin') {
                abort(403, 'Huwezi kuanzisha chat hii.');
            }

            return;
        }

        if ($recipient->role !== 'admin') {
            abort(403, 'User anaweza ku-chat na admin tu.');
        }
    }

    protected function resolveConversation(User $user, ?User $selectedContact): array
    {
        $messages = collect();
        $markedUnread = 0;

        if ($selectedContact) {
            $messages = ChatMessage::with(['sender', 'recipient'])
                ->where(function ($query) use ($user, $selectedContact) {
                    $query->where('sender_id', $user->id)
                        ->where('recipient_id', $selectedContact->id);
                })
                ->orWhere(function ($query) use ($user, $selectedContact) {
                    $query->where('sender_id', $selectedContact->id)
                        ->where('recipient_id', $user->id);
                })
                ->orderBy('created_at')
                ->get();

            $markedUnread = ChatMessage::where('sender_id', $selectedContact->id)
                ->where('recipient_id', $user->id)
                ->whereNull('read_at')
                ->update(['read_at' => now()]);
        }

        return [$messages, $markedUnread];
    }
}
