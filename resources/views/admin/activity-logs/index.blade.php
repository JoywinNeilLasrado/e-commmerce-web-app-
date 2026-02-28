@extends('layouts.admin')

@section('title', 'Activity Logs')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-extrabold text-gray-900 tracking-tight">Activity Logs</h1>
        <p class="mt-2 text-sm text-gray-500">Track all changes made by administrators across the system.</p>
    </div>

    <!-- Timeline-style Logs -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50 border-b border-gray-200">
                        <th class="py-4 px-6 text-xs font-semibold text-gray-500 uppercase tracking-wider">Time</th>
                        <th class="py-4 px-6 text-xs font-semibold text-gray-500 uppercase tracking-wider">Admin</th>
                        <th class="py-4 px-6 text-xs font-semibold text-gray-500 uppercase tracking-wider">Action</th>
                        <th class="py-4 px-6 text-xs font-semibold text-gray-500 uppercase tracking-wider">Model</th>
                        <th class="py-4 px-6 text-xs font-semibold text-gray-500 uppercase tracking-wider">Description</th>
                        <th class="py-4 px-6 text-xs font-semibold text-gray-500 uppercase tracking-wider">Details</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($logs as $log)
                        <tr class="hover:bg-gray-50/70 transition-colors duration-150">
                            {{-- Time --}}
                            <td class="py-4 px-6 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">{{ $log->created_at->format('M d, Y') }}</div>
                                <div class="text-xs text-gray-400">{{ $log->created_at->format('h:i:s A') }}</div>
                            </td>

                            {{-- Admin --}}
                            <td class="py-4 px-6 whitespace-nowrap">
                                @if($log->user)
                                    <div class="flex items-center gap-3">
                                        <div class="w-8 h-8 bg-gradient-to-br from-gray-700 to-gray-900 rounded-full flex items-center justify-center text-white text-xs font-bold shadow-sm flex-shrink-0">
                                            {{ substr($log->user->name, 0, 1) }}
                                        </div>
                                        <div>
                                            <div class="text-sm font-semibold text-gray-900">{{ $log->user->name }}</div>
                                            <div class="text-xs text-gray-400">{{ $log->user->email }}</div>
                                        </div>
                                    </div>
                                @else
                                    <span class="text-sm text-gray-400 italic">System</span>
                                @endif
                            </td>

                            {{-- Action --}}
                            <td class="py-4 px-6 whitespace-nowrap">
                                @if($log->action === 'created')
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700 ring-1 ring-emerald-600/10">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                                        Created
                                    </span>
                                @elseif($log->action === 'updated')
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-blue-50 text-blue-700 ring-1 ring-blue-600/10">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                        Updated
                                    </span>
                                @elseif($log->action === 'deleted')
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-red-50 text-red-700 ring-1 ring-red-600/10">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                        Deleted
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-gray-100 text-gray-700">
                                        {{ ucfirst($log->action) }}
                                    </span>
                                @endif
                            </td>

                            {{-- Model --}}
                            <td class="py-4 px-6 whitespace-nowrap">
                                <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-medium bg-gray-100 text-gray-700">
                                    {{ class_basename($log->model_type) }} #{{ $log->model_id }}
                                </span>
                            </td>

                            {{-- Description --}}
                            <td class="py-4 px-6 text-sm text-gray-600 max-w-xs">
                                {{ $log->description ?? '-' }}
                            </td>

                            {{-- Details --}}
                            <td class="py-4 px-6 text-sm text-gray-500">
                                @if($log->changes)
                                    <div x-data="{ open: false }" class="relative">
                                        <button @click="open = !open" class="inline-flex items-center gap-1 text-blue-600 hover:text-blue-800 text-xs font-medium transition-colors px-2 py-1 rounded-md hover:bg-blue-50">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                            <span x-text="open ? 'Hide' : 'View'"></span>
                                        </button>
                                        <div x-show="open" x-transition @click.away="open = false"
                                             class="mt-2 bg-gray-900 text-gray-100 p-4 rounded-xl text-xs overflow-auto max-w-sm max-h-56 shadow-xl border border-gray-700" style="display: none;">
                                            @if(isset($log->changes['before']) && isset($log->changes['after']))
                                                <div class="mb-2">
                                                    <span class="text-red-400 font-bold uppercase text-[10px] tracking-wider">Before</span>
                                                    <pre class="whitespace-pre-wrap font-mono mt-1 text-red-300">{{ json_encode($log->changes['before'], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) }}</pre>
                                                </div>
                                                <hr class="border-gray-700 my-2">
                                                <div>
                                                    <span class="text-green-400 font-bold uppercase text-[10px] tracking-wider">After</span>
                                                    <pre class="whitespace-pre-wrap font-mono mt-1 text-green-300">{{ json_encode($log->changes['after'], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) }}</pre>
                                                </div>
                                            @else
                                                <pre class="whitespace-pre-wrap font-mono">{{ json_encode($log->changes, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) }}</pre>
                                            @endif
                                        </div>
                                    </div>
                                @else
                                    <span class="text-gray-300 text-xs">—</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-16 px-6 text-center">
                                <div class="flex flex-col items-center justify-center space-y-3">
                                    <div class="w-16 h-16 rounded-2xl bg-gray-100 flex items-center justify-center">
                                        <svg class="w-8 h-8 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                    </div>
                                    <p class="text-gray-500 text-sm font-medium">No activity logs yet</p>
                                    <p class="text-gray-400 text-xs">Actions taken by admins will appear here automatically.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <!-- Pagination -->
        @if($logs->hasPages())
            <div class="bg-gray-50 px-6 py-4 border-t border-gray-200">
                {{ $logs->links() }}
            </div>
        @endif
    </div>
</div>

<!-- Alpine.js for toggle interactions -->
<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
@endsection
