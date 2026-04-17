@extends('layouts.app')

@section('content')
<div class="dashboard-header mb-4">
    <div class="row align-items-center">
        <div class="col-md-8">
            <h1 class="page-title">
                <i class="bi bi-kanban me-2"></i>My Tasks
            </h1>
            <p class="page-subtitle">Manage and track your to-do items efficiently</p>
        </div>
        <div class="col-md-4 text-md-end">
            <a href="{{ route('tasks.create') }}" class="btn btn-glow btn-lg" id="btn-create-task">
                <i class="bi bi-plus-lg me-2"></i>New Task
            </a>
        </div>
    </div>
</div>

{{-- Statistics Cards --}}
<div class="row mb-4 g-3">
    <div class="col-6 col-lg-3">
        <div class="stat-card stat-total" id="stat-total">
            <div class="stat-icon"><i class="bi bi-collection"></i></div>
            <div class="stat-number">{{ $totalTasks }}</div>
            <div class="stat-label">Total Tasks</div>
        </div>
    </div>
    <div class="col-6 col-lg-3">
        <div class="stat-card stat-pending" id="stat-pending">
            <div class="stat-icon"><i class="bi bi-clock"></i></div>
            <div class="stat-number">{{ $pendingTasks }}</div>
            <div class="stat-label">Pending</div>
        </div>
    </div>
    <div class="col-6 col-lg-3">
        <div class="stat-card stat-progress" id="stat-in-progress">
            <div class="stat-icon"><i class="bi bi-arrow-repeat"></i></div>
            <div class="stat-number">{{ $inProgressTasks }}</div>
            <div class="stat-label">In Progress</div>
        </div>
    </div>
    <div class="col-6 col-lg-3">
        <div class="stat-card stat-completed" id="stat-completed">
            <div class="stat-icon"><i class="bi bi-check-circle"></i></div>
            <div class="stat-number">{{ $completedTasks }}</div>
            <div class="stat-label">Completed</div>
        </div>
    </div>
</div>

{{-- Filters --}}
<div class="glass-card mb-4">
    <form action="{{ route('tasks.index') }}" method="GET" class="row g-3 align-items-end" id="filter-form">
        <div class="col-md-4">
            <label class="form-label fw-semibold"><i class="bi bi-search me-1"></i> Search</label>
            <input type="text" name="search" class="form-control glass-input" placeholder="Search tasks..." value="{{ request('search') }}" id="filter-search">
        </div>
        <div class="col-md-3">
            <label class="form-label fw-semibold"><i class="bi bi-funnel me-1"></i> Status</label>
            <select name="status" class="form-select glass-input" id="filter-status">
                <option value="all" {{ request('status') == 'all' ? 'selected' : '' }}>All Status</option>
                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="in_progress" {{ request('status') == 'in_progress' ? 'selected' : '' }}>In Progress</option>
                <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
            </select>
        </div>
        <div class="col-md-3">
            <label class="form-label fw-semibold"><i class="bi bi-flag me-1"></i> Priority</label>
            <select name="priority" class="form-select glass-input" id="filter-priority">
                <option value="all" {{ request('priority') == 'all' ? 'selected' : '' }}>All Priority</option>
                <option value="low" {{ request('priority') == 'low' ? 'selected' : '' }}>Low</option>
                <option value="medium" {{ request('priority') == 'medium' ? 'selected' : '' }}>Medium</option>
                <option value="high" {{ request('priority') == 'high' ? 'selected' : '' }}>High</option>
            </select>
        </div>
        <div class="col-md-2">
            <button type="submit" class="btn btn-outline-light w-100" id="btn-filter">
                <i class="bi bi-filter me-1"></i> Filter
            </button>
        </div>
    </form>
</div>

{{-- Task List --}}
<div class="glass-card">
    @if($tasks->count() > 0)
        <div class="table-responsive">
            <table class="table table-hover task-table mb-0" id="tasks-table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Title</th>
                        <th>Status</th>
                        <th>Priority</th>
                        <th>Due Date</th>
                        <th>Created</th>
                        <th class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($tasks as $index => $task)
                    <tr class="task-row {{ $task->status === 'completed' ? 'task-done' : '' }}" id="task-row-{{ $task->id }}">
                        <td class="fw-semibold">{{ $tasks->firstItem() + $index }}</td>
                        <td>
                            <a href="{{ route('tasks.show', $task) }}" class="task-title-link">
                                {{ $task->title }}
                            </a>
                            @if($task->description)
                                <small class="d-block text-muted mt-1">{{ Str::limit($task->description, 50) }}</small>
                            @endif
                        </td>
                        <td>
                            @if($task->status === 'pending')
                                <span class="badge badge-status badge-pending"><i class="bi bi-clock me-1"></i>Pending</span>
                            @elseif($task->status === 'in_progress')
                                <span class="badge badge-status badge-in-progress"><i class="bi bi-arrow-repeat me-1"></i>In Progress</span>
                            @else
                                <span class="badge badge-status badge-completed"><i class="bi bi-check-circle me-1"></i>Completed</span>
                            @endif
                        </td>
                        <td>
                            @if($task->priority === 'high')
                                <span class="badge badge-priority badge-high"><i class="bi bi-exclamation-triangle me-1"></i>High</span>
                            @elseif($task->priority === 'medium')
                                <span class="badge badge-priority badge-medium"><i class="bi bi-dash-circle me-1"></i>Medium</span>
                            @else
                                <span class="badge badge-priority badge-low"><i class="bi bi-arrow-down-circle me-1"></i>Low</span>
                            @endif
                        </td>
                        <td>
                            @if($task->due_date)
                                <span class="{{ $task->due_date->isPast() && $task->status !== 'completed' ? 'text-danger fw-bold' : '' }}">
                                    <i class="bi bi-calendar-event me-1"></i>{{ $task->due_date->format('M d, Y') }}
                                </span>
                            @else
                                <span class="text-muted">—</span>
                            @endif
                        </td>
                        <td>
                            <small>{{ $task->created_at->format('M d, Y') }}</small>
                        </td>
                        <td>
                            <div class="d-flex justify-content-center gap-1">
                                <a href="{{ route('tasks.show', $task) }}" class="btn btn-sm btn-action btn-view" title="View" id="btn-view-{{ $task->id }}">
                                    <i class="bi bi-eye"></i>
                                </a>
                                <a href="{{ route('tasks.edit', $task) }}" class="btn btn-sm btn-action btn-edit" title="Edit" id="btn-edit-{{ $task->id }}">
                                    <i class="bi bi-pencil-square"></i>
                                </a>
                                <form action="{{ route('tasks.destroy', $task) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this task?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-action btn-delete" title="Delete" id="btn-delete-{{ $task->id }}">
                                        <i class="bi bi-trash3"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        @if($tasks->hasPages())
        <div class="d-flex justify-content-center mt-4">
            {{ $tasks->appends(request()->query())->links() }}
        </div>
        @endif
    @else
        <div class="text-center py-5" id="empty-state">
            <i class="bi bi-clipboard2-check empty-icon"></i>
            <h4 class="mt-3">No tasks found</h4>
            <p class="text-muted">Get started by creating your first task!</p>
            <a href="{{ route('tasks.create') }}" class="btn btn-glow mt-2">
                <i class="bi bi-plus-lg me-2"></i>Create Task
            </a>
        </div>
    @endif
</div>
@endsection
